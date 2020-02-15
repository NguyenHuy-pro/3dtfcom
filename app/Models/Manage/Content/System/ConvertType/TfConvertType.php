<?php namespace App\Models\Manage\Content\System\ConvertType;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfConvertType extends Model
{

    protected $table = 'tf_convert_types';
    protected $fillable = ['type_id', 'name', 'description', 'action', 'created_at'];
    protected $primaryKey = 'type_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($name, $description = '')
    {
        $hFunction = new \Hfunction();
        $modelType = new TfConvertType();
        $modelType->name = $name;
        $modelType->description = $description;
        $modelType->action = 1;
        $modelType->created_at = $hFunction->createdAt();
        if ($modelType->save()) {
            $this->lastId = $modelType->type_id;
            return true;
        } else {
            return false;
        }
    }

    # get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- Update ----------
    public function updateInfo($typeId, $name, $description)
    {
        return TfConvertType::where('type_id', $typeId)->update([
            'name' => $name,
            'description' => $description
        ]);
    }

    public function actionDelete($typeId)
    {
        return TfConvertType::where('type_id', $typeId)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-CONVERT-POINT ----------
    public function convertPoint()
    {
        return $this->hasMany('App\Models\Manage\Content\System\ConvertPoint\TfConvertPoint', 'type_id', 'type_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $convertType = TfConvertType::select('type_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($convertType, $selected);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfConvertType::where('type_id', $objectId)->pluck($column);
        }
    }

    public function typeId()
    {
        return $this->type_id;
    }

    # get info
    public function name($typeId = null)
    {
        return $this->pluck('name', $typeId);
    }

    public function description($typeId = null)
    {
        return $this->pluck('description', $typeId);
    }

    public function createdAt($typeId = null)
    {
        return $this->pluck('created_at', $typeId);
    }

    # check exist of name
    public function existName($name)
    {
        $convertType = DB::table('tf_convert_types')->where('name', $name)->count();
        return ($convertType > 0) ? true : false;
    }

    # check exist of name (when edit info)
    public function existEditName($typeId, $name)
    {
        $result = TfConvertType::where('type_id', '<>', $typeId)->where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    # total records
    public function totalRecords()
    {
        $total = TfConvertType::count();
        return $total;
    }

}
