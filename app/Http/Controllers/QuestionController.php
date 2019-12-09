<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $question = Question::where('url', $url)->firstOrFail();
        
        return view('question.show', ['question' => $question]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }


    public function adminIndex($questions = null)
    {
        if(!$questions){
            $questions = Question::orderBy('id', 'desc')->paginate(10);
        } else {
            $questions = $questions->paginate(20);
        }
        return view('admin.questions.questions', ['questions' => $questions]);
    }


    public function adminAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:20',
            'url' => 'required|string'
        ]);

        if($validator->fails()){
            return redirect('/admin/dashboard/tags')->withErrors($validator)->withInput();
        } 

        $tag = new Tag();
        $tag->name = strToLower($request->name);
        $tag->url = URL::to('/tag') . '/' . Str::slug(htmlspecialchars($request->url), '-');
        $tag->save();

        return redirect('/admin/dashboard/tags')->with('status', 'A tag has been created!');


    }


    public function adminShow($id)
    {
        $question = Question::findOrFail($id);
        return view('admin.questions.show', ['question' => $question]);
    }


    public function adminDestroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return redirect('/admin/dashboard/questions/')->with('status', 'The question has been deleted!');
    }


    public function adminSearchQuestions(Request $request){
        
        $users = array();

        $validator = Validator::make($request->all(), [
            'id' => 'integer|nullable',
            'name' => 'string|max:300|nullable'
        ]);

        if($validator->fails()){
            return redirect('/admin/dashboard/tags/')->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $id = $request->id;
        
        $where_arr = array();

        if($name){

            $name_where = ['name', 'LIKE', '%' . $name . '%'];
            array_push($where_arr, $name_where);

        } if ($id){

            $id_where = ['id', '=', $id];
            array_push($where_arr, $id_where);

        } if(empty($request->all())) {
            return '';
        }

        $tags = Tag::where($where_arr);

        if(empty($tags)){
            return $this->adminIndex();
        }
        return $this->adminIndex($tags);
    }


}
