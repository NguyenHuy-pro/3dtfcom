<?php namespace App\Models\Manage\Content\System\BuildingServiceType;

use Illuminate\Database\Eloquent\Model;

class TfBuildingServiceType extends Model
{

    protected $table = 'tf_building_service_types';
    protected $fillable = ['type_id', 'name', 'action', 'created_at'];
    protected $primaryKey = 'type_id';
    public $timestamps = false;

    private $lastId;

    #============ ============ ============ INSET && UPDATE ============ ========== =========
    #---------- Insert ------------
    public function insert($name)
    {
        $hFunction = new \Hfunction();
        $modelType = new TfBuildingServiceType();
        $modelType->name = $name;
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

    #---------- Update ------------
    public function updateInfo($typeId, $name)
    {
        return TfBuildingServiceType::where('type_id', $typeId)->update(['name' => $name]);
    }

    public function updateStatus($typeId, $status)
    {
        return TfBuildingServiceType::where('type_id', $typeId)->update(['status' => $status]);
    }

    public function actionDelete($typeId)
    {
        return TfBuildingServiceType::where('type_id', $typeId)->update(['action' => 0]);
    }
    #========== ========== ========= RELATION ========== ========= =========
    #----------- TF-Building article -----------
    public function buildingArticles()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Service\Articles\TfBuildingArticles', 'type_id', 'type_id');
    }

    #========== ========== ========= GET INFO ========== ========= =========
    public function getInfo($objectId = null, $field = null)
    {
        if (empty($objectId)) {
            return TfBuildingServiceType::where('action', 1)->get();
        } else {
            $result = TfBuildingServiceType::where('type_id', $objectId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }
    // Create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfBuildingServiceType::select('type_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuildingServiceType::where('type_id', $objectId)->pluck($column);
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

    public function createdAt($typeId = null)
    {
        return $this->pluck('created_at', $typeId);
    }

    # total record
    public function totalRecords()
    {
        return TfBuildingServiceType::count();
    }

    #========== ========== ========= CHECK INFO ========== ========= =========
    #check exist of name
    public function existName($name)
    {
        $provinceType = TfBuildingServiceType::where('name', $name)->count();
        return ($provinceType > 0) ? true : false;
    }

    public function existEditName($typeId, $name)
    {
        $result = TfBuildingServiceType::where('type_id', '<>', $typeId)->where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

}
