<?php

namespace App\Http\Controllers;

use App\PreQuestion;
use App\Question;
use App\PreChoice;
use App\Choice;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use Auth;

class PreQuestionController extends Controller
{


    public function __construct(){

        $this->middleware('role:admin|moderator|user');

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

        $user = Auth::user();

        $prequestion = new PreQuestion();
        $prequestion->title = $request->title;
        $prequestion->description = $request->description;
        $prequestion->user_id = $user->id;
        $prequestion->save();

        if($request->options){
            $options = $request->options;
            foreach($options as $option){
                $choice = new PreChoice();
                $choice->choice = $option;
                $choice->pre_question_id = $prequestion->id;
                $choice->save();
                
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
    public function destroy($id)
    {   
        $prequestion = PreQuestion::findOrFail($id);
        $prequestion->delete();

        return redirect('admin/dashboard/prequestions/')->with('status', 'Question has been deleted!');
    }


    public function approve(Request $request){

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:15|max:200',
            'question_id' => 'required|integer',
            'description' => 'string|max:500|nullable',
            'options' => 'array',
            'options.*' => 'string|max:200',
            'user_id' => 'required|integer'
        ]);

        if($validator->fails()){

            return redirect()->back()->withErrors($validator)->withInput();

        }

        $prequestion = PreQuestion::findOrFail($request->question_id);

        $question = new Question();

        $question->title = $request->title;
        $question->description = $request->description;
        $question->url = Str::slug(htmlspecialchars($request->title), '-');
        $question->user_id = $request->user_id;
        $question->save(); 

        if($request->options){
            $options = $request->options;
            foreach($options as $option){
                $choice = new Choice();
                $choice->choice = $option;
                $choice->question_id = $question->id;
                $choice->save();
            }
        }

        $prequestion->delete();

        return redirect('/admin/dashboard/prequestions/')->with('status', 'Question has been approved!');

    }
}
