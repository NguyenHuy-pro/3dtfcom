<?php namespace App\Models\Manage\Content\Map\Banner\LicenseInvite;

use App\Models\Manage\Content\Map\Banner\License\TfBannerLicense;
use App\Models\Manage\Content\Seller\TfSeller;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Database\Eloquent\Model;

class TfBannerLicenseInvite extends Model
{

    protected $table = 'tf_banner_license_invites';
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
        $model = new TfBannerLicenseInvite();
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
        if (TfBannerLicenseInvite::where('invite_id', $inviteId)->update(['agree' => 1, 'register' => 1, 'action' => 0])) {
            //statistic for seller
            $userInviteId = $dataInvite->bannerLicense->userId();
            if ($modelSeller->checkExistUser($userInviteId)) $modelSeller->plusBannerInviteRegisterOfUser($userInviteId);
        }
    }

    public function checkNewMember($newUserId)
    {
        $modelUser = new TfUser();
        $modelSeller = new TfSeller();
        $modelBannerLicense = new TfBannerLicense();
        if ($modelBannerLicense->checkAccessInviteCode()) {
            //user access from invitation but user do not select banner
            $inviteCode = $modelBannerLicense->getAccessInviteCode();
            if (TfBannerLicenseInvite::where('inviteCode', $inviteCode)->update(['register' => 1, 'action' => 0])) {
                //statistic for seller
                $dataInvite = $this->getInfoOfCode($inviteCode);
                $userInviteId = $dataInvite->bannerLicense->userId();
                if ($modelSeller->checkExistUser($userInviteId)) $modelSeller->plusBannerInviteRegisterOfUser($userInviteId);
                //update introduce user
                $modelUser->updateUserIntroduce($userInviteId, $newUserId);
            }
        }
    }

    public function actionDelete($inviteId = null)
    {
        if (empty($inviteId)) $inviteId = $this->inviteId();
        return TfBannerLicenseInvite::where('invite_id', $inviteId)->update(['action' => 0]);
    }

    //when delete banner
    public function actionDeleteByLicense($licenseId = null)
    {
        if (!empty($licenseId)) {
            TfBannerLicenseInvite::where(['license_id' => $licenseId, 'action' => 1])->update(['action' => 0]);
        }
    }

    //delete
    public function getDrop($inviteId = null)
    {
        if (empty($inviteId)) $inviteId = $this->inviteId();
        return TfBannerLicenseInvite::where('invite_id', $inviteId)->delete();
    }

    # ========== ========== ========= RELATION ========= ========== ==========
    #---------- TF-BANNER-LICENSE ----------
    public function bannerLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\License\TfBannerLicense', 'license_id', 'license_id');
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfoOfCode($inviteCode)
    {
        return TfBannerLicenseInvite::where('inviteCode', $inviteCode)->first();
    }

    public function getInfo($inviteId = null, $field = null)
    {
        if (empty($inviteId)) {
            return TfBannerLicenseInvite::where('action', 1)->get();
        } else {
            $result = TfBannerLicenseInvite::where(['invite_id' => $inviteId, 'action' => 1])->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #----------- TF-USER -------------
    public function infoSentByUser($userId = null)
    {
        $modelBannerLicense = new TfBannerLicense();
        $result = null;
        if (!empty($userId)) {
            $listLicenseId = $modelBannerLicense->listIdOfUser($userId);
            if (!empty($listLicenseId)) {
                $result = TfBannerLicenseInvite::whereIn('license_id', $listLicenseId)->where('action', 1)->get();
            }
        }
        return $result;
    }

    #----------- INVITE INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBannerLicenseInvite::where('invite_id', $objectId)->pluck($column);
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
        return $this->pluck('agree', $inviteId);
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
        return TfBannerLicenseInvite::count();
    }

    //check email is inviting
    public function existEmailInviting($email)
    {
        $result = TfBannerLicenseInvite::where('email', $email)->where('action', 1)->count();
        return ($result > 0) ? true : false;
    }

    #----------- TF-BANNER-LICENSE -----------
    public function infoOfLicense($licenseId)
    {
        return TfBannerLicenseInvite::where('license_id', $licenseId)->where('action', 1)->first();
    }

    public function existBannerLicense($licenseId)
    {
        return (count($this->infoOfLicense($licenseId)) > 0) ? true : false;
    }

    //check expiry date
    public function checkExpiryDate()
    {
        $hFunction = new \Hfunction();
        $date = $hFunction->carbonNow();
        return TfBannerLicenseInvite::where('dateEnd', '<', $date)->where('action', 1)->update(['action' => 0]);
    }

}
