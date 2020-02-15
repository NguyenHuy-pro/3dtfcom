<?php namespace App\Models\Manage\Content\Users\Activity;

use App\Models\Manage\Content\Users\Activity\Comment\TfUserActivityComment;
use App\Models\Manage\Content\Users\Activity\Love\TfUserActivityLove;
use Illuminate\Database\Eloquent\Model;

class TfUserActivity extends Model
{

    protected $table = 'tf_user_activities';
    protected $fillable = ['activity_id', 'showStatus', 'action', 'created_at', 'bannerImage_id', 'building_id', 'buildingBanner_id', 'user_id', 'userPost_id'];
    protected $primaryKey = 'activity_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #---------- ---------- Insert ---------- ----------
    //develop : bannerImage_id, building_id, buildingBanner_id, userPost_id
    public function insert($bannerImageId, $buildingId, $buildingBannerId, $userId, $postId = null)
    {
        $hFunction = new \Hfunction();
        $modelUserActivity = new TfUserActivity();
        $modelUserActivity->showStatus = 1;
        $modelUserActivity->created_at = $hFunction->carbonNow();
        $modelUserActivity->bannerImage_id = $bannerImageId;
        $modelUserActivity->building_id = $buildingId;
        $modelUserActivity->buildingBanner_id = $buildingBannerId;
        $modelUserActivity->userPost_id = $postId;
        $modelUserActivity->user_id = $userId;
        if ($modelUserActivity->save()) {
            $this->lastId = $modelUserActivity->activity_id;
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

    #---------- ---------- Update info ---------- ----------
    //delete
    public function actionDelete($activityId = null)
    {
        if (empty($activityId)) $activityId = $this->postId();
        if (TfUserActivity::where('activity_id', $activityId)->update(['action' => 0])) {

        }
    }

    //per building only has a highlight post
    public function hideActivity($activityId = null)
    {
        if (empty($activityId)) $activityId = $this->postId();
        return TfUserActivity::where('activity_id', $activityId)->update(['action' => 0]);

    }
    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-USER-ACTIVITY-LOVE -----------
    public function userActivityLove()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Activity\Love\TfUserActivityLove', 'activity_id', 'activity_id');
    }

    public function totalLove($activityId=null)
    {
        $modelUserActivityLove = new TfUserActivityLove();
        return $modelUserActivityLove->totalOfActivity((empty($activityId)?$this->activityId():$activityId));
    }

    #----------- TF-USER-ACTIVITY-COMMENT -----------
    public function userActivityComment()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Activity\Comment\TfUserActivityComment', 'activity_id', 'activity_id');
    }

    public function commentInfoOfActivity($activityId, $take, $dateTake)
    {
        $modelUserActivityComment = new TfUserActivityComment();
        return $modelUserActivityComment->infoOfActivity($activityId, $take, $dateTake);
    }

    public function totalComment($activityId=null)
    {
        $modelUserActivityComment = new TfUserActivityComment();
        return $modelUserActivityComment->totalOfActivity((empty($activityId)?$this->activityId():$activityId));
    }

    #----------- TF-USER-POST -----------
    public function userPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Post\TfUserPost', 'userPost_id', 'post_id');
    }

    public function deleteByPost($postId)
    {
        return TfUserActivity::where('userPost_id', $postId)->update(['action' => 0]);
    }

    #----------- TF-BANNER-IMAGE -----------
    public function bannerImage()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\Image\TfBannerImage', 'bannerImage_id', 'image_id');
    }

    public function deleteByBannerImage($imageId)
    {
        return TfUserActivity::where('bannerImage_id', $imageId)->update(['action' => 0]);
    }

    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    public function deleteByBuilding($buildingId)
    {
        return TfUserActivity::where('building_id', $buildingId)->update(['action' => 0]);
    }

    #----------- TF-BUILDING-BANNER -----------
    public function buildingBanner()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Banner\TfBuildingBanner', 'buildingBanner_id', 'banner_id');
    }

    public function deleteByBuildingBanner($bannerId)
    {
        return TfUserActivity::where('buildingBanner_id', $bannerId)->update(['action' => 0]);
    }

    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }


    # get activity of user
    public function infoOfUser($userId, $take = null, $dateTake = null)
    {
        if (empty($take) && empty($dateTake)) {
            return TfUserActivity::where(['user_id' => $userId, 'showStatus' => 1, 'action' => 1])->orderBy('created_at', 'DESC')->get();
        } else {
            return TfUserActivity::where(['user_id' => $userId, 'showStatus' => 1, 'action' => 1])->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
        }

    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($activityId = null, $field = null)
    {
        if (empty($activityId)) {
            return TfUserActivity::where('action', 1)->get();
        } else {
            $result = TfUserActivity::where(['activity_id' => $activityId, 'action' => 1])->first();
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
            return TfUserActivity::where('activity_id', $objectId)->pluck($column);
        }
    }

    public function activityId()
    {
        return $this->activity_id;
    }

    public function showStatus($activityId = null)
    {
        return $this->pluck('showStatus', $activityId);
    }

    public function bannerImageId($activityId = null)
    {
        return $this->pluck('bannerImage_id', $activityId);
    }

    # get building intro
    public function buildingId($activityId = null)
    {
        return $this->pluck('building_id', $activityId);
    }

    public function buildingBannerId($activityId = null)
    {
        return $this->pluck('buildingBanner_id', $activityId);
    }


    public function userPostId($activityId = null)
    {
        return $this->pluck('userPost_id', $activityId);
    }


    public function userId($activityId = null)
    {
        return $this->pluck('user_id', $activityId);
    }


    public function createdAt($activityId = null)
    {
        return $this->pluck('created_at', $activityId);
    }

    //check activity object
    public function checkNewBuilding($activityId = null)
    {
        return (empty($this->buildingId($activityId))) ? false : true;
    }

    public function checkBannerImage($activityId = null)
    {
        return (empty($this->bannerImageId($activityId))) ? false : true;
    }

    public function checkBuildingBanner($activityId = null)
    {
        return (empty($this->buildingBannerId($activityId))) ? false : true;
    }

    public function checkUserPost($activityId = null)
    {
        return (empty($this->userPostId($activityId))) ? false : true;
    }

    //total
    public function totalRecords()
    {
        return TfUserActivity::count();
    }

    // total
    public function totalActivityRecords()
    {
        return TfUserActivity::where('action', 1)->count();
    }


}
