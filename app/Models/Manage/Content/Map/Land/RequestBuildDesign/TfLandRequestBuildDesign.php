<?php namespace App\Models\Manage\Content\Map\Land\RequestBuildDesign;

use App\Models\Manage\Content\Building\Business\TfBuildingBusiness;
use App\Models\Manage\Content\Building\Notify\TfBuildingNewNotify;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Map\Land\License\TfLandLicense;
use App\Models\Manage\Content\Map\Land\RequestBuild\TfLandRequestBuild;
use App\Models\Manage\Content\Sample\Building\TfBuildingSample;
use App\Models\Manage\Content\Sample\BuildingSampleLicense\TfBuildingSampleLicense;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Relation\TfRelation;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Database\Eloquent\Model;
use File;

class TfLandRequestBuildDesign extends Model
{

    protected $table = 'tf_land_request_build_designs';
    protected $fillable = ['design_id', 'image', 'deliveryDate', 'confirm', 'publish', 'action', 'created_at', 'request_id', 'staff_id', 'size_id'];
    protected $primaryKey = 'design_id';
    public $timestamps = false;

    private $lastId;
    #=========== =========== =========== INSERT && UPDATE =========== =========== ===========
    #----------- Insert -----------
    public function insert($image, $deliveryDate, $requestId, $staffId, $sizeId)
    {
        $hFunction = new \Hfunction();
        $modelBuildDesign = new TfLandRequestBuildDesign();
        $modelBuildDesign->image = $image;
        $modelBuildDesign->deliveryDate = $deliveryDate;
        $modelBuildDesign->confirm = 0;
        $modelBuildDesign->publish = 0;
        $modelBuildDesign->action = 1;
        $modelBuildDesign->size_id = $sizeId;
        $modelBuildDesign->request_id = $requestId;
        $modelBuildDesign->staff_id = $staffId;
        $modelBuildDesign->created_at = $hFunction->carbonNow();
        if ($modelBuildDesign->save()) {
            $this->lastId = $modelBuildDesign->design_id;
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

    public function pathRootImage()
    {
        return 'public/images/sample/land-request-build-design';
    }

    //upload image
    public function uploadImage($file, $imageName)
    {
        $hFunction = new \Hfunction();
        $pathImage = $this->pathRootImage();
        if (!is_dir($pathImage)) mkdir($pathImage);
        return $hFunction->uploadSave($file, $pathImage . '/', $pathImage . '/', $imageName, 200);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete($this->pathRootImage() . '/' . $imageName);
    }

    #up design image
    public function updateImage($imageName, $designId)
    {
        return TfLandRequestBuildDesign::where('design_id', $designId)->update(['image' => $imageName]);
    }

    #conform
    public function publishYes($requestBuildDesignId)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserStatistic = new TfUserStatistic();
        $modelRelation = new TfRelation();
        $modelBuilding = new TfBuilding();
        $modelBusinessType = new TfBusinessType();
        $modelBuildingSample = new TfBuildingSample();
        $modelLandLicense = new TfLandLicense();
        $modelLandRequestBuild = new TfLandRequestBuild();
        $modelLandRequestBuildDesign = new TfLandRequestBuildDesign();
        $modelBuildingSampleLicense = new TfBuildingSampleLicense();
        $dataLandRequestBuildDesign = $modelLandRequestBuildDesign->getInfo($requestBuildDesignId);
        $dataLandRequestBuild = $dataLandRequestBuildDesign->landRequestBuild;
        $price = 0;
        $staffId = $dataLandRequestBuildDesign->staffId();
        $private = 1;
        $businessTypeId = $dataLandRequestBuild->typeId();
        $businessName = $dataLandRequestBuild->businessType->name();
        $imageName = '3d-ads-social-virtual-city-virtual-land-online-marketing-' . $businessName . '-' . $hFunction->getTimeCode();
        $designImageName = $dataLandRequestBuildDesign->image();
        $imageType = $hFunction->getTypeImg($designImageName);
        $newImageName = "$imageName.$imageType";
        $oldPath = $dataLandRequestBuildDesign->pathImage();
        $newPath = $modelBuildingSample->pathRootImage() . "/$newImageName";
        if (copy($oldPath, $newPath)) {
            if ($modelBuildingSample->insert($newImageName, $price, $private, $dataLandRequestBuildDesign->sizeId(), null, $businessTypeId, $staffId, $requestBuildDesignId)) {
                $buildingSampleId = $modelBuildingSample->insertGetId();
                $dataLandRequestBuild = $dataLandRequestBuildDesign->landRequestBuild;
                $buildingName = $dataLandRequestBuild->buildingName();
                $buildingDisplayName = $dataLandRequestBuild->buildingDisplayName();
                $buildingPhone = $dataLandRequestBuild->buildingPhone();
                $buildingWebsite = $dataLandRequestBuild->buildingWebsite();
                $buildingAddress = $dataLandRequestBuild->buildingAddress();
                $buildingEmail = $dataLandRequestBuild->buildingEmail();
                $buildingShortDescription = $dataLandRequestBuild->buildingShortDescription();
                $buildingDescription = $dataLandRequestBuild->buildingDescription();
                $businessTypeId = $dataLandRequestBuild->typeId();
                $landLicenseId = $dataLandRequestBuild->licenseId();
                $userRequestId = $dataLandRequestBuild->landLicense->userId();
                $postRelationId = $modelRelation->publicRelationId();
                //update request build design
                if (TfLandRequestBuildDesign::where(['design_id' => $requestBuildDesignId])->update(['confirm' => 1, 'publish' => 1, 'action' => 0])) {
                    $modelLandRequestBuild->actionDelete($dataLandRequestBuild->requestId());
                }
                //add license for sample
                $modelBuildingSampleLicense->insert($buildingSampleId, $userRequestId);

                //check active status of license
                if($modelLandLicense->checkActive($landLicenseId)){
                    //insert building
                    if ($modelBuilding->insert($buildingName, $buildingDisplayName, $buildingShortDescription, $buildingDescription, $buildingWebsite, $buildingPhone, $buildingAddress, $buildingEmail, $buildingSampleId, $landLicenseId, $postRelationId, null)) {
                        $newBuildingId = $modelBuilding->insertGetId();
                        $dataBusiness = $modelBusinessType->businessOfType($businessTypeId);
                        //add business for building
                        if (count($dataBusiness) > 0) {
                            foreach ($dataBusiness as $business) {
                                $modelBuildingBusiness = new TfBuildingBusiness();
                                $modelBuildingBusiness->insert($newBuildingId, $business->businessId());
                            }
                        }
                        //statistical info of user
                        if ($modelUserStatistic->existUser($userRequestId)) {
                            $modelUserStatistic->plusBuilding($userRequestId);
                        } else {
                            $modelUserStatistic->insert($userRequestId, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0);
                        }

                        //notify new building of request user
                        $listFriend = $modelUser->listFriendId($userRequestId);
                        if (!empty($listFriend)) {
                            foreach ($listFriend as $key => $value) {
                                $modelBuildingNewNotify = new TfBuildingNewNotify();
                                $modelBuildingNewNotify->insert($newBuildingId, $value);
                                $modelUserStatistic->plusActionNotify($value);
                            }
                        }
                    }
                }

            }
        }
    }

    public function publishNo($designId)
    {
        return TfLandRequestBuildDesign::where(['design_id' => $designId])->update(['confirm' => 1, 'action' => 0]);
    }

    #delete
    public function actionDelete($designId)
    {
        return TfLandRequestBuildDesign::where('design_id', $designId)->where('action', 1)->update(['action' => 0]);
    }

    public function deleteByRequest($requestId)
    {
        return TfLandRequestBuildDesign::where(['request_id' => $requestId])->update(['action' => 0]);
    }
    #=========== ========== ========== RELATION =========== ========== =========
    #-----------TF-SIZE -----------
    public function size()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Size\TfSize', 'size_id', 'size_id');
    }

