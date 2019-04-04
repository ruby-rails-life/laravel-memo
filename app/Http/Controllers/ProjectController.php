<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Validator;
use App\Libraries\CommonFunctions;
use Log;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //プロジェクト名称
        $project_name = $request->input('project_name');
        $estimated_delivery_date_from = $request->input('estimated_delivery_date_from');
        $estimated_delivery_date_to = $request->input('estimated_delivery_date_to');
        
        //クエリ生成
        $query = Project::query();
 
        //プロジェクト名称がある場合
        if(!empty($project_name))
        {
            $query->where('project_name','like',"%$project_name%");
        }
        if(!empty($estimated_delivery_date_from))
        {
            $query->where('estimated_delivery_date','>=',$estimated_delivery_date_from);
        }
        if(!empty($estimated_delivery_date_to))
        {
            $query->where('estimated_delivery_date','<=',$estimated_delivery_date_to);
        }
        
        //DEBUG
        $projects_sql = $query->toSql();
        Log::debug('$projects_sql="'.$projects_sql.'""');

        //ページネーション
        $projects = $query->orderBy('created_at','desc')->paginate(2);
        Log::debug('$projects="'.$projects.'""');

        return view('project.index', ['projects' => $projects,
            'project_name'=>$project_name,
            'estimated_delivery_date_from' =>$estimated_delivery_date_from,
            'estimated_delivery_date_to' =>$estimated_delivery_date_to   
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ArrProjectStatus = CommonFunctions::GetProjectStatus();
        return view('project.create',['arrProjectStatus'=>$ArrProjectStatus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'project_name' => 'required', 
        ];

        $messages = array(
            'project_name.required' => 'ProjectNameを入力してください。',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            
            $project = new Project;
            $project->project_name = $request->project_name;
            $project->order_date = $request->order_date;
            $project->project_status = $request->project_status;
            $project->estimated_delivery_date = $request->estimated_delivery_date;
            $project->sales_staff_id = Auth::user()->id;
            $project->save();
 
            return redirect('/project')->with('message', '新規登録が完了しました。');

        } else {
            return back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        $ArrProjectStatus = CommonFunctions::GetProjectStatus();
        return view('project.show', ['project' => $project,'arrProjectStatus'=>$ArrProjectStatus]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::find($id);
        $ArrProjectStatus = CommonFunctions::GetProjectStatus();
        return view('project.edit', ['project' => $project,'arrProjectStatus'=>$ArrProjectStatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'project_name' => 'required', 
        ];

        $messages = array(
            'project_name.required' => 'ProjectNameを入力してください。',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {
            $project = Project::find($id);
            $project->project_name = $request->project_name;
            $project->order_date = $request->order_date;
            $project->project_status = $request->project_status;
            $project->estimated_delivery_date = $request->estimated_delivery_date;
            $project->save();

            return redirect('/project')->with('message', '編集が完了しました。');
        }else{
            return back()->withErrors($validator)->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
