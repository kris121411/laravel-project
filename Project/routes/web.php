<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/




Route::get('/',[ 'as' =>'login','middleware'=> 'check',function () {
   return view('login'); 
}]);
Route::get('/home',['middleware'=> 'recheck',function () {
    return view('home');
}]);
Route::get('/user',['middleware'=> 'recheck',function () {
    return view('user');
}]);
//Route::get('user/get_users','UserController@get_users');

Route::get('/permissionmodal','HomeController@get_tab2');
Route::get('/user/save_data',array('uses'=>'UserController@save_update_user'));
Route::get('/user/get_data_by_id',array('uses'=>'UserController@get_user_byid'));

Route::get('/home/permissions',['middleware'=> 'recheck','uses'=>'HomeController@redirectpermission']);
Route::get('home/get_tab','HomeController@get_tab');
Route::get('home/get_tabitems','HomeController@get_tabitems');

Route::get('login/authenticate','AuthController@authenticate');
Route::get('/logout',['middleware'=> 'recheck','uses'=>'AuthController@logout']);


Route::get('dashboard', 'HomeController@get_tab2'); 
Route::get('home', ['middleware'=> 'recheck','uses'=>'HomeController@get_tab2']); 

Route::get('permissionsmenu1',['uses'=>'UserController@get_users']);
Route::get('uploadform',['uses'=>'ImportExportController@get_user_table','as'=>'uploadfile']);
Route::get('downloadExcel/xlsx', 'ImportExportController@export_users');
Route::get('downloadTemplate/xlsx', 'ImportExportController@export_user_template');
Route::post('importExcel/xlsx', 'ImportExportController@importExcel');
Route::get('error',['middleware'=> 'recheck','as'=>'error','uses'=>'ErrorController@error1']);
