<?php namespace App\Models\Manage\Content\Building\PostNewNotify;

use Illuminate\Database\Eloquent\Model;

class TfBuildingPostNewNotify extends Model
{

    protected $table = 'tf_building_post_new_notifies';
    protected $fillable = ['post_id', 'user_id', 'newInfo', 'displayNotify', 'action', 'created_at'];
    //protected $primaryKey = ['building_id','user_id'];
    //public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT ========= ========== ==========
    // new insert
    public function insert($postId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelNotify = new TfBuildingPostNewNotify();
        $modelNotify->post_id = $postId;
        $modelNotify->user_id = $userId;
        $modelNotify->newInfo = 1;
        $modelNotify->displayNotify = 1;
        $modelNotify->action = 1;
        $modelNotify->created_at = $hFunction->carbonNow();
        return $modelNotify->save();
    }

    #------------ Update -------------
    // new info status of user
    public function updateNewInfoOfUser($userId)
    {
        return TfBuildingPostNewNotify::where(['user_id' => $userId, 'newInfo' => 1])->update(['newInfo' => 0]);
    }

    //hide the post display on activity
    public function updateDisplayNotify($postId, $userId)
    {
        return TfBuildingPostNewNotify::where('post_id', $postId)->where('user_id', $userId)->update(['displayNotify' => 0]);
    }

    // action status
    public function updateAction($postId, $userId)
    {
        return TfBuildingPostNewNotify::where('post_id', $postId)->where('user_id', $userId)->update(['action' => 0]);
    }
    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-BUILDING-POST -----------
    public function buildingPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Post\TfBuildingPosts', 'post_id', 'post_id');
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
        return TfBuildingPostNewNotify::count();
    }

}
