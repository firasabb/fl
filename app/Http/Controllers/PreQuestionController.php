<?php

namespace App\Http\Controllers;

use App\PreQuestion;
use App\Question;
use App\PreChoice;
use App\Choice;
use App\Tag;
use App\Category;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use Auth;
use Spatie\Searchable\Search;
use Illuminate\Support\Facades\Crypt;


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
        $prequestions = PreQuestion::orderBy('id', 'asc')->paginate(1);
        $categories = Category::all(); 
        return view('admin.prequestions.prequestions', ['prequestions' => $prequestions, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('prequestions.create', ['categories' => $categories]);
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
            'categories' => 'required|array',
            'categories.*' => 'integer',
            'options' => 'array',
            'options.*' => 'string|max:200'
        ]);

        if($validator->fails()){
            return redirect('/ask/question/')->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        $prequestion = new PreQuestion();
        $prequestion->title = $request->title;
        $prequestion->description = $request->description;
        $prequestion->user_id = $user->id;
        $prequestion->save();

        $options = $request->options;
        if($options){
            foreach($options as $option){
                $choice = new PreChoice();
                $choice->choice = $option;
                $prequestion->choices()->save($choice);
            }
        }

        $categories = $request->categories;
        foreach($categories as $category){
            $category = Category::findOrFail($category);
            $prequestion->categories()->attach($category);
        }

        if($user->hasAnyRole(['admin', 'moderator'])){
            $this->adminAddQuestion($prequestion->id);
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

    /** 
    *
    * Approve the prequestion for users not admins
    *
    * @param Request
    * @return Response
    *
    */

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

        $question = $this->makeNewQuestion($request); 

        if($request->options){
            $options = $request->options;
            foreach($options as $option){
                $choice = new Choice();
                $choice->choice = $option;
                $choice->question_id = $question->id;
                $choice->save();
            }
        }

        $categories = $request->categories;
        foreach($categories as $category){
            $category = Category::findOrFail($category);
            $question->categories()->attach($category);
        }

        $prequestion->delete();

        return redirect('/admin/dashboard/prequestions/')->with('status', 'The Question has been approved!');

    }


    /** 
    *
    * Approve the prequestion for admins
    *
    * @param Request
    * @return Response
    *
    */


    public function adminAddQuestion($prequestion_id){

        $prequestion = PreQuestion::findOrFail($prequestion_id);
        $prechoices = $prequestion->choices;
        $question = $this->makeNewQuestion($prequestion);
        $prequestion->delete();

        if(!empty($prechoices)){
            foreach($prechoices as $prechoice){
                $choice = new Choice;
                $choice->choice = $prechoice->choice;
                $choice->question_id = $question->id;
                $choice->save();
            }
        }

        $categories = $prequestion->categories;
        foreach($categories as $category){
            $question->categories()->attach($category);
        }

        return redirect('/admin/dashboard/questions/')->with('status', 'A new question has been added by an admin.');
    }




    public function suggestTags(Request $request){

        $tag = $request->tag;

        if($tag){

            $suggestion = Tag::where('name', $tag)->get();
    
            $searchResults = (new Search())
                        ->registerModel(\App\Tag::class, 'name')
                        ->perform($tag);

            $response = array(
                'status' => 'success',
                'results' => $searchResults
            );
    
            return response()->json($response);

        }

        $response = array(
            'status' => 'error',
            'message' => 'no tag has been searched for'
        );

        return response()->json($response);
    }



    /**
     * 
     * Make new Question
     * 
     * @param Object: Prequestion or Request
     * @return New Question
     * 
     */


    private function makeNewQuestion($obj){

        $question = new Question();
        $question->title = $obj->title;
        $question->description = $obj->description;
        $question->url = Str::slug($obj->title, '-');
        $question->user_id = $obj->user_id;
        $question->save();
        return $question;

    }


}
