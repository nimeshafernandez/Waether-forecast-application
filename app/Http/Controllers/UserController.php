<?php

namespace App\Http\Controllers;

use App\User;
use App\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role_or_permission:Super Admin|user_management_create'])->only('create');
        $this->middleware(['role_or_permission:Super Admin|user_management_view'])->only('index', 'show');
    }
    public function index()
    {
        $page_category = "users";
        $page_name = "view_users";
        $users = User::all();
 
        return view('pages.user.index', compact(['page_category', 'page_name', 'users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_category = "users";
        $page_name = "create_new_user";
        $warehouses = Warehouse::all();
        $roles = null;

        if( Auth::user()->getRoleNames()[0] == "Super Admin"){
            $roles = Role::all();
        }
        else{
            $roles = Role::where('name','!=', 'Super Admin')->get();
        }
 
        return view('pages.user.create', compact(['page_category', 'page_name', 'warehouses', 'roles']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'warehouse_id' => ['required'],
            'role_id' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $validated_data = $request->all();

        $role_id = $validated_data['role_id'];
        $role = Role::findById($role_id);

        $warehouse_id = $validated_data['warehouse_id'];
        $warehouse = Warehouse::findOrFail($warehouse_id);

        $user = User::create([
            'name' => $validated_data['name'],
            'email' => $validated_data['email'],
            'username' => $validated_data['username'],
            'password' => $validated_data['password'],
            'warehouse_id' => $warehouse->id
        ]);
        $user->syncRoles($role);

        return redirect(route('user.show', $user->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $page_category = "users";
        $page_name = "view_users";
        
        $user = User::findOrFail($id);
        
        return view('pages.user.show', compact(['page_category', 'page_name', 'user']));
        
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
