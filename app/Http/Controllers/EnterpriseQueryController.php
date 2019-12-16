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
        }else{
            $return['status'] = 0;
        }
        return $return;
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
            } else {
                $return['status'] = 0;
            }
        }elseif ($parameter['type'] == 'shareholder'){/*股东信息*/
            $return = $model->shareholderList($parameter);
        }elseif ($parameter['type'] == 'key_personnel'){/*主要人员*/
            $return = $model->keyPersonnel($parameter);
        }elseif ($parameter['type'] == 'alteration'){/*工商变更*/
            $return = $model->alteration($parameter);
        }
        return $return;
    }
}