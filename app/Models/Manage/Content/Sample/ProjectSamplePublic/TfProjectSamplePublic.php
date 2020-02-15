<?php namespace App\Models\Manage\Content\Sample\ProjectSamplePublic;

use Illuminate\Database\Eloquent\Model;

class TfProjectSamplePublic extends Model
{

    protected $table = 'tf_project_sample_publics';
    protected $fillable = ['public_id', 'topPosition', 'leftPosition', 'zIndex', 'publish', 'project_id', 'sample_id', 'created_at', 'updated_at'];
    protected $primaryKey = 'public_id';
    #public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========= ========= INSERT && UPDATE ========= ========= =========
    #------------ Insert ------------
    public function insert($topPosition, $leftPosition, $zIndex, $projectId, $sampleId)
    {
        $hFunction = new \Hfunction();
        $model = new TfProjectSamplePublic();
        $model->topPosition = $topPosition;
        $model->leftPosition = $leftPosition;
        $model->zIndex = $zIndex;
        $model->project_id = $projectId;
        $model->sample_id = $sampleId;
        $model->created_at = $hFunction->createdAt();
        if ($model->save()) {
            $this->lastId = $model->public_id;
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
    public function updatePosition($publicId, $topPosition, $leftPosition, $zIndex = '')
    {
        return TfProjectSamplePublic::where('public_id', $publicId)->update(['topPosition' => $topPosition, 'leftPosition' => $leftPosition, 'zIndex' => $zIndex]);
    }

    public function updatePublish($publicId = null)
    {
        if (empty($publicId)) $publicId = $this->publicId();
        return TfProjectSamplePublic::where('public_id', $publicId)->update(['publish' => 1]);
    }

    # delete
    public function actionDrop($publicId = null)
    {
        if (empty($publicId)) $publicId = $this->publicId();
        return TfProjectSamplePublic::where('public_id', $publicId)->delete();
    }

    #========== ========= ========= RELATION ========= ========= =========
    # ---------- TF-PROJECT-SAMPLE ----------
    public function projectSample()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\ProjectSample\TfProjectSample', 'project_id', 'project_id');
    }

    # ----------- TF-PUBLIC-SAMPLE ----------
    public function publicSample()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Publics\TfPublicSample', 'sample_id', 'sample_id');
    }

    # ---------- BANNER INFO ----------
    #---------- TF-PROJECT ------------
    public function infoOfProject($projectId)
    {
        return TfProjectSamplePublic::where('project_id', $projectId)->get();
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProjectSamplePublic::where('public_id', $objectId)->pluck($column);
        }
    }

    public function publicId()
    {
        return $this->public_id;
    }

    public function projectId($publicId = null)
    {
        return $this->pluck('project_id', $publicId);
    }

    public function sampleId($publicId = null)
    {
        return $this->pluck('sample_id', $publicId);
    }

    public function topPosition($publicId = null)
    {
        return $this->pluck('topPosition', $publicId);
    }

    public function leftPosition($publicId = null)
    {
        return $this->pluck('leftPosition', $publicId);
    }

    public function zIndex($publicId = null)
    {
        return $this->pluck('zIndex', $publicId);
    }

    public function publish($publicId = null)
    {
        return $this->pluck('publish', $publicId);
    }

    public function createdAt($publicId = null)
    {
        return $this->pluck('created_at', $publicId);
    }

    public function updatedAt($publicId = null)
    {
        return $this->pluck('updated_at', $publicId);
    }

}
