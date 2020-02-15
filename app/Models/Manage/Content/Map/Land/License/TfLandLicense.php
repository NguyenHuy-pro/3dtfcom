<?php namespace App\Models\Manage\Content\Map\Land\License;

use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Map\Land\LicenseCancel\TfLandLicenseCancel;
use App\Models\Manage\Content\Map\Land\LicenseInvite\TfLandLicenseInvite;
use App\Models\Manage\Content\Map\Land\RequestBuild\TfLandRequestBuild;
use App\Models\Manage\Content\Map\Land\Transaction\TfLandTransaction;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class TfLandLicense extends Model
{

    protected $table = 'tf_land_licenses';
    protected $fillable = ['license_id', 'name', 'dateBegin', 'dateEnd', 'status', 'action', 'land_id', 'user_id', 'transactionStatus_id', 'created_at'];
    protected $primaryKey = 'license_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========= INSERT && UPDATE =========== =========== =========
    #----------- Insert ------------
    public function insert($dateBegin, $dateEnd, $landId, $userId, $transactionStatusId)
    {
        $hFunction = new \Hfunction();
        $modelTransactionStatus = new TfTransactionStatus();
        $modelLandLicense = new TfLandLicense();
        $modelLandLicense->name = "LL" . $hFunction->getTimeCode();
        $modelLandLicense->dateBegin = $dateBegin;
        $modelLandLicense->dateEnd = $dateEnd;
        $modelLandLicense->land_id = $landId;
        $modelLandLicense->user_id = $userId;
        $modelLandLicense->transactionStatus_id = $transactionStatusId;
        $modelLandLicense->created_at = $hFunction->carbonNow();
        if ($modelLandLicense->save()) {
            $this->lastId = $modelLandLicense->license_id;
            //add transaction for land
            $modelLandTransaction = new TfLandTransaction();
            $transactionStatusId = $modelTransactionStatus->normalStatusId();# 3 normal
            $modelLandTransaction->insert($landId, $transactionStatusId);
            return true;
        } else {
            return false;
        }
    }

    //get new id a
    public function insertGetId()
    {
        return $this->lastId;
    }

    #----------- UPDATE ------------
    public function updateStatus($licenseId, $status)
    {
        return TfLandLicense::where('license_id', $licenseId)->update(['status' => $status]);
    }

    //delete
    public function actionDelete($licenseId = null)
    {
        $modelBuilding = new TfBuilding();
        $modelLandRequestBuild = new TfLandRequestBuild();
        if (empty($licenseId)) $licenseId = $this->licenseId();
        if (TfLandLicense::where('license_id', $licenseId)->update(['action' => 0])) {
            //building
            $modelBuilding->actionDeleteByLicense($licenseId);
            //request build
            $modelLandRequestBuild->deleteByLicense($licenseId);

        }
    }

    //when delete land
    public function actionDeleteByLand($landId = null)
    {
        if (!empty($landId)) {
            $licenseId = TfLandLicense::where(['land_id' => $landId, 'action' => 1])->pluck('license_id');
            if (count($licenseId) > 0) {
                $this->actionDelete($licenseId);
            }
        }
    }

    # ========== ========== ========= RELATION ========= ========== ==========
    # --------- TF-TRANSACTION-STATUS ----------
    public function transactionStatus()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Transaction\TfTransactionStatus', 'status_id', 'transactionStatus_id');
    }

    #---------- TF-LAND ----------
    public function land()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\TfLand', 'land_id', 'land_id');
    }

    //only license is using of a land
    public function infoOfLand($landId)
    {
        return TfLandLicense::where('land_id', $landId)->where('action', 1)->first();
    }

    public function dateEndOfLand($landId)
    {
        return TfLandLicense::where('land_id', $landId)->where('action', 1)->pluck('dateEnd');
    }


    public function licenseIdViableOfLand($landId)
    {
        return TfLandLicense::where(['land_id' => $landId, 'action' => 1])->pluck('license_id');
    }

    //inspect lands under its management staff.
    public function checkExistLand($landId)
    {
        $result = TfLandLicense::where('land_id', $landId)->where('action', 1)->count();
        return ($result > 0) ? true : false;
    }

    //---------- TF-LAND-REQUEST-BUILD ----------
    public function landRequestBuild()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\RequestBuild\TfLandRequestBuild', 'license_id', 'license_id');
    }

    public function landRequestBuildInfoActive($licenseId = null)
    {
        $modelLandRequestBuild = new TfLandRequestBuild();
        $licenseId = (!empty($licenseId)) ? $licenseId : $this->licenseId();
        return $modelLandRequestBuild->infoActiveOfLicense($licenseId);

    }

    //check request build
    public function existRequestBuild($licenseId = null)
    {
        $modelLandRequestBuild = new TfLandRequestBuild();
        $licenseId = (!empty($licenseId)) ? $licenseId : $this->licenseId();
        return $modelLandRequestBuild->existLandLicense($licenseId);
    }

    # ---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //exist land of user
    public function existLandOfUser($userId, $landId)
    {
        $result = TfLandLicense::where('user_id', $userId)->where('land_id', $landId)->where('action', 1)->count();
        return ($result > 0) ? true : false;
    }

    //get user id of land
    public function userIdOfLand($landId)
    {
        return TfLandLicense::where('land_id', $landId)->where('action', 1)->pluck('user_id');
    }

    //get license info of user login (only one license)
    public function accessLicenseOfUser($userId)   # return object
    {
        return TfLandLicense::where('user_id', $userId)->where('action', 1)->orderBy('license_id', 'DESC')->first();
    }

    //list license id of user
    public function listIdOfUser($userId)
    {
        return TfLandLicense::where('user_id', $userId)->where('action', 1)->orderBy('license_id', 'DESC')->lists('license_id');
    }

    //list land id of user
    public function listLandIdOfUser($userId)
    {
        return TfLandLicense::where('user_id', $userId)->where('action', 1)->orderBy('license_id', 'DESC')->lists('land_id');
    }

    //list license info of user
    public function infoOfUser($userId, $skip = '', $take = '')
    {
        if (empty($skip) && empty($take)) {
            return TfLandLicense::where('user_id', $userId)->where('action', 1)->orderBy('license_id', 'DESC')->get();
        } else {
            return TfLandLicense::where('user_id', $userId)->where('action', 1)->skip($skip)->take($take)->orderBy('license_id', 'DESC')->get();
        }
    }

    //check exist free license of user
    public function existFreeLicenseOfUser($userId)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $freeStatus = $modelTransactionStatus->freeStatusId(); //free id
        $result = TfLandLicense::where('user_id', $userId)->where('transactionStatus_id', $freeStatus)->count();
        return ($result > 0) ? true : false;
    }

    public function existInviteLicenseOfUser($userId)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $inviteStatus = $modelTransactionStatus->inviteStatusId(); //free id
        $result = TfLandLicense::where('user_id', $userId)->where('transactionStatus_id', $inviteStatus)->count();
        return ($result > 0) ? true : false;
    }

    # ---------- TF-USER-EXCHANGE-LAND ----------
    public function userExchangeLand()
    {
        return $this->hasOne('App\Models\Manage\Content\Users\ExchangeLand', 'license_id', 'license_id');
    }

    # ---------- TF-LAND-LICENSE-CANCEL ----------
    public function landLicenseCancel()
    {
        return $this->hasOne('App\Models\Manage\Content\Map\Land\LicenseCancel\TfLandLicenseCancel', 'license_id', 'license_id');
    }

    public function cancelLicense($reason, $content, $licenseId = null)
    {
        $modelLandLicenseCancel = new TfLandLicenseCancel();
        if (empty($licenseId)) $licenseId = $this->licenseId();
        return $modelLandLicenseCancel->insert($reason, $content, $licenseId);
    }

    # ---------- TF-LAND-LICENSE-EXPIRY ----------
    public function landLicenseExpiry()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\LicenseExpiry\TfLandLicenseExpiry', 'license_id', 'license_id');
    }

    # ---------- TF-LAND-LICENSE-INVITE ----------
    public function landLicenseInvite()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\LicenseInvite\TfLandLicenseInvite', 'license_id', 'license_id');
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

    public function landLicenseInviteInfo($licenseId = null)
    {
        $modelLicenseInvite = new TfLandLicenseInvite();
        if (empty($licenseId)) $licenseId = $this->licenseId();
        return $modelLicenseInvite->infoOfLicense($licenseId);
    }

    public function existInvite($licenseId = null)
    {
        $modelLandLicenseInvite = new TfLandLicenseInvite();
        if (empty($licenseId)) $licenseId = $this->licenseId();
        return $modelLandLicenseInvite->existInviteOfLicense($licenseId);
    }

    public function checkAccessInviteCode()
    {
        return (Session::has('accessLandInviteCode')) ? true : false;
    }

    //set access invite
    public function setAccessInviteCode($inviteCode)
    {
        return Session::put('accessLandInviteCode', $inviteCode);
    }

    //get access invite
    public function getAccessInviteCode()
    {
        return (Session::has('accessLandInviteCode')) ? Session::get('accessLandInviteCode') : null;
    }

    public function checkAccessInvite($licenseId = null)
    {
        if (Session::has('accessLandInviteCode')) {
            $inviteCode = Session::get('accessLandInviteCode');
            $modelLandLicenseInvite = new TfLandLicenseInvite();
            $dataLandLicenseInvite = $modelLandLicenseInvite->getInfoOfCode($inviteCode);
            if (empty($licenseId)) $licenseId = $this->licenseId();
            if ($licenseId == $dataLandLicenseInvite->licenseId()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    # ---------- TF-BUILDING ----------
    public function building()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\TfBuilding', 'license_id', 'license_id');
    }

    public function buildingViable($licenseId = null)
    {
        $modelBuilding = new TfBuilding();
        if (empty($licenseId)) $licenseId = $this->licenseId();
        return $modelBuilding->infoOfLandLicense($licenseId);
    }

    public function checkExistBuilding($licenseId = null)
    {
        return (count($this->buildingViable($licenseId)) > 0) ? true : false;
    }

    #========== ========== ========== GET INFO ========== =========== ===========
    public function checkActive($licenseId)
    {
        $result = TfLandLicense::where(['license_id' => $licenseId, 'action' => 1])->count();
        return ($result > 0) ? true : false;
    }

    public function getInfo($licenseId = null, $field = null)
    {
        if (empty($licenseId)) {
            return TfLandLicense::where('action', 1)->get();
        } else {
            $result = TfLandLicense::where('license_id', $licenseId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # ----------LICENSE INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfLandLicense::where('license_id', $objectId)->pluck($column);
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

    public function landId($licenseId = null)
    {
        return $this->pluck('land_id', $licenseId);
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

    //Last id
    public function lastId()
    {
        $result = TfLandLicense::orderBy('license_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->license_id;
    }

    //total records
    public function totalRecords()
    {
        return TfLandLicense::where('action', 1)->count();
    }

}
