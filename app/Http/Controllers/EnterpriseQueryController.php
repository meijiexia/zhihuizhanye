<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class EnterpriseQueryController extends BaseController
{
    /*   企业列表     */
    public function enterpriseList(Request $request){
        $parameter = $request->input();
        $model = new \App\Http\Model\Company();
        $data = $model->companyList($parameter);
        $return = array();
        if($data){
            $return['status'] = 1;
            $return['count'] = count($data);
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        }else{
            $return['status'] = 0;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }
    /*    企业信息     */
    public function basicMsg(Request $request){
        $parameter = $request->input();
        $model = new \App\Http\Model\Shareholder();
        if($parameter['type'] == 'basic_msg') {/*企业信息*/
            $data = $model->basicMsg($parameter);
            if ($data) {
                $return['status'] = 1;
                $return['data'] = $data;
                $return['msg'] = '请求成功！';
            } else {
                $return['status'] = 0;
                $return['msg'] = '请求失败！';
            }
        }elseif ($parameter['type'] == 'shareholder'){/*股东信息*/
            $data = $model->shareholderList($parameter);
            if ($data) {
                $return['status'] = 1;
                $return['data'] = $data;
                $return['msg'] = '请求成功！';
            } else {
                $return['status'] = 0;
                $return['msg'] = '请求失败！';
            }
        }elseif ($parameter['type'] == 'key_personnel'){/*主要人员*/
            $data = $model->keyPersonnel($parameter);
            if ($data) {
                $return['status'] = 1;
                $return['data'] = $data;
                $return['msg'] = '请求成功！';
            } else {
                $return['status'] = 0;
                $return['msg'] = '请求失败！';
            }
        }elseif ($parameter['type'] == 'alteration'){/*工商变更*/
            $data = $model->alteration($parameter);
            if ($data) {
                $return['status'] = 1;
                $return['data'] = $data;
                $return['msg'] = '请求成功！';
            } else {
                $return['status'] = 0;
                $return['msg'] = '请求失败！';
            }
        }
        echo json_encode($return);
        exit;
    }

    /*   获取企业联系方式接口  */
    public function Contact(Request $request){
        $companyid = $request->input('companyid');
        $model = new \App\Http\Model\Company();
        $data = $model->Contact($companyid);
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

    /*    获取员工人脉接口  */
    public function Employee(Request $request){
        $company = $request->input();
        $company['start'] = ($company['page']-1)*$company['num'];
        $model = new \App\Http\Model\Company();
        $data = $model->Employee($company);
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

}