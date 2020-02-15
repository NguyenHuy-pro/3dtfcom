<?php namespace App\Models\Manage\Content\Users\Friend;

use Illuminate\Database\Eloquent\Model;

use DB;

class TfUserFriend extends Model
{

    protected $table = 'tf_user_friends';
    protected $fillable = ['friend_id', 'user_id', 'friendUser_id', 'newInfo', 'status', 'created_at'];
    protected $primaryKey = 'friend_id';
    public $timestamps = false;

    //========== ========== ========== INSERT && EDIT ========== ========== ==========
    //----------- ------------ new insert ----------- ------------
    public function insert($userId, $friendUserId)
    {
        $hFunction = new \Hfunction();
        $modelUserFriend = new TfUserFriend();
        $modelUserFriend->user_id = $userId;
        $modelUserFriend->friendUser_id = $friendUserId;
        $modelUserFriend->created_at = $hFunction->createdAt();
        return $modelUserFriend->save();
    }

    //----------- ------------ update info ----------- ------------
    //new info
    public function updateNewInfo($userId = '', $friendUserId = '')
    {
        return TfUserFriend::where('user_id', $userId)->where('friendUser_id', $friendUserId)->update(['newInfo' => 0]);
    }

    //new info
    public function updateNewInfoAll($userId)
    {
        return TfUserFriend::where('user_id', $userId)->where('newInfo', 1)->update(['newInfo' => 0]);
    }


    //status
    public function updateStatus($userId = '', $friendUserId = '')
    {
        return TfUserFriend::where('user_id', $userId)->where('friendUser_id', $friendUserId)->update(['status' => 0]);
    }

    // delete
    public function actionDelete($userId, $friendUserId)
    {
        $strSql = "DELETE FROM tf_user_friends WHERE(user_id = $userId AND friendUser_id = $friendUserId ) OR (user_id = $friendUserId AND friendUser_id = $userId)";
        return DB::select($strSql);
    }

    //========== ========== ========== Relation ========== ========== ==========
    public function userNotifyFriend()
    {
        return $this->hasOne('App\Models\Manage\Content\Users\Notify\TfUserNotifyFriend', 'friend_id', 'friend_id');
    }


    //----------- TF- USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    // get list friend id of user
    public function listFriendOfUser($userId = '')
    {
        // send request
        $list_1 = TfUserFriend::where('user_id', $userId)->lists('friendUser_id');
        // receive request
        $list_2 = TfUserFriend::where('friendUser_id', $userId)->lists('user_id');
        return array_merge($list_1, $list_2);
    }

    // check friend
    public function checkFriendOfUser($userId = '', $checkUserId = '')
    {
        $result_1 = TfUserFriend::where('user_id', $userId)->where('friendUser_id', $checkUserId)->count();
        $result_2 = TfUserFriend::where('user_id', $checkUserId)->where('friendUser_id', $userId)->count();
        return ($result_1 + $result_2 > 0) ? true : false;
    }

    //========== ========== ========== GET INFO ========== ========== ==========
    // ---------- Get INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserFriend::where('friend_id', $objectId)->pluck($column);
        }
    }

    public function friendId()
    {
        return $this->friend_id;
    }

}
