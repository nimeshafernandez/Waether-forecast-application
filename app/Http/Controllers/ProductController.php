<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Super Admin|product_management_view'])->only('index');
        $this->middleware(['role_or_permission:Super Admin|product_management_create'])->only('create');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_category = "products";
        $page_name = "view_products";  
        $warehouse_id = '0';
        $super_admin = false;

        if(Auth::user()->getRoleNames()[0] == "Super Admin"){
            $super_admin = true;
        }

        if ($id = Auth::user()->warehouse ){
            $warehouse_id = $id->id;
        }      
        
        return view('pages.product.index', compact(['page_category', 'page_name','warehouse_id','super_admin']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_category = "products";
        $page_name = "add_products"; 
        $warehouse_id = '0';
        $super_admin = false;

        if(Auth::user()->getRoleNames()[0] == "Super Admin"){
            $super_admin = true;
        }

        if ($id = Auth::user()->warehouse ){
            $warehouse_id = $id->id;
        }             
        
        return view('pages.product.create',  compact(['page_category', 'page_name','warehouse_id','super_admin']));
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
