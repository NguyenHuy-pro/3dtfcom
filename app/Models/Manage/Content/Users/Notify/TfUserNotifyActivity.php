<?php namespace App\Models\Manage\Content\Users\Notify;

use Illuminate\Database\Eloquent\Model;

class TfUserNotifyActivity extends Model
{

    protected $table = 'tf_user_notify_activities';
    protected $fillable = ['notify_id', 'newStatus', 'action', 'created_at', 'user_id', 'buildingPost_id', 'buildingShare_id', 'buildingLove_id', 'buildingComment_id', 'buildingNew_id', 'bannerShare_id', 'landShare_id'];
    protected $primaryKey = 'notify_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #---------- ---------- Insert ---------- ----------
    public function insert($userId, $buildingPostId, $buildingShareId, $buildingLoveId, $buildingCommentId, $buildingNewId, $bannerShareId, $landShareId)
    {
        $hFunction = new \Hfunction();
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        $modelUserNotifyActivity->newStatus = 1;
        $modelUserNotifyActivity->created_at = $hFunction->carbonNow();
        $modelUserNotifyActivity->user_id = $userId;
        $modelUserNotifyActivity->buildingPost_id = $buildingPostId;
        $modelUserNotifyActivity->buildingShare_id = $buildingShareId;
        $modelUserNotifyActivity->buildingLove_id = $buildingLoveId;
        $modelUserNotifyActivity->buildingComment_id = $buildingCommentId;
        $modelUserNotifyActivity->buildingNew_id = $buildingNewId;
        $modelUserNotifyActivity->bannerShare_id = $bannerShareId;
        $modelUserNotifyActivity->landShare_id = $landShareId;
        if ($modelUserNotifyActivity->save()) {
            $this->lastId = $modelUserNotifyActivity->notify_id;
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
    public function actionDelete($notifyId = null)
    {
        if (empty($notifyId)) $notifyId = $this->postId();
        if (TfUserNotifyActivity::where('notify_id', $notifyId)->update(['action' => 0])) {

        }
    }

    #----------- TF-BUILDING-LOVE -----------
    public function buildingLove()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Love\TfBuildingLove', 'buildingLove_id', 'love_id');
    }

    #----------- TF-BUILDING-POST -----------
    public function buildingPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Post\TfBuildingPost', 'buildingPost_id', 'post_id');
    }

    public function deleteByBuildingPost($postId)
    {
        return TfUserNotifyActivity::where('buildingPost_id', $postId)->update(['action' => 0]);
    }

    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'buildingNew_id', 'building_id');
    }

    public function deleteByBuilding($buildingId)
    {
        return TfUserNotifyActivity::where('buildingNew_id', $buildingId)->update(['action' => 0]);
    }

    #----------- TF-BUILDING-SHARE -----------
    public function buildingShare()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Share\TfBuildingShare', 'buildingShare_id', 'share_id');
    }

    public function deleteByBuildingShare($shareId)
    {
        return TfUserNotifyActivity::where('buildingShare_id', $shareId)->update(['action' => 0]);
    }

    #----------- TF-BUILDING-COMMENT -----------
    public function buildingComment()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Comment\TfBuildingComment', 'buildingComment_id', 'comment_id');
    }

    public function deleteByBuildingComment($commentId)
    {
        return TfUserNotifyActivity::where('buildingComment_id', $commentId)->update(['action' => 0]);
    }

    #----------- TF-BANNER-SHARE -----------
    public function bannerShare()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\Share\TfBannerShare', 'bannerShare_id', 'share_id');
    }

    public function deleteByBannerShare($shareId)
    {
        return TfUserNotifyActivity::where('bannerShare_id', $shareId)->update(['action' => 0]);
    }

    #----------- TF-LAND-SHARE -----------
    public function landShare()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\Share\TfLandShare', 'landShare_id', 'share_id');
    }

    public function deleteByLandShare($shareId)
    {
        return TfUserNotifyActivity::where('landShare_id', $shareId)->update(['action' => 0]);
    }


    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }


    // get activity of user
    public function infoOfUser($userId, $take = null, $dateTake = null)
    {
        if (empty($take) && empty($dateTake)) {
            return TfUserNotifyActivity::where(['user_id' => $userId, 'action' => 1])->orderBy('created_at', 'DESC')->get();
        } else {
            return TfUserNotifyActivity::where(['user_id' => $userId, 'action' => 1])->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
        }

    }

    public function totalNewNotifyOfUser($userId)
    {
        return TfUserNotifyActivity::where(['user_id' => $userId, 'newStatus' => 1, 'action' => 1])->count();
    }

    public function turnOffNewStatusOfUser($userId)
    {
        return TfUserNotifyActivity::where(['user_id' => $userId, 'newStatus' => 1])->update(['newStatus' => 0]);
    }

    public function deleteByUser($userId)
    {
        return TfUserNotifyActivity::where('user_id', $userId)->update(['action' => 0]);
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($notifyId = null, $field = null)
    {
        if (empty($notifyId)) {
            return TfUserNotifyActivity::where('action', 1)->get();
        } else {
            $result = TfUserNotifyActivity::where(['notify_id' => $notifyId, 'action' => 1])->first();
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
            return TfUserNotifyActivity::where('notify_id', $objectId)->pluck($column);
        }
    }

    public function notifyId()
    {
        return $this->notify_id;
    }

    public function newStatus($notifyId = null)
    {
        return $this->pluck('newStatus', $notifyId);
    }

    public function buildingPostId($notifyId = null)
    {
        return $this->pluck('buildingPost_id', $notifyId);
    }

    public function buildingShareId($notifyId = null)
    {
        return $this->pluck('buildingShare_id', $notifyId);
    }

    public function buildingCommentId($notifyId = null)
    {
        return $this->pluck('buildingComment_id', $notifyId);
    }

    public function buildingNewId($notifyId = null)
    {
        return $this->pluck('buildingNew_id', $notifyId);
    }

    public function buildingLoveId($notifyId = null)
    {
        return $this->pluck('buildingLove_id', $notifyId);
    }

    public function bannerShareId($notifyId = null)
    {
        return $this->pluck('bannerShare_id', $notifyId);
    }

    public function landShareId($notifyId = null)
    {
        return $this->pluck('landShare_id', $notifyId);
    }

    public function userId($notifyId = null)
    {
        return $this->pluck('user_id', $notifyId);
    }


    public function createdAt($notifyId = null)
    {
        return $this->pluck('created_at', $notifyId);
    }

    //=================== check object type ======================
    public function checkBuildingNew($notifyId = null)
    {
        return (empty($this->buildingNewId($notifyId))) ? false : true;
    }

    public function checkBuildingPost($notifyId = null)
    {
        return (empty($this->buildingPostId($notifyId))) ? false : true;
    }

    public function checkBuildingComment($notifyId = null)
    {
        return (empty($this->buildingCommentId($notifyId))) ? false : true;
    }

    public function checkBuildingLove($notifyId = null)
    {
        return (empty($this->buildingLoveId($notifyId))) ? false : true;
    }

    public function checkBuildingShare($notifyId = null)
    {
        return (empty($this->buildingShareId($notifyId))) ? false : true;
    }

    public function checkBannerShare($notifyId = null)
    {
        return (empty($this->bannerShareId($notifyId))) ? false : true;
    }

    public function checkLandShare($notifyId = null)
    {
        return (empty($this->landShareId($notifyId))) ? false : true;
    }

    //total
    public function totalRecords()
    {
        return TfUserNotifyActivity::count();
    }

    # total
    public function totalActivityRecords()
    {
        return TfUserNotifyActivity::where('action', 1)->count();
    }

}
