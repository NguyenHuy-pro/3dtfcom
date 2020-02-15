<?php namespace App\Models\Manage\Content\Map\Land\RequestBuild;


use App\Models\Manage\Content\Map\Land\RequestBuildDesign\TfLandRequestBuildDesign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class TfLandRequestBuild extends Model
{

    protected $table = 'tf_land_request_builds';
    protected $fillable = ['request_id', 'imageSample', 'designDescription', 'buildingName', 'buildingDisplayName', 'buildingPhone', 'buildingEmail', 'buildingAddress', 'buildingWebsite', 'buildingShortDescription', 'buildingDescription', 'point', 'action', 'created_at', 'type_id', 'license_id'];
    protected $primaryKey = 'request_id';
    public $timestamps = false;

    private $lastId;
    #=========== =========== =========== INSERT && UPDATE =========== =========== ===========
    #----------- Insert -----------
    public function insert($imageSample, $designDescription, $buildingName, $buildingDisplayName, $buildingPhone, $buildingEmail, $buildingAddress, $buildingWebsite, $buildingShortDescription, $buildingDescription, $point, $typeId, $licenseId)
    {
        $hFunction = new \Hfunction();
        $modelRequestBuild = new TfLandRequestBuild();
        $modelRequestBuild->imageSample = $imageSample;
        $modelRequestBuild->designDescription = $designDescription;
        $modelRequestBuild->buildingName = $buildingName;
        $modelRequestBuild->buildingDisplayName = $buildingDisplayName;
        $modelRequestBuild->buildingPhone = $buildingPhone;
        $modelRequestBuild->buildingEmail = $buildingEmail;
        $modelRequestBuild->buildingAddress = $buildingAddress;
        $modelRequestBuild->buildingWebsite = $buildingWebsite;
        $modelRequestBuild->buildingShortDescription = $buildingShortDescription;
        $modelRequestBuild->buildingDescription = $buildingDescription;
        $modelRequestBuild->point = $point;
        $modelRequestBuild->action = 1;
        $modelRequestBuild->type_id = $typeId;
        $modelRequestBuild->license_id = $licenseId;
        $modelRequestBuild->created_at = $hFunction->createdAt();
        if ($modelRequestBuild->save()) {
            $this->lastId = $modelRequestBuild->request_id;
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

    //upload image
    public function uploadImage($file, $imageName)
    {
        $hFunction = new \Hfunction();
        $pathImage = "public/images/map/land/request-build";
        if (!is_dir($pathImage)) mkdir($pathImage);
        return $hFunction->uploadSave($file, $pathImage . '/', $pathImage . '/', $imageName, 200);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/map/land/request-build/' . $imageName);
    }

    #---------- Update ------------
    public function actionDelete($requestId)
    {
        $modelLandRequestBuildDesign = new TfLandRequestBuildDesign();
        if (TfLandRequestBuild::where('request_id', $requestId)->where('action', 1)->update(['action' => 0])) {
            return $modelLandRequestBuildDesign->deleteByRequest($requestId);
        } else {
            return false;
        }
    }

    public function deleteByLicense($licenseId)
    {
        $dataLandRequestBuild = $this->infoActiveOfLicense($licenseId);
        if (count($dataLandRequestBuild) > 0) {
            return $this->actionDelete($dataLandRequestBuild->requestId());
        }
    }

    #=========== ========== ========== RELATION =========== ========== =========
    #-----------TF-LAND-LICENSE -----------
    public function landLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'license_id', 'license_id');
    }

    public function existLandLicense($licenseId)
    {
        $result = TfLandRequestBuild::where(['license_id' => $licenseId, 'action' => 1])->count();
        return ($result > 0) ? true : false;
    }

    public function infoActiveOfLicense($licenseId)
    {
        return TfLandRequestBuild::where(['license_id' => $licenseId, 'action' => 1])->first();
    }
    #-----------TF-BUSINESS-TYPE -----------
    public function businessType()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\BusinessType\TfBusinessType', 'type_id', 'type_id');
    }

    # ---------- TF-LAND-REQUEST-BUILD-DESIGN ---------
    public function landRequestBuildDesign()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\RequestBuildDesign\TfLandRequestBuildDesign', 'request_id', 'request_id');
    }

    public function landRequestBuildDesignOfRequest($requestId = null)
    {
        $modelLandRequestBuildDesign = new TfLandRequestBuildDesign();
        $requestId = (!empty($requestId)) ? $requestId : $this->requestId();
        return $modelLandRequestBuildDesign->infoActivityOfRequestBuild($requestId);
    }

    #=========== ========== ========== GET INFO INFO =========== ========== =========
    public function getInfo($requestId = null, $field = null)
    {
        if (empty($requestId)) {
            return TfLandRequestBuild::where('action', 1)->get();
        } else {
            $result = TfLandRequestBuild::where(['request_id' => $requestId, 'action' => 1])->first();
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
            return TfLandRequestBuild::where('request_id', $objectId)->pluck($column);
        }
    }

    public function requestId()
    {
        return $this->request_id;
    }

    public function imageSample($requestId = null)
    {
        return $this->pluck('imageSample', $requestId);
    }

    public function designDescription($requestId = null)
    {
        return $this->pluck('designDescription', $requestId);
    }

    public function buildingName($requestId = null)
    {
        return $this->pluck('buildingName', $requestId);
    }

    public function buildingDisplayName($requestId = null)
    {
        return $this->pluck('buildingDisplayName', $requestId);
    }

    public function buildingPhone($requestId = null)
    {
        return $this->pluck('buildingPhone', $requestId);
    }

    public function buildingEmail($requestId = null)
    {
        return $this->pluck('buildingEmail', $requestId);
    }

    public function buildingAddress($requestId = null)
    {
        return $this->pluck('buildingAddress', $requestId);
    }

    public function buildingWebsite($requestId = null)
    {
        return $this->pluck('buildingWebsite', $requestId);
    }

    public function buildingShortDescription($requestId = null)
    {
        return $this->pluck('buildingShortDescription', $requestId);
    }

    public function buildingDescription($requestId = null)
    {
        return $this->pluck('buildingDescription', $requestId);
    }

    public function point($requestId = null)
    {
        return $this->pluck('point', $requestId);
    }

    public function typeId($requestId = null)
    {
        return $this->pluck('type_id', $requestId);
    }

    public function licenseId($requestId = null)
    {
        return $this->pluck('license_id', $requestId);
    }

    public function createdAt($requestId = null)
    {
        return $this->pluck('created_at', $requestId);
    }

    public function pathImage($image = null)
    {
        $image = (!empty($image)) ? $image : $this->imageSample();
        return asset("public/images/map/land/request-build/$image");
    }

    # total records -->return number
    public function totalRecords()
    {
        return TfLandRequestBuild::where('action', 1)->count();
    }

    #=========== ========== ========== CHECK INFO =========== ========== =========


}
