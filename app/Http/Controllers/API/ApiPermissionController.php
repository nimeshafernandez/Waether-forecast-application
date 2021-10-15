<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ApiPermissionController extends Controller
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
        $role = Role::find($id);

        $pos = $request->pos;
        foreach ($pos as $key => $value) {
            switch ($key) {
                case 'enabled':
                    if ($value) {
                        $role->givePermissionTo('POS');
                    } else {
                        $role->revokePermissionTo('POS');
                    }
                    break;
        }

            $user = $request->user;
            foreach ($user as $key => $value) {
                switch ($key) {
                case 'create':
                    if ($value) {
                        $role->givePermissionTo('user_management_create');
                    } else {
                        $role->revokePermissionTo('user_management_create');
                    }
                    break;

                case 'view':
                    if ($value) {
                        $role->givePermissionTo('user_management_view');
                    } else {
                        $role->revokePermissionTo('user_management_view');
                    }
                    break;
                case 'update':
                    if ($value) {
                        $role->givePermissionTo('user_management_update');
                    } else {
                        $role->revokePermissionTo('user_management_update');
                    }
                    break;
                case 'delete':
                    if ($value) {
                        $role->givePermissionTo('user_management_delete');
                    } else {
                        $role->revokePermissionTo('user_management_delete');
                    }
                    break;
            }
            }

            $product = $request->product;
            foreach ($product as $key => $value) {
                switch ($key) {
                case 'create':
                    if ($value) {
                        $role->givePermissionTo('product_management_create');
                    } else {
                        $role->revokePermissionTo('product_management_create');
                    }
                    break;

                case 'view':
                    if ($value) {
                        $role->givePermissionTo('product_management_view');
                    } else {
                        $role->revokePermissionTo('product_management_view');
                    }
                    break;
                case 'update':
                    if ($value) {
                        $role->givePermissionTo('product_management_update');
                    } else {
                        $role->revokePermissionTo('product_management_update');
                    }
                    break;
                case 'delete':
                    if ($value) {
                        $role->givePermissionTo('product_management_delete');
                    } else {
                        $role->revokePermissionTo('product_management_delete');
                    }
                    break;
            }
            }

            $customer = $request->customer;
            foreach ($customer as $key => $value) {
                switch ($key) {
                case 'create':
                    if ($value) {
                        $role->givePermissionTo('customer_management_create');
                    } else {
                        $role->revokePermissionTo('customer_management_create');
                    }
                    break;

                case 'view':
                    if ($value) {
                        $role->givePermissionTo('customer_management_view');
                    } else {
                        $role->revokePermissionTo('customer_management_view');
                    }
                    break;
                case 'update':
                    if ($value) {
                        $role->givePermissionTo('customer_management_update');
                    } else {
                        $role->revokePermissionTo('customer_management_update');
                    }
                    break;
                case 'delete':
                    if ($value) {
                        $role->givePermissionTo('customer_management_delete');
                    } else {
                        $role->revokePermissionTo('customer_management_delete');
                    }
                    break;
            }
            }

            $supplier = $request->supplier;
            foreach ($supplier as $key => $value) {
                switch ($key) {
                case 'create':
                    if ($value) {
                        $role->givePermissionTo('supplier_management_create');
                    } else {
                        $role->revokePermissionTo('supplier_management_create');
                    }
                    break;

                case 'view':
                    if ($value) {
                        $role->givePermissionTo('supplier_management_view');
                    } else {
                        $role->revokePermissionTo('supplier_management_view');
                    }
                    break;
                case 'update':
                    if ($value) {
                        $role->givePermissionTo('supplier_management_update');
                    } else {
                        $role->revokePermissionTo('supplier_management_update');
                    }
                    break;
                case 'delete':
                    if ($value) {
                        $role->givePermissionTo('supplier_management_delete');
                    } else {
                        $role->revokePermissionTo('supplier_management_delete');
                    }
                    break;
            }
            }

            $warehouse = $request->warehouse;
            foreach ($warehouse as $key => $value) {
                switch ($key) {
                case 'create':
                    if ($value) {
                        $role->givePermissionTo('warehouse_management_create');
                    } else {
                        $role->revokePermissionTo('warehouse_management_create');
                    }
                    break;

                case 'view':
                    if ($value) {
                        $role->givePermissionTo('warehouse_management_view');
                    } else {
                        $role->revokePermissionTo('warehouse_management_view');
                    }
                    break;
                case 'update':
                    if ($value) {
                        $role->givePermissionTo('warehouse_management_update');
                    } else {
                        $role->revokePermissionTo('warehouse_management_update');
                    }
                    break;
                case 'delete':
                    if ($value) {
                        $role->givePermissionTo('warehouse_management_delete');
                    } else {
                        $role->revokePermissionTo('warehouse_management_delete');
                    }
                    break;
            }
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
        //
    }

    public function permission_per_role ($id){

        $role = Role::find($id);
        $permissions = $role->permissions()->get(['name']);

        return $permissions;
    }
}
