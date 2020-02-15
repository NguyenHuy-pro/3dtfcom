<?php namespace App\Models\Manage\Content\Map\Banner\LicenseExpiry;

use Illuminate\Database\Eloquent\Model;

class TfBannerLicenseExpiry extends Model
{

    protected $table = 'tf_banner_license_expiries';
    protected $fillable = ['expiry_id', 'content', 'newInfo', 'reserve', 'status', 'created_at', 'license_id'];
    protected $primaryKey = 'expiry_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========= INSERT && UPDATE =========== =========== =========
    #----------- Insert --------------
    public function insert($content, $licenseId)
    {
        $hFunction = new \Hfunction();
        $modelExpiry = new TfBannerLicenseExpiry();
        $modelExpiry->content = $content;
        $modelExpiry->newInfo = 1;
        $modelExpiry->reserve = 0; # default 0
        $modelExpiry->status = 1;
        $modelExpiry->license_id = $licenseId;
        $modelExpiry->created_at = $hFunction->createdAt();
        if ($modelExpiry->save()) {
            $this->lastId = $modelExpiry->expiry_id;
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

    #---------- Update -----------
    public function updateStatus($expiryId, $status)
    {
        return TfBannerLicenseExpiry::where('expiry_id', $expiryId)->update(['status' => $status]);
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
            return TfBannerLicenseExpiry::where('expiry_id', $objectId)->pluck($column);
        }
    }

    public function expiryId()
    {
        return $this->expiry_id;
    }

    public function content($expiryId = null)
    {
        return $this->pluck('content', $expiryId);
    }

    public function reserve($expiryId = null)
    {
        return $this->pluck('reserve', $expiryId);
    }

    public function createdAt($expiryId = null)
    {
        return $this->pluck('created_at', $expiryId);
    }

    public function licenseId($expiryId = null)
    {
        return $this->pluck('license_id', $expiryId);
    }

}
