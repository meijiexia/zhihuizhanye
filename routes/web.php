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

Route::get('/', function () {
    return view('welcome');
});
//企业查询
Route::match(['get','post'],'enterpriseList', '\App\Http\Controllers\enterpriseQueryController@enterpriseList');
//企业查询
Route::match(['get','post'],'basicMsg', '\App\Http\Controllers\enterpriseQueryController@basicMsg');
//股东信息
Route::match(['get','post'],'shareholder', '\App\Http\Controllers\enterpriseQueryController@shareholder');
//主要人员
Route::match(['get','post'],'keyPersonnel', '\App\Http\Controllers\enterpriseQueryController@keyPersonnel');
//工商变更
Route::match(['get','post'],'alteration', '\App\Http\Controllers\enterpriseQueryController@alteration');