<?php namespace App\Models\Manage\Content\Sample\PublicType;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class TfPublicType extends Model
{

    protected $table = 'tf_public_types';
    protected $fillable = ['type_id', 'name', 'defaultStatus', 'status', 'action', 'created_at'];
    protected $primaryKey = 'type_id';
    public $timestamps = false;

    private $lastId;
    #========== ============ =========== INSERT && UPDATE ========== ========== ==========
    #----------- Insert ------------
    public function insert($name)
    {
        $hFunction = new \Hfunction();
        $modelType = new TfPublicType();
        $modelType->name = $name;
        $modelType->status = 1;
        $modelType->action = 1;
        $modelType->created_at = $hFunction->createdAt();
        if ($modelType->save()) {
            $this->lastId = $modelType->type_id;
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

    #----------- Update ------------
    public function updateInfo($typeId, $name)
    {
        return TfPublicType::where('type_id', $typeId)->update(['name' => $name]);
    }

    # update status
    public function updateStatus($typeId, $status)
    {
        return TfPublicType::where('type_id', $typeId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($typeId)
    {
        return TfPublicType::where('type_id', $typeId)->update(['action' => 0]);
    }

    #========== ============ =========== RELATION ========== ========== ==========
    # ---------- TF-PUBLIC-SAMPLE -----------
    public function publicSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Publics\TfPublicSample', 'type_id', 'type_id');
    }

    #========== ============ =========== GET INFO ========== ========== ==========
    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $publicType = TfPublicType::select('type_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($publicType, $selected);
    }

    # get info
    public function getInfo($typeId = '', $field = '')
    {
        if (empty($typeId)) {
            return null;
        } else {
            $result = TfPublicType::find($typeId);
            if (empty($field)) {
                return (!empty($result)) ? $result : null;
            } else {
                return (!empty($result)) ? $result->$field : null;
            }
        }
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfPublicType::where('type_id', $objectId)->pluck($column);
        }
    }

    public function typeId()
    {
        return $this->type_id;
    }

    public function name($typeId = null)
    {
        return $this->pluck('name', $typeId);
    }

    public function defaultStatus($typeId = null)
    {
        return $this->pluck('defaultStatus', $typeId);
    }

    public function status($typeId = null)
    {
        return $this->pluck('status', $typeId);
    }

    public function createdAt($typeId = null)
    {
        return $this->pluck('created_at', $typeId);
    }

    # check exist of name
    public function existName($name)
    {
        $result = TfPublicType::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditName($name, $typeId)
    {
        $result = TfPublicType::where('name', $name)->where('type_id', '<>', $typeId)->count();
        return ($result > 0) ? true : false;
    }

    # total records -->return number
    public function totalRecords()
    {
        return TfPublicType::where('action', 1)->count();
    }

    public function typeIdOfDefault()
    {
        return TfPublicType::where([
            'defaultStatus' => 1,
            'status' => 1,
            'action' => 1
        ])->pluck('type_id');
    }

    public function checkWay($typeId = null)
    {
        if (empty($typeId)) $typeId = $this->typeId();
        return ($typeId == 1) ? true : false; # 1 => Way
    }
}
