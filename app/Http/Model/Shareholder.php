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


    public function basicMsg($parameter){
        if($parameter['company_id']){
            $company = DB::table('company');
            $company = $company->where('company_id',$parameter['company_id']);
            $data = $company->select(['company_id','name','address','level','legal_person','company_desc','main_business','update_time','social_code','registration_num','organization_code','company_status','registered_money','company_type','company_creat_time','company_end_time','register_agency','approve_time','company_scale','website_id'])
                ->first();
            $rst = DB::table('website')->where('website_id',$data->website_id)->where('website_status',0)->first();
            $data->website = $rst->website_address;
            $return = $data;
        }else{
            $return = false;
        }
        return $return;
    }

    public function shareholderList($parameter){
        $company_id = $parameter['company_id'];//$this->company_id($parameter['name']);
        //offset 设置从哪里开始，limit 设置想要查询多少条数据
        $return = array();
        if($parameter['limit']){
            $limit = $parameter['limit'];
            $offset = ($parameter['page']-1) * $limit;
        }else{
            $limit = 1;
            $offset = $parameter['page'];
        }
        $shareholder = DB::table('shareholder');
        $shareholder = $shareholder->where('company_id','=',$company_id);
        $return['count'] = $shareholder->count();//总条数
        $return['page'] = ceil($return['count']/$limit);//页数
        $return['page'] = $parameter['page'];//当前页
//        DB::connection()->enableQueryLog();
        $return['data'] = $shareholder
            ->select(['shareholder_name','shareholer_act_money','shareholder_money','shareholder_time'])
            ->offset($offset)
            ->limit($limit)
            ->get();
//        dump(DB::getQueryLog());
        return $return;
    }
    public function keyPersonnel($parameter){
        $company_id = $parameter['company_id'];//$this->company_id($parameter['name']);
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
        $company_id = $parameter['company_id'];//$this->company_id($parameter['name']);
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

    //获取公司发展融资历史数据
    public function companyDevelopmentFinancing($parameter){
        $company_id = $parameter['company_id'];
        $rst = DB::table('financing_record')->where('company_id',$company_id)->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        return $rst;
    }

    //获取创始团队数据
    public function companyDevelopmentTeam($parameter){
        $count = DB::table('initiation_team')->where('company_id',$parameter['company_id'])->count();
        $rst = DB::table('initiation_team')->where('company_id',$parameter['company_id'])->skip($parameter['start'])->take($parameter['limit'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        $data['rst'] = $rst;
        $data['count'] = $count;
        return $data;
    }

    //获取相似产品数据
    public function companyDevelopmentProduct($parameter){
        $count = DB::table('similar_product')->where('company_id',$parameter['company_id'])->count();
        $rst = DB::table('similar_product')->where('company_id',$parameter['company_id'])->skip($parameter['start'])->take($parameter['limit'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        $data['rst'] = $rst;
        $data['count'] = $count;
        return $data;
    }

    //获取资质证书数据
    public function companyDevelopmentCertificate($parameter){
        $category = DB::table('certificate')->where('company_id',$parameter['company_id'])->orderBy('certified_time','asc')->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        foreach ($category as $k => $v){
            $content[] = $v['certificate_type'];
        }
        $contents = array_unique($content);
        $count = count($contents);
        $contents = implode('、',$contents);
        $time = date('Y-m-d',$category[0]['certified_time']);
        $categorys['contents'] = $contents;
        $categorys['count'] = $count;
        $categorys['time'] = $time;
        $counts = DB::table('certificate')->where('company_id',$parameter['company_id'])->count();
        $Certificate = DB::table('certificate')->where('company_id',$parameter['company_id'])->skip($parameter['start'])->take($parameter['limit'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        $data['certificate'] = $Certificate;
        $data['categorys'] = $categorys;
        $data['counts'] = $counts;
        return $data;
    }

    //获取税务资质数据
    public function companyDeveTaxQualification($parameter){
        $count = DB::table('tax_qualification')->where('company_id',$parameter['company_id'])->count();
        $rst = DB::table('tax_qualification')->where('company_id',$parameter['company_id'])->skip($parameter['start'])->take($parameter['limit'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        $data['rst'] = $rst;
        $data['count'] = $count;
        return $data;
    }

    //获取注册人员数据
    public function companyDevePersonnel($parameter){
        $count = DB::table('registered_personnel')->where('company_id',$parameter['company_id'])->count();
        $rst = DB::table('registered_personnel')->where('company_id',$parameter['company_id'])->skip($parameter['start'])->take($parameter['limit'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        $data['rst'] = $rst;
        $data['count'] = $count;
        return $data;
    }

    //获取进出口数据
    public function companyDeveImportExport($parameter){
        $rst = DB::table('import_export')->where('company_id',$parameter['company_id'])->first();
        return $rst;
    }

    //获取专利信息数据
    public function companyDevePatent($parameter){
        $count = DB::table('patent_information')->where('company_id',$parameter['company_id'])->count();
        $rst = DB::table('patent_information')->where('company_id',$parameter['company_id'])->skip($parameter['start'])->take($parameter['limit'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        $data['rst'] = $rst;
        $data['count'] = $count;
        return $data;
    }

    //获取软件著作权数据
    public function companyDeveSoftwareCopyright($parameter){
        $count = DB::table('software_copyright')->where('company_id',$parameter['company_id'])->count();
        $rst = DB::table('software_copyright')->where('company_id',$parameter['company_id'])->skip($parameter['start'])->take($parameter['limit'])->get()->map(function ($value) {
            return (array)$value;
        })->toArray();
        $data['rst'] = $rst;
        $data['count'] = $count;
        return $data;
    }

}
