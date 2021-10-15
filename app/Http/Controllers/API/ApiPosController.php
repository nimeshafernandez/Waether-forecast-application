<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Stock;
use App\Ledger;
use App\Product;
use App\Receipt;
use App\LedgerType;
use App\PaymentType;
use App\ReceiptItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ApiPosController extends Controller
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
        //
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
        // return response()->json($request);
        $check_object = [
            'receipt' => false,
            'receipt_items' => false,
        ];
        $input = $request->all();
        $products_backup = [];
        // return response()->json($request);

        $payment_type_id = PaymentType::whereType($input['payment_method'])->first()->id;
        $receipt = Receipt::create([
            'user_id' => $input['user_id'],
            'warehouse_id' => $input['warehouse_id'],
            'payment_type_id' => $payment_type_id,
            'total' => $input['grand_total'],
            'discount' => $input['grand_total_discount']
        ]);

        if($input['payment_method'] == "credit"){

            //if the customer purchase credit, add records
            
            $credit_customer_array = $input['credit_customer'];
            $customer = Customer::find($credit_customer_array['id']);
            $customer->credit->items()->create(['receipt_id' => $receipt->id]);

            $customer->credit->total += $receipt->total;
            $customer->credit->save();
  
        }

        if ($receipt) {

            $check_object['receipt'] = true;

            $products = $input['products'];
            foreach ($products as $product) {
                $receipt_item = ReceiptItems::create([
                    'receipt_id' => $receipt->id,
                    'product_id' => $product['product_id'],
                    'product_price' => $product['product_price'],
                    'quantity' => $product['quantity'],
                    'discount_allowed' => $product['allowed_discount']
                ]);
                if ($receipt_item) {
                    $check_object['receipt_items'] = true;
                } else {
                    $check_object['receipt_items'] = false;
                }

                $find_product = Product::find($product['product_id']);
                $current_stock = $find_product->stock->quantity;

                //creating backup for recovery
                array_push($products_backup, ['product_id' => $product['product_id'], 'quantity' => $current_stock]);

                //reducing the quantity
                $current_stock -= $product['quantity'];

                $stock_id = $find_product->stock->id;
                $update_stock = Stock::find($stock_id);
                $update_stock->update([
                    'quantity' => $current_stock
                ]);
            }

            $transaction_type = LedgerType::whereType('income')->first();
            $transaction_income = Ledger::create([
                'ledger_types_id' => $transaction_type->id,
                'desc' => 'Sales Income Ref: ' . $receipt->id,
                'amount' => $request->input('grand_total')
            ]);

            if ($request->input('grand_total_discount') > 0) {
                $transaction_type_expense = LedgerType::whereType('expense')->first();
                $transaction_expense = Ledger::create([
                    'ledger_types_id' => $transaction_type_expense->id,
                    'desc' => 'Discount Allowed On Receipt Ref: ' . $receipt->id,
                    'amount' => $request->input('grand_total_discount')
                ]);
            }


            if ($check_object['receipt'] == true && $check_object['receipt_items'] == true) {

                return response()->json(['message' => 'Transaction accepted', 'receipt_id' => $receipt->id, 'receipt_date' => $receipt->created_at], 200);
            } else {

                $transaction_income->delete();
                if( ! is_null($transaction_type_expense)){
                    $transaction_expense->delete();
                }


                $receipt->items()->delete();
                $receipt->delete();

                foreach ($products_backup as $pb) {
                    $stock = Stock::whereProductId($pb['product_id']);
                    $stock->update([
                        'quantity' => $pb['quantity']
                    ]);
                }

                return response()->json(['message' => 'Transaction failed, will fall back!'], 206);
            }
        } else {
            return response()->json(['message' => 'Unable to create receipt!'], 500);
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
