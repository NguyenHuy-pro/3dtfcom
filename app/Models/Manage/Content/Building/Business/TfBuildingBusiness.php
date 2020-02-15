<?php namespace App\Models\Manage\Content\Building\Business;

use Illuminate\Database\Eloquent\Model;

class TfBuildingBusiness extends Model
{

    protected $table = 'tf_building_businesses';
    protected $fillable = ['building_id', 'business_id', 'created_at'];
    #protected $primaryKey = '';
    //public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    //insert
    public function insert($buildingId, $businessId)
    {
        $hFunction = new \Hfunction();
        $modelBuildingBusiness = new TfBuildingBusiness();
        $modelBuildingBusiness->building_id = $buildingId;
        $modelBuildingBusiness->business_id = $businessId;
        $modelBuildingBusiness->created_at = $hFunction->createdAt();
        return $modelBuildingBusiness->save();
    }

    //update
    public function actionDelete($buildingId, $businessId)
    {
        return TfBuildingBusiness::where('building_id', $buildingId)->where('business_id', $businessId)->delete();
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    #----------- ---------- BUILDING ----------- -----------
    // get info of building on condition
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    // get list business id of building
    public function listBusinessOfBuilding($buildingId)
    {
        return TfBuildingBusiness::where('building_id', $buildingId)->lists('business_id');
    }

    #----------- ---------- BUSINESS ----------- -----------
    // get info of user on condition
    public function business()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Business\TfBusiness', 'business_id', 'business_id');
    }

    // total records
    public function totalRecords()
    {
        return TfBuildingBusiness::count();
    }


}
