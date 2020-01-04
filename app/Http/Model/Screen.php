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
    public function screenList($uid,$key){
        $company = DB::table('condition_group');
        if(empty($uid)) return false;
//        DB::connection()->enableQueryLog();
        if($key){
            $company = $company->where("name",'like','%'.$key.'%');
        }
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
        return $condition;
    }

    //获取企业列表
    public function companyList($screen){
//        $screen['satisfy'] = 1;
//        $screen['condition'] = array(
//            array(
//                'name' => '企业名称',
//                'field' => 'name',
//                'condition_val' => '河北',
//                'state' => 5
//            ),
//            array(
//                'name' => '有无电话',
//                'field' => 'tel',
//                'condition_val' => '无',
//                'state' => 2
//            ),
//            array(
//                'name' => '公司规模',
//                'field' => 'company_scale',
//                'condition_val' => '100',
//                'auxiliary_val' => '50',
//                'state' => 3
//            ),
//            array(
//                'name' => '成立时间',
//                'field' => 'company_creat_time',
//                'condition_val' => '1569895200至1577844000',
//                'state' => 4
//            )
//        );
//        DB::connection()->enableQueryLog();
        $counts = DB::table('company');
        if($screen['condition']){
            foreach ($screen['condition'] as $k => $v){
                if($screen['satisfy'] == 1){
                    if($v['state'] == 1){
                        $counts = $counts->where("name",'like','%'.$v['condition_val'].'%');
                    }elseif ($v['state'] == 2){
                        if($v['condition_val'] == '有'){
                            $counts = $counts->where($v['field'],'!=','');
                        }else{
                            $counts = $counts->where($v['field'],'=','');
                        }
                    }elseif ($v['state'] == 3){
                        $counts=$counts->whereBetween($v['field'], [(int)$v['auxiliary_val'],(int)$v['condition_val']]);
                    }elseif ($v['state'] == 4){
                        $time = explode('至',$v['condition_val']);
                        $counts=$counts->whereBetween($v['field'], [(int)$time[0], (int)$time[1]]);
                    }elseif ($v['state'] == 5){
                        $counts = $counts->where($v['field'],'like','%'.$v['condition_val'].'%');
                    }
                }else{
                    if($v['state'] == 1){
                        if($k == 0){
                            $counts = $counts->where($v['field'],'like','%'.$v['condition_val'].'%');
                        }else{
                            $counts = $counts->orwhere($v['field'],'like','%'.$v['condition_val'].'%');
                        }
                    }elseif ($v['state'] == 2){
                        if($v['condition_val'] == '有'){
                            if($k == 0){
                                $counts = $counts->where($v['field'],'!=','');
                            }else{
                                $counts = $counts->orwhere($v['field'],'!=','');
                            }
                        }else{
                            if($k == 0){
                                $counts = $counts->where($v['field'],'=','');
                            }else{
                                $counts = $counts->orwhere($v['field'],'=','');
                            }
                        }
                    }elseif ($v['state'] == 3){
                        $counts=$counts->orWhereBetween($v['field'], [(int)$v['auxiliary_val'], (int)$v['condition_val']]);
                    }elseif ($v['state'] == 4){
                        $time = explode('至',$v['condition_val']);
                        $counts=$counts->orWhereBetween($v['field'], [(int)$time[0], (int)$time[1]]);
                    }elseif ($v['state'] == 5){
                        if($k == 0){
                            $counts = $counts->where($v['field'],'like','%'.$v['condition_val'].'%');
                        }else{
                            $counts = $counts->orwhere($v['field'],'like','%'.$v['condition_val'].'%');
                        }
                    }
                }
            }
        }
        $count = $counts->count();
        $company = $counts->skip($screen['start'])->take($screen['limit'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
//        dd(DB::getQueryLog());
        if($company){
            foreach ($company as $k => $v){
                $rst = DB::table('website')->where('website_id',$v['website_id'])->where('website_status',0)->first();
                if($rst){
                    $company[$k]['website'] = $rst->website_address;
                }
                $count = DB::table('user_personnel')->where('company_id',$v['company_id'])->count();
                $company[$k]['contact'] = $count;
            }
        }
        $data['count'] = $count;
        $data['company'] = $company;
        return $data;
    }

    //企业转线索
    public function turnClue($screen){
        if($screen){
            $clue = DB::table('company')->whereIn('company_id',$screen)->increment('clue_num', 1, ['clue' => 2]);
            if($clue){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //设置企业查询条件组
    public function companyConditionGroupSet($condition){
//        $condition['name'] = '企业查询';
//        $condition['satisfy'] = 1;
//        $condition['condition'] = array(
//            array(
//                'condition_id' => '1',
//                'condition_name' => '自媒体名称',
//                'field' => 'name',
//                'condition_val' => '河北红燊',
//                'auxiliary_val' => '等于任一',
//                'suffix' => null,
//                'state' => 1
//            )
//        );
//        var_dump($condition);
//        die;
//        DB::connection()->enableQueryLog();
        $id=DB::table("condition_group")->insertGetId(['uid'=>1,'name'=>$condition['name'],'satisfy'=>$condition['satisfy'],'num'=>1,'time'=>time()]);
        if ($id){
            foreach ($condition['condition'] as $k => $v){
                $condition=DB::table("condition_group_attach")->insertGetId(['group_id'=>$id,'condition_id'=>$v['condition_id'],'condition_name'=>$v['condition_name'],'field'=>$v['field'],'condition_val'=>$v['condition_val'],'auxiliary_val'=>$v['auxiliary_val'],'suffix'=>$v['suffix'],'state'=>$v['state'],'time'=>time()]);
            }
        }
//        dd(DB::getQueryLog());
        return true;
    }

    //删除高级筛选条件组
    public function companyConditionGroupDel($id){
        if($id){
//            DB::connection()->enableQueryLog();
            $attach = DB::table('condition_group_attach')->where('group_id',$id)->delete();
            $group = DB::table('condition_group')->where('id',$id)->delete();
//        dd(DB::getQueryLog());
            return true;
        }else{
            return false;
        }
    }




    /************************************ 智能推荐接口 ****************************************/

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