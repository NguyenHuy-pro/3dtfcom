<?php namespace App\Models\Manage\Content\Building\Share;

use App\Models\Manage\Content\Building\ShareView\TfBuildingShareView;
use App\Models\Manage\Content\Sample\TfBuildingSample;
use App\Models\Manage\Content\Seller\TfSeller;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use Illuminate\Database\Eloquent\Model;

class TfBuildingShare extends Model
{

    protected $table = 'tf_building_shares';
    protected $fillable = ['share_id', 'shareCode', 'content', 'shareLink', 'email', 'action', 'created_at', 'building_id', 'user_id'];
    protected $primaryKey = 'share_id';
    public $timestamps = false;

    private $lastId;
    //========== ========== ========== INSERT && UPDATE ========= ========== ==========
    //----------- Insert -----------
    //add new
    public function insert($shareCode, $content = null, $shareLink = null, $email = null, $buildingId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelSeller = new TfSeller();
        $modelBuildingShare = new TfBuildingShare();
        $modelBuildingShare->shareCode = $shareCode;
        $modelBuildingShare->content = $content;
        $modelBuildingShare->shareLink = $shareLink;
        $modelBuildingShare->email = $email;
        $modelBuildingShare->building_id = $buildingId;
        $modelBuildingShare->user_id = $userId;
        $modelBuildingShare->created_at = $hFunction->carbonNow();
        if ($modelBuildingShare->save()) {
            $this->lastId = $modelBuildingShare->share_id;
            if (!empty($userId)) {
                if ($modelSeller->checkExistUser($userId)) $modelSeller->plusBuildingShareOfUser($userId);
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
    public function updateAction($shareId = null)
    {
        if (empty($shareId)) $shareId = $this->share_id;
        return TfBuildingShare::where('share_id', $shareId)->update(['action' => 0]);
    }

    // delete
    public function getDelete($shareId = null)
    {
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        if (empty($shareId)) $shareId = $this->share_id;
        if (TfBuildingShare::where('share_id', $shareId)->delete()) {
            //delete notify
            $modelUserNotifyActivity->deleteByBuildingShare($shareId);
        }
    }

    //when delete building
    public function actionDeleteByBuilding($buildingId = null)
    {
        if (!empty($buildingId)) {
            $listId = TfBuildingShare::where(['building_id' => $buildingId, 'action' => 1])->lists('share_id');
            if (!empty($listId)) {
                foreach ($listId as $value) {
                    $this->actionDelete($value);
                }
            }
        }
    }

    public function existShareCode($shareCode)
    {
        $result = TfBuildingShare::where('shareCode', $shareCode)->count();
        return ($result > 0) ? true : false;
    }

    //========== ========== ========== RELATION ========= ========== ==========
    //----------- TF-USER-NOTIFY-ACTIVITY -----------
    public function userNotifyActivity()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity', 'share_id', 'buildingShare_id');
    }

    //----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    //----------- TF-USER -----------
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
                return TfBuildingShare::where(['user_id' => $userId, 'action' => 1])->orderBy('created_at', 'DESC')->get();
            } else {
                return TfBuildingShare::where(['user_id' => $userId, 'action' => 1])->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
            }
        }
    }

    //use for statistic
    public function infoOfUserByDate($userId, $fromDate, $toDate)
    {
        return TfBuildingShare::where('user_id', $userId)->where('created_at', '>', $fromDate)->where('created_at', '<=', $toDate)->orderBy('created_at', 'DESC')->get();
    }


    //----------- TF-BUILDING-SHARE-NOTIFY -----------
    public function buildingShare()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\ShareNotify\TfBuildingShareNotify', 'share_id', 'share_id');
    }

    //----------- TF-BUILDING-SHARE-VIEW -----------
    public function buildingShareView()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\ShareView\TfBuildingShareView', 'share_id', 'share_id');
    }

    public function infoBuildingShareView($shareId = null)
    {
        $modelBuildingShareView = new TfBuildingShareView();
        if (empty($shareId)) $shareId = $this->shareId();
        return $modelBuildingShareView->infoByShare($shareId);
    }

    public function totalView($shareId = null)
    {
        $modelBuildingShareView = new TfBuildingShareView();
        if (empty($shareId)) $shareId = $this->shareId();
        return $modelBuildingShareView->totalViewByShare($shareId);
    }

    // view and register
    public function totalViewRegister($shareId = null)
    {
        $modelBuildingShareView = new TfBuildingShareView();
        if (empty($shareId)) $shareId = $this->shareId();
        return $modelBuildingShareView->totalViewRegisterByShare($shareId);
    }

    //========== ========== ========== GET INFO ========= ========== ==========

    public function getInfoByShareCode($shareCode)
    {
        return TfBuildingShare::where(['shareCode' => $shareCode, 'action' => 1])->first();
    }

    public function getInfo($shareId = null, $field = null)
    {
        if (empty($shareId)) {
            return TfBuildingShare::where('action', 1)->get();
        } else {
            $result = TfBuildingShare::where('share_id', $shareId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuildingShare::where('share_id', $objectId)->pluck($column);
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

    public function content($shareId = null)
    {
        return $this->pluck('content', $shareId);
    }

    public function shareLink($shareId = null)
    {
        return $this->pluck('shareLink', $shareId);
    }

    public function email($shareId = null)
    {
        return $this->pluck('email', $shareId);
    }

    public function buildingId($shareId = null)
    {
        return $this->pluck('building_id', $shareId);
    }

    public function userId($shareId = null)
    {
        return $this->pluck('user_id', $shareId);
    }

    public function createdAt($shareId = null)
    {
        return $this->pluck('created_at', $shareId);
    }

    public function totalRecords()
    {
        return TfBuildingShare::count();
    }
}