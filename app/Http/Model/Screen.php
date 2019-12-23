<?php
/**
 * 高级筛选模型
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/12/10
 * Time: 15:35
 */
namespace App\Http\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class Screen extends Model{
    //指定表名
    protected $table = 'condition_group';
    //指定id
    protected  $primaryKey = 'id';
    //指定不允许批量赋值字段
    protected $guarded = [];
    //自动维护时间戳
    public $timestamps = false;
    //获取用户条件组
    public function screenList($uid){
        $company = DB::table('condition_group');
        if(empty($uid)) return false;
//        DB::connection()->enableQueryLog();
//        $data = $company->where('uid',$uid)->orderBy('num','desc')->get();
        $group = $company->where('uid',$uid)->orderBy('num','desc')->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
//        dd(DB::getQueryLog());
        foreach ($group as $k => $v){
            $attach = DB::table('condition_group_attach')->where('group_id',$v['id'])->get()->map(function ($value) {
                return (array)$value;
            })->toArray();
            $group[$k]['attach'] = $attach;
        }
        return $group;
    }

    //获取条件
    public function conditionList(){
        $condition = DB::table('condition')->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        foreach ($condition as $k => $v){
            $condition_val = DB::table('condition_val')->where('condition_id',$v['id'])->orderBy('level','asc')->get()->map(function ($value) {
                return (array)$value;
            })->toArray();
            $condition[$k]['val'] = $condition_val;
        }
        return $condition;
    }

    //获取企业列表
    public function companyList($screen){
        $company = DB::table('company')->skip($screen['start'])->take($screen['num'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        return $company;
    }

    //企业转线索
    public function turnClue($screen){
        if($screen){
            $ids = implode(',',$screen);
            $clue = DB::table('company')->whereIn('company_id',[$ids])->increment('clue_num', 1, ['clue' => 2]);
            if($clue){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //获取企业列表
    public function recommendCompany($screen){
        $count = DB::table('company')->count();
        $company = DB::table('company')->skip($screen['start'])->take($screen['num'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        $company['count'] = $count;
        return $company;
    }
}