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
use App\Player;
class Shareholder extends Model{
    //指定表名
    protected $table = 'shareholder';
    //指定id
    protected  $primaryKey = 'shareholder_id';
    //指定不允许批量赋值字段
    protected $guarded = [];
    //自动维护时间戳
    public $timestamps = false;
    public static function company_id($name){
        $company = DB::table('Company');
        $company = $company->where('name','like',$name);
        $company_id = $company->pluck('company_id');
        return $company_id[0];
    }


    public function basicMsg($parameter){
        if($parameter['name']){
            $company = DB::table('Company');
            $company = $company->where('name','like','%'.$parameter['name'].'%');
            $data = $company
                ->select(['company_id','name','address','company_desc','main_business','update_time','social_code','registration_num','organization_code','company_status','registered_money','company_type','company_creat_time','company_end_time','register_agency','approve_time','company_scale'])
                ->first();
            $website = DB::table('website');
            $website = $website->where('company_id','=',$data->company_id)
                ->select('website_address')
                ->first();
            $data->website_address = $website->website_address;
            $return = $data;
        }else{
            $return = false;
        }
        return $return;
    }

    public function shareholderList($parameter){
        $company_id = $this->company_id($parameter['name']);
        //offset 设置从哪里开始，limit 设置想要查询多少条数据
        $return = array();
        if($parameter['limit']){
            $limit = $parameter['limit'];
            $offset = ($parameter['page']-1) * $limit;
        }else{
            $limit = 1;
            $offset = $parameter['page'];
        }
        $shareholder = DB::table('Shareholder');
        $shareholder = $shareholder->where('company_id','=',$company_id);
        $return['count'] = $shareholder->count();//总条数
        $return['page'] = ceil($return['count']/$limit);//页数
        $return['page'] = $parameter['page'];//当前页
//        DB::connection()->enableQueryLog();
        $return['data'] = $shareholder
            ->select(['shareholder_name','shareholder_money','shareholder_time'])
            ->offset($offset)
            ->limit($limit)
            ->get();
//        dump(DB::getQueryLog());
        return $return;
    }
    public function keyPersonnel($parameter){
        $company_id = $this->company_id($parameter['name']);
        $return = array();
        if($parameter['limit']){
            $limit = $parameter['limit'];
            $offset = ($parameter['page']-1) * $limit;
        }else{
            $limit = 1;
            $offset = $parameter['page'];
        }
//        DB::connection()->enableQueryLog();
        $ruc = DB::table('r_user_company');
        $ruc = $ruc
            ->where('r_user_company.company_id','=',$company_id)
            ->select(['r_user_company.user_id','r_user_company.position','user_personnel.user_name'])
            ->join('user_personnel',function ($join){
                $join->on('r_user_company.user_id','=','user_personnel.user_id');
            });
        $return['count'] = $ruc->count();//总条数
        $return['page'] = ceil($return['count']/$limit);//页数
        $return['at_page'] = $parameter['page'];//当前页
        $return['data'] = $ruc
            ->offset($offset)
            ->limit($limit)
            ->get();
//        dump(DB::getQueryLog());
        return $return;
    }

    public function alteration($parameter){
        $company_id = $this->company_id($parameter['name']);
        //offset 设置从哪里开始，limit 设置想要查询多少条数据
        $return = array();
        if($parameter['limit']){
            $limit = $parameter['limit'];
            $offset = ($parameter['page']-1) * $limit;
        }else{
            $limit = 1;
            $offset = $parameter['page'];
        }
        $company_change = DB::table('company_change');
        $company_change = $company_change->where('company_id','=',$company_id);
        $return['count'] = $company_change->count();//总条数
        $return['page'] = ceil($return['count']/$limit);//页数
        $return['at_page'] = $parameter['page'];//当前页
//        DB::connection()->enableQueryLog();
//        $company_change = $company_change->orderBy('change_time','desc');
        $company_change = $company_change->orderBy('company_change_id','desc');
        $return['data'] = $company_change
            ->select(['company_change_id','change_item','change_time','change_after_content','change_before_content'])
            ->offset($offset)
            ->limit($limit)
            ->get();
//        dump(DB::getQueryLog());
        return $return;
    }

}