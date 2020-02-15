<?php namespace App\Models\Manage\Content\Building\Rank;

use Illuminate\Database\Eloquent\Model;

class TfBuildingRank extends Model
{

    protected $table = 'tf_building_ranks';
    protected $fillable = ['building_id', 'rank_id', 'action', 'created_at'];
    #protected $primaryKey = ['building_id','rank_id'];
    #public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    # insert
    public function insert($buildingId, $rankId)
    {
        $hFunction = new \Hfunction();
        $modelBuildingRank = new TfBuildingRank();
        $modelBuildingRank->building_id = $buildingId;
        $modelBuildingRank->rank_id = $rankId;
        $modelBuildingRank->action = 1;
        $modelBuildingRank->created_at = $hFunction->createdAt();
        return $modelBuildingRank->save();
    }

    # update
    public function actionDelete($buildingId, $rankId)
    {
        return TfBuildingRank::where('building_id', $buildingId)->where('rank', $rankId)->update(['action' => 0]);
    }

    #when delete building
    public function actionDeleteByBuilding($buildingId = null)
    {
        if (!empty($buildingId)) {
            TfBuildingRank::where(['building_id' => $buildingId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    #----------- TF-RANK -----------
    # get info of rank on condition
    public function rank()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Rank\TfRank', 'rank_id', 'rank_id');
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    # total records
    public function totalRecords()
    {
        return TfBuildingRank::count();
    }

}
