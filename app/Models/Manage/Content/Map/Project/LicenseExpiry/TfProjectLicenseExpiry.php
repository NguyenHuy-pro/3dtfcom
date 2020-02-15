<?php namespace App\Models\Manage\Content\Map\Project\LicenseExpiry;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfProjectLicenseExpiry extends Model {

    protected $table = 'tf_project_license_expiries';
    protected $fillable = ['expiry_id','content','newInfo','reserve','created_at','license_id'];
    protected $primaryKey = 'expiry_id';
    public $timestamps = false;

    private $lastId;
    #=========== =========== =========== INSERT && UPDATE =========== ========== ===========
    #------------ Insert -------------
    public function insert($content, $licenseId)
    {
        $hFunction = new \Hfunction();
        $modelLicenseExpiry = new TfProjectLicenseExpiry();
        $modelLicenseExpiry->content = $content;
        $modelLicenseExpiry->newInfo = 1; # default
        $modelLicenseExpiry->reserve = 0; # default
        $modelLicenseExpiry->license_id = $licenseId;
        $modelLicenseExpiry->created_at = $hFunction->createdAt();
        if ($modelLicenseExpiry->save()) {
            $this->listId = $modelLicenseExpiry->cancel_id;
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
        return TfProjectLicenseExpiry::where('expiry_id', $expiryId)->update(['status' => $status]);
    }

    #========== ========== ========= RELATION =========== =========== =========
    # ---------- TF-PROJECT-LICENSE ----------
    public function projectLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\License\TfProjectLicense', 'license_id', 'license_id');
    }


    #========== ========== ========= GET INFO =========== =========== =========
    # get notify content
    public function content($expiryId = null)
    {
        if (empty($expiryId)) {
            return $this->content;
        } else {
            return TfProjectLicenseExpiry::where('expiry_id', $expiryId)->pluck('content');
        }
    }

}
