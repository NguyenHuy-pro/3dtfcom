<?php namespace App\Models\Manage\Content\Map\Banner\LicenseCancel;

use Illuminate\Database\Eloquent\Model;

class TfBannerLicenseCancel extends Model
{

    protected $table = 'tf_banner_license_cancels';
    protected $fillable = ['cancel_id', 'reason', 'content', 'newInfo', 'created_at', 'license_id'];
    protected $primaryKey = 'cancel_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========= INSERT && UPDATE =========== =========== =========
    #----------- Insert --------------
    public function insert($reason, $content, $licenseId)
    {
        $hFunction = new \Hfunction();
        $modelCancel = new TfBannerLicenseCancel();
        $modelCancel->reason = $reason;
        $modelCancel->content = $content;
        $modelCancel->newInfo = 1;
        $modelCancel->license_id = $licenseId;
        $modelCancel->created_at = $hFunction->createdAt();
        if ($modelCancel->save()) {
            $this->lastId = $modelCancel->cancel_id;
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
    # ---------- TF-BANNER-LICENSE ----------
    public function bannerLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\License\TfBannerLicense', 'license_id', 'license_id');
    }

    #========== ========== ========= GET INFO =========== =========== =========
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBannerLicenseCancel::where('cancel_id', $objectId)->pluck($column);
        }
    }

    public function cancelId()
    {
        return $this->cancel_id;
    }

    public function content($cancelId = null)
    {
        return $this->pluck('content', $cancelId);
    }

    public function reason($cancelId = null)
    {
        return $this->pluck('reason', $cancelId);
    }

    public function createdAt($cancelId = null)
    {
        return $this->pluck('created_at', $cancelId);
    }

    public function licenseId($cancelId = null)
    {
        return $this->pluck('license_id', $cancelId);
    }

}
