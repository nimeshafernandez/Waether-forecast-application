<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Super Admin|customer_management_view'])->only('overview');
        $this->middleware(['role_or_permission:Super Admin|customer_management_view'])->only('index');
        $this->middleware(['role_or_permission:Super Admin|customer_management_update'])->only('payment');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $page_category = "customers";
        $page_name = "view_customers";     
        
        return view('pages.customer.index', compact(['page_category', 'page_name']));
    }

    public function overview()
    {
        $page_category = "customers";
        $page_name = "overview_customers";     
        
        return view('pages.customer.overview', compact(['page_category', 'page_name']));
    }

    public function payment()
    {
        $page_category = "customers";
        $page_name = "payment_customers";     
        
        return view('pages.customer.payment', compact(['page_category', 'page_name']));
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
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page_category = "customers";
        $page_name = "overview_customers";     
        $customer = Customer::with('credit')->findOrFail($id);
        
        return view('pages.customer.show', compact(['page_category', 'page_name', 'customer']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
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
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
