<?php namespace App\Models\Manage\Content\Building\BadInfoReport;

use Illuminate\Database\Eloquent\Model;

class TfBuildingBadInfoReport extends Model
{

    protected $table = 'tf_building_bad_info_reports';
    protected $fillable = ['report_id', 'accuracy', 'confirm', 'action', 'dateConfirm', 'created_at', 'building_id', 'badInfo_id', 'user_id', 'staff_id'];
    protected $primaryKey = 'report_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #----------- insert -----------
    public function insert($buildingId, $userId, $badInfoId)
    {
        $hFunction = new \Hfunction();
        $modelReport = new TfBuildingBadInfoReport();
        $modelReport->accuracy = 1;
        $modelReport->confirm = 0;
        $modelReport->action = 1;
        $modelReport->building_id = $buildingId;
        $modelReport->user_id = $userId;
        $modelReport->badInfo_id = $badInfoId;
        $modelReport->staff_id = null;
        $modelReport->created_at = $hFunction->createdAt();
        if ($modelReport->save()) {
            $this->lastId = $modelReport->report_id;
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
    #------------ Update -----------
    # accuracy status
    public function updateAccuracy($reportId = null)
    {
        if (empty($reportId)) $reportId = $this->report_id;
        return TfBuildingBadInfoReport::where('report_id', $reportId)->update(['accuracy' => 0]);
    }

    # confirm status
    public function updateConfirm($reportId = null)
    {
        $hFunction = new \Hfunction();
        $dateConfirm = $hFunction->carbonNow();
        if (empty($reportId)) $reportId = $this->report_id;
        return TfBuildingBadInfoReport::where('report_id', $reportId)->update(['confirm' => 1, 'dateConfirm' => $dateConfirm]);
    }

    # delete
    public function actionDelete($reportId = null)
    {
        if (empty($reportId)) $reportId = $this->report_id;
        return TfBuildingBadInfoReport::where('report_id', $reportId)->update(['action' => 0]);
    }

    # when delete building
    public function actionDeleteByBuilding($buildingId = null)
    {
        if (!empty($buildingId)) {
            TfBuildingBadInfoReport::where(['building_id' => $buildingId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($reportId = null, $field = null)
    {
        if (empty($reportId)) {
            return TfBuildingBadInfoReport::where('action', 1)->get();
        } else {
            $result = TfBuildingBadInfoReport::where('report_id', $reportId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #----------- TF-BAD-INFO -----------
    public function badInfo()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\BadInfo\TfBadInfo', 'badInfo_id', 'badInfo_id');
    }

    #----------- Check info -------------
    public function checkUserReported($userId, $buildingId)
    {
        $result = TfBuildingBadInfoReport::where(['user_id' => $userId, 'building_id' => $buildingId])->get();
        return (count($result) > 0) ? true : false;
    }

    #----------- REPORT INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuildingBadInfoReport::where('report_id', $objectId)->pluck($column);
        }
    }

    public function reportId()
    {
        return $this->report_id;
    }

    public function accuracy($reportId = null)
    {
        return $this->pluck('accuracy', $reportId);
    }

    public function confirm($reportId = null)
    {
        return $this->pluck('confirm', $reportId);
    }

    public function dateConfirm($reportId = null)
    {
        return $this->pluck('dateConfirm', $reportId);
    }

    public function createdAt($reportId = null)
    {
        return $this->pluck('created_at', $reportId);
    }

    public function buildingId($reportId = null)
    {
        return $this->pluck('building_id', $reportId);
    }

    public function badInfoId($reportId = null)
    {
        return $this->pluck('badInfo_id', $reportId);
    }

    public function userId($reportId = null)
    {
        return $this->pluck('user_id', $reportId);
    }

    public function staffId($reportId = null)
    {
        return $this->pluck('staffId', $reportId);
    }

    # total records
    public function totalRecords()
    {
        return TfBuildingBadInfoReport::where('action', 1)->count();
    }

}
