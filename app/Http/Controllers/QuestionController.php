<?php

namespace App\Http\Controllers;

use App\Question;
use App\Category;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

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


    public function adminShow($id)
    {
        $question = Question::findOrFail($id);
        $categories = Category::all();
        $hasCategories = $question->categories->pluck('id');
        return view('admin.questions.show', ['question' => $question, 'categories' => $categories, 'hasCategories' => $hasCategories]);
    }


    /**
     * 
     * Update the question
     * @param request
     * @return response
     * 
     */
    public function adminEdit(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:15|max:200',
            'description' => 'string|max:500|nullable',
            'categories' => 'required|array',
            'categories.*' => 'integer',
            'options' => 'array',
            'options.*' => 'string|max:200',
            'tags' => 'string|max:150'
        ]);

        if($validator->fails()){
            return redirect()->route('admin.show.question', ['id' => $id])->withErrors($validator)->withInput();
        } 

        $question->title = $request->title;
        $question->url = $request->url;
        $question->description = $request->description;
        $question->categories()->sync($request->categories);
        $tagsArr = array();
        $tags = $request->tags;
        $tags = explode(', ', $tags);
        foreach($tags as $tag){
            $tag = Tag::where('name', 'LIKE', $tag)->first();
            array_push($tagsArr, $tag->id);
        }
        $question->tags()->sync($tagsArr);
        //$question->options = $request->options;
        $question->save();

        return redirect()->route('admin.show.question', ['id' => $id])->with('status', 'This category has been edited');
    }


    public function adminDestroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();
        return redirect('/admin/dashboard/questions/')->with('status', 'The question has been deleted!');
    }


    public function adminSearchQuestions(Request $request){
        
        $validator = Validator::make($request->all(), [
            'id' => 'integer|nullable',
            'title' => 'string|nullable',
            'url' => 'string|nullable'
        ]);

        if($validator->fails() || empty($request->all())){
            return redirect()->route('admin.index.questions')->withErrors($validator)->withInput();
        }

        $id = $request->id;
        $title = $request->title;
        $url = Str::slug($request->url);
        
        $where_arr = array();

        if($id){

            $id_where = ['id', '=', $id];
            array_push($where_arr, $id_where);

        } if($title){

            $title_where = ['title', 'LIKE', '%' . $title . '%'];
            array_push($where_arr, $title_where);

        } if($url){

            $url_where = ['url', 'LIKE', '%' . $url . '%'];
            array_push($where_arr, $url_where);

        }

        $questions = Question::where($where_arr);

        if(empty($questions)){
            return $this->adminIndex();
        }
        return $this->adminIndex($questions);
    }


}
