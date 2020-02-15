<?php namespace App\Models\Manage\Content\Sample\ProjectIcon;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class TfProjectIconSample extends Model
{

    protected $table = 'tf_project_icon_samples';
    protected $fillable = ['sample_id', 'name', 'image', 'price', 'private', 'status', 'action', 'created_at', 'size_id', 'design_id', 'staff_id'];
    protected $primaryKey = 'sample_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert -----------
    public function insert($image, $price, $private, $sizeId, $designId = null, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelSample = new TfProjectIconSample();
        $modelSample->name = "ICON-" . $hFunction->getTimeCode();
        $modelSample->image = $image;
        $modelSample->price = $price;
        $modelSample->private = $private;
        $modelSample->status = 1; //default
        $modelSample->action = 1; //default
        $modelSample->size_id = $sizeId;
        $modelSample->design_id = $designId;
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
        $pathImage = "public/images/sample/project-icon";
        if (!is_dir($pathImage)) mkdir($pathImage);
        return $hFunction->uploadSaveNoResize($file, $pathImage . '/', $imageName);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/sample/project-icon/' . $imageName);
    }

    #---------- Update -----------
    public function updateStatus($sampleId, $status)
    {
        return TfProjectIconSample::where('sample_id', $sampleId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($sampleId)
    {
        return TfProjectIconSample::where('sample_id', $sampleId)->update(['action' => 0]);
    }

    #=========== =========== =========== RELATION =========== ========== ===========
    # --------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Map\Project\TfProject', 'App\Models\Manage\Content\Map\Project\Icon\TfProjectIcon', 'sample_id', 'project_id');
    }

    # ---------- TF-PROJECT-ICON ----------
    public function projectIcon()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Icon\TfProjectIcon', 'sample_id', 'sample_id');
    }

    #------------- TF-DESIGN-STORE -------------
    public function designStore()
    {
        #return $this->belongsTo('App\Models\Manage\Content\Design\TfDesignStore');
    }

    #------------ TF-STAFF --------------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #-------------- TF-SIZE -------------
    public function size()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Size\TfSize', 'size_id', 'size_id');
    }


    #=========== =========== =========== GET INFO =========== ========== ===========
    public function getInfo($sampleId = null, $field = null)
    {
        if (empty($sampleId)) {
            return TfProjectIconSample::where('action', 1)->get();
        } else {
            $result = TfProjectIconSample::where('sample_id', $sampleId)->first();
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
            return TfProjectIconSample::where('sample_id', $objectId)->pluck($column);
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

    public function createdAt($sampleId = null)
    {
        return $this->pluck('created_at', $sampleId);
    }

    public function staffId($sampleId = null)
    {
        return $this->pluck('staff_id', $sampleId);
    }

    public function sizeId($sampleId = null)
    {
        return $this->pluck('size_id', $sampleId);
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

    # last id
    public function lastID()
    {
        $objectSample = TfProjectIconSample::orderBy('sample_id', 'DESC')->first();
        return (empty($objectSample)) ? 0 : $objectSample->sample_id;
    }

    # total records
    public function totalRecords()
    {
        return TfProjectIconSample::where('action', 1)->count();
    }

    #path image
    public function pathImage($image = null)
    {
        if (empty($image)) $image = $this->image;
        return asset("public/images/sample/project-icon/$image");
    }

    #=========== =========== =========== CHECK INFO =========== =========== ===========

    # check private status of sample
    public function checkPrivate($sampleId = '')
    {
        $sample = TfProjectIconSample::where('sample_id', $sampleId)->where('private', 1)->count();
        return ($sample > 0) ? true : false;
    }

    # get list sample
    public function sampleIsUsing()
    {
        return TfProjectIconSample::where('status', 1)->where('action', 1)->get();
    }
}
