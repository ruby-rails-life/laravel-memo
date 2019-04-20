<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\RelationNullable;
use App\Http\Resources\RelationNullable as RelNullResource;
use App\Http\Resources\RelationNullableCollection as RelNullCollection;

Route::get('/welcome', function () {
    $locale = App::getLocale();
    session(['mySessionKey' => 'mySessionValue']);
    return view('welcome', ['locale' => $locale]);
})->middleware(['locale']);

Route::get('/', 'ArticleController@index');

Route::get('create', 'ArticleController@create');
Route::post('create', 'ArticleController@store');
Route::get('edit/{id}', 'ArticleController@edit');
Route::post('edit', 'ArticleController@update');
Route::get('delete/{id}', 'ArticleController@show');
Route::post('delete', 'ArticleController@delete');

Route::resource('posts', 'PostController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['web']], function () {

    //普通の一覧用
    Route::get('/','ArticleController@index');

    //JSON API
    Route::get('json','ArticleController@json');

    //APIを呼び出す一覧用
    Route::get('ajax','ArticleController@ajax');

});

Route::resource('/photos', 'PhotosController', ['only' => ['create', 'store','index']]);

# 入力画面
Route::get('bmi/form', [
  'uses' => 'BmiCalController@getIndex',
  'as' => 'bmi.form'
]);
 
# 計算結果
Route::post('bmi/result', [
  'uses' => 'BmiCalController@result',
  'as' => 'bmi.result'
]);

Route::get('/students', 'StudentsController@create');
Route::post('/students', 'StudentsController@store')->middleware('can:admin,App\Student');

Route::group(['middleware' => ['auth']], function () {
  // この中はログインされている場合のみルーティングされる
  Route::get('/todo', function () {
    return view('vue.todo');
  });

  Route::get('/user', 'UserController@index');

  Route::resource('/clover','CloverController');
  Route::get('/clover/restore/{clover_name}', 'CloverController@restore');
  Route::post('/clover/delete/{clover_name}', 'CloverController@delete');
  Route::get('/clover/editRelationMtm/{clover_name}', 'CloverController@editRelationMtm');
  Route::post('/clover/updateRelationMtm/{clover_name}', 'CloverController@updateRelationMtm');
  Route::get('/clover_json', 'CloverController@getJson');
  Route::get('/clover_makejson', 'CloverController@getMakeJson');


  Route::resource('/relationHm', 'RelationHmController', ['only' => ['create', 'store','index','show']]);
  Route::post('/relationHm/createThought/{id}', 'RelationHmController@createThought');

  Route::resource('/relationMtm', 'RelationMtmController', ['only' => ['create', 'store','index','show']]);
  Route::get('/relationMtm_res','RelationMtmController@relationMtm_res');
  
  Route::resource('/relationHmt', 'RelationHmtController', ['only' => ['create', 'store','index','show']]);
  Route::post('/relationHmt/createThought/{id}', 'RelationHmtController@createThought');

  Route::resource('/relationNullable', 'RelationNullableController');
  Route::post('/relationNullable/dissociate/{id}', 'RelationNullableController@dissociate');
  Route::get('/relationNullable_res', function () {
    return (new RelNullResource(RelationNullable::find(1)))
        ->response()
        ->header('X-Value', 'True');
    //return new RelNullResource(RelationNullable::all());
  });
  Route::get('/relationNullable_col', function () {
    //return new RelNullCollection(RelationNullable::all());
    //return new RelNullCollection(RelationNullable::paginate());
    return (new RelNullCollection(RelationNullable::all()))
                ->additional(['meta' => [
                    'hello' => 'world',
                ]]);
  });
 
  Route::get('/image', 'ImageController@index');
  Route::get('/thought', 'ThoughtController@index');
  Route::get('/category', 'CategoryController@index');

  Route::get('/file', 'FileController@index');  


  Route::post('/project/{id}/restore', 'ProjectController@restore');
  Route::get('/project/csv_index', 'ProjectController@csv_index')->name('project.csv_index');
  Route::post('/project/csv_import', 'ProjectController@csv_import');
  Route::get('/project/csv_download', 'ProjectController@csv_download')->name('project.csv_download');
  Route::get('/project/excel_download', 'ProjectController@excel_download')->name('project.excel_download');
  Route::get('/project/pdf_download', 'ProjectController@pdf_download')->name('project.pdf_download');
  Route::get('/project/excel_index', 'ProjectController@excel_index')->name('project.excel_index');
  Route::post('/project/excel_import', 'ProjectController@excel_import');
  Route::get('/project/{id}/mailable', 'ProjectController@mailable');
  Route::resource('/project', 'ProjectController');

});


Route::group(['prefix' => 'admin'], function() {
  Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('admin.login');
  Route::post('login', 'Admin\Auth\LoginController@login')->name('admin.login');
  Route::post('logout', 'Admin\Auth\LoginController@logout')->name('admin.logout');
  Route::get('register', 'Admin\Auth\RegisterController@showRegisterForm')->name('admin.register');
  Route::post('register', 'Admin\Auth\RegisterController@register')->name('admin.register');
  Route::get('home', 'Admin\HomeController@index')->name('admin.home');
  
  Route::get('password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
  Route::post('password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
  Route::get('password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
  Route::post('password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('admin.password.update');


});