<?php namespace App\Models\Manage\Content\Map\Project\Build;

use App\Models\Manage\Content\Map\Banner\TfBanner;
use App\Models\Manage\Content\Map\Land\TfLand;
use Illuminate\Database\Eloquent\Model;

class TfProjectBuild extends Model
{

    protected $table = 'tf_project_builds';
    protected $fillable = ['build_id', 'buildStatus', 'finishDate', 'firstStatus', 'publishStatus', 'confirmPublish', 'confirmDate', 'openingDate', 'status', 'action', 'created_at', 'project_id'];
    protected $primaryKey = 'build_id';
    #public $incrementing = false;
    public $timestamps = false;
    public $lastId;

    #============ ============ ============ INSERT && UPDATE =========== ============ ============
    #------------ Insert -----------
    public function insert($projectId, $firstStatus)
    {
        $hFunction = new \Hfunction();
        $modelBuild = new TfProjectBuild();
        $modelBuild->project_id = $projectId;
        $modelBuild->firstStatus = $firstStatus;
        $modelBuild->created_at = $hFunction->createdAt();
        if ($modelBuild->save()) {
            $this->lastId = $modelBuild->build_id;
            return true;
        } else {
            return false;
        }
    }

    #get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #----------- Update -----------
    public function disableStatus($buildId = null)
    {
        if (empty($buildId)) $buildId = $this->buildId();
        return TfProjectBuild::where('build_id', $buildId)->update(['status' => 0]);
    }

    # finish build
    public function finishBuild($buildId = null)
    {
        if (empty($buildId)) $buildId = $this->buildId();
        return TfProjectBuild::where('build_id', $buildId)->update(['buildStatus' => 0, 'finishDate' => date('Y-m-d H:i:s')]);
    }

    # delete
    public function actionDelete($buildId = null)
    {
        if (empty($buildId)) $buildId = $this->buildId();
        return TfProjectBuild::where('build_id', $buildId)->update(['action' => 0, 'status' => 0]);
    }

