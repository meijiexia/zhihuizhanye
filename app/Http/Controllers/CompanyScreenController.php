<?php

namespace App\Http\Controllers;
header("Access-Control-Allow-Origin:*");
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CompanyScreenController extends BaseController
{
    /**************************************************** 企业高级筛选控制器 ****************************************/
    /*  设置条件组 */
    public function companyConditionGroupSet(Request $request){
        $condition = $request->input();
        $model = new \App\Http\Model\Screen();
        $data = $model->companyConditionGroupSet($condition);
        if($data){
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        }else{
            $return['status'] = 0;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*   获取条件组     */
    public function companyConditionGroupGet(Request $request){
        session(['uid'=>1]);
        $uid = session('uid');//$request->input('uid');
        $key = $request->input('key');
        $model = new \App\Http\Model\Screen();
        $data = $model->screenList($uid,$key);
        $return = array();
        if($data){
            $return['status'] = 1;
            $return['msg'] = '请求成功！';
            $return['data'] = $data;
        }else{
            $return['status'] = 1;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*   删除条件组     */
    public function companyConditionGroupDel(Request $request){
        $id = $request->input('id');
        $model = new \App\Http\Model\Screen();
        $data = $model->companyConditionGroupDel($id);
        $return = array();
        if($data){
            $return['status'] = 1;
            $return['msg'] = '请求成功！';
            $return['data'] = $data;
        }else{
            $return['status'] = 0;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*    获取条件     */
    public function conditionList(Request $request){
        $model = new \App\Http\Model\Screen();
        $data = $model->conditionList();
        $return = array();
        if($data){
            $return['status'] = 1;
            $return['msg'] = '请求成功！';
            $return['data'] = $data;
        }else{
            $return['status'] = 0;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*    获取企业信息     */
    public function companyList(Request $request){
        $screen = $request->input();
        $screen['start'] = ($screen['page']-1)*$screen['limit'];
        $model = new \App\Http\Model\Screen();
        $data = $model->companyList($screen);
        $return = array();
        if($data){
            $return['status'] = 1;
            $return['msg'] = '请求成功！';
            $return['data'] = $data;
        }else{
            $return['status'] = 0;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*   企业转线索方法     */
    public function turnClue(Request $request){
        $companyid = $request->input();
        $model = new \App\Http\Model\Screen();
        $data = $model->turnClue($companyid);
        $return = array();
        if($data){
            $return['status'] = 1;
            $return['msg'] = '请求成功！';
        }else{
            $return['status'] = 0;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*************************************************智能推荐的方法*********************************************/
    /*获取企业信息*/
    public function recommendCompany(Request $request){
        $screen = $request->input();
        $screen['start'] = ($screen['page']-1)*$screen['num'];
        $model = new \App\Http\Model\Screen();
        $data = $model->recommendCompany($screen);
        $return = array();
        if($data){
            $return['status'] = 1;
            $return['msg'] = '请求成功！';
            $return['data'] = $data;
        }else{
            $return['status'] = 0;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }
}