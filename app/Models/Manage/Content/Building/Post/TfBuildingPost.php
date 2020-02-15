<?php namespace App\Models\Manage\Content\Building\Post;

use App\Models\Manage\Content\Building\Activity\TfBuildingActivity;
use App\Models\Manage\Content\Building\PostComment\TfBuildingPostComment;
use App\Models\Manage\Content\Building\PostImage\TfBuildingPostImage;
use App\Models\Manage\Content\Building\PostInfoNotify\TfBuildingPostInfoNotify;
use App\Models\Manage\Content\Building\PostInfoReport\TfBuildingPostInfoReport;
use App\Models\Manage\Content\Building\PostLove\TfBuildingPostLove;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class TfBuildingPost extends Model
{

    protected $table = 'tf_building_posts';
    protected $fillable = ['post_id', 'postCode', 'content', 'image', 'newInfo', 'highlight', 'action', 'created_at', 'building_id', 'viewRelation_id', 'buildingIntro_id', 'user_id'];
    protected $primaryKey = 'post_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #---------- ---------- Insert ---------- ----------
    public function insert($content = null, $image = null, $buildingId, $viewRelationId = '', $buildingIntroId = '', $userId)
    {
        $hFunction = new \Hfunction();
        $modelBuildingPost = new TfBuildingPost();
        $modelBuildingPost->postCode = $userId . $hFunction->getTimeCode();
        $modelBuildingPost->content = $content;
        $modelBuildingPost->image = $image;
        $modelBuildingPost->newInfo = 1;
        $modelBuildingPost->building_id = $buildingId;
        $modelBuildingPost->viewRelation_id = $viewRelationId;
        $modelBuildingPost->buildingIntro_id = $buildingIntroId;
        $modelBuildingPost->user_id = $userId;
        $modelBuildingPost->created_at = $hFunction->createdAt();
        if ($modelBuildingPost->save()) {
            $this->lastId = $modelBuildingPost->post_id;
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
        $pathSmallImage = "public/images/building/posts/small";
        $pathFullImage = "public/images/building/posts/full";
        if (!is_dir($pathFullImage)) mkdir($pathFullImage);
        if (!is_dir($pathSmallImage)) mkdir($pathSmallImage);
        return $hFunction->uploadSave($file, $pathSmallImage . '/', $pathFullImage . '/', $imageName, 500);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/building/posts/small/' . $imageName);
        File::delete('public/images/building/posts/full/' . $imageName);
    }

    #---------- ---------- Update info ---------- ----------
    public function updateInfo($postId, $content = null, $image = null, $buildingIntroId = null, $viewRelationId = null)
    {
        TfBuildingPost::where(['post_id' => $postId])->update(
            [
                'content' => $content,
                'image' => $image,
                'viewRelation_id' => $viewRelationId,
                'buildingIntro_id' => $buildingIntroId
            ]);
    }

    //delete
    public function actionDelete($postId = null)
    {
        $modelBuildingPostComment = new TfBuildingPostComment();
        $modelBuildingPostInfoNotify = new TfBuildingPostInfoNotify();
        $modelBuildingPostInfoReport = new TfBuildingPostInfoReport();
        $modelBuildingActivity = new TfBuildingActivity();
        $modelUserNotifyActivity = new TfUserNotifyActivity();

        if (empty($postId)) $postId = $this->postId();
        if (TfBuildingPost::where('post_id', $postId)->update(['action' => 0])) {
            //delete notify
            $modelBuildingPostInfoNotify->actionDeleteByPost($postId);

            $modelBuildingPostInfoReport->actionDeleteByPost($postId);

            //delete comment
            $modelBuildingPostComment->actionDeleteByPost($postId);

            //activity of building
            $modelBuildingActivity->deleteByBuildingPost($postId);

            //delete notify for user
            $modelUserNotifyActivity->deleteByBuildingPost($postId);
        }
    }

    //when delete building
    public function actionDeleteByBuilding($buildingId = null)
    {
        if (!empty($buildingId)) {
            $listId = TfBuildingPost::where(['building_id' => $buildingId, 'action' => 1])->lists('post_id');
            if (!empty($listId)) {
                foreach ($listId as $value) {
                    $this->actionDelete($value);
                }
            }
        }
    }

    //update highlight post
    //per building only has a highlight post
    public function updateHighlight($highlightStatus = 1, $postId = null)
    {
        if (empty($postId)) $postId = $this->postId();
        //turn off old highlight status of building
        $buildingId = $this->buildingId($postId);
        TfBuildingPost::where(['building_id' => $buildingId, 'highlight' => 1])->update(['highlight' => 0]);
        //turn on new highlight
        TfBuildingPost::where(['post_id' => $postId])->update(['highlight' => $highlightStatus]);

    }
    #========== ========== ========== RELATION ========= ========== ==========
    //----------- TF-USER-NOTIFY-ACTIVITY -----------
    public function userNotifyActivity()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity', 'post_id', 'buildingPost_id');
    }

    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    #----------- TF-BUILDING-POST-NEW-NOTIFY -----------
    public function buildingPostNewNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\PostNewNotify\TfBuildingPostNewNotify', 'post_id', 'post_id');
    }

    #----------- TF-BUILDING-POST-LOVE -----------
    public function buildingPostLove()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Post\TfBuildingPostLove', 'post_id', 'post_id');
    }

    #----------- TF-BUILDING-POST-IMAGE -----------
    public function buildingPostImage()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\PostImage\TfBuildingPostImage', 'post_id', 'post_id');
    }

    public function imageActivityInfo($postId = null)
    {
        $modelBuildingPostImage = new TfBuildingPostImage();
        $postId = (empty($postId)) ? $this->postId() : $postId;
        return $modelBuildingPostImage->infoOfBuildingPost($postId);
    }

    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #----------- TF-BUILDING-POST-COMMENT -----------
    public function buildingPostComment()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\PostComment\TfBuildingPostComment', 'post_id', 'post_id');
    }

    #----------- TF-BUILDING-POST-INFO-NOTIFY -----------
    public function buildingPostInfoNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\PostInfoNotify\TfBuildingPostInfoNotify', 'post_id', 'post_id');
    }

    #----------- TF-BUILDING-POST-INFO-REPORT -----------
    public function buildingPostInfoReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\PostInfoReport\TfBuildingPostInfoReport', 'post_id', 'post_id');
    }

    #----------- TF-BUILDING-ACTIVITY -----------
    public function buildingActivity()
    {
        return $this->hasOne('App\Models\Manage\Content\Building\Activity\TfBuildingActivity', 'post_id', 'post_id');
    }


    //----------- TF-RELATION -----------
    public function relation()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Relation\TfRelation', 'relation_id', 'viewRelation_id');
    }

    //----------- TF-BAD-INFO -----------
    public function badInfo()
    {
        return $this->belongsToMany('App\Models\Manage\Content\System\BadInfo\TfBadInfo', 'App\Models\Manage\Content\Building\PostInfoNotify\TfBuildingPostInfoNotify', 'post_id', 'badInfo_id');
    }

    //========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($postId = null, $field = null)
    {
        if (empty($postId)) {
            return TfBuildingPost::where('action', 1)->get();
        } else {
            $result = TfBuildingPost::where(['post_id' => $postId, 'action' => 1])->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function infoOfPostCode($postCode = '')
    {
        return TfBuildingPost::where(['postCode' => $postCode, 'action' => 1])->first();
    }

    //----------- TF-BUILDING -----------
    public function infoHighLightOfBuilding($buildingId)
    {
        return TfBuildingPost::where(['building_id' => $buildingId, 'highlight' => 1, 'action' => 1])->first();
    }

    // get posts of building with user login
    public function infoOfBuilding($buildingId, $take = null, $dateTake = null, $highlight = 0)
    {
        if (empty($take) && empty($dateTake)) {
            return TfBuildingPost::where(['building_id' => $buildingId, 'highlight' => $highlight, 'action' => 1])->orderBy('post_id', 'DESC')->get();
        } else {
            return TfBuildingPost::where(['building_id' => $buildingId, 'highlight' => $highlight, 'action' => 1])->where('created_at', '<', $dateTake)->orderBy('post_id', 'DESC')->skip(0)->take($take)->get();
        }

    }

    #----------- TF-BUILDING-POST-LOVE -----------
    //total love of posts
    public function totalLove($postId = null)
    {
        $modelLove = new TfBuildingPostLove();
        if (empty($postId)) $postId = $this->postId();
        return $modelLove->totalOfPosts($postId);
    }

    #----------- TF-BUILDING-POST-COMMENT -----------
    //total love of posts
    public function totalComment($postId = null)
    {
        $modelComment = new TfBuildingPostComment();
        if (empty($postId)) $postId = $this->postId();
        return $modelComment->totalOfPosts($postId);
    }

    // get comment of post
    public function commentInfoOfPost($postId, $take = null, $dateTake = null)
    {
        $modelPostsComment = new TfBuildingPostComment();
        return $modelPostsComment->infoOfPost($postId, $take, $dateTake);
    }


    //----------- POST INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuildingPost::where('post_id', $objectId)->pluck($column);
        }
    }

    public function postId()
    {
        return $this->post_id;
    }

    public function buildingIntroId($postId = null)
    {
        return $this->pluck('buildingIntro_id', $postId);
    }

    // get building intro
    public function buildingId($postId = null)
    {
        return $this->pluck('building_id', $postId);
    }

    public function userId($postId = null)
    {
        return $this->pluck('user_id', $postId);
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
        /*$hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('content', $postId));*/
    }

    public function newInfo($postId = null)
    {
        return $this->pluck('newInfo', $postId);
    }

    public function highlight($postId = null)
    {
        return $this->pluck('highlight', $postId);
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
        return TfBuildingPost::count();
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
        return asset("public/images/building/posts/small/$image");
    }

    public function pathFullImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset("public/images/building/posts/full/$image");
    }

}
