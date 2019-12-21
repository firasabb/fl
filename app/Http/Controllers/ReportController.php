<?php

namespace App\Http\Controllers;

use App\Report;
use App\Question;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Crypt;

class ReportController extends Controller
{


    public function __construct(){

    }



    public function store(Request $request, $type){

        $validator = Validator::make($request->all(), [
            '_q' => 'required|string',
            'body' => 'required|string'
        ]);

        if($validator->fails()){

            return back()->withErrors($validator)->withInput();

        }

        if($type == 'question'){
            
            $_q = Crypt::decrypt($request->_q);
            var_dump($request->_q);
            $question = Question::findOrFail($_q);
            $report = new Report();
            $report->body = $request->body;
            $report->save();
            $report->reportable()->save($question);

            return back()->with('status', 'Your report has been successfully submitted! Thank you for helping us making the website a better place.');

        }
        


    }






    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex($reports = null)
    {
        $reports = Report::orderBy('id', 'desc')->paginate(20);
        return view('admin.reports.reports', ['reports' => $reports]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adminAdd(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function adminShow(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function adminEdit(Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function adminDestroy(Report $report)
    {
        //
    }

    public function adminSearchReports(){

    }

}