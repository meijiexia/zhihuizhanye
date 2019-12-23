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
//联系方式
Route::match(['get','post'],'Contact', '\App\Http\Controllers\enterpriseQueryController@Contact');
//员工人脉
Route::match(['get','post'],'Employee', '\App\Http\Controllers\enterpriseQueryController@Employee');







//高级筛选获取条件组
Route::match(['get','post'],'conditionGroup', '\App\Http\Controllers\CompanyScreenController@conditionGroup');
Route::match(['get','post'],'conditionList', '\App\Http\Controllers\CompanyScreenController@conditionList');
Route::match(['get','post'],'companyList', '\App\Http\Controllers\CompanyScreenController@companyList');
Route::match(['get','post'],'turnClue', '\App\Http\Controllers\CompanyScreenController@turnClue');
Route::match(['get','post'],'recommendCompany', '\App\Http\Controllers\CompanyScreenController@recommendCompany');