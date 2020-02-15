<?php namespace App\Models\Manage\Content\Sample\Publics;

use App\Models\Manage\Content\Sample\PublicType\TfPublicType;
use Illuminate\Database\Eloquent\Model;
use DB;
use FIle;

class TfPublicSample extends Model
{

    protected $table = 'tf_public_samples';
    protected $fillable = ['sample_id', 'name', 'image', 'status', 'action', 'created_at', 'size_id', 'type_id', 'staff_id'];
    protected $primaryKey = 'sample_id';
    public $timestamps = false;

    private $lastId;

    #=========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert -----------
    public function insert($image, $sizeId, $publicTypeId, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelSample = new TfPublicSample();
        $modelSample->name = "public-" . $hFunction->getTimeCode();
        $modelSample->image = $image;
        $modelSample->status = 1; //default
        $modelSample->action = 1; //default
        $modelSample->size_id = $sizeId;
        $modelSample->type_id = $publicTypeId;
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
        $pathImage = "public/images/sample/public";
        if (!is_dir($pathImage)) mkdir($pathImage);
        return $hFunction->uploadSaveNoResize($file, $pathImage . '/', $imageName);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/sample/public/' . $imageName);
    }

    #---------- Update ---------
    public function updateStatus($sampleId = '', $status = '')
    {
        return TfPublicSample::where('sample_id', $sampleId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($sampleId = null)
    {
        if (empty($sampleId)) $sampleId = $this->sampleId();
        return TfPublicSample::where('sample_id', $sampleId)->update(['action' => 0]);
    }

    #=========== ========== ========== RELATION ========== ========== ==========
    # ---------- TF-PUBLIC ---------
    public function publics()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Publics\TfPublic', 'sample_id', 'sample_id');
    }

    # ---------- TF-PUBLIC-TYPE ---------
    public function publicType()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\PublicType\TfPublicType', 'type_id', 'type_id');
    }

    # ---------- TF-STAFF ---------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    # ---------- TF-SIZE ---------
    public function size()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Size\TfSize', 'size_id', 'size_id');
    }

    # --------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Map\Project\TfProject', 'App\Models\Manage\Content\Map\Publics\TfPublic', 'sample_id', 'project_id');
    }

    #=========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($sampleId = '', $field = '')
    {
        if (empty($sampleId)) {
            return TfPublicSample::where('action', 1)->orderBy('name', 'ASC')->get();
        } else {
            $result = TfPublicSample::where('sample_id', $sampleId)->first();
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
            return TfPublicSample::where('sample_id', $objectId)->pluck($column);
        }
    }

    public function sampleId()
    {
        return $this->sample_id;
    }

    public function name($sampleId = null)
    {
        return $this->pluck('name', $sampleId);
    }

    public function image($sampleId = null)
    {
        return $this->pluck('image', $sampleId);
    }

    public function status($sampleId = null)
    {
        return $this->pluck('status', $sampleId);
    }

    public function typeId($sampleId = null)
    {
        return $this->pluck('type_id', $sampleId);
    }

    public function createdAt($sampleId = null)
    {
        return $this->pluck('created_at', $sampleId);
    }

    public function sizeId($sampleId = null)
    {
        return $this->pluck('size_id', $sampleId);
    }

    public function staffId($sampleId = null)
    {
        return $this->pluck('staff_id', $sampleId);
    }

    # last id
    public function lastId()
    {
        $result = TfPublicSample::orderBy('sample_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->sample_id;
    }

    # total records
    public function totalRecords()
    {
        return TfPublicSample::where('action', 1)->count();
    }

    #path image
    public function pathImage($image = null)
    {
        if (empty($image)) $image = $this->image;
        return (empty($image)) ? $image : asset("public/images/sample/public/$image");
    }

    #check way
    public function checkWay($sampleId = null)
    {
        $modelPublicType = new TfPublicType();
        $typeId = $this->typeId($sampleId);
        return $modelPublicType->checkWay($typeId);
    }

    #build tool
    public function publicTool($typeId)
    {
        return TfPublicSample::where('type_id', $typeId)->where('action', 1)->get();
    }
}
