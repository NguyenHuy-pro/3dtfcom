<?php namespace App\Models\Manage\Content\Users\Notify;

use Illuminate\Database\Eloquent\Model;

class TfUserNotifyFriend extends Model {

    protected $table = 'tf_user_notify_friends';
    protected $fillable = ['notify_id', 'newStatus', 'action', 'created_at', 'user_id', 'request_id', 'friend_id'];
    protected $primaryKey = 'notify_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #---------- ---------- Insert ---------- ----------
    public function insert($userId, $requestId, $friendId)
    {
        $hFunction = new \Hfunction();
        $modelUserNotifyFriend = new TfUserNotifyFriend();
        $modelUserNotifyFriend->newStatus = 1;
        $modelUserNotifyFriend->created_at = $hFunction->carbonNow();
        $modelUserNotifyFriend->user_id = $userId;
        $modelUserNotifyFriend->request_id = $requestId;
        $modelUserNotifyFriend->friend_id = $friendId;
        if ($modelUserNotifyFriend->save()) {
            $this->lastId = $modelUserNotifyFriend->notify_id;
            return true;
        } else {
            return false;
        }

    }

    //get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- ---------- Update info ---------- ----------
    //delete
    public function actionDelete($notifyId = null)
    {
        if (empty($notifyId)) $notifyId = $this->postId();
        if (TfUserNotifyFriend::where('notify_id', $notifyId)->update(['action' => 0])) {

        }
    }

    #----------- TF-USER-REQUEST-----------
    public function userRequest()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Love\TfBuildingLove', 'buildingLove_id', 'love_id');
    }

    public function deleteByRequest($requestId)
    {
        return TfUserNotifyFriend::where('request_id', $requestId)->update(['action' => 0]);
    }
    #----------- TF-USER-FRIEND-----------
    public function userFriend()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Love\TfBuildingLove', 'buildingLove_id', 'love_id');
    }

    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }


    //notify of user
    public function infoOfUser($userId, $take = null, $dateTake = null)
    {
        if (empty($take) && empty($dateTake)) {
            return TfUserNotifyFriend::where(['user_id' => $userId, 'action' => 1])->orderBy('created_at', 'DESC')->get();
        } else {
            return TfUserNotifyFriend::where(['user_id' => $userId, 'action' => 1])->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
        }

    }

    //new notify of user
    public function totalNewNotifyOfUser($userId)
    {
        return TfUserNotifyFriend::where(['user_id' => $userId, 'newStatus' => 1, 'action' => 1])->count();
    }

    public function turnOffNewStatusOfUser($userId)
    {
        return TfUserNotifyFriend::where(['user_id' => $userId, 'newStatus' => 1])->update(['newStatus' => 0]);
    }

    public function deleteByUser($userId)
    {
        return TfUserNotifyFriend::where('user_id', $userId)->update(['action' => 0]);
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($notifyId = null, $field = null)
    {
        if (empty($notifyId)) {
            return TfUserNotifyFriend::where('action', 1)->get();
        } else {
            $result = TfUserNotifyFriend::where(['notify_id' => $notifyId, 'action' => 1])->first();
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
            return TfUserNotifyFriend::where('notify_id', $objectId)->pluck($column);
        }
    }

    public function notifyId()
    {
        return $this->notify_id;
    }

    public function newStatus($notifyId = null)
    {
        return $this->pluck('newStatus', $notifyId);
    }

    public function requestId($notifyId = null)
    {
        return $this->pluck('request_id', $notifyId);
    }

    public function friendId($notifyId = null)
    {
        return $this->pluck('friend_id', $notifyId);
    }

    public function userId($notifyId = null)
    {
        return $this->pluck('user_id', $notifyId);
    }


    public function createdAt($notifyId = null)
    {
        return $this->pluck('created_at', $notifyId);
    }

    //=================== check object type ======================
    public function checkRequest($notifyId = null)
    {
        return (empty($this->requestId($notifyId))) ? false : true;
    }

    public function checkFriend($notifyId = null)
    {
        return (empty($this->friendId($notifyId))) ? false : true;
    }

    //total
    public function totalRecords()
    {
        return TfUserNotifyFriend::count();
    }

    # total
    public function totalActivityRecords()
    {
        return TfUserNotifyFriend::where('action', 1)->count();
    }


}
