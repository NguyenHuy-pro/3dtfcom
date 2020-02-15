<?php namespace App\Models\Manage\Content\Map\ProvinceArea;

use App\Models\Manage\Content\Map\Project\TfProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;

class TfProvinceArea extends Model
{

    protected $table = 'tf_province_areas';
    protected $fillable = ['province_id', 'area_id', 'defaultCenter'];
    //protected $primaryKey = 'province_id','area_id';
    //public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========= RELATION ========== ========== ==========
    #----------- TF-PROVINCE -----------
    public function province()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Province\TfProvince', 'province_id', 'province_id');
    }

    #----------- TF-AREA -----------
    public function area()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Area\TfArea', 'area_id', 'area_id');
    }

    #========== ========== ========= GET INFO ========== ========== ==========
    # get center area of province
    public function centerAreaOfProvince($provinceId)
    {
        return TfProvinceArea::where('province_id', $provinceId)->where('defaultCenter', 1)->pluck('area_id');
    }

    #get project
    public function projectInfo($provinceId, $areaId)
    {
        $modelProject = new TfProject();
        return $modelProject->infoOfProvinceAndArea($provinceId, $areaId);
    }
    #========== ========== ========== setup ========= ======== ==========
    #check center
    public function checkCenter($provinceId, $areaId)
    {
        $result = TfProvinceArea::where('province_id', $provinceId)->where('area_id', $areaId)->where('defaultCenter', 1)->count();
        return ($result > 0) ? true : false;
    }

    #check status
    public function checkSetup()
    {
        if (Session::has('setupStatus')) {
            return Session::get('setupStatus');
        } else {
            return false;
        }
    }

    # get setup area
    public function getSetupArea()
    {
        return Session::get('setupArea');
    }

    # set setup
    public function openSetup($areaId)
    {
        Session::put('setupArea', $areaId);
        return Session::put('setupStatus', true);
    }

    # close setup
    public function closeSetup()
    {
        Session::forget('setupArea');
        return Session::put('setupStatus', false);
    }

}
