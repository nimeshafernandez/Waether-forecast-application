<?php

namespace App\Http\Controllers\API;

use App\Credit;
use App\Http\Controllers\Controller;
use App\Customer;
use Illuminate\Http\Request;

class ApiCustomerController extends Controller
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
        $customers = Customer::with('credit')->paginate(config('company.page_result_limit'));

        return response()->json($customers, 200);
    }

    public function getAllCustomers()  {
        $customers = Customer::all();
        return response()->json($customers, 200);
    }

    public function search($keyword){

        $customers = Customer::with('credit')->where('name', 'like', '%' . $keyword . '%')->orwhere('nic_no', 'like', '%' . $keyword . '%')->orwhere('phone', 'like', '%' . $keyword . '%')->paginate(config('company.page_result_limit'));

        if (is_null($customers)) {
            return response()->json(['message' => 'No records'], 404);
        } else {
            return response()->json($customers, 200);
        }
    }

    public function getPayment(Request $request, $id){
        
        $customer = Customer::find($id);

        if(is_null($customer)){
            return response()->json(['message' => 'Unable to find customer!'], 404);
        }else{

            $amount = $request['amount'];
            $customer->credit->total -= $amount;
            $customer->credit->paid_total += $amount;
            $customer->credit->save();

            return response()->json(['message' => 'Payment accepted!'], 200);
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
            'address' => ['required'],
            'phone' => ['required', 'min:10'],
            'nic_no' => ['required', 'min:10', 'unique:customers'],
        ]);

        $customer = Customer::create([
            'name' => $validated_data['name'],
            'address' => $validated_data['address'],
            'phone' => $validated_data['phone'],
            'nic_no' => $validated_data['nic_no']
        ]);

        $credit = Credit::create([
            'customer_id' => $customer->id
        ]);

        if (is_null($customer)) {
            return response()->json(['message' => 'Record Entry Failed!'], 400);
        } else {
            return response()->json(['message' => 'Record Added Successfully'], 200);
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
        $customer = Customer::find($id);      

        if(is_null($customer)){

            return response()->json(['message' => 'Failed to find record!'], 404);
        }else{

            $receipts = Customer::find($id)->credit->receipts()->orderBy('created_at', 'DESC')->paginate(config('company.page_result_limit'));
            return response()->json(['customer' => $customer, 'receipts' => $receipts], 200);
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
        $validated_data = $request->validate([
            'name' => ['required'],
            'address' => ['required'],
            'phone' => ['required', 'min:10'],
            'nic_no' => ['required', 'min:10', 'unique:customers,nic_no,' . $id],
        ]);

        $customer = Customer::find($id);
        if (is_null($customer)) {
            return response()->json(['message' => 'Customer not found!'], 404);
        } else {

            $input = $request->all();
            $customer->update([
                'name' => $validated_data['name'],
                'address' => $validated_data['address'],
                'phone' => $validated_data['phone'],
                'nic_no' =>  $validated_data['nic_no'],
            ]);



            if(is_null($customer)){
                return response()->json(['message' => 'Record Update Failed!'], 400);
            }else{
                return response()->json(['message' => 'Record Updated Successfully'], 200);
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
        $customer = Customer::find($id);

        if (is_null($customer)) {
            return response()->json(['message' => 'Record Not Found!'], 404);
        } else {
            $customer->delete();
            return response()->json(['message' => 'Record Deleted Successfully'], 200);
        }
    }
}
