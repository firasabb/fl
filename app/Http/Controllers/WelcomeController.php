<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;

class WelcomeController extends Controller
{

    public function __construct(){

    }

    public function index(){

        $questions = Question::orderBy('id', 'desc')->paginate(5);
        return view('welcome', ['questions' => $questions]);

    }
}
