<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Validator;
use App\Libraries\CommonFunctions;
use Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Exports\ProjectExport;
use App\Imports\ProjectImport;
use Intervention\Image\Facades\Image;
use Response;
use App\Events\ProjectCreated;
use App\Events\ProjectUpdated;
use App\Events\ProjectDeleted;
use App\Notifications\ProjectCreatedNotification;
use App\Notifications\ProjectCreatedMarkDown;

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
        
        $query = $this->queryConds(
            $project_name, 
            $estimated_delivery_date_from, 
            $estimated_delivery_date_to,
            $search_range
        );
        
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

    private function queryConds(
        $project_name, 
        $estimated_delivery_date_from, 
        $estimated_delivery_date_to,
        $search_range) {
        
        //クエリ生成
        switch ($search_range){
            case "1":
                $query = Project::with(['Sales', 'Developer']);
                break;
            case "2":
                $query = Project::onlyTrashed()->with(['Sales', 'Developer']);
                break;
            case "3":
                $query = Project::withTrashed()->with(['Sales', 'Developer']);
                break;
            default:
                $query = Project::with(['Sales', 'Developer']);
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

        return $query;
    }

    private function getQueryByConds($input) {
        $project_name = isset($input['project_name']) ?  $input['project_name'] : '';
        $estimated_delivery_date_from = isset($input['estimated_delivery_date_from']) ? $input['estimated_delivery_date_from'] : '';
        $estimated_delivery_date_to = isset($input['estimated_delivery_date_to']) ? $input['estimated_delivery_date_to'] : '';
        $search_range = isset($input['search_range']) ? $input['search_range'] : '';

        $query = $this->queryConds(
            $project_name, 
            $estimated_delivery_date_from, 
            $estimated_delivery_date_to,
            $search_range
        );
        
        return $query;
    }

    private function getProjectsByConds($input) {
        
        $query = $this->getQueryByConds($input);
        
        $projects = $query->orderBy('id','asc')->get();

        return $projects;
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
            //'project_image' => 'required|file|mimetypes:image/jpeg|mimes:jpg,jpeg',
        ];

        $messages = array(
            //'project_image.required'  => 'ファイルを選択してください。',
            'project_image.file'      => 'ファイルアップロードに失敗しました。',
            'project_image.mimetypes' => 'ファイル形式が不正です。',
            'project_image.mimes'     => 'ファイル拡張子が異なります。',
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->passes()) {

            $project_image = "";
            $input = $request->all();

            if (isset($input['project_image'])) {
                $fileName = $input['project_image']->getClientOriginalName();
                $fileName = time()."@".$fileName;
                $image = Image::make($input['project_image']->getRealPath());
 
                //画像リサイズ ※追加
                // $image->resize(100, null, function ($constraint) {
                //     $constraint->aspectRatio();
                // });
                //$image->resize(100,100);
                //$image->fit(50);
                //$image->crop(100, 100);
                //$image->trim('top-left', 'left');
                //$image->resize(100,100)->greyscale();
                //$image->resize(100,100)->invert();
                //$image->resize(100,100)->flip('v');
                //$image->resize(100,100)->pixelate(12);
                
                $project_image = 'images/' . $fileName;

                if ($image->width() < 100) {
                    $background_img = \Image::canvas(100, 100);
                    $background_img->fill('#ffffff');
                    $background_img->insert($image, 'center'); 
                    $background_img->save(public_path() . '/' . $project_image);
                }else {
                    $image->fit(100, 100, function ($constraint) {
                        $constraint->upsize();
                    });
                    $image->save(public_path() . '/' . $project_image);
                }
            }
                        
            $project = new Project;
            $project->project_name = $input['project_name'];
            $project->order_date = $input['order_date'];
            $project->project_status = $input['project_status'];
            $project->estimated_delivery_date = $input['estimated_delivery_date'];
            $project->sales_staff_id = Auth::user()->id;
            if (!empty($project_image))  $project->project_image = $project_image;
            
            $project->save();

            //イベント
            event(new ProjectCreated($project));
            //通知
            $project->notify(new ProjectCreatedMarkDown($project));
            //$project->notify(new ProjectCreatedNotification($project));
            // \Notification::route('mail', 'xxx@yyy.com')
            //     ->notify(new ProjectCreatedNotification($project));

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

            event(new ProjectUpdated($project));

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
        $project = Project::find($id);

        Project::destroy($id);
       
        event(new ProjectDeleted($project));
        
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

    /**
     * CSVダウンロード
     */
    public function csv_download_old(Request $request)
    {
        $input = $request->input();
        $query = $this->getQueryByConds($input);
               
        return  new StreamedResponse(
            function () {
                $stream = fopen('php://output', 'w');
                // ExcelでUTF-8と認識させるためにBOMを付ける
                //fwrite($stream, '\xEF\xBB\xBF');
                $header = ['プロジェクトID', 'プロジェクト名称', '受注日'];
                mb_convert_variables("SJIS-win", "UTF-8", $header);
                fputcsv($stream, $header);

                Project::chunk(1000, function ($projects) use ($stream) {
                    foreach ($projects as $project) {
                        mb_convert_variables("SJIS-win", "UTF-8", $project);
                        fputcsv($stream, [
                            $project->id, 
                            $project->project_name,
                            $project->order_date
                        ]);
                    }
                });

                fclose($stream);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="projects.csv"',
            ]
        );
    }

    /**
     * CSVダウンロード
     */
    public function csv_download(Request $request)
    {
        $input = $request->input();
        $query = $this->getQueryByConds($input);
               
        $stream = fopen('php://output', 'w');
        // ExcelでUTF-8と認識させるためにBOMを付ける
        //fwrite($stream, '\xEF\xBB\xBF');
        $header = ['プロジェクトID', 'プロジェクト名称', '受注日'];
        mb_convert_variables("SJIS-win", "UTF-8", $header);
        fputcsv($stream, $header);

        $query->chunk(1000, function ($projects) use ($stream) {
            foreach ($projects as $project) {
                mb_convert_variables("SJIS-win", "UTF-8", $project);
                fputcsv($stream, [
                    $project->id, 
                    $project->project_name,
                    $project->order_date
                ]);
            }
        });

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="projects.csv"'
        ];

        return Response::make(
            stream_get_contents($stream),
            200,
            $headers
        );
    }

    /**
     * Excelダウンロード
     */
    public function excel_download(Request $request)
    {
        $input = $request->input();
        $projects = $this->getProjectsByConds($input);
        $view = \view('project.excel_download', ['projects'=>$projects]);
        return \Excel::download(new ProjectExport($view), 'projects.xlsx');
    }

    /**
     * PDFダウンロード
     */
    public function pdf_download(Request $request)
    {
        $input = $request->input();
        $projects = $this->getProjectsByConds($input);
        // //$pdf = app('dompdf.wrapper');
        // //$pdf->loadView('project.pdf_download', ['projects' => $projects]);
        $pdf = \PDF::loadView('project.pdf_download', ['projects' => $projects]);
        
        return $pdf->stream('sample.pdf');
        // PDFをダウンロードさせたい場合は下記を return します。
        //return $pdf->download('projects.pdf'); 
    }


    /**
     * Excelインポート
     */
    public function excel_index()
    {
        return view('project.excel_index');
    }
    
    public function excel_import(Request $request)
    {
        setlocale(LC_ALL, 'ja_JP.UTF-8');

        $validator = \Validator::make($request->all(), [
                'file_upload' => 'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|mimes:xlsx',
            ], [
                'file_upload.required'  => 'ファイルを選択してください。',
                'file_upload.file'      => 'ファイルアップロードに失敗しました。',
                'file_upload.mimetypes' => 'ファイル形式が不正です。',
                'file_upload.mimes'     => 'ファイル拡張子が異なります。',
            ]
        );
;

        if ($validator->fails() === true){
            return redirect('/project/excel_index')->with('message', $validator->errors()->first('file_upload'));
        }
        // アップロードしたファイルを取得
        // 'file_upload' はCSVファイルインポート画面の inputタグのname属性
        $uploaded_file = $request->file('file_upload');

        // アップロードしたファイルの絶対パスを取得
        $file_path = $request->file('file_upload')->path($uploaded_file);

        \Excel::import(new ProjectImport, $file_path);

        return redirect('/project/excel_index')->with('message', '正常にインポートしました。');
    }

    /**
     * CSVインポート
     */
    public function csv_index()
    {
        return view('project.csv_index');
    }

    public function csv_import(Request $request)
    {
        Log::debug('Import 開始時間'. date("Y/m/d H:m:s"));

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
    
        $temp_table_sql = <<< TEMP_TABLE
            CREATE TEMPORARY TABLE csv_table (
                line_num int(10) UNSIGNED NOT NULL, 
                delete_flg varchar(1) DEFAULT NULL,
                id varchar(100) DEFAULT NULL,
                project_name varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                order_date date DEFAULT NULL,
                estimated_delivery_date date DEFAULT NULL,
                project_status varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                development_progress tinyint(4) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        TEMP_TABLE;
        DB::statement($temp_table_sql);

        $file_path = 'C:/wks/laravel_import_csv.csv';
        $new_line = '\r\n';

        $load_data_cmd = <<< LOAD_DATA
            LOAD DATA LOCAL INFILE '$file_path' INTO TABLE csv_table CHARACTER SET UTF8 FIELDS TERMINATED BY ',' LINES TERMINATED BY '$new_line' IGNORE 1 LINES (line_num,delete_flg,id,project_name,order_date,estimated_delivery_date,project_status,development_progress); 
        LOAD_DATA;

      $pdo = DB::connection()->getPdo();  
      // $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      // $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
      // $pdo->setAttribute(\PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES UTF8");
      // $pdo->setAttribute(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
      // $pdo->setAttribute(\PDO::MYSQL_ATTR_LOCAL_INFILE, true);
$stmt = $pdo->prepare($load_data_cmd,array(\PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));
$stmt->execute();


        //$pdo = DB::connection()->getPdo()->prepare($load_data_cmd);
        //$pdo->execute();
        //DB::statement($load_data_cmd);

        //$this->insertCsvData('csv_table', $array_csvdata);
        //DB::table('csv_table')->insert($array_csvdata);
        
        $insert_sql = <<< INSERT_SQL
            INSERT INTO projects(
                project_name,
                order_date,
                estimated_delivery_date,
                project_status,
                development_progress
            )
            SELECT project_name,
                   order_date,
                   estimated_delivery_date,
                   project_status,
                   development_progress
              FROM csv_table
             WHERE delete_flg = ''
               AND id = '' 
        INSERT_SQL;

        DB::statement($insert_sql);

        $update_sql = <<< UPDATE_SQL
            UPDATE projects proj,
                   csv_table csv
               SET proj.project_name = csv.project_name,
                   proj.order_date = csv.order_date,
                   proj.estimated_delivery_date = csv.estimated_delivery_date,
                   proj.project_status = csv.project_status,
                   proj.development_progress = csv.development_progress
             WHERE csv.delete_flg = ''
               AND csv.id <> ''
               AND proj.id = csv.id  
        UPDATE_SQL;

        DB::statement($update_sql);

        // $delete_sql = <<< DELETE_SQL
        //     DELETE proj FROM projects proj
        //      INNER JOIN csv_table csv
        //         ON proj.id = csv.id
        //      WHERE csv.delete_flg = '1'  
        // DELETE_SQL;

        // DB::statement($delete_sql);

        $delete_sql = <<< DELETE_SQL
            UPDATE projects proj,
                   csv_table csv
               SET proj.deleted_at = CURRENT_TIMESTAMP 
             WHERE csv.delete_flg = '1'
               AND csv.id <> ''
               AND proj.id = csv.id  
        DELETE_SQL;

        DB::statement($delete_sql);

        // $file = new \SplFileObject($file_path);
        // $file->setFlags(
        //     \SplFileObject::READ_CSV |       // CSV 列として行を読み込む
        //     \SplFileObject::READ_AHEAD |     // 先読み/巻き戻しで読み出す。
        //     \SplFileObject::SKIP_EMPTY |     // 空行は読み飛ばす
        //     \SplFileObject::DROP_NEW_LINE    // 行末の改行を読み飛ばす
        // );

        // $array_csvdata = $this->makeCsvDataTemp($file);

        $file = null;
        unlink($file_path);
       
        
        Log::debug('Import 終了時間'. date("Y/m/d H:m:s"));

        return redirect('/project/csv_index')->with('message', '正常にインポートしました。');
    }

    public function csv_import_2(Request $request)
    {
        Log::debug('Import 開始時間'. date("Y/m/d H:m:s"));

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

        // CSVの中身に対するバリデーションを実施
        $csv_errors = $this->validateCsvData($file);
        if (count($csv_errors) >= 1) {
            $file = null;
            unlink($file_path);
            return redirect()->route('project.csv_index')->with('errors',$csv_errors);
        }

        $array_csvdata = $this->makeCsvData($file);

        $file = null;
        unlink($file_path);
       
        //追加した配列の数を数える
        if (isset($array_csvdata['ins'])) {
            //$this->insertCsvData($array_csvdata['ins']);
            $this->insertCsvData('projects', $array_csvdata['ins']);
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

        Log::debug('Import 終了時間'. date("Y/m/d H:m:s"));

        return redirect('/project/csv_index')->with('message', '正常にインポートしました。');
    }

    private function validateCsvData($file) {
        // バリデーションルール生成
        $csv_errors = [];
        $csv_id_list = [];
        $arrProjectStatus = CommonFunctions::GetProjectStatus();
        $column_name = $this->getColumnName();
        $error_msg = "";
                
        foreach ($file as $line_num => $line) {
            if (0 === $line_num || 1 === count($line)) {
                // 最初の行または空行など余分な空白がCSVの途中に混ざっている場合は無視
                continue;
            }
            if (count($line) !== 7) {
                $error_msg = sprintf("Line %d : カラム数が不正です", $line_num);
                $csv_errors = array_merge($csv_errors, [$error_msg]);
            }

            for($i=0; $i<count($line); $i++){
                $line[$i] = mb_convert_encoding($line[$i], 'UTF-8', 'SJIS'); 
                $column_value[$column_name[$i]] = $line[$i];
            }    

            if (empty($column_value['delete_flg'])) {
                $validator = \Validator::make(
                    $column_value,
                    $this->defineValidationRules(),
                    $this->defineValidationMessages()
                );

                if ($validator->fails()) {
                    $cur_error = [];
                    foreach ($validator->errors()->all() as $error) {
                        $error_msg = sprintf("Line %d : %s", $line_num, $error);
                        $cur_error[] = $error_msg;
                    }
                    $csv_errors = array_merge($csv_errors, $cur_error);
                    continue;
                }

                if (!empty($column_value['project_status']) && !isset($arrProjectStatus[$column_value['project_status']])) {
                    $error_msg = sprintf("Line %d : ステータス[%s]は無効です", $line_num, $column_value['project_status']);
                    $csv_errors = array_merge($csv_errors, [$error_msg]);
                }                
            }

            // Update, Delete
            if ($column_value['id']) {
                if (!Project::where('id', '=', $column_value['id'])->exists()) {
                    $error_msg = sprintf("Line %d : [ID=%s]のプロジェクトが存在しません", $line_num,$column_value['id']);
                    $csv_errors = array_merge($csv_errors, [$error_msg]);
                }
                       
                // CSV内でIDが重複していないかチェック
                if (!isset($csv_id_list[$column_value['id']])) {
                    $csv_id_list[$column_value['id']] = $column_value['id'];
                } else {
                    $error_msg = sprintf("Line %d : [ID=%s]がCSV内で重複しています", $line_num,$column_value['id']);
                    $csv_errors = array_merge($csv_errors, [$error_msg]);
                }
            }
        }

        return $csv_errors;
    }

    private function makeCsvDataTemp($file) {
        $row_count = 0;
        $column_name = [];
        $column_value = [];
        $array_csvdata = [];

        foreach ($file as $row)
        {
            if ($row_count == 0){
                $column_name = $this->getColumnName();
            } else {
                // 1行目のヘッダーは取り込まない
                $column_value['line_num'] = $row_count;
                for($i=0; $i<count($row); $i++){
                    $row[$i] = mb_convert_encoding($row[$i], 'UTF-8', 'SJIS'); 
                    $column_value[$column_name[$i]] = $row[$i];
                }
                array_push($array_csvdata, $column_value);
            }
            $row_count++;
        }

        return $array_csvdata;
    }

    private function makeCsvData($file) {
        $row_count = 0;
        $column_name = [];
        $column_value = [];
        $array_csvdata = [];

        foreach ($file as $row)
        {
            if ($row_count == 0){
                $column_name = $this->getColumnName();
            } else {
                $data_div = 'ins';
                // 1行目のヘッダーは取り込まない
                for($i=0; $i<count($row); $i++){
                    $row[$i] = mb_convert_encoding($row[$i], 'UTF-8', 'SJIS'); 
                    if ($i == 0 && $row[$i] == '1') {
                        $data_div = 'del';
                    } else if($i==1 && !empty($row[$i])) {
                        $column_value['id'] = $row[$i];
                        if (empty($row[0])) $data_div = 'upd';
                    } else if ($i >= 2) {
                        $column_value[$column_name[$i]] = $row[$i];
                    } 
                }
                //array_push($array_csvdata[$data_div], $column_value);
                $array_csvdata[$data_div][] = $column_value;
            }
            $row_count++;
        }

        return $array_csvdata;
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

    private function insertCsvData($tableName, $csvData) {
        $array_count = count($csvData);
        //もし配列の数が500未満なら
        if ($array_count < 500){
                //バルクインサート
            //Project::insert($csvData);
            DB::table($tableName)->insert($csvData);
        } else {
            //追加した配列が500以上なら、array_chunkで500ずつ分割する
            $array_partial = array_chunk($csvData, 500); //配列分割
   
            //分割した数を数えて
            $array_partial_count = count($array_partial); //配列の数
 
            //分割した数の分だけインポートを繰り替えす
            for ($i = 0; $i <= $array_partial_count - 1; $i++){
                //Project::insert($array_partial[$i]);
                DB::table($tableName)->insert($array_partial[$i]);
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
