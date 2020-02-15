<?php namespace App\Models\Manage\Content\System\BusinessType;

use App\Models\Manage\Content\Sample\Building\TfBuildingSample;
use App\Models\Manage\Content\System\Business\TfBusiness;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use DB;
use File;

class TfBusinessType extends Model
{

    protected $table = 'tf_business_types';
    protected $fillable = ['type_id', 'name', 'description', 'defaultSetup', 'status', 'action', 'created_at'];
    protected $primaryKey = 'type_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    //---------- Insert ----------
    public function insert($name, $description = null)
    {
        $hFunction = new \Hfunction();
        $modelBusinessType = new TfBusinessType();
        $modelBusinessType->name = $name;
        $modelBusinessType->description = $description;
        $modelBusinessType->created_at = $hFunction->createdAt();
        if ($modelBusinessType->save()) {
            $this->lastId = $modelBusinessType->type_id;
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

    #---------- Update ----------
    public function updateInfo($typeId, $name, $description)
    {
        return TfBusinessType::where('type_id', $typeId)->update([
            'name' => $name,
            'description' => $description
        ]);
    }

    public function updateStatus($typeId, $status)
    {
        return TfBusinessType::where('type_id', $typeId)->update(['status' => $status]);
    }


    # delete
    public function actionDelete($typeId = null)
    {
        if (empty($typeId)) $typeId = $this->typeId();
        return TfBusinessType::where('type_id', $typeId)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    //---------- TF-BUSINESS ----------
    public function business()
    {
        return $this->hasMany('App\Models\Manage\Content\System\Business\TfBusiness', 'type_id', 'type_id');
    }

    #---------- TF-BUILDING-SAMPLE ----------
    public function buildingSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Building\TfBuildingSample', 'businessType_id', 'type_id');
    }
    public function listBuildingSampleId($typeId = null)
    {
        $modelSample = new TfBuildingSample();
        if (empty($typeId)) $typeId = $this->typeId();
        return $modelSample->listIdOfBusinessType($typeId);
    }

    //---------- TF-BUSINESS ----------
    public function adsBannerImage()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\Image\TfAdsBannerImage', 'type_id', 'type_id');
    }

    public function businessOfType($typeId = null)
    {
        $modelBusiness = new TfBusiness();
        if (empty($typeId)) $typeId = $this->typeId();
        return $modelBusiness->infoOfBusinessType($typeId);
    }

    //---------- TF-LAND-REQUEST-BUILD ----------
    public function landRequestBuild()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\RequestBuild\TfLandRequestBuild', 'type_id', 'type_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($typeId = null, $field = null)
    {
        if (empty($typeId)) {
            return TfBusinessType::where('action', 1)->where('status', 1)->get();
        } else {
            $result = TfBusinessType::where('type_id', $typeId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }


    //create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfBusinessType::select('type_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    //get default type
    public function defaultTypeId()
    {
        return TfBusinessType::where(['defaultSetup' => 1, 'action' => 1])->pluck('type_id');
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBusinessType::where('type_id', $objectId)->pluck($column);
        }
    }

    public function typeId()
    {
        return $this->type_id;
    }

    public function name($typeId = null)
    {
        return $this->pluck('name', $typeId);
    }

    public function defaultSetup($typeId = null)
    {
        return $this->pluck('defaultSetup', $typeId);
    }

    public function description($typeId = null)
    {
        return $this->pluck('description', $typeId);
    }

    public function status($typeId = null)
    {
        return $this->pluck('status', $typeId);
    }

    public function createdAt($typeId = null)
    {
        return $this->pluck('created_at', $typeId);
    }

    //total records -->return number
    public function totalRecords()
    {
        return TfBusinessType::where('action', 1)->count();
    }


    #========== ========== ========== check info ========== ========== ==========
    //check exist of name
    public function existName($name)
    {
        $result = TfBusinessType::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditName($name, $typeId)
    {
        $result = TfBusinessType::where('name', $name)->where('type_id', '<>', $typeId)->count();
        return ($result > 0) ? true : false;
    }

    #========== ========== ========== Access business type on map ========== ========== ==========
    //save business accept to map
    public function setAccess($businessTypeId)
    {
        $dataBusinessType = TfBusinessType::find($businessTypeId);
        Session::put('accessBusinessType', $dataBusinessType);
    }

    public function deleteAccess()
    {
        return Session::forget('accessBusinessType');
    }

    public function getAccess()
    {
        if (Session::has('accessBusinessType')) {
            return Session::get('accessBusinessType');
        } else {
            return null;
        }
    }
}
