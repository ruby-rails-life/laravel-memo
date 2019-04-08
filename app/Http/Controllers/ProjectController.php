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
        $page = $request->input('page');
        $project_name = $request->input('project_name');
        $estimated_delivery_date_from = $request->input('estimated_delivery_date_from');
        $estimated_delivery_date_to = $request->input('estimated_delivery_date_to');
        $search_range = $request->input('search_range');
        $search_flg = $request->input('search_flg');
        
        if (empty($page) || $page == 1) {
            if (empty($search_flg) && $request->session()->exists('project.project_name')) {
                $project_name = $request->session()->get('project.project_name');
                $estimated_delivery_date_from = $request->session()->get('project.est_delivery_date_from');
                $estimated_delivery_date_to = $request->session()->get('project.est_delivery_date_to');
                $search_range = $request->session()->get('project.search_range');
            } elseif ($search_flg == "1") {
                $request->session()->put('project.project_name', $project_name);
                $request->session()->put('project.est_delivery_date_from', $estimated_delivery_date_from);
                $request->session()->put('project.est_delivery_date_to', $estimated_delivery_date_to);
                $request->session()->put('project.search_range', $search_range);
            }elseif ($search_flg == "2") {
                $request->session()->forget('project.project_name');
                $request->session()->forget('project.est_delivery_date_from');
                $request->session()->forget('project.est_delivery_date_to');
                $request->session()->forget('project.search_range');
            }

        }
        
        //クエリ生成
        switch ($search_range){
            case "1":
                $query = Project::query();
                break;
            case "2":
                $query = Project::onlyTrashed();
                break;
            case "3":
                $query = Project::withTrashed();
                break;
            default:
                $search_range = "1";
                $query = Project::query();
        }
        
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
        $projects = $query->orderBy('id','desc')->paginate(2);
        Log::debug('$projects="'.$projects.'""');

        $arrSearchRange = CommonFunctions::GetSearchRange();
        $arrProjectStatus = CommonFunctions::GetProjectStatus();

        return view('project.index', ['projects' => $projects,
            'project_name'=>$project_name,
            'estimated_delivery_date_from' =>$estimated_delivery_date_from,
            'estimated_delivery_date_to' =>$estimated_delivery_date_to,
            'search_range' => $search_range,
            'arrSearchRange' => $arrSearchRange,
            'arrProjectStatus' => $arrProjectStatus,               
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrProjectStatus = CommonFunctions::GetProjectStatus();
        return view('project.create',['arrProjectStatus'=>$arrProjectStatus]);
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
        $project = Project::withTrashed()->find($id);
        $arrProjectStatus = CommonFunctions::GetProjectStatus();
        return view('project.show', ['project' => $project,'arrProjectStatus'=>$arrProjectStatus]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::withTrashed()->find($id);
        $arrProjectStatus = CommonFunctions::GetProjectStatus();
        return view('project.edit', ['project' => $project,'arrProjectStatus'=>$arrProjectStatus]);
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
            $project->development_progress = $request->development_progress;
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
        Project::destroy($id);

        return redirect('/project');
    }

    public function restore($id)
    {
       Project::onlyTrashed()
        ->where('id', $id)
        ->restore();

       return redirect('/project');
       //return redirect()->route('project.index', ['search_range' => '3']);
    }

    public function csv_index()
    {
        return view('project.csv_index');
    }

    public function csv_import(Request $request)
    {
        setlocale(LC_ALL, 'ja_JP.UTF-8');

        $validator = $this->validateUploadFile($request);

        if ($validator->fails() === true){
            return redirect('/project/csv_index')->with('message', $validator->errors()->first('file_upload'));
        }
        // アップロードしたファイルを取得
        // 'file_upload' はCSVファイルインポート画面の inputタグのname属性
        $uploaded_file = $request->file('file_upload');

        // アップロードしたファイルの絶対パスを取得
        $file_path = $request->file('file_upload')->path($uploaded_file);
        $file = new \SplFileObject($file_path);
        $file->setFlags(
            \SplFileObject::READ_CSV |       // CSV 列として行を読み込む
            \SplFileObject::READ_AHEAD |     // 先読み/巻き戻しで読み出す。
            \SplFileObject::SKIP_EMPTY |     // 空行は読み飛ばす
            \SplFileObject::DROP_NEW_LINE    // 行末の改行を読み飛ばす
        );

        $row_count = 0;
        $column_name = [];
        $column_value = [];
        $array_csvdata = [];

        foreach ($file as $row)
        {
            if ($row_count == 0){
                $column_name = $this->getColumnName($row);
            } else {
                $data_div = 'ins';
                // 1行目のヘッダーは取り込まない
                for($i=0; $i<count($row); $i++){
                    $row[$i] = mb_convert_encoding($row[$i], 'UTF-8', 'SJIS'); 
                    if ($i == 0 && $row[$i] == '1') {
                        $data_div = 'del';
                    } else if($i==1 && !empty($row[$i])) {
                        if (empty($row[0])) $data_div = 'upd';
                        $column_value['id'] = $row[$i];
                    } else if ($i >= 2) {
                        $column_value[$column_name[$i]] = $row[$i];
                    } 
                }
                
                $validator = \Validator::make(
                    $column_value,
                    $this->defineValidationRules(),
                    $this->defineValidationMessages()
                );

                if ($validator->passes()) {
                    //array_push($array_csvdata[$data_div], $column_value);
                    $array_csvdata[$data_div][] = $column_value;
                } else {
                    return back()->withErrors($validator)->with('message', sprintf('%d行目データにエラーが発生しました。',$row_count));
                }
            }
            $row_count++;
        }

        $file = null;
        unlink($file_path);

        //追加した配列の数を数える
        if (isset($array_csvdata['ins'])) {
            $this->insertCsvData($array_csvdata['ins']);
        }

        //更新
        if (isset($array_csvdata['upd'])) {
            foreach ($array_csvdata['upd'] as $update_data) {
                $this->updateCsvData($update_data['id'], $update_data);
            }
        }

        //削除
        if (isset($array_csvdata['del'])) {
            foreach ($array_csvdata['del'] as $delete_data) {
                $this->deleteCsvData($delete_data['id']);
            }
        }

        return redirect('/project/csv_index')->with('message', '正常にインポートしました。');
    }

    private function validateUploadFile(Request $request)
    {
        return \Validator::make($request->all(), [
                'file_upload' => 'required|file|mimetypes:text/plain|mimes:csv,txt',
            ], [
                'file_upload.required'  => 'ファイルを選択してください。',
                'file_upload.file'      => 'ファイルアップロードに失敗しました。',
                'file_upload.mimetypes' => 'ファイル形式が不正です。',
                'file_upload.mimes'     => 'ファイル拡張子が異なります。',
            ]
        );
    }

    private function getColumnName() {
        $column_name = [
            'delete_flg',
            'id',
            'project_name',
            'order_date', 
            'estimated_delivery_date',
            'project_status',
            'development_progress',
        ];
        return $column_name;
    }

    private function defineValidationRules()
    {
        return [
            // CSVデータ用バリデーションルール
            'project_name' => 'required', 
        ];
    }

    /**
     * バリデーションメッセージの定義
     *
     * @return array
     */
    private function defineValidationMessages()
    {
        return [
            // CSVデータ用バリデーションエラーメッセージ
            'project_name.required' => 'プロジェクト名称を入力してください。',
        ];
    }

    private function insertCsvData($csvData) {
        $array_count = count($csvData);
        //もし配列の数が500未満なら
        if ($array_count < 500){
                //バルクインサート
            Project::insert($csvData);
        } else {
            //追加した配列が500以上なら、array_chunkで500ずつ分割する
            $array_partial = array_chunk($csvData, 500); //配列分割
   
            //分割した数を数えて
            $array_partial_count = count($array_partial); //配列の数
 
            //分割した数の分だけインポートを繰り替えす
            for ($i = 0; $i <= $array_partial_count - 1; $i++){
                Project::insert($array_partial[$i]);
            }
        }
    }

    private function updateCsvData($id, $csvData) {
        $project = Project::find($id);
        $project->project_name = $csvData['project_name'];
        $project->order_date = $csvData['order_date'];
        $project->project_status = $csvData['project_status'];
        $project->estimated_delivery_date = $csvData['estimated_delivery_date'];
        $project->development_progress = $csvData['development_progress'];
        $project->save();
    }

    private function deleteCsvData($id) {
        Project::destroy($id);
    }
}
