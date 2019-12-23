<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class CompanyScreenController extends BaseController
{
    /**************************************************** 企业高级筛选控制器 ****************************************/
    /*   获取条件组     */
    public function conditionGroup(Request $request){
        session(['uid'=>1]);
        $uid = session('uid');//$request->input('uid');
        $model = new \App\Http\Model\Screen();
        $data = $model->screenList($uid);
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
        $screen['start'] = ($screen['page']-1)*$screen['num'];
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