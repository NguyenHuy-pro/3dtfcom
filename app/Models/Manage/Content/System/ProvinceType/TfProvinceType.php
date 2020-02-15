<?php namespace App\Models\Manage\Content\System\ProvinceType;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfProvinceType extends Model
{

    protected $table = 'tf_province_types';
    protected $fillable = ['type_id', 'name', 'status', 'created_at'];
    protected $primaryKey = 'type_id';
    public $timestamps = false;

    private $lastId;

    #============ ============ ============ INSET && UPDATE ============ ========== =========
    #---------- Insert ------------
    public function insert($name)
    {
        $hFunction = new \Hfunction();
        $modelProvinceType = new TfProvinceType();
        $modelProvinceType->name = $name;
        $modelProvinceType->created_at = $hFunction->createdAt();
        if ($modelProvinceType->save()) {
            $this->lastId = $modelProvinceType->type_id;
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
        return TfProvinceType::where('type_id', $typeId)->update(['name' =>$name]);
    }

    public function updateStatus($typeId, $status)
    {
        return TfProvinceType::where('type_id', $typeId)->update(['status' => $status]);
    }

    public function actionDelete($typeId)
    {
        return TfProvinceType::where('type_id', $typeId)->delete();
    }
    #========== ========== ========= RELATION ========== ========= =========
    #----------- TF-PROVINCE -----------
    public function province()
    {
        return $this->hasMany('App\Models\Manage\Content\System\Province\TfProvince', 'type_id', 'type_id');
    }

    #========== ========== ========= GET INFO ========== ========= =========
    // Create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfProvinceType::select('type_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProvinceType::where('type_id', $objectId)->pluck($column);
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

    public function status($typeId = null)
    {
        return $this->pluck('status', $typeId);
    }

    public function createdAt($typeId = null)
    {
        return $this->pluck('created_at', $typeId);
    }

    # total record
    public function totalRecords()
    {
        return TfProvinceType::count();
    }

    #========== ========== ========= CHECK INFO ========== ========= =========
    #check exist of name
    public function existName($name)
    {
        $provinceType = TfProvinceType::where('name', $name)->count();
        return ($provinceType > 0) ? true : false;
    }

    public function existEditName($typeId, $name)
    {
        $result = TfProvinceType::where('type_id', '<>', $typeId)->where('name', $name)->count();
        return ($result > 0) ? true : false;
    }


}
