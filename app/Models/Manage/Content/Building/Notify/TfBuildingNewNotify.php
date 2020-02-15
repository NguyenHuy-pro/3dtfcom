<?php namespace App\Models\Manage\Content\Building\Notify;

use Illuminate\Database\Eloquent\Model;

class TfBuildingNewNotify extends Model
{

    protected $table = 'tf_building_new_notifies';
    protected $fillable = ['building_id', 'user_id', 'newInfo', 'status', 'created_at'];
    #protected $primaryKey = ['building_id','user_id'];
    //public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT ========= ========== ==========
    # new insert
    public function insert($buildingId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelBuildingNewNotify = new TfBuildingNewNotify();
        $modelBuildingNewNotify->building_id = $buildingId;
        $modelBuildingNewNotify->user_id = $userId;
        $modelBuildingNewNotify->created_at = $hFunction->createdAt();
        return $modelBuildingNewNotify->save();
    }

    #------------ Update -------------
    # new info status
    public function updateNewInfo($buildingId, $userId)
    {
        return TfBuildingNewNotify::where('building_id', $buildingId)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    # action status
    public function updateStatus($buildingId, $userId)
    {
        return TfBuildingNewNotify::where('building_id', $buildingId)->where('user_id', $userId)->update(['status' => 0]);
    }
    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    #----------- TF-USER -----------
    public function users()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #========== ========== ========== INFO ========= ========== ==========
    # total records
    public function totalRecords()
    {
        return TfBuildingNewNotify::count();
    }

}
