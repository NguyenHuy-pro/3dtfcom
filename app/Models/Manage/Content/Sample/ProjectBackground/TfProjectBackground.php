<?php namespace App\Models\Manage\Content\Sample\ProjectBackground;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class TfProjectBackground extends Model
{

    protected $table = 'tf_project_backgrounds';
    protected $fillable = ['background_id', 'name', 'image', 'status', 'action', 'created_at'];
    protected $primaryKey = 'background_id';
    public $timestamps = false;

    private $lastId;

    #========== ============ =========== INSERT & UPDATE ========== ========== ==========
    #------------ Insert -----------
    public function insert($image)
    {
        $hFunction = new \Hfunction();
        $modelProjectBackground = new TfProjectBackground();
        $modelProjectBackground->name = "PB" . $hFunction->getTimeCode();
        $modelProjectBackground->image = $image;
        $modelProjectBackground->created_at = $hFunction->createdAt();
        if ($modelProjectBackground->save()) {
            $this->lastId = $modelProjectBackground->background_id;
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
        $pathFullImage = "public/images/sample/project-background/full";
        $pathSmallImage = "public/images/sample/project-background/small";
        if (!is_dir($pathFullImage)) mkdir($pathFullImage);
        if (!is_dir($pathSmallImage)) mkdir($pathSmallImage);
        return $hFunction->uploadSave($file, $pathSmallImage.'/', $pathFullImage.'/', $imageName, 200);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/sample/project-background/full/' . $imageName);
        File::delete('public/images/sample/project-background/small/' . $imageName);
    }

    #------------ Update ------------
    public function updateInfo($image, $backgroundId = null)
    {
        if (empty($backgroundId)) $backgroundId = $this->backgroundId();
        $modelProjectBackground = TfProjectBackground::find($backgroundId);
        $modelProjectBackground->image = $image;
        return $modelProjectBackground->save();
    }

    # status
    public function updateStatus($status, $backgroundId = null)
    {
        if (empty($backgroundId)) $backgroundId = $this->backgroundId();
        return TfProjectBackground::where('background_id', $backgroundId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($backgroundId = null)
    {
        if (empty($backgroundId)) $backgroundId = $this->backgroundId();
        return TfProjectBackground::where('background_id', $backgroundId)->update(['action' => 0]);
    }

    # delete
    public function actionDrop($backgroundId = null)
    {
        if (empty($backgroundId)) $backgroundId = $this->backgroundId();
        return TfProjectBackground::where('background_id', $backgroundId)->delete();
    }

    #========== ========= =========== RELATION ========== ========= ===========
    # ---------- TF-PROJECT ----------
    public function project()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project', 'background_id', 'background_id');
    }

    # ---------- TF-PROJECT-SAMPLE ----------
    public function projectSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\ProjectSample', 'background_id', 'background_id');
    }

    #========== ========= =========== GET INFO ========== ========= ===========
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProjectBackground::where('background_id', $objectId)->pluck($column);
        }
    }

    public function backgroundId()
    {
        return $this->background_id;
    }

    public function name($backgroundId = null)
    {
        return $this->pluck('name', $backgroundId);
    }

    public function image($backgroundId = null)
    {
        return $this->pluck('image', $backgroundId);
    }

    public function status($backgroundId = null)
    {
        return $this->pluck('status', $backgroundId);
    }

    public function createdAt($backgroundId = null)
    {
        return $this->pluck('created_at', $backgroundId);
    }

    # get path image
    public function pathSmallImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset('public/images/sample/project-background/small/' . $image);
    }

    public function pathFullImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset('public/images/sample/project-background/full/' . $image);
    }

    public function totalRecords()
    {
        return TfProjectBackground::where(['action' => 1])->count();
    }

    #-----
    public function backgroundTool()
    {
        return TfProjectBackground::where('action', 1)->get();
    }
}
