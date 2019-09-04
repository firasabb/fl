<?php

namespace App\Http\Controllers;

use App\PreQuestion;
use App\PreChoice;
use Illuminate\Http\Request;
use Validator;

class PreQuestionController extends Controller
{


    public function __construct(){

        //$this->middleware('role:admin|moderator|user');

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prequestions = PreQuestion::orderBy('id', 'desc')->paginate(1); 
        return view('admin.prequestions.prequestions', ['prequestions' => $prequestions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('prequestions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PreQuestion $preQuestion)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:15|max:200',
            'description' => 'string|max:500|nullable',
            'options' => 'array',
            'options.*' => 'string|max:200'
        ]);

        if($validator->fails()){
            return redirect('/create/question/')->withErrors($validator)->withInput();
        }

        $prequestion = new PreQuestion();
        $prequestion->title = $request->title;
        $prequestion->description = $request->description;
        $prequestion->save();

        if($request->options){
            $options = $request->options;
            foreach($options as $option){
                $choice = new PreChoice();
                $choice->choice = $option;
                $choice->save();
                $prequestion->choices()->save($choice);
            }
        }

        return redirect('/home')->with('status', 'Your Question Has Been Created! Once it is approved, it is going to be public...');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PreQuestion  $preQuestion
     * @return \Illuminate\Http\Response
     */
    public function show(PreQuestion $preQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PreQuestion  $preQuestion
     * @return \Illuminate\Http\Response
     */
    public function edit(PreQuestion $preQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreQuestion  $preQuestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PreQuestion $preQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PreQuestion  $preQuestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreQuestion $preQuestion)
    {
        //
    }
}
