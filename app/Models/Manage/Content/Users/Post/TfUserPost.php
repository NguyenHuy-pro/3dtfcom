<?php namespace App\Models\Manage\Content\Users\Post;

use App\Models\Manage\Content\Users\Activity\TfUserActivity;
use App\Models\Manage\Content\Users\Post\Comment\TfUserPostComment;
use App\Models\Manage\Content\Users\PostLove\TfUserPostLove;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class TfUserPost extends Model
{

    protected $table = 'tf_user_posts';
    protected $fillable = ['post_id', 'postCode', 'content', 'image', 'newInfo', 'action', 'created_at', 'viewRelation_id', 'userWall_id', 'userPost_id'];
    protected $primaryKey = 'post_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #---------- ---------- Insert ---------- ----------
    public function insert($content = null, $image = null, $viewRelationId, $userWallId, $userPostId)
    {
        $hFunction = new \Hfunction();
        $modelUserPost = new TfUserPost();
        $modelUserPost->postCode = $userPostId . $hFunction->getTimeCode();
        $modelUserPost->content = $content;
        $modelUserPost->image = $image;
        $modelUserPost->newInfo = 1;
        $modelUserPost->viewRelation_id = $viewRelationId;
        $modelUserPost->userWall_id = $userWallId;
        $modelUserPost->userPost_id = $userPostId;
        $modelUserPost->created_at = $hFunction->createdAt();
        if ($modelUserPost->save()) {
            $this->lastId = $modelUserPost->post_id;
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

    //upload image
    public function uploadImage($file, $imageName)
    {
        $hFunction = new \Hfunction();
        $pathSmallImage = "public/images/user/post/small";
        $pathFullImage = "public/images/user/post/full";
        if (!is_dir($pathFullImage)) mkdir($pathFullImage);
        if (!is_dir($pathSmallImage)) mkdir($pathSmallImage);
        return $hFunction->uploadSave($file, $pathSmallImage . '/', $pathFullImage . '/', $imageName, 500);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/user/post/small/' . $imageName);
        File::delete('public/images/user/post/full/' . $imageName);
    }

    #---------- ---------- Update info ---------- ----------
    public function updateInfo($postId, $content = null, $image = null, $viewRelationId = null)
    {
        TfUserPost::where(['post_id' => $postId])->update(
            [
                'content' => $content,
                'image' => $image,
                'viewRelation_id' => $viewRelationId
            ]);
    }

    //delete
    public function actionDelete($postId = null)
    {
        $modelUserActivity = new TfUserActivity();
        if (empty($postId)) $postId = $this->postId();
        if (TfUserPost::where('post_id', $postId)->update(['action' => 0])) {
            //delete notify
            $modelUserActivity->deleteByPost($postId);
        }
    }

    //when delete building
    public function actionDeleteByUser($userId = null)
    {
        if (!empty($userId)) {
            $listId = TfUserPost::where('userWall_id', $userId)->orwhere('userPost_id', $userId)->where('action', 1)->lists('post_id');
            if (!empty($listId)) {
                foreach ($listId as $value) {
                    $this->actionDelete($value);
                }
            }
        }
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-USER -----------
    public function userWall()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'userWall_id', 'user_id');
    }

    public function userPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'userPost_id', 'user_id');
    }

    //----------- TF-USER-POST-COMMENT -----------
    public function userPostComment()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Post\Comment\TfUserPostComment', 'post_id', 'post_id');
    }

    public function totalComment($postId = null)
    {
        $modelUserPostComment = new TfUserPostComment();
        return $modelUserPostComment->totalOfPosts((empty($postId)) ? $this->postId() : $postId);
    }

    public function commentInfoOfPost($postId, $take, $dateTake)
    {
        $modelUserPostComment = new TfUserPostComment();
        return $modelUserPostComment->infoOfPost($postId, $take, $dateTake);
    }

    //----------- TF-USER-POST-LOVE -----------
    public function userPostLove()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\PostLove\TfUserPostLove', 'user_id', 'user_id');
    }

    public function totalLove($postId = null)
    {
        $modelUserPost = new TfUserPostLove();
        return $modelUserPost->totalOfPost((empty($postId)) ? $this->postId() : $postId);
    }

    //----------- TF-RELATION -----------
    public function relation()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Relation\TfRelation', 'relation_id', 'viewRelation_id');
    }

    //----------- TF-USER-ACTIVITY -----------
    public function userActivity()
    {
        return $this->hasOne('App\Models\Manage\Content\Users\Activity\TfUserActivity', 'post_id', 'userPost_id');
    }

    //========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($postId = null, $field = null)
    {
        if (empty($postId)) {
            return TfUserPost::where('action', 1)->get();
        } else {
            $result = TfUserPost::where(['post_id' => $postId, 'action' => 1])->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function infoOfPostCode($postCode = '')
    {
        return TfUserPost::where(['postCode' => $postCode, 'action' => 1])->first();
    }

    //----------- POST INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserPost::where('post_id', $objectId)->pluck($column);
        }
    }

    public function postId()
    {
        return $this->post_id;
    }

    public function userWallId($postId = null)
    {
        return $this->pluck('userWall_id', $postId);
    }

    // get building intro
    public function userPostId($postId = null)
    {
        return $this->pluck('userPost_id', $postId);
    }

    public function postCode($postId = null)
    {
        return $this->pluck('postCode', $postId);
    }

    public function image($postId = null)
    {
        return $this->pluck('image', $postId);
    }

    public function content($postId = null)
    {
        return $this->pluck('content', $postId);
    }

    public function newInfo($postId = null)
    {
        return $this->pluck('newInfo', $postId);
    }

    public function viewRelationId($postId = null)
    {
        return $this->pluck('viewRelation_id', $postId);
    }

    public function createdAt($postId = null)
    {
        return $this->pluck('created_at', $postId);
    }

    // total
    public function totalRecords()
    {
        return TfUserPost::count();
    }

    // get last Id
    public function lastId()
    {
        //return TfBuildingPost::orderBy('post_id', 'DESC')->pluck('post_id');
    }

    //get path image
    public function pathSmallImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset("public/images/user/post/small/$image");
    }

    public function pathFullImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset("public/images/user/post/full/$image");
    }

}
