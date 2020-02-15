<?php namespace App\Models\Manage\Content\System\BadInfo;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfBadInfo extends Model
{

    protected $table = 'tf_bad_infos';
    protected $fillable = ['badInfo_id', 'name', 'action', 'created_at'];
    protected $primaryKey = 'badInfo_id';
    public $timestamps = false;

    private $lastId;

    #========= =========== =========== INSERT && UPDATE =========== =========== ===========
    #--------- Insert --------
    public function insert($name)
    {
        $hFunction = new \Hfunction();
        $modelBadInfo = new TfBadInfo();
        $modelBadInfo->name = $name;
        $modelBadInfo->action = 1;
        $modelBadInfo->created_at = $hFunction->createdAt();
        if ($modelBadInfo->save()) {
            $this->lastId = $modelBadInfo->badInfo_id;
            return true;
        } else {
            return false;
        }
    }

    //get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #--------- Update -------------
    public function updateInfo($badInfoId, $name)
    {
        $modelBadInfo = TfBadInfo::find($badInfoId);
        $modelBadInfo->name = $name;
        return $modelBadInfo->save();
    }

    //delete
    public function actionDelete($badInfoId)
    {
        return TfBadInfo::where('badInfo_id', $badInfoId)->update(['action' => 0]);
    }

    #========= =========== =========== RELATION =========== =========== ===========

    #----------- TF-BUILDING-POST -----------
    public function building()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Building\TfBuilding', 'App\Models\Manage\Content\Building\Report\TfBuildingBadInfoNotify', 'badInfo_id', 'building_id');
    }

    #----------- TF-BUILDING-BAD-INFO-REPORT -----------
    public function buildingBadInfoReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Report\TfBuildingBadInfoReport', 'badInfo_id', 'badInfo_id');
    }

    #----------- TF-BUILDING-BAD-INFO-NOTIFY -----------
    public function buildingBadInfoNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Report\TfBuildingBadInfoNotify', 'badInfo_id', 'badInfo_id');
    }

    #----------- TF-BUILDING-POST -----------
    public function buildingPost()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Building\Post\TfBuildingPost', 'App\Models\Manage\Content\Building\Post\TfBuildingPostInfoNotify', 'badInfo_id', 'post_id');
    }

    #----------- TF-BUILDING-POST-INFO-NOTIFY -----------
    public function buildingPostInfoNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Post\TfBuildingPostInfoNotify', 'badInfo_id', 'badInfo_id');
    }

    #----------- TF-BUILDING-POST-INFO-REPORT -----------
    public function buildingPostInfoReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Post\TfBuildingPostInfoReport', 'badInfo_id', 'badInfo_id');
    }

    #---------- TF-BANNER-BAD-INFO-NOTIFY -----------
    public function bannerBadInfoNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Report\TfBannerBadInfoNotify', 'badInfo_id', 'badInfo_id');
    }

    #----------- TF-BANNER-IMAGE -----------
    public function bannerImage()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Map\Banner\Image\TfBannerImage', 'App\Models\Manage\Content\Map\Banner\Report\TfBannerBadInfoNotify', 'badInfo_id', 'image_id');
    }

    #---------- TF-BANNER-BAD-INFO-REPORT -----------
    public function bannerBadInfoReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Report\TfBannerBadInfoReport', 'badInfo_id', 'badInfo_id');
    }

    #----------- TF-ADS-BANNER-IMAGE-REPORT -----------
    public function adsBannerImageReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\ImageReport\TfAdsBannerImageReport', 'badInfo_id', 'badInfo_id');
    }

    #========= =========== =========== GET INFO =========== =========== ===========
    public function getInfo($badInfoId = null, $field = null)
    {
        if (empty($badInfoId)) {
            return TfBadInfo::where('action', 1)->get();
        } else {
            $result = TfBadInfo::where('badInfo_id', $badInfoId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBadInfo::where('badInfo_id', $objectId)->pluck($column);
        }
    }

    public function badInfoId()
    {
        return $this->badInfo_id;
    }


    public function name($badInfoId = null)
    {
        return $this->pluck('name', $badInfoId);
    }

    public function createdAt($badInfoId = null)
    {
        return $this->pluck('created_at', $badInfoId);
    }

    // Check exist of name
    public function existName($name)
    {
        $badInfo = TfBadInfo::where('name', $name)->count();
        return ($badInfo > 0) ? true : false;
    }

    public function existEditName($badInfoId, $name)
    {
        $result = TfBadInfo::where('badInfo_id', '<>', $badInfoId)->where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    // total records
    public function totalRecords()
    {
        return TfBadInfo::where('action', 1)->count();
    }

}
