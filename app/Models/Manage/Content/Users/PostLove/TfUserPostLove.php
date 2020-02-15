<?php namespace App\Models\Manage\Content\Users\PostLove;

use Illuminate\Database\Eloquent\Model;

class TfUserPostLove extends Model {

    protected $table = 'tf_user_post_loves';
    protected $fillable = ['post_id', 'user_id', 'newInfo', 'status', 'created_at'];
    #protected $primaryKey = ['userPost_id','user_id'];
    #public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #---------- Insert -----------
    public function insert($postsId, $userId, $newInfo = 1)
    {
        $hFunction = new \Hfunction();
        $modelPostsLove = new TfuserPostLove();
        $modelPostsLove->post_id = $postsId;
        $modelPostsLove->user_id = $userId;
        $modelPostsLove->newInfo = $newInfo; // when develop notify love -> new info = 1
        $modelPostsLove->status = 0;
        $modelPostsLove->created_at = $hFunction->createdAt();
        return $modelPostsLove->save();
    }

    #---------- Update ----------
    public function updateNewInfo($postsId, $userId)
    {
        return TfUserPostLove::where('post_id', $postsId)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    # action status
    public function updateStatus($postsId, $userId)
    {
        return TfUserPostLove::where('post_id', $postsId)->where('user_id', $userId)->update(['status' => 0]);
    }

    # delete
    public function actionDelete($postsId, $userId)
    {
        return TfUserPostLove::where('post_id', $postsId)->where('user_id', $userId)->delete();
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #-----------  TF-USER POST -----------
    public function userPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\user\Post\TfUserPost', 'post_id', 'post_id');
    }

    # total love of posts of user
    public function totalOfPost($postId)
    {
        return TfUserPostLove::where('post_id',$postId)->count();
    }

    #========== ========== ========== CHECK INFO ========= ========== ==========
    public function existLovePostOfUser($postsId, $userId)
    {
        $result = TfUserPostLove::where('post_id', $postsId)->where('user_id', $userId)->count();
        return ($result > 0) ? true : false;
    }

    # total records
    public function totalRecords()
    {
        return TfUserPostLove::count();
    }

}
