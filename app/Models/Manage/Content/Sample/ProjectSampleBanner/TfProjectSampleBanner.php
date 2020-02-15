<?php namespace App\Models\Manage\Content\Sample\ProjectSampleBanner;

use Illuminate\Database\Eloquent\Model;

class TfProjectSampleBanner extends Model {

    protected $table = 'tf_project_sample_banners';
    protected $fillable = ['banner_id', 'topPosition', 'leftPosition', 'zIndex', 'publish', 'transactionStatus_id', 'project_id', 'sample_id','created_at', 'updated_at'];
    protected $primaryKey = 'banner_id';
    #public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========= ========= INSERT && UPDATE ========= ========= =========
    #------------ Insert ------------
    public function insert($topPosition, $leftPosition, $zIndex, $transactionStatusId, $projectId, $sampleId)
    {
        $hFunction = new \Hfunction();
        $model = new TfProjectSampleBanner();
        $model->topPosition = $topPosition;
        $model->leftPosition = $leftPosition;
        $model->zIndex = $zIndex;
        $model->transactionStatus_id = $transactionStatusId;
        $model->project_id = $projectId;
        $model->sample_id = $sampleId;
        $model->created_at = $hFunction->createdAt();
        if ($model->save()) {
            $this->lastId = $model->banner_id;
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
    public function updatePosition($bannerId = '', $topPosition = '', $leftPosition = '', $zIndex = '')
    {
        return TfProjectSampleBanner::where('banner_id', $bannerId)->update(['topPosition' => $topPosition, 'leftPosition' => $leftPosition, 'zIndex' => $zIndex]);
    }

    public function updatePublish($bannerId=null)
    {
        if(empty($bannerId)) $bannerId = $this->bannerId();
        return TfProjectSampleBanner::where('banner_id', $bannerId)->update(['publish' => 1]);
    }

    # delete
    public function actionDrop($bannerId=null)
    {
        if(empty($bannerId)) $bannerId = $this->bannerId();
        return TfProjectSampleBanner::where('banner_id', $bannerId)->delete();
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
        return $this->belongsTo('App\Models\Manage\Content\Map\Transaction\TfTransactionStatus', 'transactionStatus_id' , 'status_id');
    }

    # ----------- TF-BANNER-SAMPLE ----------
    public function bannerSample()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Banner\TfBannerSample', 'sample_id', 'sample_id');
    }

    # ---------- BANNER INFO ----------
    #---------- TF-PROJECT ------------
    public function infoOfProject($projectId)
    {
        return TfProjectSampleBanner::where('project_id', $projectId)->get();
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProjectSampleBanner::where('banner_id', $objectId)->pluck($column);
        }
    }

    public function bannerId()
    {
        return $this->banner_id;
    }

    public function projectId($bannerId = null)
    {
        return $this->pluck('project_id', $bannerId);
    }

    public function sampleId($bannerId = null)
    {
        return $this->pluck('sample_id', $bannerId);
    }

    public function transactionStatusId($bannerId = null)
    {
        return $this->pluck('transactionStatus_id', $bannerId);
    }

    public function topPosition($bannerId = null)
    {
        return $this->pluck('topPosition', $bannerId);
    }

    public function leftPosition($bannerId = null)
    {
        return $this->pluck('leftPosition', $bannerId);
    }

    public function zIndex($bannerId = null)
    {
        return $this->pluck('zIndex', $bannerId);
    }

    public function publish($bannerId = null)
    {
        return $this->pluck('publish', $bannerId);
    }

    public function createdAt($bannerId = null)
    {
        return $this->pluck('created_at', $bannerId);
    }

    public function updatedAt($bannerId = null)
    {
        return $this->pluck('updated_at', $bannerId);
    }

}
