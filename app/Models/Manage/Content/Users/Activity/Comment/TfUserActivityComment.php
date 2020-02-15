<?php namespace App\Models\Manage\Content\Users\Activity\Comment;

use Illuminate\Database\Eloquent\Model;

class TfUserActivityComment extends Model {

    protected $table = 'tf_user_activity_comments';
    protected $fillable = ['comment_id', 'content', 'action', 'created_at', 'activity_id', 'user_id'];
    protected $primaryKey = 'comment_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- ---------- Insert ---------- ----------
    public function insert($content, $activityId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelComment = new TfUserActivityComment();
        $modelComment->content = $content;
        $modelComment->action = 1;
        $modelComment->activity_id = $activityId;
        $modelComment->user_id = $userId;
        $modelComment->created_at = $hFunction->createdAt();
        if ($modelComment->save()) {
            $this->lastId = $modelComment->comment_id;
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

    #---------- Update ----------
    //update content
    public function updateContent($commentId, $content)
    {
        return TfUserActivityComment::where('comment_id', $commentId)->update(['content' => $content]);
    }

    //delete
    public function actionDelete($commentId=null)
    {
        if(empty($commentId)) $commentId = $this->commentId();
        return TfUserActivityComment::where('comment_id', $commentId)->update(['action' => 0]);
    }

    //when delete post
    public function actionDeleteByActivity($activityId = null)
    {
        if (!empty($activityId)) {
            TfUserActivityComment::where(['activity_id' => $activityId, 'action' => 1])->update(['action' => 0]);
        }
    }
    #========== ========== ========== RELATION ========== ========== ==========
    #-----------  TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #----------- TF-USER-ACTIVITY -----------
    public function userActivity()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Activity\TfUserActivity', 'activity_id', 'activity_id');
    }

    //get comment of activity
    public function infoOfActivity($activityId, $take = null, $dateTake = null)
    {
        if (empty($take) && empty($dateTake)) {
            return TfUserActivityComment::where('activity_id', $activityId)->where('action', 1)->orderBy('created_at', 'DESC')->get();
        } else {
            return TfUserActivityComment::where('activity_id', $activityId)->where('action', 1)->where('created_at', '<', $dateTake)->orderBy('comment_id', 'DESC')->skip(0)->take($take)->get();
        }

    }

    //total comment of activity
    public function totalOfActivity($activityId)
    {
        return TfUserActivityComment::where('activity_id', $activityId)->where('action', 1)->count();
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($commentId = '', $field = '')
    {
        if (empty($commentId)) {
            return TfUserActivityComment::where('action', 1)->get();
        } else {
            $result = TfUserActivityComment::where('comment_id', $commentId)->first();
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
            return TfUserActivityComment::where('comment_id', $objectId)->pluck($column);
        }
    }

    public function commentId()
    {
        return $this->comment_id;
    }

    public function content($commentId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('content', $commentId));
    }

    public function activityId($commentId = null)
    {
        return $this->pluck('activity_id', $commentId);
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
        return TfUserActivityComment::where('action', 1)->count();
    }

}
