<?php namespace App\Models\Manage\Content\Users\Love;

use Illuminate\Database\Eloquent\Model;

class TfUserLove extends Model {

    protected $table = 'tf_user_loves';
    protected $fillable = ['user_id', 'loveUser_id', 'newInfo', 'status', 'created_at'];
    #protected $primaryKey = 'share_id';
    public $timestamps = false;

    #========== =========== =========== INSERT && EDIT =========== =========== ===========
    #----------- ----------- Insert ----------- -----------
    public function insert($userId, $loveUserId,$newInfo='')
    {
        $hFunction = new \Hfunction();
        $modelUserLove = new TfUserLove();
        $modelUserLove->user_id = $userId;
        $modelUserLove->loveUser_id = $loveUserId;
        $modelUserLove->newInfo = $newInfo;
        $modelUserLove->created_at = $hFunction->createdAt();
        return $modelUserLove->save();
    }

    #----------- ----------- Update info ----------- -----------
    # status
    public function updateNewInfo($userId = '', $loveUserId = '')
    {
        return TfUserLove::where('user_id', $userId)->where('loveUser_id', $loveUserId)->update(['newInfo' => 0]);
    }

    # status
    public function updateStatus($userId = '', $loveUserId = '')
    {
        return TfUserLove::where('user_id', $userId)->where('loveUser_id', $loveUserId)->update(['status' => 0]);
    }

    # delete
    public function actionDelete($userId, $loveUserId)
    {
        return TfUserLove::where('user_id', $userId)->where('loveUser_id', $loveUserId)->delete();
    }

    #========== =========== =========== get info =========== =========== ===========
    public function user()
    {
        return $this->belongsTo('App/Models/Manage/Content/Users/TfUser', 'user_id', 'user_id');
    }

    # total love of  user
    public function totalLoveOfUser($userId)
    {
        return TfUserLove::where('loveUser_id', $userId)->count();
    }

    #check exist loved of user
    public function existLoveOfUser($userId='', $checkUserId='')
    {
        $result = TfUserLove::where('user_id', $userId)->where('loveUser_id', $checkUserId)->count();
        return ($result > 0)? true: false;
    }
}
