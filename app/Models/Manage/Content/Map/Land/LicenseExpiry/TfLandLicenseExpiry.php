<?php namespace App\Models\Manage\Content\Map\Land\LicenseExpiry;

use Illuminate\Database\Eloquent\Model;

class TfLandLicenseExpiry extends Model {

    protected $table = 'tf_land_license_expiries';
    protected $fillable = ['expiry_id','content','newInfo','reserve','status','created_at','license_id'];
    protected $primaryKey = 'expiry_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========= INSERT && UPDATE =========== =========== =========
    #----------- Insert --------------
    public function insert($content, $licenseId)
    {
        $hFunction = new \Hfunction();
        $modelExpiry = new TfLandLicenseExpiry();
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
        return TfLandLicenseExpiry::where('expiry_id', $expiryId)->update(['status' => $status]);
    }

    #========== ========== ========= RELATION =========== =========== =========
    # ---------- TF-LAND-LICENSE ----------
    public function landLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'license_id', 'license_id');
    }


    #========== ========== ========= GET INFO =========== =========== =========
    # get notify content
    public function content($expiryId = null)
    {
        if (empty($expiryId)) {
            return $this->content;
        } else {
            return TfLandLicenseExpiry::where('expiry_id', $expiryId)->pluck('content');
        }
    }

}
