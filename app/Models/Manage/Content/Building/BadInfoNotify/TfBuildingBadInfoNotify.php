<?php namespace App\Models\Manage\Content\Building\BadInfoNotify;

use Illuminate\Database\Eloquent\Model;

class TfBuildingBadInfoNotify extends Model
{

    protected $table = 'tf_building_bad_info_notifies';
    protected $fillable = ['notify_id', 'content', 'newInfo', 'action', 'created_at', 'building_id', 'badInfo_id'];
    protected $primaryKey = 'notify_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    public function insert($content = '', $buildingId, $badInoId)
    {
        $hFunction = new \Hfunction();
        $modelNotify = new TfBuildingBadInfoNotify();
        $modelNotify->content = $content;
        $modelNotify->newInfo = 1;
        $modelNotify->action = 1;
        $modelNotify->created_at = $hFunction->createdAt();
        $modelNotify->building_id = $buildingId;
        $modelNotify->badInfo_id = $badInoId;
        if ($modelNotify->save()) {
            $this->lastId = $modelNotify->notify_id;
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
    #------------ Update ------------
    # new info status
    public function updateNewInfo($notifyId = null)
    {
        if (empty($notifyId)) $notifyId = $this->notifyId();
        return TfBuildingBadInfoNotify::where('notify_id', $notifyId)->update(['newInfo' => 0]);
    }


    public function actionDelete($notifyId)
    {
        if (empty($notifyId)) $notifyId = $this->notifyId();
        return TfBuildingBadInfoNotify::where('notify_id', $notifyId)->update(['action' => 0]);
    }

    # when delete building
    public function actionDeleteByBuilding($buildingId = null)
    {
        if (!empty($buildingId)) {
            TfBuildingBadInfoNotify::where(['building_id' => $buildingId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    #----------- TF-BAD-INFO -----------
    public function badInfo()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\BadInfo\TfBadInfo', 'badInfo_id', 'badInfo_id');
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($notifyId = '', $field = '')
    {
        if (empty($notifyId)) {
            return null;
        } else {
            $result = TfBuildingBadInfoNotify::where('notify_id', $notifyId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #----------- ---------- NOTIFY INFO ----------- -----------
    public function notifyId()
    {
        return $this->notify_id;
    }

    public function content($notifyId = null)
    {
        if (empty($notifyId)) {
            return $this->content;
        } else {
            return $this->getInfo($notifyId, 'content');
        }
    }

    public function newInfo($notifyId = null)
    {
        if (empty($notifyId)) {
            return $this->newInfo;
        } else {
            return $this->getInfo($notifyId, 'newInfo');
        }
    }

    public function buildingId($notifyId = null)
    {
        if (empty($notifyId)) {
            return $this->building_id;
        } else {
            return $this->getInfo($notifyId, 'building_id');
        }
    }

    public function badInfoId($notifyId = null)
    {
        if (empty($notifyId)) {
            return $this->badInfo_id;
        } else {
            return $this->getInfo($notifyId, 'badInfo_id');
        }
    }

    public function createdAt($notifyId = null)
    {
        if (empty($notifyId)) {
            return $this->created_at;
        } else {
            return $this->getInfo($notifyId, 'created_at');
        }
    }

    # total records
    public function totalRecords()
    {
        return TfBuildingBadInfoNotify::where('action', 1)->count();
    }

}
