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

/*
Route::get('/', function () {
    return view('welcome');
});
*/
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
Route::post('/students', 'StudentsController@store');