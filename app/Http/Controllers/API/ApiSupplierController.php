<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Supplier;
use Illuminate\Http\Request;

class ApiSupplierController extends Controller
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
        $suppliers = Supplier::paginate(config('company.page_result_limit'));

        return response()->json($suppliers, 200);
    }

    public function getAllSuppliers() {   

            $suppliers = Supplier::all();
            return response()->json($suppliers, 200); 
    }

    public function getAllSuppliersSearch($search) {
         
            $suppliers = Supplier::where('name', 'like', '%'.$search.'%')->get();
            return response()->json($suppliers, 200);        
       
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
            'email' => ['nullable', 'email', 'unique:suppliers'],
        ]);

        $supplier = Supplier::create([
            'name' => $validated_data['name'],
            'address' => $validated_data['address'],
            'phone' => $validated_data['phone']
        ]);

        if ($request->has('email')) {
            $supplier->update([
                'email' => $validated_data['email']
            ]);
        }


        if (is_null($supplier)) {
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
            'address' => ['required'],
            'phone' => ['required', 'min:10'],
            'email' => ['nullable' , 'email ', 'unique:suppliers,email, '.$id],
        ]);

        $supplier = Supplier::find($id);
        if (is_null($supplier)) {
            return response()->json(['message' => 'Supplier not found!'], 404);
        } else {

            $input = $request->all();
            $supplier->update([
                'name' => $validated_data['name'],
                'address' => $validated_data['address'],
                'phone' => $validated_data['phone']
            ]);


            if ($request->has('email')) {
                $supplier->update([
                    'email' => $validated_data['email']
                ]);
            }

            if(is_null($supplier)){
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
        $supplier = Supplier::find($id);

        if (is_null($supplier)) {
            return response()->json(['message' => 'Record Not Found!'], 404);
        } else {
            $supplier->delete();
            return response()->json(['message' => 'Record Deleted Successfully'], 200);
        }
    }
}
