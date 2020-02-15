<?php namespace App\Models\Manage\Content\Building\PostLove;

use Illuminate\Database\Eloquent\Model;

class TfBuildingPostLove extends Model
{

    protected $table = 'tf_building_post_loves';
    protected $fillable = ['post_id', 'user_id', 'newInfo', 'status', 'created_at'];
    #protected $primaryKey = ['buildingPost_id','user_id'];
    #public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #---------- Insert -----------
    public function insert($postsId, $userId, $newInfo = null)
    {
        $hFunction = new \Hfunction();
        $modelPostsLove = new TfBuildingPostLove();
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
        return TfBuildingPostLove::where('post_id', $postsId)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    # action status
    public function updateStatus($postsId, $userId)
    {
        return TfBuildingPostLove::where('post_id', $postsId)->where('user_id', $userId)->update(['status' => 0]);
    }

    # delete
    public function actionDelete($postsId, $userId)
    {
        return TfBuildingPostLove::where('post_id', $postsId)->where('user_id', $userId)->delete();
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #-----------  TF-BUILDING POST -----------
    public function buildingPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Post\TfBuildingPost', 'post_id', 'post_id');
    }

    # total love of posts of building
    public function totalOfPosts($postId)
    {
        return TfBuildingPostLove::where('post_id',$postId)->count();
    }

    #========== ========== ========== CHECK INFO ========= ========== ==========
    public function existLovePostsOfUser($postsId, $userId)
    {
        $result = TfBuildingPostLove::where('post_id', $postsId)->where('user_id', $userId)->count();
        return ($result > 0) ? true : false;
    }

    # total records
    public function totalRecords()
    {
        return TfBuildingPostLove::count();
    }

}
