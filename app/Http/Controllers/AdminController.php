<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

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

        return view('admin.users.users')->with('users', $users);

    }


    public function showUser($id){

        $user = User::findOrFail($id);
        return view('admin.users.show')->with('user', $user);
        
    }
}
