<?php namespace App\Models\Manage\Content\Map\Banner\Share;

use App\Models\Manage\Content\Map\Banner\ShareView\TfBannerShareView;
use App\Models\Manage\Content\Seller\TfSeller;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use Illuminate\Database\Eloquent\Model;

class TfBannerShare extends Model
{

    protected $table = 'tf_banner_shares';
    protected $fillable = ['share_id', 'shareCode', 'message', 'shareLink', 'email', 'action', 'created_at', 'banner_id', 'user_id'];
    protected $primaryKey = 'share_id';
    public $timestamps = false;

    private $lastId;
    //========== ========== ========== INSERT && UPDATE ========= ========== ==========
    //----------- Insert -----------
    //add new
    public function insert($shareCode, $message = null, $shareLink = null, $email = null, $bannerId, $userId)
    {
        $modelSeller = new TfSeller();
        $hFunction = new \Hfunction();
        $modelBannerShare = new TfBannerShare();
        $modelBannerShare->shareCode = $shareCode;
        $modelBannerShare->message = $message;
        $modelBannerShare->shareLink = $shareLink;
        $modelBannerShare->email = $email;
        $modelBannerShare->banner_id = $bannerId;
        $modelBannerShare->user_id = $userId;
        $modelBannerShare->created_at = $hFunction->createdAt();
        if ($modelBannerShare->save()) {
            $this->lastId = $modelBannerShare->share_id;
            if (!empty($userId)) {
                if ($modelSeller->checkExistUser($userId)) $modelSeller->plusBannerShareOfUser($userId);
            }
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

    //----------- Update -----------
    public function actionDelete($shareId)
    {
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        if (TfBannerShare::where('share_id', $shareId)->update(['action' => 0])) {
            //delete notify
            $modelUserNotifyActivity->deleteByBannerShare($shareId);
        }
    }

    //when delete banner
    public function actionDeleteByBanner($bannerId = null)
    {
        if (!empty($bannerId)) {
            $objectId = TfBannerShare::where(['banner_id' => $bannerId, 'action' => 1])->pluck('share_id');
            if (!empty($objectId)) {
                $this->actionDelete($objectId);
            }
        }
    }

    // delete
    public function getDrop($shareId)
    {
        return TfBannerShare::where('share_id', $shareId)->delete();
    }

    public function existShareCode($shareCode)
    {
        $result = TfBannerShare::where('shareCode', $shareCode)->count();
        return ($result > 0) ? true : false;
    }


    #========== ========== ========= RELATION ========= ========== ==========
    //----------- TF-USER-NOTIFY-ACTIVITY -----------
    public function userNotifyActivity()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity', 'share_id', 'bannerShare_id');
    }

    ##---------- TF-BANNER ----------
    public function banner()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\TfBanner', 'banner_id', 'banner_id');
    }

    ##---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    // info of user
    public function infoByUser($userId = null, $take = null, $dateTake = null)
    {
        if (empty($userId)) {
            return null;
        } else {
            if (empty($take) && empty($dataTake)) {
                return TfBannerShare::where(['user_id' => $userId, 'action' => 1])->orderBy('created_at', 'DESC')->get();
            } else {
                return TfBannerShare::where(['user_id' => $userId, 'action' => 1])->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
            }
        }
    }

    //use for statistic
    public function infoOfUserByDate($userId, $fromDate, $toDate)
    {
        return TfBannerShare::where('user_id', $userId)->where('created_at', '>', $fromDate)->where('created_at', '<=', $toDate)->orderBy('created_at', 'DESC')->get();
    }

    //---------- TF-BANNER-SHARE-NOTIFY ----------
    public function bannerShareNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\ShareNotify\TfBannerShareNotify', 'share_id', 'share_id');
    }

    //---------- TF-BANNER-SHARE-VIEW ----------
    public function bannerShareView()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\ShareView\TfBannerShareView', 'share_id', 'share_id');
    }

    //========== ========== ========== GET INFO ========= ========== ==========
    //----------- TF-BANNER-SHARE-VIEW ------------
    public function infoBannerShareView($shareId = null)
    {
        $modelBannerShareView = new TfBannerShareView();
        if (empty($shareId)) $shareId = $this->shareId();
        return $modelBannerShareView->infoByShare($shareId);
    }

    public function totalView($shareId = null)
    {
        $modelBannerShareView = new TfBannerShareView();
        if (empty($shareId)) $shareId = $this->shareId();
        return $modelBannerShareView->totalViewByShare($shareId);
    }

    // view and register
    public function totalViewRegister($shareId = null)
    {
        $modelBannerShareView = new TfBannerShareView();
        if (empty($shareId)) $shareId = $this->shareId();
        return $modelBannerShareView->totalViewRegisterByShare($shareId);
    }

    public function getInfoByShareCode($shareCode)
    {
        return TfBannerShare::where(['shareCode' => $shareCode, 'action' => 1])->first();
    }

    public function getInfo($shareId = null, $field = null)
    {
        if (empty($shareId)) {
            return TfBannerShare::where('action', 1)->get();
        } else {
            $result = TfBannerShare::where(['share_id' => $shareId, 'action' => 1])->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    //----------- SHARE INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBannerShare::where('share_id', $objectId)->pluck($column);
        }
    }

    public function shareId()
    {
        return $this->share_id;
    }

    public function shareCode($shareId = null)
    {
        return $this->pluck('shareCode', $shareId);
    }

    public function message($shareId = null)
    {
        return $this->pluck('message', $shareId);
    }

    public function shareLink($shareId = null)
    {
        return $this->pluck('shareLink', $shareId);
    }

    public function email($shareId = null)
    {
        return $this->pluck('email', $shareId);
    }

    public function bannerId($shareId = null)
    {
        return $this->pluck('banner_id', $shareId);
    }

    public function userId($shareId = null)
    {
        return $this->pluck('user_id', $shareId);
    }

    public function createdAt($shareId = null)
    {
        return $this->pluck('created_at', $shareId);
    }

    //total records
    public function totalRecords()
    {
        return TfBannerShare::count();
    }

}
