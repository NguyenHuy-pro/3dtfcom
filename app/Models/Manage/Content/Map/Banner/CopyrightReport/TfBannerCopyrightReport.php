<?php namespace App\Models\Manage\Content\Map\Banner\CopyrightReport;

use Illuminate\Database\Eloquent\Model;

class TfBannerCopyrightReport extends Model
{

    protected $table = 'tf_banner_copyright_reports';
    protected $fillable = ['report_id', 'image', 'description', 'accuracy', 'confirm', 'status', 'action', 'dateConfirm', 'created_at', 'image_id', 'user_id', 'staff_id'];
    protected $primaryKey = 'report_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #----------- Insert -------------
    public function insert($image, $description, $imageId, $userId, $staffId=null)
    {
        $hFunction = new \Hfunction();
        $modelReport = new TfBannerCopyrightReport();
        $modelReport->image = $image;
        $modelReport->description = $description;
        $modelReport->accuracy = 1;
        $modelReport->confirm = 0;
        $modelReport->status = 1;
        $modelReport->action = 1;
        $modelReport->dateConfirm = null;
        $modelReport->image_id = $imageId;
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

    #get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #----------- Update -------------
    public function updateAccuracy($reportId)
    {
        return TfBannerCopyrightReport::where('report_id', $reportId)->update(['accuracy' => 0]);
    }

    public function updateStatus($reportId, $status)
    {
        return TfBannerCopyrightReport::where('report_id', $reportId)->update(['status' => $status]);
    }

    public function updateConfirm($reportId)
    {
        return TfBannerCopyrightReport::where('report_id', $reportId)->update(['confirm' => 1]);
    }

    # delete
    public function actionDelete($reportId)
    {
        return TfBannerCopyrightReport::where('report_id', $reportId)->update(['action' => 0]);
    }

    #delete by image (when delete image)
    public function actionDeleteByImage($imageId = null)
    {
        if (!empty($imageId)) {
            TfBannerCopyrightReport::where(['image_id' => $imageId, 'action' => 1])->update(['action' => 0]);
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

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($reportId = '', $field = '')
    {
        if (empty($reportId)) {
            return null;
        } else {
            $result = TfBannerCopyrightReport::where('report_id', $reportId)->first();
            if (empty($field)) {  # have not to select a field
                return $result; # return object or null
            } else { # have not to select a field
                return $result->$field;
            }
        }
    }

    # total records
    public function totalRecords()
    {
        return TfBannerCopyrightReport::where('action', 1)->count();
    }

}
