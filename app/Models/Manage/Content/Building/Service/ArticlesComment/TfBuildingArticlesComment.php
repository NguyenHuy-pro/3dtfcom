<?php namespace App\Models\Manage\Content\Building\Service\ArticlesComment;

use Illuminate\Database\Eloquent\Model;

class TfBuildingArticlesComment extends Model
{

    protected $table = 'tf_building_articles_comments';
    protected $fillable = ['comment_id', 'content', 'action', 'created_at', 'articles_id', 'user_id'];
    protected $primaryKey = 'comment_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- ---------- Insert ---------- ----------
    public function insert($content, $articlesIs, $userId)
    {
        $hFunction = new \Hfunction();
        $modelComment = new TfBuildingArticlesComment();
        $modelComment->content = $content;
        $modelComment->action = 1;
        $modelComment->articles_id = $articlesIs;
        $modelComment->user_id = $userId;
        $modelComment->created_at = $hFunction->createdAt();
        if ($modelComment->save()) {
            $this->lastId = $modelComment->comment_id;
            return true;
        } else {
            return false;
        }
    }

    # get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- Update ----------
    # update content
    public function updateContent($commentId, $content)
    {
        return TfBuildingArticlesComment::where('comment_id', $commentId)->update(['content' => $content]);
    }

    #delete
    public function actionDelete($commentId = null)
    {
        if (empty($commentId)) $commentId = $this->commentId();
        return TfBuildingArticlesComment::where('comment_id', $commentId)->update(['action' => 0]);
    }

    #when delete post
    public function actionDeleteByArticles($articlesId = null)
    {
        if (!empty($articlesId)) {
            TfBuildingArticlesComment::where(['articles_id' => $articlesId, 'action' => 1])->update(['action' => 0]);
        }
    }
    #========== ========== ========== RELATION ========== ========== ==========
    #-----------  TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    public function checkCommentOfUser($userId, $commentId = null)
    {
        return ($userId == $this->userId($commentId)) ? true : false;
    }

    #----------- TF-BUILDING-ARTICLES -----------
    public function buildingArticles()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Service\Articles\TfBuildingArticles', 'articles_id', 'articles_id');
    }

    # total comment of articles
    public function totalOfArticles($articlesId)
    {
        return TfBuildingArticlesComment::where('articles_id', $articlesId)->where('action', 1)->count();
    }

    # get comment of articles
    public function activityInfoOfArticles($articlesId, $take = null, $dateTake = null)
    {
        if (empty($take) && empty($dateTake)) {
            return TfBuildingArticlesComment::where('articles_id', $articlesId)->where('action', 1)->orderBy('created_at', 'DESC')->get();
        } else {
            return TfBuildingArticlesComment::where('articles_id', $articlesId)->where('action', 1)->where('created_at', '<', $dateTake)->orderBy('comment_id', 'DESC')->skip(0)->take($take)->get();
        }

    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($commentId = '', $field = '')
    {
        if (empty($commentId)) {
            return TfBuildingArticlesComment::where('action', 1)->get();
        } else {
            $result = TfBuildingArticlesComment::where('comment_id', $commentId)->first();
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
            return TfBuildingArticlesComment::where('comment_id', $objectId)->pluck($column);
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

    public function articlesId($commentId = null)
    {
        return $this->pluck('articles_id', $commentId);
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
        return TfBuildingArticlesComment::where('action', 1)->count();
    }

}
