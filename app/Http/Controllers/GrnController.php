<?php

namespace App\Http\Controllers;

use App\Grn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrnController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Super Admin|product_management_create'])->only('create');
        $this->middleware(['role_or_permission:Super Admin|product_management_view'])->only('index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $page_category = "stocks";
        $page_name = "view_stocks";     
        $warehouse_id = '0';
        $super_admin = false;

        if(Auth::user()->getRoleNames()[0] == "Super Admin"){
            $super_admin = true;
        }

        if ($id = Auth::user()->warehouse ){
            $warehouse_id = $id->id;
        }      
        
        return view('pages.stock.index', compact(['page_category', 'page_name','warehouse_id','super_admin']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_category = "stocks";
        $page_name = "create_stocks";     
        $warehouse_id = '0';
        $super_admin = false;
        $user_id = Auth::user()->id;
      
        if(Auth::user()->getRoleNames()[0] == "Super Admin"){
            $super_admin = true;
        }

        if ($id = Auth::user()->warehouse ){
            $warehouse_id = $id->id;
        }
        

        
        return view('pages.stock.create', compact(['page_category', 'page_name','super_admin', 'warehouse_id','user_id']));
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
     * @param  \App\Grn  $grn
     * @return \Illuminate\Http\Response
     */
    public function show(Grn $grn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grn  $grn
     * @return \Illuminate\Http\Response
     */
    public function edit(Grn $grn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grn  $grn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grn $grn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grn  $grn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grn $grn)
    {
        //
    }
}
