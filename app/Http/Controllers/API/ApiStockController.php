<?php

namespace App\Http\Controllers\API;

use App\Grn;
use App\Stock;
use App\Ledger;
use App\Barcode;
use App\GrnList;
use App\Product;
use App\Warehouse;
use App\LedgerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ApiStockController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('stock')->get();
        return response()->json($products, 200);
    }

    public function byWarehouse($id)
    {
        $warehouse = Warehouse::find($id);
        $products = $warehouse->products()->with('stock')->paginate(config('company.page_result_limit'));

        if (is_null($products)) {
            return response()->json(['message' => 'No records'], 404);
        } else {
            return response()->json($products, 200);
        }
    }

    public function searchProductsByWarehouse($keyword, $id)
    {
        $warehouse = Warehouse::find($id);
        $results = $warehouse->products()->with('stock')->where('name', 'like', '%' . $keyword . '%')->orWhere('search_term',  'like', '%' . $keyword . '%')->orWhere('code',  'like', '%' . $keyword . '%')->paginate(config('company.page_result_limit'));

        if (is_null($results)) {
            return response()->json(['message' => 'No records'], 404);
        } else {
            return response()->json($results, 200);
        }
    }

    public function byWarehouseNonPaginate($id) 
    {
        $warehouse = Warehouse::find($id);
        $products = $warehouse->products()->with('stock')->where('active', '!=' , '0')->get();

        if (is_null($products)) {
            return response()->json(['message' => 'No records'], 404);
        } else {
            return response()->json($products, 200);
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'supplier_id' => ['required'],
            'warehouse_id' => ['required'],
            'invoice' => ['required', 'unique:grns'],
            'products' => ['required'],
            'user_id' => ['required'],           

        ]);

        //Check Object
        $checkObject = [
            'grn_created' => false,
            'grn_list_all' => false,
        ];

        //creaate GRN for reference
        $grn = Grn::create([
            'supplier_id' => $validated_data['supplier_id'],
            'user_id' => $validated_data['user_id'],
            'warehouse_id' => $validated_data['warehouse_id'],
            'invoice' => $validated_data['invoice']
        ]);
        if($grn){
            $checkObject['grn_created'] = true;
        }else{
            $checkObject['grn_created'] = false;
            return response()->json(['message' => 'Failed to create GRN, will fall back!'], 206);
        }

        $products = $validated_data['products'];
        $products_backup = [];

        foreach ($products as $product) {
            
            $grn_list = GrnList::create([
                'grn_id' => $grn->id,
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity'],
                'unit_cost' => $product['unit_cost'],
                'exp_date' => $product['exp_date']
            ]);
            if($grn_list){
                $checkObject['grn_list_all'] = true;
            }else{
                $checkObject['grn_list_all'] = false;
            }


            $find_product = Product::find($product['product_id']);
            $current_stock = $find_product->stock->quantity;

            //creating backup for recovery
            array_push($products_backup, ['product_id' =>$product['product_id'], 'quantity' => $current_stock ]);

            $current_stock +=  $product['quantity'];

            $stock_id = $find_product->stock->id;
            $update_stock = Stock::find($stock_id);
            $update_stock->update([
                'quantity' => $current_stock
            ]);

            $find_barcode =  $product['barcode'];
            if (!(is_null($find_barcode))) {

                $no_barcodes = Barcode::where('product_id', '=',$product['product_id'])->count();

                if ($no_barcodes >= config('company.max_barcode_storage')) {
                    $barcode_del = Barcode::whereProductId($product['product_id'])->oldest()->first();
                    $barcode_del->delete();
                }

                $is_bc_existing = Barcode::where('barcode', '=', $find_barcode)->first();
                if(! (is_null($is_bc_existing))){
                    $is_bc_existing->delete();
                }

                Barcode::create([
                    'product_id' =>  $product['product_id'],
                    'barcode' => $find_barcode
                ]);
            }
        }

        $transaction_type = LedgerType::whereType('expense')->first();
        $transaction = Ledger::create([
            'ledger_types_id' => $transaction_type->id,
            'desc' => 'Received Stock Ref: ' . $grn->id,
            'amount' => $request->input('grand_total')
        ]);

        if( $checkObject['grn_created'] && $checkObject['grn_list_all']){

            //on success process                      
            return response()->json(['message' => 'GRN Succuessfull'], 200);

        }else{

            //reverse process
            $transaction->delete();
            $grn->grnlist()->delete();
            $grn->delete();

            foreach ($products_backup as $pb) {
                $stock = Stock::whereProductId($pb['product_id']);
                $stock->update([
                    'quantity' => $pb['quantity']
                ]);
            }          

            return response()->json(['message' => 'Failed to create GRN, will fall back!'], 206);
            
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
