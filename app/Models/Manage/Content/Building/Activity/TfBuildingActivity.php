<?php namespace App\Models\Manage\Content\Building\Activity;

use Illuminate\Database\Eloquent\Model;

class TfBuildingActivity extends Model
{

    protected $table = 'tf_building_activities';
    protected $fillable = ['activity_id', 'highlight', 'action', 'created_at', 'building_id', 'articles_id', 'post_id'];
    protected $primaryKey = 'activity_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #---------- ---------- Insert ---------- ----------
    public function insert($buildingId, $articlesId = null, $postId = null)
    {
        $hFunction = new \Hfunction();
        $modelBuildingActivity = new TfBuildingActivity();
        $modelBuildingActivity->highlight = 0;
        $modelBuildingActivity->created_at = $hFunction->carbonNow();
        $modelBuildingActivity->articles_id = $articlesId;
        $modelBuildingActivity->building_id = $buildingId;
        $modelBuildingActivity->post_id = $postId;
        if ($modelBuildingActivity->save()) {
            $this->lastId = $modelBuildingActivity->activity_id;
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
        if (TfBuildingActivity::where('activity_id', $activityId)->update(['action' => 0])) {

        }
    }

    //per building only has a highlight post
    public function hideActivity($activityId = null)
    {
        if (empty($activityId)) $activityId = $this->postId();
        return TfBuildingActivity::where('activity_id', $activityId)->update(['action' => 0]);

    }
    #========== ========== ========== RELATION ========= ========== ==========

    #----------- TF-BUILDING-ARTICLES -----------
    public function buildingArticles()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Service\Articles\TfBuildingArticles', 'articles_id', 'articles_id');
    }

    public function deleteByBuildingArticles($articlesId)
    {
        return TfBuildingActivity::where('articles_id', $articlesId)->update(['action' => 0]);
    }

    #----------- TF-BUILDING-POST -----------
    public function buildingPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Post\TfBuildingPost', 'post_id', 'post_id');
    }

    public function deleteByBuildingPost($postId)
    {
        return TfBuildingActivity::where('post_id', $postId)->update(['action' => 0]);
    }

    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    public function deleteByBuilding($buildingId)
    {
        return TfBuildingActivity::where('building_id', $buildingId)->update(['action' => 0]);
    }

    public function infoHighLightOfBuilding($buildingId)
    {
        return TfBuildingActivity::where(['building_id' => $buildingId, 'highlight' => 1, 'action' => 1])->first();
    }

    # get activity of building
    public function infoOfBuilding($buildingId, $take = null, $dateTake = null, $highlight = 0)
    {
        if (empty($take) && empty($dateTake)) {
            return TfBuildingActivity::where(['building_id' => $buildingId, 'highlight' => $highlight, 'action' => 1])->orderBy('created_at', 'DESC')->get();
        } else {
            return TfBuildingActivity::where(['building_id' => $buildingId, 'highlight' => $highlight, 'action' => 1])->where('created_at', '<', $dateTake)->orderBy('activity_id', 'DESC')->skip(0)->take($take)->get();
        }

    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($activityId = null, $field = null)
    {
        if (empty($activityId)) {
            return TfBuildingActivity::where('action', 1)->get();
        } else {
            $result = TfBuildingActivity::where(['activity_id' => $activityId, 'action' => 1])->first();
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
            return TfBuildingActivity::where('activity_id', $objectId)->pluck($column);
        }
    }

    public function activityId()
    {
        return $this->activity_id;
    }


    # get building intro
    public function buildingId($activityId = null)
    {
        return $this->pluck('building_id', $activityId);
    }

    public function articlesId($activityId = null)
    {
        return $this->pluck('articles_id', $activityId);
    }


    public function postId($activityId = null)
    {
        return $this->pluck('post_id', $activityId);
    }

    public function createdAt($activityId = null)
    {
        return $this->pluck('created_at', $activityId);
    }

    //check activity object
    public function checkBuildingArticles($activityId = null)
    {
        return (empty($this->articlesId($activityId))) ? false : true;
    }

    public function checkBuildingPost($activityId = null)
    {
        return (empty($this->postId($activityId))) ? false : true;
    }

    //total
    public function totalRecords()
    {
        return TfBuildingActivity::count();
    }

    // total
    public function totalActivityRecords()
    {
        return TfBuildingActivity::where('action', 1)->count();
    }

    #========== ========== ========== CHECK INFO ========= ========== ==========
    public function checkActivityPost($activityId = null)
    {
        return (empty($this->postId($activityId))) ? false : true;
    }

    public function checkActivityArticles($activityId = null)
    {
        return (empty($this->articlesId($activityId))) ? false : true;
    }

}
