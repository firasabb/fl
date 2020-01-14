<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AnswerController extends Controller
{
    /**
     * Display a listing of the answers.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex($answers = null)
    {
        if(!$answers){
            $answers = Answer::orderBy('id', 'desc')->paginate(20);
        } else {
            $answers = $answers->paginate(20);
        }
        return view('admin.answers.answers', ['answers' => $answers]);
    }

    /**
     * Save the answer into the database.
     * @param encryptedid
     * @return \Illuminate\Http\Response
     */
    public function store($encryptedId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'description' => 'max:2500|nullable',
        ]);

        if($validator->fails() || !$encryptedId){
            return redirect()->back()->withErrors()->withInput();
        }
        $question = Question::findOrFail(decrypt($encryptedId));
        $user = Auth::user();
        $answer = new Answer();
        $answer->title = $request->title;
        $answer->description = $request->description;
        $answer->question_id = $question->id;
        $user->answers()->save($answer);
        $answer->save();

        return redirect()->back()->with('status', 'Your answer has been added successfully!');
    }



    /**
     * Show answer page for admins and moderators
     * 
     * @param answer id
     * @return response
     */
    public function adminShow($id)
    {
        $answer = Answer::findOrFail($id);
        return view('admin.answers.show', ['answer' => $answer]);
    }


    /**
     * Delete answer for admins and moderators
     * 
     * @param answer id
     * @return response
     */
    public function adminDestroy($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();
        return redirect()->route('admin.index.answers')->with('status', 'The question has been deleted!');
    }


    /**
     * 
     * Update the answer
     * @param request
     * @return response
     * 
     */
    public function adminEdit(Request $request, $id)
    {
        $answer = Answer::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:40',
            'description' => 'string'
        ]);

        if($validator->fails()){
            return redirect()->route('admin.show.answer', ['id' => $id])->withErrors($validator)->withInput();
        } 

        $answer->title = $request->title;
        $answer->description = $request->description;
        $answer->save();

        return redirect()->route('admin.show.answer', ['id' => $id])->with('status', 'This category has been edited');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }


    public function adminSearchAnswers(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'integer|nullable',
            'question_id' => 'integer|nullable',
            'title' => 'string|nullable',
            'description' => 'string|nullable'
        ]);

        if($validator->fails() || empty($request->all())){
            return redirect()->route('admin.index.answers')->withErrors($validator)->withInput();
        }

        $id = $request->id;
        $question_id = $request->question_id;
        $title = $request->title;
        $description = $request->description;
        $where_arr = array();

        if($id){

            $id_where = ['id', '=', $id];
            array_push($where_arr, $id_where);

        } if($question_id){

            $question_id_where = ['question_id', '=', $question_id];
            array_push($where_arr, $question_id_where);

        } if($title){

            $title_where = ['title', 'LIKE', '%' . $title . '%'];
            array_push($where_arr, $title_where);

        } if($description){

            $description_where = ['description', 'LIKE', '%' . $description . '%'];
            array_push($where_arr, $description_where);

        }

        $answers = Answer::where($where_arr);

        if(empty($answers)){
            return $this->adminIndex();
        }
        return $this->adminIndex($answers);
    }
}
