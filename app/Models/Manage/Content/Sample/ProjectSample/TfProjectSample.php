<?php namespace App\Models\Manage\Content\Sample\ProjectSample;

use App\Models\Manage\Content\Sample\ProjectBackground\TfProjectBackground;
use App\Models\Manage\Content\Sample\ProjectSampleBanner\TfProjectSampleBanner;
use App\Models\Manage\Content\Sample\ProjectSampleLand\TfProjectSampleLand;
use App\Models\Manage\Content\Sample\ProjectSamplePublic\TfProjectSamplePublic;
use Illuminate\Database\Eloquent\Model;

class TfProjectSample extends Model
{

    protected $table = 'tf_project_samples';
    protected $fillable = ['project_id', 'code', 'description', 'image', 'build', 'confirm', 'valid', 'publish', 'status', 'action', 'staff_id', 'created_at', 'updated_at'];
    protected $primaryKey = 'project_id';
    public $timestamps = false;

    private $lastId;

    #========== ============ =========== INSERT & UPDATE ========== ========== ==========
    #------------ Insert -----------
    public function insert($image, $staffId, $description = null, $backgroundId = null)
    {
        $hFunction = new \Hfunction();
        $modelProject = new TfProjectSample();
        $modelProject->code = "PS" . $hFunction->getTimeCode();
        $modelProject->description = $description;
        $modelProject->image = $image;
        $modelProject->staff_id = $staffId;
        $modelProject->background_id = $backgroundId;
        $modelProject->created_at = $hFunction->createdAt();
        if ($modelProject->save()) {
            $this->lastId = $modelProject->project_id;
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

    #------------ Update ------------
    public function updateInfo($image, $staffId, $description, $projectId = null)
    {
        if (empty($projectId)) $projectId = $this->projectId();
        $modelProject = TfProjectSample::find($projectId);
        $modelProject->image = $image;
        $modelProject->description = $description;
        $modelProject->staff_id = $staffId;
        return $modelProject->save();
    }

    # status
    public function updateStatus($status, $projectId = null)
    {
        if (empty($projectId)) $projectId = $this->projectId();
        return TfProjectSample::where('project_id', $projectId)->update(['status' => $status]);
    }

    # background
    public function updateBackground($backgroundId, $projectId = null)
    {
        if (empty($projectId)) $projectId = $this->projectId();
        return TfProjectSample::where('project_id', $projectId)->update(['background_id' => $backgroundId]);
    }

    # delete
    public function actionDelete($projectId = null)
    {
        if (empty($projectId)) $projectId = $this->projectId();
        return TfProjectSample::where('project_id', $projectId)->update(['action' => 0]);
    }

    #------------ Build -----------
    #finish build
    public function finishBuild($projectId = null)
    {
        if (empty($projectId)) $projectId = $this->projectId();
        return TfProjectSample::where('project_id', $projectId)->update(['build' => 0]);
    }

    #open build
    public function openBuild($projectId = null)
    {
        if (empty($projectId)) $projectId = $this->projectId();
        return TfProjectSample::where('project_id', $projectId)->update(['build' => 1, 'publish' => 0, 'confirm' => 0, 'valid' => 0]);
    }

    #------------ Publish -----------
    public function publishAgree($projectId = null)
    {
        if (empty($projectId)) $projectId = $this->projectId();
        return TfProjectSample::where('project_id', $projectId)->update(['confirm' => 1, 'publish' => 1, 'valid' => 1]);
    }

    public function publishDisagree($projectId = null)
    {
        if (empty($projectId)) $projectId = $this->projectId();
        return TfProjectSample::where('project_id', $projectId)->update(['confirm' => 1, 'publish' => 0, 'valid' => 0]);
    }
    #========== ============ =========== RELATION ========== ========== ==========
    # ---------- TF-STAFF ----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\staff\TfStaff', 'staff_id', 'staff_id');
    }

    # ---------- TF-PROJECT-SAMPLE-BANNER ----------
    public function projectSampleBanner()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\ProjectSampleBanner\TfProjectSampleBanner', 'project_id', 'project_id');
    }

