<?php namespace App\Models\Manage\Content\Users\PostNewNotify;

use Illuminate\Database\Eloquent\Model;

class TfUserPostNewNotify extends Model {

    protected $table = 'tf_user_post_new_notifies';
    protected $fillable = ['post_id', 'user_id', 'newInfo', 'showNotify', 'action', 'created_at'];
    //protected $primaryKey = ['user_id','user_id'];
    //public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT ========= ========== ==========
    // new insert
    public function insert($postId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelNotify = new TfUserPostNewNotify();
        $modelNotify->post_id = $postId;
        $modelNotify->user_id = $userId;
        $modelNotify->newInfo = 1;
        $modelNotify->showNotify = 1;
        $modelNotify->action = 1;
        $modelNotify->created_at = $hFunction->carbonNow();
        return $modelNotify->save();
    }

    #------------ Update -------------
    // new info status of user
    public function updateNewInfoOfUser($userId)
    {
        return TfUserPostNewNotify::where(['user_id' => $userId, 'newInfo' => 1])->update(['newInfo' => 0]);
    }

    //hide the post display on activity
    public function updateShowNotify($postId, $userId)
    {
        return TfUserPostNewNotify::where('post_id', $postId)->where('user_id', $userId)->update(['showNotify' => 0]);
    }

    // action status
    public function updateAction($postId, $userId)
    {
        return TfUserPostNewNotify::where('post_id', $postId)->where('user_id', $userId)->update(['action' => 0]);
    }
    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-USER-POST -----------
    public function userPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\user\Post\TfUserPost', 'post_id', 'post_id');
    }

    #----------- TF-USER -----------
    public function users()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #========== ========== ========== INFO ========= ========== ==========
    // total records
    public function totalRecords()
    {
        return TfUserPostNewNotify::count();
    }

}
