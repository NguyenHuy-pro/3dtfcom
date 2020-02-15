<?php namespace App\Models\Manage\Content\Map\Project\LicenseCancel;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfProjectLicenseCancel extends Model {

    protected $table = 'tf_project_license_cancels';
    protected $fillable = ['cancel_id','reason','content','newInfo','created_at','license_id'];
    protected $primaryKey = 'cancel_id';
    public $timestamps = false;

    private $lastId;
    #=========== =========== =========== INSERT && UPDATE =========== ========== ===========
    #---------- Insert ------------
    public function insert($content, $reason, $licenseId)
    {
        $hFunction = new \Hfunction();
        $modelLicenseCancel = new TfProjectLicenseCancel();
        $modelLicenseCancel->reason = $reason;
        $modelLicenseCancel->notifyContent = $content;
        $modelLicenseCancel->newInfo = 1; # default
        $modelLicenseCancel->license_id = $licenseId;
        $modelLicenseCancel->created_at = $hFunction->createdAt();
        if ($modelLicenseCancel->save()) {
            $this->listId = $modelLicenseCancel->cancel_id;
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

    #========== ========== ========= RELATION =========== =========== =========
    # ---------- TF-PROJECT-LICENSE ----------
    public function projectLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\License\TfProjectLicense', 'license_id', 'license_id');
    }

    #========== ========== ========= GET INFO =========== =========== =========
    public function reason($cancelId = null)
    {
        if (empty($cancelId)) {
            return $this->reason;
        } else {
            return TfProjectLicenseCancel::where('cancel_id', $cancelId)->pluck('reason');
        }
    }

    # get notify content
    public function content($cancelId = null)
    {
        if (empty($cancelId)) {
            return $this->content;
        } else {
            return TfProjectLicenseCancel::where('cancel_id', $cancelId)->pluck('content');
        }
    }
}
