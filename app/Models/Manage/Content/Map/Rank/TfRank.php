<?php namespace App\Models\Manage\Content\Map\Rank;

use Illuminate\Database\Eloquent\Model;

class TfRank extends Model
{

    protected $table = 'tf_ranks';
    protected $fillable = ['rank_id', 'rankValue', 'pointBegin', 'pointEnd', 'type', 'created_at'];
    protected $primaryKey = 'rank_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    public function insert($rankValue, $pointBegin, $pointEnd, $type)
    {
        $hFunction = new \Hfunction();
        $modelRank = new TfRank();
        $modelRank->rankValue = $rankValue;
        $modelRank->pointBegin = $pointBegin;
        $modelRank->pointEnd = $pointEnd;
        $modelRank->type = $type;
        $modelRank->created_at = $hFunction->createdAt();
        if ($modelRank->save()) {
            $this->lastId = $modelRank->lastId;
            return true;
        } else {
            return false;
        }

    }

    #get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-PROJECT -----------
    public function project()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Map\Project\TfProject', 'App\Models\Manage\Content\Map\Project\Rank\TfProjectRank', 'rank_id', 'project_id');
    }

    #----------- TF-PROJECT-RANK -----------
    public function projectRank()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Rank\TfProjectRank', 'rank_id', 'rank_id');
    }

    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Building\TfBuilding', 'App\Models\Manage\Content\Building\Rank\TfBuildingRank', 'rank_id', 'building_id');
    }

    #----------- TF-BUILDING-RANK -----------
    public function buildingRank()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Rank\TfBuildingRank', 'rank_id', 'rank_id');
    }

    #-----------TF-RULE-PROJECT-RANK -----------
    public function ruleProjectRank()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Rule\TfRuleProjectRank', 'rank_id', 'rank_id');
    }

    #-----------TF-RULE-BANNER-RANK -----------
    public function ruleBannerRank()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Rule\TfRuleBannerRank', 'rank_id', 'rank_id');
    }

    #----------- TF-RULE-LAND-RANK -----------
    public function ruleLandRank()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Rule\TfRuleLandRank', 'rank_id', 'rank_id');
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfRank::where('rank_id', $objectId)->pluck($column);
        }
    }

    public function rankId()
    {
        return $this->rank_id;
    }

    public function rankValue($rankId = null)
    {
        return $this->pluck('rank_id', $rankId);
    }

    public function pointBegin($rankId = null)
    {
        return $this->pluck('pointBegin', $rankId);
    }

    public function pointEnd($rankId = null)
    {
        return $this->pluck('pointEnd', $rankId);
    }

    public function type($rankId = null)
    {
        return $this->pluck('type', $rankId);
    }

    public function createdAt($rankId = null)
    {
        return $this->pluck('created_at', $rankId);
    }

    #check root
    public function checkRoot($rankId)
    {
        $rank = TfRank::where('rank_id', $rankId)->where('type', 1)->count();
        return ($rank > 0) ? true : false;
    }

    #total records
    public function totalRecords()
    {
        return TfRank::count();
    }

}
