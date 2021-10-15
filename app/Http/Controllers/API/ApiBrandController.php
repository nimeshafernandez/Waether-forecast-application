<?php

namespace App\Http\Controllers\API;

use App\Brand;
use App\Http\Controllers\Controller;
use App\Warehouse;
use Illuminate\Http\Request;

class ApiBrandController extends Controller
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
        $brands = Brand::all();
        return response()->json($brands, 200);
    }

    public function byWarehouse($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $brands = $warehouse->brands;

        if (is_null($brands)) {
            return response()->json(['message' => 'No records'], 404);
        } else {
            return response()->json($brands, 200);
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
        $validatedData = $request->validate([
            'name' => ['required'],
            'warehouse_id' => ['required']
        ]);

        $brand = Brand::create([
            'name' => $validatedData['name'],
            'warehouse_id' => $validatedData['warehouse_id']
        ]);

        if ($brand) {
            return response()->json(['message' => 'Record Added'], 200);
        } else {
            return response()->json(['message' => 'Request Failed!'], 400);
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
        $validatedData = $request->validate([
            'name' => ['required'],
            'warehouse_id' => ['required']
        ]);

        $brand = Brand::find($id);
        
        if ($brand) {
            $brand->update([
                'name' => $validatedData['name']
            ]);
            $brand->save();
    
            return response()->json(['message' => 'Record Updated'], 200);
        } else {
            return response()->json(['message' => 'Request Failed!'], 400);
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
        $brand = Brand::find($id);

        if ($brand) {
            $brand->delete();
            return response()->json(['message' => 'Record Deleted'], 200);
        } else {
            return response()->json(['message' => 'Request Failed!'], 400);
        }
    }
}
