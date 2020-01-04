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
//企业名称补全
Route::match(['get','post'],'companyNameCompletion', '\App\Http\Controllers\EnterpriseQueryController@companyNameCompletion');
//企业查询
Route::match(['get','post'],'enterpriseList', '\App\Http\Controllers\EnterpriseQueryController@enterpriseList');
//企业基本信息
Route::match(['get','post'],'companyBasicMsg', '\App\Http\Controllers\EnterpriseQueryController@companyBasicMsg');
//企业查询
Route::match(['get','post'],'basicMsg', '\App\Http\Controllers\EnterpriseQueryController@basicMsg');
//股东信息
Route::match(['get','post'],'shareholder', '\App\Http\Controllers\EnterpriseQueryController@shareholder');
//主要人员
Route::match(['get','post'],'keyPersonnel', '\App\Http\Controllers\EnterpriseQueryController@keyPersonnel');
//工商变更
Route::match(['get','post'],'alteration', '\App\Http\Controllers\EnterpriseQueryController@alteration');
//联系方式
Route::match(['get','post'],'Contact', '\App\Http\Controllers\EnterpriseQueryController@Contact');
//员工人脉
Route::match(['get','post'],'Employee', '\App\Http\Controllers\EnterpriseQueryController@Employee');
//设置企业查询条件组
Route::match(['get','post'],'conditionGroupSet', '\App\Http\Controllers\EnterpriseQueryController@conditionGroupSet');
//获取企业查询条件组
Route::match(['get','post'],'conditionGroupGet', '\App\Http\Controllers\EnterpriseQueryController@conditionGroupGet');
//删除企业查询条件组
Route::match(['get','post'],'conditionGroupDel', '\App\Http\Controllers\EnterpriseQueryController@conditionGroupDel');
//公司发展融资历史接口
Route::match(['get','post'],'companyDevelopmentFinancing', '\App\Http\Controllers\EnterpriseQueryController@companyDevelopmentFinancing');
//公司发展创始团队接口
Route::match(['get','post'],'companyDevelopmentTeam', '\App\Http\Controllers\EnterpriseQueryController@companyDevelopmentTeam');
//公司发展相似产品接口
Route::match(['get','post'],'companyDevelopmentProduct', '\App\Http\Controllers\EnterpriseQueryController@companyDevelopmentProduct');
//资质证书接口
Route::match(['get','post'],'companyDevelopmentCertificate', '\App\Http\Controllers\EnterpriseQueryController@companyDevelopmentCertificate');
//税务资质接口
Route::match(['get','post'],'companyDeveTaxQualification', '\App\Http\Controllers\EnterpriseQueryController@companyDeveTaxQualification');
//注册人员接口
Route::match(['get','post'],'companyDevePersonnel', '\App\Http\Controllers\EnterpriseQueryController@companyDevePersonnel');
//进出口接口
Route::match(['get','post'],'companyDeveImportExport', '\App\Http\Controllers\EnterpriseQueryController@companyDeveImportExport');
//专利信息接口
Route::match(['get','post'],'companyDevePatent', '\App\Http\Controllers\EnterpriseQueryController@companyDevePatent');
//软件著作权接口
Route::match(['get','post'],'companyDeveSoftwareCopyright', '\App\Http\Controllers\EnterpriseQueryController@companyDeveSoftwareCopyright');







//高级筛选获取条件组
Route::match(['get','post'],'companyConditionGroupGet', '\App\Http\Controllers\CompanyScreenController@companyConditionGroupGet');
//获取条件
Route::match(['get','post'],'conditionList', '\App\Http\Controllers\CompanyScreenController@conditionList');
//获取企业信息
Route::match(['get','post'],'companyList', '\App\Http\Controllers\CompanyScreenController@companyList');
//企业转线索
Route::match(['get','post'],'turnClue', '\App\Http\Controllers\CompanyScreenController@turnClue');
//设置条件组
Route::match(['get','post'],'companyConditionGroupSet', '\App\Http\Controllers\CompanyScreenController@companyConditionGroupSet');
//删除条件组
Route::match(['get','post'],'companyConditionGroupDel', '\App\Http\Controllers\CompanyScreenController@companyConditionGroupDel');



//智能筛选获取企业信息
Route::match(['get','post'],'recommendCompany', '\App\Http\Controllers\CompanyScreenController@recommendCompany');