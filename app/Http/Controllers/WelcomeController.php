<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Art;

class WelcomeController extends Controller
{

    public function __construct(){

    }

    public function index(){

        $arts = Art::orderBy('id', 'desc')->paginate(5);
        return view('main', ['arts' => $arts]);

    }
}
