<?php namespace App\Models\Manage\Content\Building\Comment;

use App\Models\Manage\Content\Building\CommentNotify\TfBuildingCommentNotify;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use Illuminate\Database\Eloquent\Model;

class TfBuildingComment extends Model
{

    protected $table = 'tf_building_comments';
    protected $fillable = ['comment_id', 'content', 'newInfo', 'action', 'created_at', 'building_id', 'user_id'];
    protected $primaryKey = 'comment_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #----------- insert ----------
    public function insert($content, $newInfo, $buildingId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelComment = new TfBuildingComment();
        $modelComment->content = $content;
        $modelComment->newInfo = $newInfo;
        $modelComment->building_id = $buildingId;
        $modelComment->user_id = $userId;
        $modelComment->created_at = $hFunction->createdAt();
        if ($modelComment->save()) {
            $this->lastId = $modelComment->comment_id;
            return true;
        } else {
            return false;
        }
    }

    # get id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #------------ update -----------
    # update content
    public function updateContent($commentId, $content)
    {
        return TfBuildingComment::where('comment_id', $commentId)->update(['content' => $content]);
    }

    # new info status
    public function updateNewInfo($commentId)
    {
        return TfBuildingComment::where('comment_id', $commentId)->update(['newInfo' => 0]);
    }

    #delete
    public function actionDelete($commentId)
    {
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        $modelBuildingCommentNotify = new TfBuildingCommentNotify();
        if (TfBuildingComment::where('comment_id', $commentId)->update(['action' => 0])) {
            //notify on map
            $modelBuildingCommentNotify->actionDeleteByComment($commentId);
            //notify on header
            $modelUserNotifyActivity->deleteByBuildingComment($commentId);
            return true;
        }else{
            return false;
        }
    }

    #when delete building
    public function actionDeleteByBuilding($buildingId = null)
    {
        if (!empty($buildingId)) {
            $listId = TfBuildingComment::where(['building_id' => $buildingId, 'action' => 1])->lists('comment_id');
            if (!empty($listId)) {
                foreach ($listId as $value) {
                    $this->actionDelete($value);
                }
            }
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    //----------- TF-USER-NOTIFY-ACTIVITY -----------
    public function userNotifyActivity()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity', 'comment_id', 'buildingComment_id');
    }

    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    // info of building
    public function infoOfBuilding($buildingId, $take = null, $dateTake = null)
    {
        if (empty($take) && empty($dateTake)) {
            return TfBuildingComment::where('building_id', $buildingId)->where('action', 1)->orderBy('created_at', 'DESC')->get();
        } else {
            return TfBuildingComment::where('building_id', $buildingId)->where('action', 1)->where('created_at', '<', $dateTake)->orderBy('comment_id', 'DESC')->skip(0)->take($take)->get();
        }

    }

    // get list comment if of building
    public function listIdOfBuilding($buildingId)
    {
        return TfBuildingComment::where('building_id', $buildingId)->where('action', 1)->lists('comment_id');
    }

    #----------- TF-BUILDING-COMMENT-NOTIFY -----------
    public function buildingCommentNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\CommentNotify\TfBuildingCommentNotify', 'comment_id', 'comment_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($commentId = '', $field = '')
    {
        if (empty($commentId)) {
            return TfBuildingComment::get();
        } else {
            $result = TfBuildingComment::where('comment_id', $commentId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #----------- COMMENT INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuildingComment::where('comment_id', $objectId)->pluck($column);
        }
    }

    public function commentId()
    {
        return $this->comment_id;
    }

    # content
    public function content($commentId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('content', $commentId));
    }

    public function newInfo($commentId = null)
    {
        return $this->pluck('newInfo', $commentId);
    }

    public function buildingId($commentId = null)
    {
        return $this->pluck('building_id', $commentId);
    }

    public function userId($commentId = null)
    {
        return $this->pluck('user_id', $commentId);
    }

    public function createdAt($commentId = null)
    {
        return $this->pluck('created_at', $commentId);
    }

    # total records
    public function totalRecords()
    {
        return TfBuildingComment::where('action', 1)->count();
    }


}