    #delete by project (when delete project)
    public function actionDeleteByProject($projectId = null)
    {
        if (!empty($projectId)) {
            TfProjectBuild::where(['project_id' => $projectId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #--------- Project -----------
    public function infoOfProject($projectId)
    {
        return TfProjectBuild::where('project_id', $projectId)->where('status', 1)->first();
    }

    # agree publish
    public function publishYes($buildId, $numberDay)
    {
        $hFunction = new \Hfunction();
        $projectId = $this->projectId($buildId);
        $datePublish = $hFunction->carbonNowAddDays($numberDay);
        if (TfProjectBuild::where('build_id', $buildId)->update([
            'publishStatus' => 1,
            'confirmPublish' => 1,
            'confirmDate' => $datePublish,
            'openingDate' => $datePublish
        ])
        ) {
            # publish at current date
            if ($numberDay == 0) {

                #open elements of project
                $this->openingOfProject($projectId);

                #disable build
                $this->disableStatus($buildId);
            }
        }
    }

    # does not agree publish
    public function publishFail($buildId = null)
    {
        $hFunction = new \Hfunction();
        $modelBanner = new TfBanner();
        $modelLand = new TfLand();
        if (empty($buildId)) $buildId = $this->buildId();
        //$currentDate = date('Y-m-d H:i:s');

        $projectId = $this->projectId($buildId);
        # disable banner waiting publish
        $modelBanner->publishFailOfProject($projectId);
        # disable land waiting publish
        $modelLand->publishFailOfProject($projectId);

        return TfProjectBuild::where('build_id', $buildId)->where('status', 1)->where('buildStatus', 0)->update([
            'confirmPublish' => 1,
            'confirmDate' => $hFunction->carbonNow(),
            'status' => 0
        ]);
    }

    #---------- build ---------
    # the project is building
    public function existBuildOfProject($projectId)
    {
        $result = TfProjectBuild::where('project_id', $projectId)->where('status', 1)->count();
        return ($result > 0) ? true : false;
    }

    #---------- Publish -----------
    # check project is waiting publish
    public function existWaitingPublishOfProject($projectId)
    {
        $result = TfProjectBuild::where('project_id', $projectId)->where('buildStatus', 0)->where('confirmPublish', 0)->where('status', 1)->count();
        return ($result > 0) ? true : false;
    }

    #get first published of project
    public function existFirstPublishOfProject($projectId)
    {
        $result = TfProjectBuild::where('project_id', $projectId)->where('firstStatus', 1)->where('confirmPublish', 1)->count();
        return ($result > 0) ? true : false;
    }

    # only list project id waiting publish
    public function listProjectIdWaitingPublish() # return id
    {

        return TfProjectBuild::where('buildStatus', 0)->where('confirmPublish', 0)->where('status', 1)->lists('project_id');
    }

    #------------ Project opening ------------
    public function checkOpeningOfProject($projectId)
    {
        $hFunction = new \Hfunction();
        $checkDate = $hFunction->carbonNow();
        $dataProjectBuild = TfProjectBuild::where('confirmPublish', 1)->where('openingDate', '<', $checkDate)
            ->where('status', 1)->where('buildStatus', 0)->where('project_id', $projectId)->first();
        if (count($dataProjectBuild) > 0) {
            $this->openingOfProject($projectId);
            $this->disableStatus($dataProjectBuild->build_id);
        }
    }

    public function openingOfProject($projectId)
    {
        $modelBanner = new TfBanner();
        $modelLand = new TfLand();

        #publish banner
        $modelBanner->publishSuccessOfProject($projectId);

        #publish land
        $modelLand->publishSuccessOfProject($projectId);

    }

    #============ ============ ============ RELATION =========== ============ ============
    # ---------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'project_id', 'project_id');
    }

    #============ ============ ============ GET INFO =========== ============ ============
    public function getInfo($buildId = null, $field = null)
    {
        if (empty($buildId)) {
            return TfProjectBuild::where('action', 1)->get();
        } else {
            $result = TfProjectBuild::where('build_id', $buildId)->first();
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
            return TfProjectBuild::where('build_id', $objectId)->pluck($column);
        }
    }

    public function buildId()
    {
        return $this->build_id;
    }

    public function projectId($buildId = null)
    {
        return $this->pluck('project_id', $buildId);
    }

    public function buildStatus($buildId = null)
    {
        return $this->pluck('buildStatus', $buildId);
    }

    public function finishDate($buildId = null)
    {
        return $this->pluck('finishDate', $buildId);
    }

    public function firstStatus($buildId = null)
    {
        return $this->pluck('firstStatus', $buildId);
    }

    public function publishStatus($buildId = null)
    {
        return $this->pluck('publishStatus', $buildId);
    }

    public function confirmPublish($buildId = null)
    {
        return $this->pluck('confirmPublish', $buildId);
    }

    public function confirmDate($buildId = null)
    {
        return $this->pluck('confirmDate', $buildId);
    }

    public function status($buildId = null)
    {
        return $this->pluck('status', $buildId);
    }

    public function openingDate($buildId = null)
    {
        return $this->pluck('openingDate', $buildId);
    }

    public function createdAt($buildId = null)
    {
        return $this->pluck('created_at', $buildId);
    }

    public function totalRecords()
    {
        return TfProjectBuild::where('action', 1)->count();
    }

    #recent project list published
    public function recentProjectList($take=null)
    {
        if(empty($take)){
            return TfProjectBuild::where(['publishStatus' => 1, 'status' => 0])->orderBy('openingDate', 'DESC')->lists('project_id');
        }else{
            return TfProjectBuild::where(['publishStatus' => 1, 'status' => 0])->orderBy('openingDate', 'DESC')->skip(0)->take($take)->lists('project_id');
        }

    }
}
