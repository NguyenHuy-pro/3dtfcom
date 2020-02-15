<?php namespace App\Models\Manage\Content\Sample\Building;

use App\Models\Manage\Content\Sample\BuildingSampleLicense\TfBuildingSampleLicense;
use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class TfBuildingSample extends Model
{

    protected $table = 'tf_building_samples';
    protected $fillable = ['sample_id', 'name', 'image', 'price', 'private', 'status', 'action', 'created_at', 'size_id', 'design_id', 'requestBuildDesign_id', 'businessType_id', 'staff_id'];
    protected $primaryKey = 'sample_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert -----------
    public function insert($image, $price, $private, $sizeId, $designId, $businessTypeId, $staffId, $requestBuildDesignId=null)
    {
        $hFunction = new \Hfunction();
        $modelSample = new TfBuildingSample();
        $modelSample->name = "BUILDING-" . $hFunction->getTimeCode();
        $modelSample->image = $image;
        $modelSample->price = $price;
        $modelSample->private = $private;
        $modelSample->status = 1; //default
        $modelSample->action = 1; //default
        $modelSample->size_id = $sizeId;
        $modelSample->design_id = $designId;
        $modelSample->requestBuildDesign_id = $requestBuildDesignId;
        $modelSample->businessType_id = $businessTypeId;
        $modelSample->staff_id = $staffId;
        $modelSample->created_at = $hFunction->carbonNow();
        if ($modelSample->save()) {
            $this->lastId = $modelSample->sample_id;
            return true;
        } else {
            return false;
        }

    }

    # get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    //upload image
    public function uploadImage($file, $imageName)
    {
        $hFunction = new \Hfunction();
        $pathImage = "public/images/sample/building";
        if (!is_dir($pathImage)) mkdir($pathImage);
        return $hFunction->uploadSaveNoResize($file, $pathImage . '/', $imageName);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/sample/building/' . $imageName);
    }

    #----------- Update -----------
    public function updateStatus($sampleId, $status)
    {
        return TfBuildingSample::where('sample_id', $sampleId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($sampleId = null)
    {
        if (empty($sampleId)) $sampleId = $this->samppleId();
        return TfBuildingSample::where('sample_id', $sampleId)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-DESIGN -----------
    public function design()
    {
        return $this->belongsTo('App\Models\Manage\Content\Design\Store\TfDesignStore', 'design_id', 'design_id');
    }

    #----------- TF-LAND-REQUEST-BUILD-DESIGN -----------
    public function landRequestBuildDesign()
    {
        return $this->belongsTo('App\Models\Manage\Content\Design\Store\TfLandRequestBuildDesign', 'design_id', 'requestBuildDesign_id');
    }

    #----------- TF-BUSINESS-TYPE -----------
    public function businessType()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\BusinessType\TfBusinessType', 'businessType_id', 'type_id');
    }

    #---------- TF-STAFF ----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #---------- TF-SIZE ----------
    public function size()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Size\TfSize', 'size_id', 'size_id');
    }

    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\TfBuilding', 'sample_id', 'sample_id');
    }

    #----------- TF-BUILDING-SAMPLE-LICENSE -----------
    public function buildingSampleLicense()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\BuildingSampleLicense\TfBuildingSampleLicense', 'sample_id', 'sample_id');
    }

    # --------- TF-USER----------
    public function user()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Users\TfUser', 'App\Models\Manage\Content\Sample\BuildingSampleLicense\TfBuildingSampleLicense', 'sample_id', 'user_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($sampleId = '', $field = '')
    {
        if (empty($sampleId)) {
            return TfBuildingSample::where('action', 1)->get();
        } else {
            $result = TfBuildingSample::where('sample_id', $sampleId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #----------- TF-BUSINESS-TYPE -----------
    #sample info of a business type
    public function infoOfBusinessType($businessTypeId)
    {
        return TfBuildingSample::where('businessType_id', $businessTypeId)->where('status', 1)->get();
    }

    # list sample id of business type
    public function listIdOfBusinessType($businessTypeId)
    {
        return TfBuildingSample::where('businessType_id', $businessTypeId)->where('status', 1)->lists('sample_id');
    }

    #-----------  SAMPlE INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuildingSample::where('sample_id', $objectId)->pluck($column);
        }
    }

    public function sampleId()
    {
        return $this->sample_id;
    }

    public function sizeId($sampleId = null)
    {
        return $this->pluck('size_id', $sampleId);
    }

    public function name($sampleId = null)
    {
        return $this->pluck('name', $sampleId);
    }

    public function image($sampleId = null)
    {
        return $this->pluck('image', $sampleId);
    }

    public function price($sampleId = null)
    {
        return $this->pluck('price', $sampleId);
    }

    public function privateStatus($sampleId = null)
    {
        return $this->pluck('private', $sampleId);
    }

    public function status($sampleId = null)
    {
        return $this->pluck('status', $sampleId);
    }

    public function designId($sampleId = null)
    {
        return $this->pluck('design_id', $sampleId);
    }

    public function businessTypeId($sampleId = null)
    {
        return $this->pluck('businessType_id', $sampleId);
    }

    public function createdAt($sampleId = null)
    {
        return $this->pluck('created_at', $sampleId);
    }

    # last id
    public function lastId()
    {
        $objectSample = TfBuildingSample::orderBy('sample_id', 'DESC')->first();
        return (empty($objectSample)) ? 0 : $objectSample->sample_id;
    }

    # total records
    public function totalRecords()
    {
        return TfBuildingSample::where('action', 1)->count();
    }

    public function pathRootImage()
    {
        return 'public/images/sample/building';
    }

    public function pathImage($image = null)
    {
        if (empty($image)) $image = $this->image;
        return (empty($image)) ? $image : asset("public/images/sample/building/$image");
    }

    #========== ========== ========== CHECK INFO ========== ========== ==========
    # check private status of sample
    public function checkPrivate($sampleId = '')
    {
        $sample = TfBuildingSample::where('sample_id', $sampleId)->where('private', 1)->count();
        return ($sample > 0) ? true : false;
    }

    #========== ========== ========== GENERAL ========== ========== ==========

    #----------- ----------- BUILD ON LAND ----------- -----------
    #take buildings sample  of system when build on a land or edit sample of building
    public function getBuildingSampleForBuild($sizeId = null, $privateStatus = null, $businessTypeId = '')
    {
        $modelUser = new TfUser();
        $modelSize = new TfSize();
        $modelBuildingSampleLicense = new TfBuildingSampleLicense();

        $loginUserId = $modelUser->loginUserId();
        #sample of user
        $listSampleId = $modelBuildingSampleLicense->listSampleIDOfUser($loginUserId);

        # size info
        $listSizeId = $modelSize->listSizeIDSameSize($sizeId);


        if (empty($businessTypeId) or $businessTypeId == 0) {
            # show all
            if ($privateStatus == 0) {
                # public and has not owner
                $dataBuildingSample = TfBuildingSample::whereNotIn('sample_id', $listSampleId)->where('private',$privateStatus)->whereIn('size_id', $listSizeId)->get();
            } else {
                # private and have  owned
                $dataBuildingSample = TfBuildingSample::whereIn('sample_id', $listSampleId)->whereIn('size_id', $listSizeId)->get();
            }
        } else {

            #filter by business type
            if ($privateStatus == 0) {
                # public and has not own
                $dataBuildingSample = TfBuildingSample::whereNotIn('sample_id', $listSampleId)->where('private',$privateStatus)->whereIn('size_id', $listSizeId)->where('businessType_id', $businessTypeId)->get();
            } else {
                # private and has not own
                $dataBuildingSample = TfBuildingSample::whereIn('sample_id', $listSampleId)->whereIn('size_id', $listSizeId)->where('businessType_id', $businessTypeId)->get();
            }
        }
        return $dataBuildingSample;
    }
}
