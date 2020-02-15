<?php namespace App\Models\Manage\Content\Building\Follow;

use Illuminate\Database\Eloquent\Model;

class TfBuildingFollow extends Model
{

    protected $table = 'tf_building_follows';
    protected $fillable = ['building_id', 'user_id', 'newInfo', 'status', 'created_at'];
    #protected $primaryKey = ['building_id','user_id'];
    #public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #----------- ---------- Insert ----------- -----------
    public function insert($buildingId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelBuildingFollow = new TfBuildingFollow();
        $modelBuildingFollow->building_id = $buildingId;
        $modelBuildingFollow->user_id = $userId;
        $modelBuildingFollow->newInfo = 1;
        $modelBuildingFollow->created_at = $hFunction->createdAt();
        return $modelBuildingFollow->save();
    }

    #----------- ---------- Update ----------- -----------
    # new info status
    public function updateNewInfo($buildingId, $userId)
    {
        return TfBuildingFollow::where('building_id', $buildingId)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    # action status
    public function updateAction($buildingId, $userId)
    {
        return TfBuildingFollow::where('building_id', $buildingId)->where('user_id', $userId)->update(['action' => 0]);
    }

    # delete
    public function actionDelete($buildingId, $userId)
    {
        return TfBuildingFollow::where('building_id', $buildingId)->where('user_id', $userId)->delete();
    }

    #========== ========== ========== CHECK INFO ========= ========== ==========
    public function existFollowBuildingOfUser($buildingId = '', $userId = '')
    {
        $result = TfBuildingFollow::where('building_id', $buildingId)->where('user_id', $userId)->count();
        return ($result > 0) ? true : false;
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-USER -----------
    //relation
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //get list user of building
    public function listUserOfBuilding($buildingId)
    {
        return TfBuildingFollow::where(['building_id' => $buildingId]) -> lists('user_id');
    }

    #----------- TF-BUILDING -----------
    //get info of building on condition
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    #========== ========== ========== GET INFO ========= ========== ==========

    //list building id of user
    public function buildingFollowOfUser($userId, $take = '', $dateTake = '')
    {
        if (empty($take) && empty($dateTake)) {
            return TfBuildingFollow::where('user_id', $userId)->where('status', 1)->get();
        } else {
            return TfBuildingFollow::where('user_id', $userId)->where('status', 1)->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
        }
    }


    public function buildingId()
    {
        return $this->building_id;
    }

    public function userId()
    {
        return $this->user_id;
    }

    public function newInfo()
    {
        return $this->newInfo;
    }

    public function status()
    {
        return $this->status;
    }

    public function createdAt()
    {
        return $this->created_at;
    }

    # total records
    public function totalRecords()
    {
        return TfBuildingFollow::count();
    }

}
