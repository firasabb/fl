<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\User;
use Auth;

class UserController extends Controller
{
    

    public function __construct(){

        $this->middleware('role:user');

    }



    public function showProfile($username){

        $user = User::where('username', $username)->firstOrFail();
        
        return view('users.profile', ['user' => $user]);

    }


    public function setupProfilePage($username){

        $logged_user = Auth::user();
        $user = User::where('username', $username)->firstOrFail();

        if($logged_user->id == $user->id || $logged_user->hasRole('admin')){
            return view('users.profileSetup', ['user' => $user]);
        }

    }


    public function setupProfileRequest($username){

        $logged_user = Auth::user();
        $user = User::where('username', $username)->firstOrFail();

        if($logged_user->id == $user->id || $logged_user->hasRole('admin')){
            
        }

    }

}
