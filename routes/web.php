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


Route::get('/welcome', function () {
    return view('welcome');
});

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

  Route::resource('/relationHm', 'RelationHmController', ['only' => ['create', 'store','index','show']]);
  Route::resource('/relationMtm', 'RelationMtmController', ['only' => ['create', 'store','index']]);
  Route::resource('/relationHmt', 'RelationHmtController', ['only' => ['create', 'store','index','show']]);

  Route::get('/image', 'ImageController@index');
});