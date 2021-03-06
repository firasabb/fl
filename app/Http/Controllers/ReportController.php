<?php

namespace App\Http\Controllers;

use App\Report;
use App\Art;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Crypt;
use Auth;
use DB;

class ReportController extends Controller
{


    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex($reports = null)
    {
        if(!$reports){
            $reports = Report::orderBy('id', 'desc')->paginate(20);
        } else {
            $reports = $reports->paginate(20);
        }
        $report_types = DB::table('reports')->select('reportable_type')->groupBy('reportable_type')->get();
        foreach($report_types as $report_type){
            $report_type->reportable_type = stripslashes(str_replace('App', '', $report_type->reportable_type));
        }
        return view('admin.reports.reports', ['reports' => $reports, 'report_types' => $report_types]);
    }




    /**
     * 
     * Save the report in the database
     * @param Request
     * @return Response
     * 
     */
    public function store(Request $request, $type){

        $validator = Validator::make($request->all(), [
            '_q' => 'required|string',
            'body' => 'required|string'
        ]);

        if($validator->fails()){

            return back()->withErrors($validator)->withInput();

        }

        if($type == 'art'){
            
            $_q = decrypt($request->_q);
            $user = Auth::user();
            $art = Art::findOrFail($_q);
            $report = new Report();
            $report->body = $request->body;
            $report->reportable()->associate($art);
            $user->reports()->save($report);
            $report->save();

            return back()->with('status', 'Your report has been successfully submitted! Thank you for helping us making the website a better place.');

        }

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function adminShow($id)
    {
        $report = Report::findOrFail($id);
        return view('admin.reports.show', ['report' => $report]);
    }

    /**
     * Delete the report for admins.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function adminDestroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();
        return redirect()->route('admin.index.reports')->with('message', 'The report has been deleted');
    }

    public function adminSearchReports(Request $request){

        $validator = Validator::make($request->all(), [
            'id' => 'integer|nullable',
            'reportable_id' => 'integer|nullable',
            'reportable_type' => 'string'
        ]);

        if($validator->fails() || empty($request->all())){
            return redirect()->route('admin.index.reports')->withErrors($validator)->withInput();
        }

        $id = $request->id;
        $reportable_id = $request->reportable_id;
        $reportable_type = $request->reportable_type;
        $where_arr = array();

        if($id){

            $id_where = ['id', '=', $id];
            array_push($where_arr, $id_where);

        } if($reportable_type){

            $reportable_type_where = ['reportable_type', 'LIKE', '%' . $reportable_type];
            array_push($where_arr, $reportable_type_where);

        } if($reportable_id){

            $reportable_id_where = ['reportable_id', '=', $reportable_id];
            array_push($where_arr, $reportable_id_where);

        }

        $reports = Report::where($where_arr);

        if(empty($reports)){
            return $this->adminIndex();
        }
        return $this->adminIndex($reports);
    }


}
