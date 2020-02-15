<?php namespace App\Models\Manage\Content\Building\CommentNotify;

use App\Models\Manage\Content\Building\Comment\TfBuildingComment;
use Illuminate\Database\Eloquent\Model;

class TfBuildingCommentNotify extends Model
{

    protected $table = 'tf_building_comment_notifies';
    protected $fillable = ['comment_id', 'user_id', 'newInfo', 'action', 'created_at'];
    //protected $primaryKey = ['buildingComment_id','user_id'];
    //public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    public function insert($commentId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelNotify = new TfBuildingCommentNotify();
        $modelNotify->comment_id = $commentId;
        $modelNotify->user_id = $userId;
        $modelNotify->newInfo = 1;// default 1 (new)
        $modelNotify->created_at = $hFunction->createdAt();
        $modelNotify->save();
    }

    #---------- UPDATE INFO -------------
    // new info status
    public function updateNewInfo($commentId, $userId)
    {
        return TfBuildingCommentNotify::where('comment_id', $commentId)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    // new info status of user
    public function updateNewInfoOfUser($userId)
    {
        return TfBuildingCommentNotify::where('newInfo', 1)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    // delete
    public function actionDelete($commentId, $userId)
    {
        return TfBuildingCommentNotify::where('comment_id', $commentId)->where('user_id', $userId)->update(['action' => 0]);
    }

    //when delete comment
    public function actionDeleteByComment($commentId = null)
    {
        if (!empty($commentId)) {
            TfBuildingCommentNotify::where(['comment_id' => $commentId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    #----------- TF-BUILDING-COMMENT -----------
    public function comment()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Comment\TfBuildingComment');
    }

    #----------- TF-BUILDING-COMMENT-NOTIFY -----------
    public function buildingComment()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Comment\TfBuildingComment', 'comment_id', 'comment_id');
    }

    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //check exist notify on a building
    public function checkNewNotifyOfUserOnBuilding($buildingId, $userId)
    {
        $modelBuildingComment = new TfBuildingComment();
        $listCommentId = $modelBuildingComment->listIdOfBuilding($buildingId);
        $result = TfBuildingCommentNotify::where('user_id', $userId)->whereIn('comment_id', $listCommentId)->where('newInfo', 1)->count();
        return ($result > 0) ? true : false;
    }

    // disable new info on a buildings of user
    public function disableNewOfUserOnBuilding($buildingId, $userId)
    {
        $modelBuildingComment = new TfBuildingComment();
        $listCommentId = $modelBuildingComment->listIdOfBuilding($buildingId);
        return TfBuildingCommentNotify::whereIn('comment_id', $listCommentId)->where('user_id', $userId)->where('newInfo', 1)->update(['newInfo' => 0]);

    }

    #----------- ---------- NOTIFY INFO ----------- ----------
    // total records
    public function totalRecords()
    {
        return TfBuildingCommentNotify::count();
    }


}
