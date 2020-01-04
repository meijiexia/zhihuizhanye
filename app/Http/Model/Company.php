<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/12/10
 * Time: 15:35
 */
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class Company extends Model{
    //指定表名
    protected $table = 'company';
    //指定id
    protected  $primaryKey = 'company_id';
    //指定不允许批量赋值字段
    protected $guarded = [];
    //自动维护时间戳
    public $timestamps = false;
    public function companyNameCompletion($parameter){
        $company = DB::table('company');
//        DB::connection()->enableQueryLog();
        if($parameter['key']){
            $company = $company->where('name','like','%'.$parameter['key'].'%');
        }
        $data = $company->select(['company_id','name'])->get();
//        dd(DB::getQueryLog());
        return $data;
    }

    public function companyList($parameter){
        $company = DB::table('company');
//        DB::connection()->enableQueryLog();
        if($parameter['field'] && $parameter['content']){
            foreach ($parameter['field'] as $k => $v){
                if($k == 0){
                    $company = $company->where("$v",'like','%'.$parameter['content'].'%');
                }else{
                    $company = $company->orwhere("$v",'like','%'.$parameter['content'].'%');
                }
            }
        }
        if($parameter['order']){
            $company = $company->orderBy($parameter['order'],'desc');
        }
        $data = $company
            ->select(['company_id','name','legal_person','address','registered_money','company_creat_time','company_status'])
            ->get();
//        dd(DB::getQueryLog());
        $company_brand = DB::table('company_brand');
        $return = array();
        foreach ($data as $k => $v){
            $brand_name = $company_brand
                ->where('company_id','=',$v->company_id)
                ->pluck('brand_name');
            $num = 0;
            $str = '';
            foreach ($brand_name as $k1 => $v1){
                if($num == 0){
                    $str = $v1;
                }else{
                    $str .= '、'.$str;
                }
                $num ++;
            }
            $return[$k]['company_id'] = $v->company_id;
            $return[$k]['comName'] = $v->name;
            $return[$k]['legal'] = $v->legal_person;
            $return[$k]['address'] = $v->address;
            $return[$k]['goods'] = $str;
            $return[$k]['money'] = $v->registered_money;
            $return[$k]['date'] = $v->company_creat_time;
            $return[$k]['jyStatus'] = $v->company_status;
            $return[$k]['gjStatus'] = '已成交';
        }
        return $return;
    }

    //获取联系方式
    public function Contact($parameter){
        $count = DB::table('user_personnel')->where('company_id',$parameter['companyid'])->get()->count();
        $contact = DB::table('user_personnel')->where('company_id',$parameter['companyid'])->skip($parameter['start'])->take($parameter['limit'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        foreach ($contact as $k => $v){
            $user = DB::table('user_personnel_contact')->where('user_id',$v['user_id'])->get()->map(function ($value) {
                return (array)$value;
            })->toArray();
            $contact[$k]['user_contact'] = $user;
        }
        $data['contact'] = $contact;
        $data['count'] = $count;
        return $data;
    }

    //获取员工人脉
    public function Employee($company){
        $count = DB::table('user_personnel')->where('company_id',$company['companyid'])->get()->count();
        $contact = DB::table('user_personnel')->where('company_id',$company['companyid'])->skip($company['start'])->take($company['limit'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        $data['contact'] = $contact;
        $data['count'] = $count;
        return $data;
    }

    //设置企业查询条件组
    public function conditionGroupSet($condition){
//        DB::connection()->enableQueryLog();
        $val = implode(',',$condition['condition']);
        $rst=DB::table("company_condition_group")->insertGetId(['uid'=>1,'name'=>$condition['name'],'condition'=>"$val",'time'=>time()]);
//        dd(DB::getQueryLog());
        return $rst;
    }

    //获取企业查询条件组
    public function conditionGroupGet($uid){
//        DB::connection()->enableQueryLog();
        $rst = DB::table('company_condition_group')->where('uid',$uid)->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        if ($rst){
            foreach ($rst as $k => $v){
                $rst[$k]['condition'] = explode(',',$v['condition']);
            }
        }
//        dd(DB::getQueryLog());
        return $rst;
    }

    //删除企业筛选条件组
    public function conditionGroupDel($id){
        if($id){
//            DB::connection()->enableQueryLog();
            $attach = DB::table('company_condition_group')->where('id',$id)->delete();
//        dd(DB::getQueryLog());
            return true;
        }else{
            return false;
        }
    }
}