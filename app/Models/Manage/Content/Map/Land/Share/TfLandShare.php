<?php namespace App\Models\Manage\Content\Map\Land\Share;

use App\Models\Manage\Content\Map\Land\ShareView\TfLandShareView;
use App\Models\Manage\Content\Seller\TfSeller;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use Illuminate\Database\Eloquent\Model;

class TfLandShare extends Model
{

    protected $table = 'tf_land_shares';
    protected $fillable = ['share_id', 'shareCode', 'message', 'shareLink', 'email', 'action', 'created_at', 'land_id', 'user_id'];
    protected $primaryKey = 'share_id';
    public $timestamps = false;

    private $lastId;
    //========== ========== ========== INSERT && UPDATE ========= ========== ==========
    //----------- Insert -----------
    //add new
    public function insert($shareCode, $message = null, $shareLink = null, $email = null, $landId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelSeller = new TfSeller();
        $modelLandShare = new TfLandShare();

        $modelLandShare->shareCode = $shareCode;
        $modelLandShare->message = $message;
        $modelLandShare->shareLink = $shareLink;
        $modelLandShare->email = $email;
        $modelLandShare->land_id = $landId;
        $modelLandShare->user_id = $userId;
        $modelLandShare->created_at = $hFunction->createdAt();
        if ($modelLandShare->save()) {
            $this->lastId = $modelLandShare->share_id;
            if (!empty($userId)) {
                if ($modelSeller->checkExistUser($userId)) $modelSeller->plusLandShareOfUser($userId);
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
    // action status
    public function actionDelete($shareId)
    {
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        if (TfLandShare::where('share_id', $shareId)->update(['action' => 0])) {
            //delete notify
            $modelUserNotifyActivity->deleteByLandShare($shareId);
        }
    }

    //when delete banner
    public function actionDeleteByLand($landId = null)
    {
        if (!empty($landId)) {
            $objectId = TfLandShare::where(['land_id' => $landId, 'action' => 1])->pluck('share_id');
            if (!empty($objectId)) {
                $this->actionDelete($objectId);
            }
        }
    }

    // delete
    public function getDrop($shareId)
    {
        return TfLandShare::where('share_id', $shareId)->delete();
    }

    // ========== ========== ========= CHECK INFO ========= ========== ==========
    public function existShareCode($shareCode)
    {
        $result = TfLandShare::where('shareCode', $shareCode)->count();
        return ($result > 0) ? true : false;
    }

    // ========== ========== ========= RELATION ========= ========== ==========
    //---------- TF-LAND ----------
    public function land()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\TfLand', 'land_id', 'land_id');
    }

    // ---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    public function infoByUser($userId, $take = null, $dateTake = null)
    {
        if (empty($userId)) {
            return null;
        } else {
            if (empty($take) && empty($dataTake)) {
                return TfLandShare::where(['user_id' => $userId, 'action' => 1])->orderBy('created_at', 'DESC')->get();
            } else {
                return TfLandShare::where(['user_id' => $userId, 'action' => 1])->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
            }
        }
    }

    //use for statistic
    public function infoOfUserByDate($userId, $fromDate, $toDate)
    {
        return TfLandShare::where('user_id', $userId)->where('created_at', '>', $fromDate)->where('created_at', '<=', $toDate)->orderBy('created_at', 'DESC')->get();
    }

    //---------- TF-LAND-SHARE-NOTIFY ----------
    public function landShareNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\ShareNotify\TfLandShareNotify', 'share_id', 'share_id');
    }

    //---------- TF-LAND-SHARE-VIEW ----------
    public function landShareView()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\ShareView\TfLandShareView', 'share_id', 'share_id');
    }

    public function infoLandShareView($shareId = null)
    {
        $modelLandShareView = new TfLandShareView();
        if (empty($shareId)) $shareId = $this->shareId();
        return $modelLandShareView->infoByShare($shareId);
    }

    public function totalView($shareId = null)
    {
        $modelLandShareView = new TfLandShareView();
        if (empty($shareId)) $shareId = $this->shareId();
        return $modelLandShareView->totalViewByShare($shareId);
    }

    // view and register
    public function totalViewRegister($shareId = null)
    {
        $modelLandShareView = new TfLandShareView();
        if (empty($shareId)) $shareId = $this->shareId();
        return $modelLandShareView->totalViewRegisterByShare($shareId);
    }

    //========== ========== ========== GET INFO ========= ========== ==========

    public function getInfoByShareCode($shareCode)
    {
        return TfLandShare::where(['shareCode' => $shareCode, 'action' => 1])->first();
    }

    public function getInfo($shareId = null, $field = null)
    {
        if (empty($shareId)) {
            return TfLandShare::where('action', 1)->get();
        } else {
            $result = TfLandShare::where('share_id', $shareId)->first();
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
            return TfLandShare::where('share_id', $objectId)->pluck($column);
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

    public function landId($shareId = null)
    {
        return $this->pluck('land_id', $shareId);
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
        return TfLandShare::count();
    }
}
