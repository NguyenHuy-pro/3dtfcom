<?php namespace App\Models\Manage\Content\Map\Project\Icon;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfProjectIcon extends Model
{

    protected $table = 'tf_project_icons';
    protected $fillable = ['icon_id', 'topPosition', 'leftPosition', 'zIndex', 'action', 'project_id', 'sample_id', 'created_at'];
    protected $primaryKey = 'icon_id';
    #public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #=========== =========== =========== INSERT && UPDATE =========== ========== ===========
    #---------- Insert ---------
    public function insert($topPosition, $leftPosition, $projectId, $iconSampleId, $zIndex = 802817)
    {
        $hFunction = new \Hfunction();
        $modelProjectIcon = new TfProjectIcon();
        $modelProjectIcon->topPosition = $topPosition;
        $modelProjectIcon->leftPosition = $leftPosition;
        $modelProjectIcon->zIndex = $zIndex;
        $modelProjectIcon->project_id = $projectId;
        $modelProjectIcon->sample_id = $iconSampleId;
        $modelProjectIcon->created_at = $hFunction->createdAt();
        if ($modelProjectIcon->save()) {
            $this->listId = $modelProjectIcon->icon_id;
            return true;
        } else {
            return false;
        }
    }

    #get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #----------- Update -----------
    #set position
    public function setPosition($iconId, $topPosition, $leftPosition, $zIndex)
    {
        return TfProjectIcon::where('icon_id', $iconId)->update(['topPosition' => $topPosition, 'leftPosition' => $leftPosition, 'zIndex' => $zIndex]);
    }

    # delete
    public function actionDelete($iconId)
    {
        return TfProjectIcon::where('icon_id', $iconId)->update(['action' => 0]);
    }

    #delete by project (when delete project)
    public function actionDeleteByProject($projectId = null)
    {
        if (!empty($projectId)) {
            $listId = TfProjectIcon::where(['project_id' => $projectId, 'action' => 1])->lists('icon_id');
            if (!empty($listId)) {
                foreach ($listId as $value) {
                    $this->actionDelete($value);
                }
            }
        }
    }

    #=========== =========== =========== RELATION =========== ========== ===========
    #---------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'project_id', 'project_id');
    }

    #---------- TF-PROJECT-ICON-SAMPLE ----------
    public function projectIconSample()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\ProjectIcon\TfProjectIconSample', 'sample_id', 'sample_id');
    }

    #=========== =========== =========== GET INFO =========== ========== ===========
    public function getInfo($iconId = '', $field = '')
    {
        if (empty($iconId)) {
            return TfProjectIcon::where('action', 1)->get();
        } else {
            $result = TfProjectIcon::where('icon_id', $iconId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #----------- Project -------------
    # get icon info of project
    public function iconInfoOfProject($projectId)
    {
        return TfProjectIcon::where('project_id', $projectId)->where('action', 1)->first();
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProjectIcon::where('icon_id', $objectId)->pluck($column);
        }
    }

    public function iconId()
    {
        return $this->icon_id;
    }

    public function topPosition($iconId = null)
    {
        return $this->pluck('topPosition', $iconId);
    }

    public function leftPosition($iconId = null)
    {
        return $this->pluck('leftPosition', $iconId);
    }

    public function zIndex($iconId = null)
    {
        return $this->pluck('zIndex', $iconId);
    }

    public function projectId($iconId = null)
    {
        return $this->pluck('project_id', $iconId);
    }

    public function sampleId($iconId = null)
    {
        return $this->pluck('sample_id', $iconId);
    }

    public function createdAt($iconId = null)
    {
        return $this->pluck('created_at', $iconId);
    }

}
