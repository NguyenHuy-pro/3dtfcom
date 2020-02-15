<?php namespace App\Models\Manage\Content\Building\PostInfoReport;

use Illuminate\Database\Eloquent\Model;

class TfBuildingPostInfoReport extends Model
{

    protected $table = 'tf_building_post_info_reports';
    protected $fillable = ['report_id', 'accuracy', 'confirm', 'action', 'dateConfirm', 'created_at', 'post_id', 'badInfo_id', 'user_id', 'staff_id'];
    protected $primaryKey = 'report_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #insert
    public function insert($postId, $userId, $badInfoId)
    {
        $hFunction = new \Hfunction();
        $modelReport = new TfBuildingPostInfoReport();
        $modelReport->accuracy = 1;
        $modelReport->confirm = 0;
        $modelReport->action = 1;
        $modelReport->post_id = $postId;
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

    # accuracy status
    public function updateAccuracy($reportId)
    {
        return TfBuildingPostInfoReport::where('report_id', $reportId)->update(['accuracy' => 0]);
    }

    # confirm status
    public function updateConfirm($reportId, $staffId)
    {
        $hFunction = new \Hfunction();
        $date = $hFunction->carbonNow();
        return TfBuildingPostInfoReport::where('report_id', $reportId)->update(['confirm' => 1, 'dateConfirm' => $date, 'staff_id' => $staffId]);
    }

    # delete
    public function actionDelete($reportId)
    {
        return TfBuildingPostInfoReport::where('report_id', $reportId)->update(['action' => 0]);
    }

    #when delete post
    public function actionDeleteByPost($postId = null)
    {
        if (!empty($postId)) {
            TfBuildingPostInfoReport::where(['post_id' => $postId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-BUILDING-POST -----------
    public function buildingPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Post\TfBuildingPost', 'post_id', 'post_id');
    }

    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #----------- TF-STAFF -----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #----------- TF-BAD-INFO -----------
    public function badInfo()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\BadInfo\TfBadInfo', 'badInfo_id', 'badInfo_id');
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function checkUserReported($userId, $postId)
    {
        $result = TfBuildingPostInfoReport::where(['user_id' => $userId, 'post_id' => $postId])->get();
        return (count($result) > 0) ? true : false;
    }

    public function getInfo($reportId = null, $field = null)
    {
        if (empty($reportId)) {
            return null;
        } else {
            $result = TfBuildingPostInfoReport::where('report_id', $reportId)->first();
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
            return TfBuildingPostInfoReport::where('report_id', $objectId)->pluck($column);
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

    public function postId($reportId = null)
    {
        return $this->pluck('post_id', $reportId);
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
        return TfBuildingPostInfoReport::where('action', 1)->count();
    }


}
