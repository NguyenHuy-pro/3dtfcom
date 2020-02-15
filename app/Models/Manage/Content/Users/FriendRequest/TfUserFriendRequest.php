<?php namespace App\Models\Manage\Content\Users\FriendRequest;

use App\Models\Manage\Content\Users\Friend\TfUserFriend;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyFriend;
use App\Models\Manage\Content\Users\TfUser;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use Illuminate\Database\Eloquent\Model;

class TfUserFriendRequest extends Model
{

    protected $table = 'tf_user_friend_requests';
    protected $fillable = ['request_id', 'newInfo', 'confirm', 'accept', 'created_at', 'action', 'user_id', 'requestUser_id'];
    protected $primaryKey = 'request_id';
    public $timestamps = false;

    private $lastId;

    //========== ========== ========== INSERT && UPDATE ========== ========== ==========
    //---------- Insert ----------
    public function insert($userId, $requestUserId)
    {
        $hFunction = new \Hfunction();
        $modelFriendRequest = new TfUserFriendRequest();
        $modelFriendRequest->user_id = $userId;
        $modelFriendRequest->requestUser_id = $requestUserId;
        $modelFriendRequest->created_at = $hFunction->createdAt();
        if ($modelFriendRequest->save()) {
            $this->lastId = $modelFriendRequest->request_id;
            return true;
        } else {
            return false;
        }
    }

    //---------- Update info ----------
    // yes
    public function confirmYes($userId = '', $requestUserId = '')
    {
        $modelUserFriend = new TfUserFriend();
        $modelUserStatistic = new TfUserStatistic();
        if ($modelUserFriend->insert($userId, $requestUserId)) {
            //notify user has new friend (request had agreed)
            $modelUserStatistic->plusFriendNotify($userId);

            // update total friend
            $modelUserStatistic->plusFriend($userId);
            $modelUserStatistic->plusFriend($requestUserId);

            return TfUserFriendRequest::where('user_id', $userId)->where('requestUser_id', $requestUserId)->where('action', 1)->update(['newInfo' => 0, 'confirm' => 1, 'accept' => 1, 'action' => 0]);
        } else {
            return false;
        }
    }

    // No
    public function confirmNo($userId = '', $requestUserId = '')
    {
        return TfUserFriendRequest::where('user_id', $userId)->where('requestUser_id', $requestUserId)->where('action', 1)->update(['newInfo' => 0, 'confirm' => 1, 'accept' => 0, 'action' => 0]);
    }

    // new info status
    public function updateNewInfo($requestId = null)
    {
        if (empty($requestId)) $requestId = $this->request_id;
        return TfUserFriendRequest::where('request_id', $requestId)->update(['newInfo' => 0]);
    }

    // confirm status
    public function updateConfirm($requestId = '', $acceptStatus = '')
    {
        return TfUserFriendRequest::where('request_id', $requestId)->update(['confirm' => 1, 'accept' => $acceptStatus, 'action' => 0]);
    }

    // accept status
    public function updateAccept($requestId = null)
    {
        if (empty($requestId)) $requestId = $this->requestId();
        return TfUserFriendRequest::where('request_id', $requestId)->update(['accept' => 1]);
    }

    // delete
    public function actionDelete($requestId = null)
    {
        $modelUserNotifyFriend = new TfUserNotifyFriend();
        if (empty($requestId)) $requestId = $this->requestId();
        if (TfUserFriendRequest::where('request_id', $requestId)->update(['action' => 0])) {
            $modelUserNotifyFriend->deleteByRequest($requestId);
        }
    }

    #========== ========== ========== RELATION ========== ========== =========
    # --------- TF-USER-NOTIFY-FRIEND ----------
    public function userNotifyFriend()
    {
        return $this->hasOne('App\Models\Manage\Content\Users\Notify\TfUserNotifyFriend', 'request_id', 'request_id');
    }

    //---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App/Models/Manage/Content/Users/TfUser', 'user_id', 'user_id');
    }

    // check sent request of user
    public function checkSentRequestOfUser($userId = '', $checkUserId = '')
    {
        $result = TfUserFriendRequest::where('user_id', $userId)->where('requestUser_id', $checkUserId)->where('action', 1)->where('confirm', 0)->count();
        return ($result > 0) ? true : false;
    }

    // get all receive info of user
    public function infoReceiveOfUser($userId = '', $skip = '', $take = '')
    {
        if (empty($skip) && empty($take)) {
            return TfUserFriendRequest::where('requestUser_id', $userId)->where('action', 1)->orderBy('created_at', 'DESC')->get();
        } else {
            return TfUserFriendRequest::where('requestUser_id', $userId)->where('action', 1)->orderBy('created_at', 'DESC')->skip($skip)->take($take)->get();
        }
    }

    // get all sent info of user
    public function infoSentOfUser($userId = '', $skip = '', $take = '')
    {
        if (empty($skip) && empty($take)) {
            return TfUserFriendRequest::where('user_id', $userId)->where('action', 1)->orderBy('created_at', 'DESC')->get();
        } else {
            return TfUserFriendRequest::where('user_id', $userId)->where('action', 1)->orderBy('created_at', 'DESC')->skip($skip)->take($take)->get();
        }
    }

    // get new receive info of user
    public function infoNewReceiveOfUser($userId = '')
    {
        return TfUserFriendRequest::where('requestUser_id', $userId)->where('newInfo', 1)->where('action', 1)->orderBy('created_at', 'DESC')->get();
    }

    // delete on user
    public function deleteByUser($userId = '', $requestUserId = '')
    {
        return TfUserFriendRequest::where('user_id', $userId)->where('requestUser_id', $requestUserId)->where('action', 1)->update(['action' => 0]);
    }

    #========== ========== ========== GET INFO ========== ========== =========
    public function getInfo($requestId = '', $field = '')
    {
        if (empty($requestId)) {
            return TfUserFriendRequest::where('action', 1)->get();
        } else {
            $result = TfUserFriendRequest::where('request_id', $requestId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    //check user receive friend request
    public function checkReceiveFriendRequest($userId = '', $checkUserId = '')
    {
        $result = TfUserFriendRequest::where('user_id', $checkUserId)->where('requestUser_id', $userId)->where('action', 1)->where('confirm', 0)->count();
        return ($result > 0) ? true : false;
    }

    //---------- Request Info ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserFriendRequest::where('request_id', $objectId)->pluck($column);
        }
    }

    public function requestId()
    {
        return $this->request_id;
    }

    public function newInfo($requestId = null)
    {
        return $this->pluck('newInfo', $requestId);
    }

    public function confirm($requestId = null)
    {
        return $this->pluck('confirm', $requestId);
    }

    public function accept($requestId = null)
    {
        return $this->pluck('accept', $requestId);

    }

    public function createdAt($requestId = null)
    {
        return $this->pluck('created_at', $requestId);
    }

    public function userId($requestId = null)
    {
        return $this->pluck('user_id', $requestId);
    }

    public function requestUserId($requestId = null)
    {
        return $this->pluck('requestUser_id', $requestId);
    }


    // total records
    public function totalRecords()
    {
        return TfUserFriendRequest::count();
    }

}