    # ---------- TF-PROJECT-SAMPLE-LAND ----------
    public function projectSampleLand()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\ProjectSampleLand\TfProjectSampleLand', 'project_id', 'project_id');
    }

    # ---------- TF-PROJECT-SAMPLE-PUBLIC ----------
    public function projectSamplePublic()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\ProjectSamplePublic\TfProjectSamplePublic', 'project_id', 'project_id');
    }

    # ---------- TF-PROJECT-BACKGROUND ----------
    public function projectBackground()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\ProjectBackground', 'background_id', 'background_id');
    }

    #========== ============ =========== INFO ========== ========== ==========
    public function findInfo($objectId)
    {
        return TfProjectSample::find($objectId);
    }

    # ---------- TF-PROJECT-BACKGROUND ----------
    public function pathImageBackground($defaultStatus = true, $projectId = null)
    {
        $backgroundId = $this->backgroundId($projectId);
        if (!empty($backgroundId)) {
            $dataProjectBackground = TfProjectBackground::find($backgroundId);
            return $dataProjectBackground->pathFullImage();
        } else {
            if ($defaultStatus) {
                return asset('public/main/icons/background_3d.png');
            } else {
                return null;
            }
        }
    }

    #---------- TF-PROJECT-SAMPLE-PUBLIC ----------
    public function publicInfo($projectId = null)
    {
        $model = new TfProjectSamplePublic();
        if (empty($projectId)) $projectId = $this->projectId();
        return $model->infoOfProject($projectId);
    }

    #---------- TF-PROJECT-SAMPLE-BANNER ----------
    public function bannerInfo($projectId = null)
    {
        $model = new TfProjectSampleBanner();
        if (empty($projectId)) $projectId = $this->projectId();
        return $model->infoOfProject($projectId);
    }


    #---------- TF-PROJECT-SAMPLE-LAND ----------
    public function landInfo($projectId = null)
    {
        $model = new TfProjectSampleLand();
        if (empty($projectId)) $projectId = $this->projectId();
        return $model->infoOfProject($projectId);
    }


    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProjectSample::where('project_id', $objectId)->pluck($column);
        }
    }

    public function projectId()
    {
        return $this->project_id;
    }

    public function code($projectId = null)
    {
        return $this->pluck('code', $projectId);
    }

    public function image($projectId = null)
    {
        return $this->pluck('image', $projectId);
    }

    public function description($projectId = null)
    {
        return $this->pluck('description', $projectId);
    }

    public function build($projectId = null)
    {
        return $this->pluck('build', $projectId);
    }

    public function confirm($projectId = null)
    {
        return $this->pluck('confirm', $projectId);
    }

    public function valid($projectId = null)
    {
        return $this->pluck('valid', $projectId);
    }

    public function publish($projectId = null)
    {
        return $this->pluck('publish', $projectId);
    }

    public function status($projectId = null)
    {
        return $this->pluck('status', $projectId);
    }

    public function staffId($projectId = null)
    {
        return $this->pluck('staff_id', $projectId);
    }

    public function backgroundId($projectId = null)
    {
        return $this->pluck('background_id', $projectId);
    }

    public function createdAt($projectId = null)
    {
        return $this->pluck('created_at', $projectId);
    }

    public function updateAt($projectId = null)
    {
        return $this->pluck('update_at', $projectId);
    }

    # get path image
    public function pathSmallImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset('public/images/sample/project-sample/small/' . $image);
    }

    public function pathFullImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset('public/images/sample/project-sample/full/' . $image);
    }

    public function totalRecords()
    {
        return TfProjectSample::count();
    }

    public function projectTool()
    {
        return TfProjectSample::where([
            'publish' => 1,
            'status' => 1,
            'action' => 1
        ])->orderBy('project_id', 'ASC')->get();
    }

    #------------ CHECK INFO ---------------
    public function checkBuild($projectId = null)
    {
        $buildStatus = $this->build($projectId);
        return ($buildStatus == 1) ? true : false;
    }
}
