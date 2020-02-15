<?php namespace App\Models\Manage\Content\Map\Land\LicenseCancel;

use Illuminate\Database\Eloquent\Model;

class TfLandLicenseCancel extends Model {

    protected $table = 'tf_land_license_cancels';
    protected $fillable = ['cancel_id','reason','content','newInfo','created_at','license_id'];
    protected $primaryKey = 'cancel_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========= INSERT && UPDATE =========== =========== =========
    #----------- Insert --------------
    public function insert($reason, $content, $licenseId)
    {
        $hFunction = new \Hfunction();
        $modelCancel = new TfLandLicenseCancel();
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
    # ---------- TF-LAND-LICENSE ----------
    public function landLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'license_id', 'license_id');
    }

    #========== ========== ========= GET INFO =========== =========== =========
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfLancLicenseCancel::where('cancel_id', $objectId)->pluck($column);
        }
    }
    public function reason($cancelId = null)
    {
        return $this->pluck('reason', $cancelId);
    }

    //get notify content
    public function content($cancelId = null)
    {
        return $this->pluck('content', $cancelId);
    }

}
