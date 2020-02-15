<?php namespace App\Models\Manage\Content\Sample\ProjectSampleLand;

use App\Models\Manage\Content\Sample\ProjectSamplePublic\TfProjectSamplePublic;
use Illuminate\Database\Eloquent\Model;

class TfProjectSampleLand extends Model
{

    protected $table = 'tf_project_sample_lands';
    protected $fillable = ['land_id', 'topPosition', 'leftPosition', 'zIndex', 'publish', 'transactionStatus_id', 'project_id', 'size_id', 'created_at', 'updated_at'];
    protected $primaryKey = 'land_id';
    #public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========= ========= INSERT && UPDATE ========= ========= =========
    #------------ Insert ------------
    public function insert($topPosition, $leftPosition, $zIndex, $transactionStatusId, $projectId, $sizeId)
    {
        $hFunction = new \Hfunction();
        $model = new TfProjectSampleLand();
        $model->topPosition = $topPosition;
        $model->leftPosition = $leftPosition;
        $model->zIndex = $zIndex;
        $model->transactionStatus_id = $transactionStatusId;
        $model->project_id = $projectId;
        $model->size_id = $sizeId;
        $model->created_at = $hFunction->createdAt();
        if ($model->save()) {
            $this->lastId = $model->land_id;
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
    # position
    public function updatePosition($landId, $topPosition = '', $leftPosition = '', $zIndex = '')
    {
        return TfProjectSampleLand::where('land_id', $landId)->update(['topPosition' => $topPosition, 'leftPosition' => $leftPosition, 'zIndex' => $zIndex]);
    }

    public function updatePublish($landId = null)
    {
        if (empty($landId)) $landId = $this->landId();
        return TfProjectSamplePublic::where('land_id', $landId)->update(['publish' => 1]);
    }

    # delete
    public function actionDrop($landId = null)
    {
        if (empty($landId)) $landId = $this->landId();
        return TfProjectSampleLand::where('land_id', $landId)->delete();
    }

    #========== ========= ========= RELATION ========= ========= =========
    # ---------- TF-PROJECT-SAMPLE ----------
    public function projectSample()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\ProjectSample\TfProjectSample', 'project_id', 'project_id');
    }


    # ---------- TF-TRANSACTION-STATUS ----------
    public function transactionStatus()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Transaction\TfTransactionStatus', 'transactionStatus_id', 'status_id');
    }

    # ----------- TF-SIZE ----------
    public function size()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Size\TfSize', 'size_id', 'size_id');
    }

    #------------ ---------- INFO ---------- ---------------

    #---------- TF-PROJECT ------------
    public function infoOfProject($projectId)
    {
        return TfProjectSampleLand::where('project_id', $projectId)->get();
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProjectSampleLand::where('land_id', $objectId)->pluck($column);
        }
    }

    public function landId()
    {
        return $this->land_id;
    }

    public function projectId($landId = null)
    {
        return $this->pluck('project_id', $landId);
    }

    public function sizeId($landId = null)
    {
        return $this->pluck('size_id', $landId);
    }

    public function transactionStatusId($landId = null)
    {
        return $this->pluck('transactionStatus_id', $landId);
    }

    public function topPosition($landId = null)
    {
        return $this->pluck('topPosition', $landId);
    }

    public function leftPosition($landId = null)
    {
        return $this->pluck('leftPosition', $landId);
    }

    public function zIndex($landId = null)
    {
        return $this->pluck('zIndex', $landId);
    }

    public function publish($landId = null)
    {
        return $this->pluck('publish', $landId);
    }

    public function createdAt($landId = null)
    {
        return $this->pluck('created_at', $landId);
    }

    public function updatedAt($landId = null)
    {
        return $this->pluck('updated_at', $landId);
    }

}
