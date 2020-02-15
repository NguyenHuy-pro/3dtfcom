<?php namespace App\Models\Manage\Content\Sample\Banner;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class TfBannerSample extends Model
{

    protected $table = 'tf_banner_samples';
    protected $fillable = ['sample_id', 'name', 'image', 'border', 'status', 'action', 'created_at', 'size_id', 'staff_id'];
    protected $primaryKey = 'sample_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert -----------
    public function insert($image, $border, $sizeId, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelSample = new TfBannerSample();
        $modelSample->name = "BAN-" . $hFunction->getTimeCode();
        $modelSample->image = $image;
        $modelSample->border = $border;
        $modelSample->status = 1; //default
        $modelSample->action = 1; //default
        $modelSample->size_id = $sizeId;
        $modelSample->staff_id = $staffId;
        $modelSample->created_at = $hFunction->createdAt();
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
        $pathImage = "public/images/sample/banner";
        if (!is_dir($pathImage)) mkdir($pathImage);
        return $hFunction->uploadSaveNoResize($file, $pathImage . '/', $imageName);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/sample/banner/' . $imageName);
    }

    #---------- Update ---------
    public function updateStatus($sampleId, $status)
    {
        return TfBannerSample::where('sample_id', $sampleId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($sampleId = null)
    {
        if (empty($sampleId)) $sampleId = $this->sampleId();
        return TfBannerSample::where('sample_id', $sampleId)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
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

    # --------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Map\Project\TfProject', 'App\Models\Manage\Content\Map\Banner\TfBanner', 'sample_id', 'project_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($sampleId = '', $field = '')
    {
        if (empty($sampleId)) {
            return TfBannerSample::where('action', 1)->get();
        } else {
            $result = TfBannerSample::where('sample_id', $sampleId)->first();
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
            return TfBannerSample::where('sample_id', $objectId)->pluck($column);
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

    public function staffId($sampleId = null)
    {
        return $this->pluck('staff_id', $sampleId);
    }

    public function name($sampleId = null)
    {
        return $this->pluck('name', $sampleId);
    }

    public function image($sampleId = null)
    {
        return $this->pluck('image', $sampleId);
    }

    public function border($sampleId = null)
    {
        return $this->pluck('border', $sampleId);
    }

    public function status($sampleId = null)
    {
        return $this->pluck('status', $sampleId);
    }

    public function createdAt($sampleId = null)
    {
        return $this->pluck('created_at', $sampleId);
    }

    #last id
    public function lastId()
    {
        $result = TfBannerSample::orderBy('sample_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->sample_id;
    }

    # total records
    public function totalRecords()
    {
        return TfBannerSample::where('action', 1)->count();
    }

    public function pathImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return (empty($image)) ? $image : asset("public/images/sample/banner/$image");
    }

    #get sample when build
    public function bannerTool()
    {
        return TfBannerSample::where('status', 1)->where('action', 1)->orderBy('size_id', 'ASC')->get();
    }

}
