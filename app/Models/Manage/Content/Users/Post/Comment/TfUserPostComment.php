<?php namespace App\Models\Manage\Content\Users\Post\Comment;

use Illuminate\Database\Eloquent\Model;

class TfUserPostComment extends Model {

    protected $table = 'tf_user_post_comments';
    protected $fillable = ['comment_id', 'content', 'action', 'created_at', 'post_id', 'user_id'];
    protected $primaryKey = 'comment_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- ---------- Insert ---------- ----------
    public function insert($content, $postsId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelComment = new TfUserPostComment();
        $modelComment->content = $content;
        $modelComment->action = 1;
        $modelComment->post_id = $postsId;
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
        return TfUserPostComment::where('comment_id', $commentId)->update(['content' => $content]);
    }

    //delete
    public function actionDelete($commentId=null)
    {
        if(empty($commentId)) $commentId = $this->commentId();
        return TfUserPostComment::where('comment_id', $commentId)->update(['action' => 0]);
    }

    //when delete post
    public function actionDeleteByPost($postId = null)
    {
        if (!empty($postId)) {
            TfUserPostComment::where(['post_id' => $postId, 'action' => 1])->update(['action' => 0]);
        }
    }
    #========== ========== ========== RELATION ========== ========== ==========
    #-----------  TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #----------- TF-USER-POST -----------
    public function userPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Post\TfUserPost', 'post_id', 'post_id');
    }


    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($commentId = '', $field = '')
    {
        if (empty($commentId)) {
            return TfUserPostComment::where('action', 1)->get();
        } else {
            $result = TfUserPostComment::where('comment_id', $commentId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    //total comment of posts
    public function totalOfPosts($postId)
    {
        return TfUserPostComment::where('post_id', $postId)->where('action', 1)->count();
    }

    //get comment of posts
    public function infoOfPost($postId, $take = null, $dateTake = null)
    {
        if (empty($take) && empty($dateTake)) {
            return TfUserPostComment::where('post_id', $postId)->where('action', 1)->orderBy('created_at', 'DESC')->get();
        } else {
            return TfUserPostComment::where('post_id', $postId)->where('action', 1)->where('created_at', '<', $dateTake)->orderBy('comment_id', 'DESC')->skip(0)->take($take)->get();
        }

    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserPostComment::where('comment_id', $objectId)->pluck($column);
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

    public function postId($commentId = null)
    {
        return $this->pluck('post_id', $commentId);
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
        return TfUserPostComment::where('action', 1)->count();
    }

}
