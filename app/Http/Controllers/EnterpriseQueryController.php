<?php

namespace App\Http\Controllers;
header("Access-Control-Allow-Origin:*");
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class EnterpriseQueryController extends BaseController
{

    /*   企业名称补全接口     */
    public function companyNameCompletion(Request $request){
        $parameter = $request->input();
        $model = new \App\Http\Model\Company();
        $data = $model->companyNameCompletion($parameter);
        $return = array();
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

    /*  企业基本信息  */
    public function companyBasicMsg(Request $request){
        $parameter = $request->input();
        $model = new \App\Http\Model\Shareholder();
        $data = $model->basicMsg($parameter);
        if ($data) {
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        } else {
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
        $parameter = $request->input();
        $parameter['start'] = ($parameter['page']-1)*$parameter['limit'];
        $model = new \App\Http\Model\Company();
        $data = $model->Contact($parameter);
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
        $company['start'] = ($company['page']-1)*$company['limit'];
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

    /*  设置企业查询条件组 */
    public function conditionGroupSet(Request $request){
        $condition = $request->input();
        $model = new \App\Http\Model\Company();
        $data = $model->conditionGroupSet($condition);
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

    /*  获取企业查询条件组 */
    public function conditionGroupGet(Request $request){
        session(['uid'=>1]);
        $uid = session('uid');//$request->input('uid');
        $model = new \App\Http\Model\Company();
        $data = $model->conditionGroupGet($uid);
        if($data){
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        }else{
            $return['status'] = 1;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*   删除企业查询条件组     */
    public function conditionGroupDel(Request $request){
        $id = $request->input('id');
        $model = new \App\Http\Model\Company();
        $data = $model->conditionGroupDel($id);
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

    /*  公司发展融资历史接口  */
    public function companyDevelopmentFinancing(Request $request){
        $parameter = $request->input();
        $model = new \App\Http\Model\Shareholder();
        $data = $model->companyDevelopmentFinancing($parameter);
        if ($data) {
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        } else {
            $return['status'] = 1;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*  公司发展创始团队接口  */
    public function companyDevelopmentTeam(Request $request){
        $parameter = $request->input();
        $parameter['start'] = ($parameter['page']-1)*$parameter['limit'];
        $model = new \App\Http\Model\Shareholder();
        $data = $model->companyDevelopmentTeam($parameter);
        if ($data) {
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        } else {
            $return['status'] = 1;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*  公司发展相似产品接口  */
    public function companyDevelopmentProduct(Request $request){
        $parameter = $request->input();
        $parameter['start'] = ($parameter['page']-1)*$parameter['limit'];
        $model = new \App\Http\Model\Shareholder();
        $data = $model->companyDevelopmentProduct($parameter);
        if ($data) {
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        } else {
            $return['status'] = 1;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*  公司发展资质证书接口  */
    public function companyDevelopmentCertificate(Request $request){
        $parameter = $request->input();
        $parameter['start'] = ($parameter['page']-1)*$parameter['limit'];
        $model = new \App\Http\Model\Shareholder();
        $data = $model->companyDevelopmentCertificate($parameter);
        if ($data) {
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        } else {
            $return['status'] = 1;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*  经营信息税务资质接口  */
    public function companyDeveTaxQualification(Request $request){
        $parameter = $request->input();
        $parameter['start'] = ($parameter['page']-1)*$parameter['limit'];
        $model = new \App\Http\Model\Shareholder();
        $data = $model->companyDeveTaxQualification($parameter);
        if ($data) {
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        } else {
            $return['status'] = 1;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*  经营信息注册人员接口  */
    public function companyDevePersonnel(Request $request){
        $parameter = $request->input();
        $parameter['start'] = ($parameter['page']-1)*$parameter['limit'];
        $model = new \App\Http\Model\Shareholder();
        $data = $model->companyDevePersonnel($parameter);
        if ($data) {
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        } else {
            $return['status'] = 1;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*  经营信息进出口接口  */
    public function companyDeveImportExport(Request $request){
        $parameter = $request->input();
        $model = new \App\Http\Model\Shareholder();
        $data = $model->companyDeveImportExport($parameter);
        if ($data) {
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        } else {
            $return['status'] = 1;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*  知识产权专利信息接口  */
    public function companyDevePatent(Request $request){
        $parameter = $request->input();
        $parameter['start'] = ($parameter['page']-1)*$parameter['limit'];
        $model = new \App\Http\Model\Shareholder();
        $data = $model->companyDevePatent($parameter);
        if ($data) {
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        } else {
            $return['status'] = 1;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

    /*  知识产权软件著作权接口  */
    public function companyDeveSoftwareCopyright(Request $request){
        $parameter = $request->input();
        $parameter['start'] = ($parameter['page']-1)*$parameter['limit'];
        $model = new \App\Http\Model\Shareholder();
        $data = $model->companyDeveSoftwareCopyright($parameter);
        if ($data) {
            $return['status'] = 1;
            $return['data'] = $data;
            $return['msg'] = '请求成功！';
        } else {
            $return['status'] = 1;
            $return['msg'] = '请求失败！';
        }
        echo json_encode($return);
        exit;
    }

}
