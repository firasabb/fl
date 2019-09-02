<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Spatie\Permission\Models\Role;
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
            'name' => 'min:3|max:30',
            'email' => 'email',
            'password' => 'min:6|max:50',
            'roles' => 'array'
        ]);

        if ($validator->fails()) {
            return redirect('/admin/dashboard/users')->withErrors($validator)->withInput(Input::except('password'));
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        $rolesIDs = $request->roles;

        foreach($rolesIDs as $roleID){

            $role = Role::findOrFail($roleID);
            $user->assignRole($role);

        }

        return redirect('/admin/dashboard/users')->with('status', 'User has been added successfully!');

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

        $rolesIDs = $request->roles;

        $rolesArr = [];

        foreach($rolesIDs as $roleID){

            $role = Role::findOrFail($roleID);
            array_push($rolesArr, $role);

        }

        $user->syncRoles($rolesArr);


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
}
