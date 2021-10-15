<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Warehouse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiCategoryController extends Controller
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
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    public function byWarehouse($id)
    {
        $warehouse = Warehouse::findOrFail($id);
        $categories = $warehouse->categories;

        if (is_null($categories)) {
            return response()->json(['message' => 'No records'], 404);
        } else {
            return response()->json($categories, 200);
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

        $category = Category::create([
            'name' => $validatedData['name'],
            'warehouse_id' => $validatedData['warehouse_id']
        ]);

        if ($category) {
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

        $category = Category::find($id);
        
        if ($category) {
            $category->update([
                'name' => $validatedData['name']
            ]);
            $category->save();
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
        $category = Category::find($id);

        if($category){
            $category->delete();
            return response()->json(['message' => 'Record Deleted'], 200);
        }else{
            return response()->json(['message' => 'Request Failed!'], 400);
        }
    }
}
