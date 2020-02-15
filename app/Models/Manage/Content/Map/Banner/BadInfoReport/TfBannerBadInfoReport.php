<?php namespace App\Models\Manage\Content\Map\Banner\BadInfoReport;

use Illuminate\Database\Eloquent\Model;

class TfBannerBadInfoReport extends Model
{

    protected $table = 'tf_banner_bad_info_reports';
    protected $fillable = ['report_id', 'accuracy', 'confirm', 'action', 'dateConfirm', 'created_at', 'image_id', 'badInfo_id', 'user_id', 'staff_id'];
    protected $primaryKey = 'report_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #insert
    public function insert($imageId, $userId, $badInfoId, $staffId = null)
    {
        $hFunction = new \Hfunction();
        $modelReport = new TfBannerBadInfoReport();
        $modelReport->accuracy = 1;
        $modelReport->confirm = 0;
        $modelReport->action = 1;
        $modelReport->dateConfirm = null;
        $modelReport->image_id = $imageId;
        $modelReport->badInfo_id = $badInfoId;
        $modelReport->user_id = $userId;
        $modelReport->staff_id = $staffId;
        $modelReport->created_at = $hFunction->createdAt();
        if ($modelReport->save()) {
            $this->lastId = $modelReport->report_id;
            return true;
        } else {
            return false;
        }

    }

    public function updateAccuracy($reportId)
    {
        return TfBannerBadInfoReport::where('report_id', $reportId)->update(['accuracy' => 0]);
    }

    public function updateConfirm($reportId)
    {
        return TfBannerBadInfoReport::where('report_id', $reportId)->update(['confirm' => 1]);
    }

    # delete
    public function actionDelete($reportId)
    {
        return TfBannerBadInfoReport::where('report_id', $reportId)->update(['action' => 0]);
    }

    #delete by image (when delete image)
    public function actionDeleteByImage($imageId = null)
    {
        if (!empty($imageId)) {
            TfBannerBadInfoReport::where(['image_id' => $imageId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========= ========== ==========
    public function bannerImage()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\Image\TfBannerImage', 'image_id', 'image_id');
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

    #========== ========= ========== Check info =========== ======= ===========
    public function checkUserReported($userId, $imageId)
    {
        $result = TfBannerBadInfoReport::where(['user_id' => $userId, 'image_id' => $imageId])->get();
        return (count($result) > 0) ? true : false;
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($reportId = null, $field = null)
    {
        if (empty($reportId)) {
            return null;
        } else {
            $result = TfBannerBadInfoReport::where('report_id', $reportId)->first();
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
            return TfBannerBadInfoReport::where('report_id', $objectId)->pluck($column);
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

    public function imageId($reportId = null)
    {
        return $this->pluck('image_id', $reportId);
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
        return TfBannerBadInfoReport::where('action', 1)->count();
    }

}
