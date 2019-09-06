<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;

class UserController extends Controller
{
    

    public function __construct(){

        $this->middleware('role:user');

    }



    public function showProfile($username){

        $user = User::where('username', $username)->firstOrFail();
        
        return view('users.profile', ['user' => $user]);

    }
}
