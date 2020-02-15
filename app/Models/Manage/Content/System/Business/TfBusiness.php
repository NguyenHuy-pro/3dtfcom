<?php namespace App\Models\Manage\Content\System\Business;

use Illuminate\Database\Eloquent\Model;

use DB;
use File;
use Request;

class TfBusiness extends Model
{

    protected $table = 'tf_businesses';
    protected $fillable = ['business_id', 'name', 'description', 'status', 'action', 'created_at', 'type_id'];
    protected $primaryKey = 'business_id';
    public $timestamps = false;

    private $lastId;

    #============ ============ ============ INSERT && UPDATE ============ ============ ============
    #---------- Insert ------------
    public function insert($name, $description = null, $typeId)
    {
        $hFunction = new \Hfunction();
        $modelBusiness = new TfBusiness();
        $modelBusiness->name = $name;
        $modelBusiness->description = $description;
        $modelBusiness->type_id = $typeId;
        $modelBusiness->created_at = $hFunction->carbonNow();
        if ($modelBusiness->save()) {
            $this->lastId = $modelBusiness->business_id;
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

    #----------- Update ----------
    public function updateInfo($businessId, $name, $description, $typeId)
    {
        return TfBusiness::where('business_id', $businessId)->update([
            'name' => $name,
            'description' => $description,
            'type_id' => $typeId
        ]);
    }

    public function updateStatus($businessId, $status)
    {
        return TfBusiness::where('business_id', $businessId)->update(['status' => $status]);
    }

    //delete
    public function actionDelete($businessId)
    {
        return TfBusiness::where('business_id', $businessId)->update(['action' => 0, 'status' => 0]);
    }

    #============ ============ ============ RELATION ============ ============ ============
    #---------- TF-BUSINESS ----------
    public function building()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Building\TfBuilding', 'App\Models\Manage\Content\Building\Business\TfBuildingBusiness', 'business_id', 'building_id');
    }

    # ---------- TF-BUILDING-BUSINESS ----------
    public function buildingBusiness()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Business\TfBuildingBusiness', 'business_id', 'business_id');
    }

    #---------- TF-BUSINESS TYPE ---------- -
    public function businessType()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\BusinessType\TfBusinessType', 'type_id', 'type_id');
    }

    #business info of a business type
    public function infoOfBusinessType($businessTypeId)
    {
        return TfBusiness::where('type_id', $businessTypeId)->where('status', 1)->where('action', 1)->get();
    }

    #---------- TF-ADS-BUSINESS-LICENSE-BUSINESS ---------- -
    public function adsBannerLicenseBusiness()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\LicenseBusiness\TfAdsBusinessLicenseBusiness', 'business_id', 'business_id');
    }

    #============ ============ ============ GET INFO ============ ============ ============
    public function getInfo($businessId = '', $field = '')
    {
        if (empty($businessId)) {
            return TfBusiness::where('action', 1)->where('status', 1)->get();
        } else {
            $result = TfBusiness::where('business_id', $businessId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfBusiness::select('business_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    #---------- BUSINESS INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBusiness::where('business_id', $objectId)->pluck($column);
        }
    }

    public function businessId()
    {
        return $this->business_id;
    }

    public function name($businessId = null)
    {
        return $this->pluck('name', $businessId);
    }

    public function description($businessId = null)
    {
        return $this->pluck('description', $businessId);
    }

    public function status($businessId = null)
    {
        return $this->pluck('status', $businessId);
    }

    public function createdAt($businessId = null)
    {
        return $this->pluck('created_at', $businessId);
    }

    public function typeId($businessId = null)
    {
        return $this->pluck('type_id', $businessId);
    }

    #total records
    public function totalRecords()
    {
        return TfBusiness::where('action', 1)->count();
    }
    #============ ============ ============ CHECK INFO ============ ============ ============
    #check exist of name (add new)
    public function existName($name)
    {
        $result = TfBusiness::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    #check exist of name (edit info)
    public function existEditName($name, $businessId)
    {
        $result = TfBusiness::where('name', $name)->where('business_id', '<>', $businessId)->count();
        return ($result > 0) ? true : false;
    }

}
