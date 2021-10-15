<?php

namespace App\Http\Controllers\API;

use App\Receipt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiReceiptController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receipt = Receipt::with('items')->find($id);

        if (is_null($receipt)) {
            return response()->json(['message' => 'Receipt not found!'], 404);
        } else {
            return response()->json($receipt, 200);
        }
    }

    public function showWithProduct($id)
    {
        $receipt_items = Receipt::with('items')->find($id);

        if (is_null($receipt_items)) {
            return response()->json(['message' => 'Receipt not found!'], 404);
        } else {
            $receipt =  Receipt::find($id);
            $receipt->user;

            $receipt_item_container = [];

            foreach ($receipt_items['items'] as $key => $item) {
                array_push($receipt_item_container, [
                    'id' => $item['id'],
                    'product_name' => $item->product->name,
                    'price' => $item['product_price'],
                    'quantity' => $item['quantity'],
                    'discount_allowed' => $item['discount_allowed']
                ]);
            }

            return response()->json(['receipt' => $receipt, 'products' => $receipt_item_container], 200);
        }
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
