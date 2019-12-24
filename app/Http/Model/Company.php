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
    public function companyList($parameter){
        $company = DB::table('company');
//        DB::connection()->enableQueryLog();
        if($parameter['field'] && $parameter['content']){
            $company = $company->where('name','like','%'.$parameter['content'].'%');
            $company = $company->orwhere('address','like','%'.$parameter['content'].'%');
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
    public function Contact($companyid){
        $contact = DB::table('user_personnel')->where('company_id',$companyid)->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        foreach ($contact as $k => $v){
            $user = DB::table('user_personnel_contact')->where('user_id',$v['user_id'])->get()->map(function ($value) {
                return (array)$value;
            })->toArray();
            $contact[$k]['user_contact'] = $user;
        }
        return $contact;
    }

    //获取员工人脉
    public function Employee($company){
        $contact = DB::table('user_personnel')->where('company_id',$company['companyid'])->skip($company['start'])->take($company['num'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        return $contact;
    }
}