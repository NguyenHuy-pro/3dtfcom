<?php namespace App\Models\Manage\Content\Map\Land\LicenseInvite;

use App\Models\Manage\Content\Map\Land\License\TfLandLicense;
use App\Models\Manage\Content\Seller\TfSeller;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Database\Eloquent\Model;

class TfLandLicenseInvite extends Model
{

    protected $table = 'tf_land_license_invites';
    protected $fillable = ['invite_id', 'inviteCode', 'email', 'message', 'dateEnd', 'agree', 'register', 'action', 'created_at', 'license_id'];
    protected $primaryKey = 'invite_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #----------- Insert -----------
    //add new
    public function insert($inviteCode, $email, $message = null, $licenseId)
    {
        $hFunction = new \Hfunction();
        $model = new TfLandLicenseInvite();
        $model->inviteCode = $inviteCode;
        $model->email = $email;
        $model->message = $message;
        $model->dateEnd = $hFunction->carbonNowAddDays(30);
        $model->agree = 0;
        $model->register = 0;
        $model->action = 1;
        $model->license_id = $licenseId;
        $model->created_at = $hFunction->carbonNow();
        if ($model->save()) {
            $this->lastId = $model->invite_id;
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

    #----------- Update -----------
    public function updateAgree($inviteId = null)
    {
        $modelSeller = new TfSeller();
        if (empty($inviteId)) $inviteId = $this->inviteId();
        $dataInvite = $this->getInfo($inviteId);
        if (TfLandLicenseInvite::where('invite_id', $inviteId)->update(['agree' => 1, 'register' => 1, 'action' => 0])) {
            //statistic for seller
            $userInviteId = $dataInvite->landLicense->userId();
            if ($modelSeller->checkExistUser($userInviteId)) $modelSeller->plusLandInviteRegisterOfUser($userInviteId);
        }
    }

    public function checkNewMember($newUserId)
    {
        $modelUser = new TfUser();
        $modelSeller = new TfSeller();
        $modelLandLicense = new TfLandLicense();
        if ($modelLandLicense->checkAccessInviteCode()) {
            //user access from invitation but user do not select land
            $inviteCode = $modelLandLicense->getAccessInviteCode();
            if (TfLandLicenseInvite::where('inviteCode', $inviteCode)->update(['register' => 1, 'action' => 0])) {
                //statistic for seller
                $dataInvite = $this->getInfoOfCode($inviteCode);
                $userInviteId = $dataInvite->landLicense->userId();
                if ($modelSeller->checkExistUser($userInviteId)) $modelSeller->plusLandInviteRegisterOfUser($userInviteId);
                //update introduce user
                $modelUser->updateUserIntroduce($userInviteId, $newUserId);
            }
        }
    }

    public function actionDelete($inviteId = null)
    {
        if (empty($inviteId)) $inviteId = $this->inviteId();
        return TfLandLicenseInvite::where('invite_id', $inviteId)->update(['action' => 0]);
    }

    //when delete Land
    public function actionDeleteByLicense($licenseId = null)
    {
        if (!empty($licenseId)) {
            TfLandLicenseInvite::where(['license_id' => $licenseId, 'action' => 1])->update(['action' => 0]);
        }
    }

    //delete
    public function getDrop($inviteId = null)
    {
        if (empty($inviteId)) $inviteId = $this->inviteId();
        return TfLandLicenseInvite::where('invite_id', $inviteId)->delete();
    }

    # ========== ========== ========= RELATION ========= ========== ==========
    #---------- TF-LAND-LICENSE ----------
    public function LandLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'license_id', 'license_id');
    }

    public function existInviteOfLicense($licenseId)
    {
        $result = TfLandLicenseInvite::where(['license_id' => $licenseId, 'action' => 1])->count();
        return ($result > 0) ? true : false;
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfoOfCode($inviteCode)
    {
        return TfLandLicenseInvite::where('inviteCode', $inviteCode)->first();
    }

    public function getInfo($inviteId = null, $field = null)
    {
        if (empty($inviteId)) {
            return TfLandLicenseInvite::where('action', 1)->get();
        } else {
            $result = TfLandLicenseInvite::where(['invite_id' => $inviteId, 'action' => 1])->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #----------- TF-USER -------------
    public function infoSentByUser($userId = null, $take = null, $dateTake = null)
    {
        $modelLandLicense = new TfLandLicense();
        if (empty($userId)) {
            return null;
        } else {
            $listLicenseId = $modelLandLicense->listIdOfUser($userId);
            if (empty($take) && empty($dateTake)) {
                return TfLandLicenseInvite::whereIn('license_id', $listLicenseId)->where('action', 1)->orderBy('created_at', 'DESC')->get();
            } else {
                return TfLandLicenseInvite::whereIn('license_id', $listLicenseId)->where('action', 1)->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
            }
        }
    }

    #----------- INVITE INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfLandLicenseInvite::where('invite_id', $objectId)->pluck($column);
        }
    }

    public function inviteId()
    {
        return $this->invite_id;
    }

    public function inviteCode($inviteId = null)
    {
        return $this->pluck('inviteCode', $inviteId);
    }

    public function message($inviteId = null)
    {
        return $this->pluck('message', $inviteId);
    }

    public function email($inviteId = null)
    {
        return $this->pluck('email', $inviteId);
    }

    public function agree($inviteId = null)
    {
        return $this->pluck('agree', $inviteId);
    }

    public function register($inviteId = null)
    {
        return $this->pluck('register', $inviteId);
    }

    public function licenseId($inviteId = null)
    {
        return $this->pluck('license_id', $inviteId);
    }

    public function createdAt($inviteId = null)
    {
        return $this->pluck('created_at', $inviteId);
    }

    //total records
    public function totalRecords()
    {
        return TfLandLicenseInvite::count();
    }

    //check email is inviting
    public function existEmailInviting($email)
    {
        $result = TfLandLicenseInvite::where('email', $email)->where('action', 1)->count();
        return ($result > 0) ? true : false;
    }

    #----------- TF-Land-LICENSE -----------
    public function infoOfLicense($licenseId)
    {
        return TfLandLicenseInvite::where('license_id', $licenseId)->where('action', 1)->first();
    }

    public function existLandLicense($licenseId)
    {
        return (count($this->infoOfLicense($licenseId)) > 0) ? true : false;
    }

    //check expiry date
    public function checkExpiryDate()
    {
        $hFunction = new \Hfunction();
        $date = $hFunction->carbonNow();
        return TfLandLicenseInvite::where('dateEnd', '<', $date)->where('action', 1)->update(['action' => 0]);
    }

}
