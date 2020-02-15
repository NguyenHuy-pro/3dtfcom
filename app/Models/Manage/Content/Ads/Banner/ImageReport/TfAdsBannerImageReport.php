<?php namespace App\Models\Manage\Content\Ads\Banner\ImageReport;

use Illuminate\Database\Eloquent\Model;

class TfAdsBannerImageReport extends Model
{

    protected $table = 'tf_ads_banner_image_reports';
    protected $fillable = ['report_id', 'created_at', 'image_id', 'user_id', 'badInfo_id'];
    protected $primaryKey = 'report_id';
    #public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    public function insert($imageId, $userId, $badInfoId)
    {
        $hFunction = new \Hfunction();
        $modelReport = new TfAdsBannerImageReport();
        $modelReport->image_id = $imageId;
        $modelReport->user_id = $userId;
        $modelReport->badInfo_id = $badInfoId;
        $modelReport->created_at = $hFunction->carbonNow();
        if ($modelReport->save()) {
            $this->lastId = $modelReport->report_id;
            return true;
        } else {
            return false;
        }
    }

    //get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-ADS-BANNER-IMAGE -----------
    //relation
    public function adsBannerImage()
    {
        return $this->belongsTo('App\Models\Manage\Content\Ads\Banner\Image\TfAdsBannerImage', 'image_id', 'image_id');
    }

    #----------- TF-USER -----------
    //relation
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //check user report of image
    public function existReportOfUserAndImage($userId, $imageId)
    {
        $result = TfAdsBannerImageReport::where(['user_id' => $userId, 'image_id' => $imageId])->count();
        return ($result > 0) ? true : false;
    }

    #----------- TF-BAD-INFO -----------
    //relation
    public function badInfo()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\BadInfo\TfBadInfo', 'badInfo_id', 'badInfo_id');
    }

    //========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($reportId = null, $field = null)
    {
        if (empty($reportId)) {
            return TfAdsBannerImageVisit::get();
        } else {
            $result = TfAdsBannerImageReport::where('report_id', $reportId)->first();
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
            return TfAdsBannerImageReport::where('report_id', $objectId)->pluck($column);
        }
    }

    public function reportId()
    {
        return $this->report_id;
    }

    public function imageId($reportId = null)
    {
        if (empty($reportId)) $reportId = $this->visitId();
        return $this->pluck('image_id', $reportId);
    }

    public function userId($reportId = null)
    {
        if (empty($reportId)) $reportId = $this->visitId();
        return $this->pluck('user_id', $reportId);
    }

    public function createdAt($reportId = null)
    {
        if (empty($reportId)) $reportId = $this->visitId();
        return $this->pluck('created_at', $reportId);
    }

    public function badInfoId($reportId = null)
    {
        if (empty($reportId)) $reportId = $this->visitId();
        return $this->pluck('badInfo_id', $reportId);
    }

    // total records
    public function totalRecords()
    {
        return TfAdsBannerImageVisit::count();
    }

}
