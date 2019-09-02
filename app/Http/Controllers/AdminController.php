<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){

        $this->middleware('role:admin');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){

        return view('admin.dashboard');
    }


    /********* 
     * 
     * 
     * 
     *      Users
     * 
     * 
     * 
     * 
    */

    public function showUsers(){

        $users = User::orderBy('id', 'DESC')->paginate(20);
        $roles = Role::all();

        return view('admin.users.users')->with('users', $users)->with('roles', $roles);

    }


    public function showUser($id){

        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.show', ['user' => $user, 'roles' => $roles]);

    }


    public function addUser(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'min:3|max:30|required',
            'email' => 'email|required',
            'password' => 'min:6|max:50|required',
            'roles' => 'array|required'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/dashboard/users/')->withErrors($validator)->withInput(Input::except('password'));
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $roles = $request->roles;

        foreach($roles as $role){

            $user->assignRole($role);

        }

        return redirect('/admin/dashboard/users/')->with('status', 'User has been added successfully!');

    }


    public function editUser($id, Request $request){

        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'min:3|max:30',
            'email' => 'email',
            'roles' => 'array'
        ]);

        if($validator->fails()){
            return redirect('/admin/dashboard/users/' . $user->id)->withErrors($validator)->withInput(Input::except('password'));
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        $roles = $request->roles;

        $user->syncRoles($roles);


        return redirect('/admin/dashboard/user/' . $user->id)->with('status', 'User has been edited successfully!');

    }


    public function destroyUser($id){

        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/admin/dashboard/users/')->with('status', 'User has been deleted!');

    }


    public function generatePassword($id){
        
        $user = User::findOrFail($id);
        $generatedPassword = $this->generateString();
        $user->password = bcrypt($generatedPassword);
        $user->save();

        return redirect('/admin/dashboard/user/' . $user->id)->with('status', 'User password has been changed to:  ' . $generatedPassword);

    }


    private function generateString($ln = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $generatedString = '';
        for($i = 0; $i < $ln; $i++){
            $generatedString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $generatedString;
    }

    /********
     * 
     * 
     * 
     * 
     * Roles
     * 
     * 
     * 
     * 
     */


     public function showRoles(){

        $roles = Role::orderBy('id', 'desc')->paginate(20);
        $permissions = Permission::all();
        return view('admin.roles.roles', ['roles' => $roles, 'permissions' => $permissions]);

     }


     
     public function addRole(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'permissions' => 'array'
        ]);

        if($validator->fails()){
            return redirect('/admin/dashboard/roles/')->withErrors($validator)->withInput();
        }

        $role = new Role();
        $role->name = strtolower($request->name);
        $role->save();

        $permissions = $request->permissions;

        foreach ($permissions as $permission) {
            
            $role->givePermissionTo($permission);

        }

        return redirect('/admin/dashboard/roles/')->with('status', 'Role has been added successfully!');

    }


     public function showRole($id){

        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        return view('admin.roles.show', ['role' => $role, 'permissions' => $permissions]);

     }


     public function editRole(Request $request, $id){

        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'permissions' => 'array'
        ]);

        if($validator->fails()){
            return redirect('/admin/dashboard/role/' . $role->id)->withErrors($validator)->withInput();
        }

        $role->name = strtolower($request->name);
        $role->save();

        $permissions = $request->permissions;

        $role->syncPermissions($permissions);

        return redirect('/admin/dashboard/role/' . $role->id)->with('status', 'Role has been edited successfully!');

     }


     public function destroyRole($id){

        $role = Role::findOrFail($id);

        $role->delete();

        return redirect('/admin/dashboard/roles/')->with('status', 'Role has been deleted successfully!');

     }

}
