<?php namespace App\Models\Manage\Content\Building\Love;

use Illuminate\Database\Eloquent\Model;

class TfBuildingLove extends Model
{

    protected $table = 'tf_building_loves';
    protected $fillable = ['love_id', 'building_id', 'user_id', 'newInfo', 'status', 'created_at'];
    protected $primaryKey = 'love_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;
    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    //----------- ---------- Insert ----------- -----------
    public function insert($buildingId, $userId, $newInfo)
    {
        $hFunction = new \Hfunction();
        $modelBuildingLove = new TfBuildingLove();
        $modelBuildingLove->building_id = $buildingId;
        $modelBuildingLove->user_id = $userId;
        $modelBuildingLove->newInfo = $newInfo;
        $modelBuildingLove->status = 1;
        $modelBuildingLove->created_at = $hFunction->createdAt();
        if ($modelBuildingLove->save()) {
            $this->lastId = $modelBuildingLove->love_id;
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
    //----------- Update -----------
    // new info status
    public function updateNewInfo($buildingId, $userId)
    {
        return TfBuildingLove::where('building_id', $buildingId)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    // new info status
    public function updateNewInfoOfUser($userId)
    {
        return TfBuildingLove::where('newInfo', 1)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    //update status
    public function disableStatus($loveId = null)
    {
        if (empty($loveId)) $loveId = $this->loveId();
        return TfBuildingLove::where('love_id', $loveId)->update(['status' => 0]);
    }

    // update status on building and user
    public function updateStatusOfBuilding($buildingId, $userId)
    {
        return TfBuildingLove::where('building_id', $buildingId)->where('user_id', $userId)->update(['status' => 0]);
    }

    // delete
    public function actionDelete($buildingId, $userId)
    {
        return TfBuildingLove::where('building_id', $buildingId)->where('user_id', $userId)->delete();
    }

    //========== ========== ========== CHECK INFO ========= ========== ==========
    public function existLoveBuildingOfUser($buildingId = '', $userId = '')
    {
        $result = TfBuildingLove::where('building_id', $buildingId)->where('user_id', $userId)->count();
        return ($result > 0) ? true : false;
    }

    //========== ========== ========== RELATION ========= ========== ==========
    //----------- TF-USER-NOTIFY-ACTIVITY -----------
    public function userNotifyActivity()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity', 'love_id', 'buildingLove_id');
    }

    //----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    //----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //========= ========= ========= GET INFO ======= ========= =========
    public function getInfo($loveId = null, $field = null)
    {
        if (empty($loveId)) {
            return TfBuildingLove::get();
        } else {
            $result = TfBuildingLove::where('love_id', $loveId)->first();
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
            return TfBuildingLove::where('love_id', $objectId)->pluck($column);
        }
    }

    public function loveId()
    {
        return $this->love_id;
    }

    public function userId($loveId = null)
    {
        return $this->pluck('user_id', $loveId);
    }

    public function buildingId($loveId = null)
    {
        return $this->pluck('building_id', $loveId);
    }

    public function newInfo($loveId = null)
    {
        return $this->pluck('newInfo', $loveId);
    }

    public function createdAt($loveId = null)
    {
        return $this->pluck('created_at', $loveId);
    }

    // total records
    public function totalRecord()
    {
        return TfBuildingLove::count();
    }

}
