<?php

namespace App\Http\Controllers\API;

use App\Barcode;
use App\Product;
use App\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stock;

class ApiProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }

    public function byWarehouse($id)
    {
        $warehouse = Warehouse::find($id);
        $products = $warehouse->products()->paginate(config('company.page_result_limit'));

        if (is_null($products)) {
            return response()->json(['message' => 'No records'], 404);
        } else {
            return response()->json($products, 200);
        }
    }

    public function searchProductsByWarehouse($keyword, $id)
    {
        $warehouse = Warehouse::find($id);
        $results = $warehouse->products()->where('name', 'like', '%' . $keyword . '%')->orWhere('search_term',  'like', '%' . $keyword . '%')->orWhere('code',  'like', '%' . $keyword . '%')->paginate(config('company.page_result_limit'));

        if (is_null($results)) {
            return response()->json(['message' => 'No records'], 404);
        } else {
            return response()->json($results, 200);
        }
    }

    public function byWarehouseNonPaginate($id) 
    {
        $warehouse = Warehouse::find($id);
        $products = $warehouse->products()->where('active', '!=' , '0')->get();

        if (is_null($products)) {
            return response()->json(['message' => 'No records'], 404);
        } else {
            return response()->json($products, 200);
        }

    }

    public function getProductByBarcode($barcode, $warehouse_id)
    {
        $product = Barcode::whereBarcode($barcode)->first();
        
        if(is_null($product)){
            return response()->json(['message' => 'Unable to find product from barcode'], 404);
        }else{
            
            if(($product->product->warehouse_id) != $warehouse_id){
                return response()->json(['message' => 'Unable to find product from barcode'], 404);            
            }
            
            $active_status = $product->product->active;
            if($active_status){
                return response()->json($product->product, 200);
            }else{
                return response()->json(['message' => 'Product Disabled'], 404);
            }
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
            'name' => ['required'],
            'search_term' => ['required'],
            'code' => ['required', ' unique:products'],
            'selling_price' => ['required', 'numeric'],
            'reorder_stock' => ['required', 'numeric'],
            'active' => ['required'],
            'custom_scale' => ['required'],
            'category_id' => ['required'],
            'brand_id' => ['required'],
            'warehouse_id' => ['required'],
        ]);

        $product = Product::create([
            'name' => $validated_data['name'],
            'search_term' => $validated_data['search_term'],
            'code' => $validated_data['code'],
            'selling_price' => $validated_data['selling_price'],
            'reorder_stock' => $validated_data['reorder_stock'],
            'active' => $validated_data['active'],
            'custom_scale' => $validated_data['custom_scale'],
            'category_id' => $validated_data['category_id'],
            'brand_id' => $validated_data['brand_id'],
            'warehouse_id' => $validated_data['warehouse_id']
        ]);

        Stock::create([
            'product_id' => $product->id,
            'quantity' => 0
        ]);

        if (is_null($product)) {
            return response()->json(['message' => 'No records'], 404);
        } else {
            return response()->json(['message' => 'Product Added Successfully'], 200);
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

        $validated_data = $request->validate([
            'name' => ['required'],
            'search_term' => ['required'],
            'code' => ['required', 'unique:products,code,' . $id],
            'selling_price' => ['required', 'numeric'],
            'reorder_stock' => ['required', 'numeric'],
            'active' => ['required'],
            'custom_scale' => ['required'],
            'category_id' => ['required'],
            'brand_id' => ['required'],
            'warehouse_id' => ['required'],
        ]);

        $product = Product::find($id);

        if (is_null($product)) {
            return response()->json(['message' => 'No record matching records found!'], 404);
        } else {

            $product->update([
                'name' => $validated_data['name'],
                'search_term' => $validated_data['search_term'],
                'code' => $validated_data['code'],
                'selling_price' => $validated_data['selling_price'],
                'reorder_stock' => $validated_data['reorder_stock'],
                'active' => $validated_data['active'],
                'custom_scale' => $validated_data['custom_scale'],
                'category_id' => $validated_data['category_id'],
                'brand_id' => $validated_data['brand_id'],
                'warehouse_id' => $validated_data['warehouse_id']
            ]);
            if ($product) {
                return response()->json(['message' => 'Product Added Successfully'], 200);
            } else {
                return response()->json(['message' => 'Action was unsuccessful!'], 400);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (is_null($product)) {
            return response()->json(['message' => 'Record Not Found!'], 404);
        } else {
            $product->delete();
            return response()->json(['message' => 'Record Deleted Successfully'], 200);
        }
    }
}
