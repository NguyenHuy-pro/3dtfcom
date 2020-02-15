<?php namespace App\Models\Manage\Content\Map\Banner\License;

use App\Models\Manage\Content\Map\Banner\LicenseCancel\TfBannerLicenseCancel;
use App\Models\Manage\Content\Map\Banner\LicenseInvite\TfBannerLicenseInvite;
use App\Models\Manage\Content\Map\Banner\Transaction\TfBannerTransaction;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class TfBannerLicense extends Model
{

    protected $table = 'tf_banner_licenses';
    protected $fillable = ['license_id', 'name', 'dateBegin', 'dateEnd', 'status', 'action', 'banner_id', 'user_id', 'transactionStatus_id', 'created_at'];
    protected $primaryKey = 'license_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========= INSERT && EDIT =========== =========== =========
    #----------- Insert --------------
    public function insert($dateBegin, $dateEnd, $bannerId, $userId, $transactionStatusId)
    {
        $hFunction = new \Hfunction();
        $modelTransactionStatus = new TfTransactionStatus();
        $modelBannerLicense = new TfBannerLicense();
        $modelBannerLicense->name = "BL" . $hFunction->getTimeCode();
        $modelBannerLicense->dateBegin = $dateBegin;
        $modelBannerLicense->dateEnd = $dateEnd;
        $modelBannerLicense->banner_id = $bannerId;
        $modelBannerLicense->user_id = $userId;
        $modelBannerLicense->transactionStatus_id = $transactionStatusId;
        $modelBannerLicense->created_at = $hFunction->createdAt();
        if ($modelBannerLicense->save()) {
            $this->lastId = $modelBannerLicense->license_id;
            $modelBannerTransaction = new TfBannerTransaction();
            $transactionStatusId = $modelTransactionStatus->normalStatusId();# 3 normal
            $modelBannerTransaction->insert($bannerId, $transactionStatusId);
            return true;
        } else {
            return false;
        }
    }

    //get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- Update -----------
    public function updateStatus($licenseId, $status)
    {
        return TfBannerLicense::where('license_id', $licenseId)->update(['status' => $status]);
    }

    //delete
    public function actionDelete($licenseId = null)
    {
        $modelBannerLicenseInvite = new TfBannerLicenseInvite();
        if (empty($licenseId)) $licenseId = $this->licenseId();
        if (TfBannerLicense::where('license_id', $licenseId)->update(['action' => 0])) {
            $modelBannerLicenseInvite->actionDeleteByLicense($licenseId);
        }
    }

    //when delete banner
    public function actionDeleteByBanner($bannerId = null)
    {
        if (!empty($bannerId)) {
            $objectId = TfBannerLicense::where(['banner_id' => $bannerId, 'action' => 1])->pluck('license_id');
            if (!empty($objectId)) {
                $this->actionDelete($objectId);
            }
        }
    }

    # ========== ========== ========= RELATION ========= ========== ==========
    # --------- TF-TRANSACTION-STATUS ----------
    public function transactionStatus()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Transaction\TfTransactionStatus', 'status_id', 'transactionStatus_id');
    }

    #---------- TF-BANNER ----------
    public function banner()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\TfBanner', 'banner_id', 'banner_id');
    }

    //inspect lands under its management staff.
    public function checkExistBanner($bannerId)
    {
        $result = TfBannerLicense::where('banner_id', $bannerId)->where('action', 1)->count();
        return ($result > 0) ? true : false;
    }

    // only get info is using of banner
    public function infoOfBanner($bannerId)
    {
        return TfBannerLicense::where('action', 1)->where('banner_id', $bannerId)->first();
    }

    #---------- TF-BANNER-IMAGE ----------
    public function bannerImage()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Image\TfBannerImage', 'banner_id', 'banner_id');
    }


    //date end of banner
    public function  dateEndOfBanner($bannerId)
    {
        return TfBannerLicense::where('action', 1)->where('banner_id', $bannerId)->pluck('dateEnd');
    }

    # ---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //list license id of user
    public function listIdOfUser($userId)
    {
        return TfBannerLicense::where('user_id', $userId)->where('action', 1)->lists('license_id');
    }

    //list land id of user
    public function listBannerIdOfUser($userId)
    {
        return TfBannerLicense::where('user_id', $userId)->where('action', 1)->lists('banner_id');
    }

    //get info of user (get all)
    public function infoOfUser($userId, $skip = '', $take = '')
    {
        if (empty($skip) && empty($take)) {
            return TfBannerLicense::where('user_id', $userId)->where('action', 1)->get();
        } else {
            return TfBannerLicense::where('user_id', $userId)->where('action', 1)->skip($skip)->take($take)->get();
        }
    }

    //check banner of user
    public function existBannerOfUser($userId, $bannerId)
    {
        $result = TfBannerLicense::where('banner_id', $bannerId)->where('user_id', $userId)->where('action', 1)->count();
        return ($result > 0) ? true : false;
    }

    //get license info of user login (only one license)
    public function accessLicenseOfUser($userId)   # return object
    {
        return TfBannerLicense::where('user_id', $userId)->where('action', 1)->orderBy('license_id', 'DESC')->first();
    }

    //check exist free license of user
    public function existFreeLicenseOfUser($userId = '')
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $freeStatus = $modelTransactionStatus->freeStatusId(); //free id
        $result = TfBannerLicense::where('user_id', $userId)->where('transactionStatus_id', $freeStatus)->count();
        return ($result > 0) ? true : false;
    }

    //check exist invitation of user
    public function existInviteLicenseOfUser($userId = '')
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $freeStatus = $modelTransactionStatus->inviteStatusId(); //free id
        $result = TfBannerLicense::where('user_id', $userId)->where('transactionStatus_id', $freeStatus)->count();
        return ($result > 0) ? true : false;
    }

    # ---------- TF-USER-EXCHANGE-BANNER ----------
    public function userExchangeBanner()
    {
        return $this->hasOne('App\Models\Manage\Content\Users\ExchangeBanner', 'license_id', 'license_id');
    }

    # ---------- TF-BANNER-LICENSE-CANCEL ----------
    public function bannerLicenseCancel()
    {
        return $this->hasOne('App\Models\Manage\Content\Map\Banner\LicenseCancel\TfBannerLicenseCancel', 'license_id', 'license_id');
    }

    public function cancelLicense($reason, $content, $licenseId = null)
    {
        $modelBannerLicenseCancel = new TfBannerLicenseCancel();
        if (empty($licenseId)) $licenseId = $this->licenseId();
        return $modelBannerLicenseCancel->insert($reason, $content, $licenseId);
    }

    # ---------- TF-BANNER-LICENSE-EXPIRY ----------
    public function bannerLicenseExpiry()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\LicenseExpiry\TfBannerLicenseExpiry', 'license_id', 'license_id');
    }

    # ---------- TF-BANNER-LICENSE-INVITE ----------
    public function bannerLicenseInvite()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\LicenseInvite\TfBannerLicenseInvite', 'license_id', 'license_id');
    }

    public function bannerLicenseInviteInfo($licenseId = null)
    {
        $modelLicenseInvite = new TfBannerLicenseInvite();
        if (empty($licenseId)) $licenseId = $this->licenseId();
        return $modelLicenseInvite->infoOfLicense($licenseId);
    }

    //check allow invite
    public function allowInvite($licenseId = null)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $transactionStatusId = $this->transactionStatusId($licenseId);
        if ($transactionStatusId == $modelTransactionStatus->freeStatusId() || $transactionStatusId == $modelTransactionStatus->inviteStatusId()) {
            return false;
        } else {
            return true;
        }
    }

    //exist invite
    public function existInvite($licenseId = null)
    {
        if (empty($licenseId)) $licenseId = $this->licenseId();
        return (count($this->bannerLicenseInviteInfo($licenseId)) > 0) ? true : false;
    }

    public function checkAccessInviteCode()
    {
        return (Session::has('accessBannerInviteCode')) ? true : false;
    }

    //set access invite
    public function setAccessInviteCode($inviteCode)
    {
        return Session::put('accessBannerInviteCode', $inviteCode);
    }

    //get access invite
    public function getAccessInviteCode()
    {
        return (Session::has('accessBannerInviteCode')) ? Session::get('accessBannerInviteCode') : null;
    }

    public function checkAccessInvite($licenseId = null)
    {
        if (Session::has('accessBannerInviteCode')) {
            $inviteCode = Session::get('accessBannerInviteCode');
            $modelBannerLicenseInvite = new TfBannerLicenseInvite();
            $dataLicenseInvite = $modelBannerLicenseInvite->getInfoOfCode($inviteCode);
            if (empty($licenseId)) $licenseId = $this->licenseId();
            if ($licenseId == $dataLicenseInvite->licenseId()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    # ========== ========== ========= GET INFO ========= ========== ==========

    # ---------- LICENSE INFO ----------
    public function getInfo($licenseId = '', $field = '')
    {
        if (empty($licenseId)) {
            return TfBannerLicense::where('action', 1)->get();
        } else {
            $result = TfBannerLicense::where('license_id', $licenseId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #------------- INFO --------------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBannerLicense::where('license_id', $objectId)->pluck($column);
        }
    }

    public function licenseId()
    {
        return $this->license_id;
    }

    public function name($licenseId = null)
    {
        return $this->pluck('name', $licenseId);
    }

    public function dateBegin($licenseId = null)
    {
        return $this->pluck('dateBegin', $licenseId);
    }

    public function dateEnd($licenseId = null)
    {
        return $this->pluck('dateEnd', $licenseId);
    }

    public function status($licenseId = null)
    {
        return $this->pluck('status', $licenseId);
    }

    public function bannerId($licenseId = null)
    {
        return $this->pluck('banner_id', $licenseId);
    }

    public function userId($licenseId = null)
    {
        return $this->pluck('user_id', $licenseId);
    }

    public function transactionStatusId($licenseId = null)
    {
        return $this->pluck('transactionStatus_id', $licenseId);
    }

    public function createdAt($licenseId = null)
    {
        return $this->pluck('created_at', $licenseId);
    }

    # Last id
    public function lastId()
    {
        $result = TfBannerLicense::orderBy('license_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->license_id;
    }

    # total records
    public function totalRecords()
    {
        return TfBannerLicense::where('action', 1)->count();
    }

}
