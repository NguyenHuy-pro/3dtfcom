<?php namespace App\Models\Manage\Content\System\PointType;

use App\Models\Manage\Content\System\PointTransaction\TfPointTransaction;
use Illuminate\Database\Eloquent\Model;
use DB;

class TfPointType extends Model
{

    protected $table = 'tf_point_types';
    protected $fillable = ['type_id', 'name', 'description', 'status', 'created_at'];
    protected $primaryKey = 'type_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($name, $description)
    {
        $hFunction = new \Hfunction();
        $modelType = new TfPointType();
        $modelType->name = $name;
        $modelType->description = $description;
        $modelType->status = 1;
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

    #----------- update ----------
    #update info
    public function updateInfo($typeId, $name, $description)
    {
        return TfPointType::where('type_id', $typeId)->update(['name' => $name, 'description' => $description]);
    }

    public function updateStatus($typeId, $status)
    {
        return TfPointType::where('type_id', $typeId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($typeId)
    {
        return TfPointType::where('type_id', $typeId)->delete();
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-POINT-TRANSACTION ------------
    public function pointTransaction()
    {
        return $this->hasMany('App\Models\Manage\Content\System\PointTransaction\TfPointTransaction', 'type_id', 'type_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfPointType::select('type_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    public function normalTypeInfo()
    {
        return TfPointType::where(['type_id' => 1])->first();
    }

    public function goldTypeInfo()
    {
        return TfPointType::where(['type_id' => 2])->first();
    }


    /*
    public function pointTransactionInfo($typeId)
    {
        return TfPointType::find($typeId)->pointTransaction->where('action', 1);
    }
    */
    public function pointTransactionInfo($typeId)
    {
        $modelPointTransaction = new TfPointTransaction();
        return $modelPointTransaction->infoOfPointType($typeId);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfPointType::where('type_id', $objectId)->pluck($column);
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

    public function description($typeId = null)
    {
        return $this->pluck('description', $typeId);

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
        $pointType = TfPointType::where('name', $name)->count();
        return ($pointType > 0) ? true : false;
    }

    # check exist of name (when edit info)
    public function existEditName($typeId, $name)
    {
        $result = TfPointType::where('type_id', '<>', $typeId)->where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    # total records
    public function totalRecords()
    {
        return TfPointType::count();
    }
}
