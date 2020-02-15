<?php namespace App\Models\Manage\Content\Ads\Position;

use App\Models\Manage\Content\Ads\Banner\TfAdsBanner;
use Illuminate\Database\Eloquent\Model;

class TfAdsPosition extends Model
{

    protected $table = 'tf_ads_positions';
    protected $fillable = ['position_id', 'name', 'width', 'status', 'action', 'created_at'];
    protected $primaryKey = 'position_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    //---------- Insert ----------
    public function insert($name, $width = 120)
    {
        $hFunction = new \Hfunction();
        $modelPosition = new TfAdsPosition();
        $modelPosition->name = $name;
        $modelPosition->width = $width;
        $modelPosition->created_at = $hFunction->createdAt();
        if ($modelPosition->save()) {
            $this->lastId = $modelPosition->position_id;
            return true;
        } else {
            return false;
        }
    }

    //get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- Update ----------
    public function updateInfo($positionId, $name, $width)
    {
        return TfAdsPosition::where('position_id', $positionId)->update([
            'name' => $name,
            'width' => $width
        ]);
    }

    public function updateStatus($positionId, $status)
    {
        return TfAdsPosition::where('position_id', $positionId)->update(['status' => $status]);
    }


    //delete
    public function actionDelete($positionId = null)
    {
        $modelAdsBanner = new TfAdsBanner();
        if (empty($positionId)) $positionId = $this->typeId();
        if (TfAdsPosition::where('position_id', $positionId)->update(['action' => 0])) {
            $modelAdsBanner->actionDeleteByPosition($positionId);
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-ADS-BANNER ----------
    public function adsBanner()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\TfAdsBanner', 'position_id', 'position_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($objectId = '', $field = '')
    {
        if (empty($objectId)) {
            return TfAdsPosition::where('action', 1)->where('status', 1)->get();
        } else {
            $result = TfAdsPosition::where('position_id', $objectId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }


    //create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfAdsPosition::select('position_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfAdsPosition::where('position_id', $objectId)->pluck($column);
        }
    }

    public function positionId()
    {
        return $this->position_id;
    }

    public function name($positionId = null)
    {
        return $this->pluck('name', $positionId);
    }

    public function width($positionId = null)
    {
        return $this->pluck('width', $positionId);
    }

    public function status($positionId = null)
    {
        return $this->pluck('status', $positionId);
    }

    public function createdAt($positionId = null)
    {
        return $this->pluck('created_at', $positionId);
    }

    //total records -->return number
    public function totalRecords()
    {
        return TfAdsPosition::where('action', 1)->count();
    }

    public function rightPositionId()
    {
        return TfAdsPosition::where(['name' => 'right', 'status' => 1])->pluck('position_id');
    }

    public function bottomPositionId()
    {
        return TfAdsPosition::where(['name' => 'bottom', 'status' => 1])->pluck('position_id');
    }

    public function leftPositionId()
    {
        return TfAdsPosition::where(['name' => 'left', 'status' => 1])->pluck('position_id');
    }

    #========== ========== ========== check info ========== ========== ==========
    //check exist of name
    public function existName($name)
    {
        $result = TfAdsPosition::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditName($name, $positionId)
    {
        $result = TfAdsPosition::where('name', $name)->where('position_id', '<>', $positionId)->count();
        return ($result > 0) ? true : false;
    }

}