    #-----------TF-LAND-REQUEST-BUILD -----------
    public function landRequestBuild()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\RequestBuild\TfLandRequestBuild', 'request_id', 'request_id');
    }

    public function infoActivityOfRequestBuild($requestId)
    {
        return TfLandRequestBuildDesign::where(['request_id' => $requestId, 'action' => 1])->first();
    }

    #-----------TF-STAFF -----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #-----------TF-BUILDING-SAMPLE -----------
    public function buildingSample()
    {
        return $this->hasOne('App\Models\Manage\Content\Sample\Building\TfBuildingSample', 'requestBuildDesign_id', 'design_id');
    }


    #=========== ========== ========== GET INFO INFO =========== ========== =========
    public function getInfo($objectId = null, $field = null)
    {
        if (empty($objectId)) {
            return TfLandRequestBuildDesign::where('action', 1)->get();
        } else {
            $result = TfLandRequestBuildDesign::where(['design_id' => $objectId, 'action' => 1])->first();
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
            return TfLandRequestBuildDesign::where('design_id', $objectId)->pluck($column);
        }
    }

    public function designId()
    {
        return $this->design_id;
    }

    public function image($designId = null)
    {
        return $this->pluck('image', $designId);
    }

    public function deliveryDate($designId = null)
    {
        return $this->pluck('deliveryDate', $designId);
    }

    public function confirm($designId = null)
    {
        return $this->pluck('confirm', $designId);
    }

    public function publish($designId = null)
    {
        return $this->pluck('publish', $designId);
    }

    public function requestId($designId = null)
    {
        return $this->pluck('request_id', $designId);
    }

    public function sizeId($designId = null)
    {
        return $this->pluck('size_id', $designId);
    }

    public function staffId($designId = null)
    {
        return $this->pluck('staff_id', $designId);
    }

    public function createdAt($designId = null)
    {
        return $this->pluck('created_at', $designId);
    }

    public function pathImage($imageName = null)
    {
        $imageName = (!empty($imageName)) ? $imageName : $this->image();
        return asset("public/images/sample/land-request-build-design/$imageName");
    }

    # total records -->return number
    public function totalRecords()
    {
        return TfLandRequestBuildDesign::where('action', 1)->count();
    }


}
