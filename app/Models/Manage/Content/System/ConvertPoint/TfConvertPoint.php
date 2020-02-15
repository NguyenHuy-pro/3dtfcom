<?php namespace App\Models\Manage\Content\System\ConvertPoint;

use Illuminate\Database\Eloquent\Model;

class TfConvertPoint extends Model
{

    protected $table = 'tf_convert_points';
    protected $fillable = ['convert_id', 'point', 'convertValue', 'action', 'type_id', 'staff_id','created_at', 'updated_at'];
    protected $primaryKey = 'convert_id';
    public $timestamps = true;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($point, $convertValue, $typeId, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelConvertPoint = new TfConvertPoint();
        $modelConvertPoint->point = $point;
        $modelConvertPoint->convertValue = $convertValue;
        $modelConvertPoint->action = 1;
        $modelConvertPoint->type_id = $typeId;
        $modelConvertPoint->staff_id = $staffId;
        $modelConvertPoint->created_at = $hFunction->createdAt();
        if ($modelConvertPoint->save()) {
            $this->lastId = $modelConvertPoint->convert_id;
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
    public function updateInfo($convertId, $point, $convertValue)
    {
        return TfConvertPoint::where('convert_id', $convertId)->update([
            'point' => $point,
            'convertValue' => $convertValue
        ]);
    }

    public function actionDelete($convertId)
    {
        return TfConvertPoint::where('convert_id', $convertId)->update(['action' => 0]);
    }

    #============ ============ ============ RELATION ============ ============ ============

    # ---------- TF-CONVERT-TYPE ----------
    public function convertType()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\ConvertType\TfConvertType', 'type_id', 'type_id');
    }

    # ---------- TF-STAFF ----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #============ ============ ============ GET INFO ============ ============ ============
    public function getInfo($convertId = null, $field = null)
    {
        if (empty($convertId)) {
            return TfConvertPoint::where('action', 1)->get();
        } else {
            $result = TfConvertPoint::where('convert_id', $convertId)->first();
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
            return TfConvertPoint::where('convert_id', $objectId)->pluck($column);
        }
    }

    public function convertId()
    {
        return $this->convert_id;
    }

    public function point($convertId = null)
    {
        return $this->pluck('point', $convertId);
    }

    public function convertValue($convertId=null)
    {
        return $this->pluck('convertValue', $convertId);
    }

    public function typeId($convertId=null)
    {
        return $this->pluck('type_id', $convertId);
    }

    public function staffId($convertId=null)
    {
        return $this->pluck('staff_id', $convertId);
    }

    public function createdAt($convertId=null)
    {
        return $this->pluck('created_at', $convertId);
    }

    // total records
    public function totalRecords()
    {
        return TfConvertPoint::where('action', 1)->count();
    }

    # get convert type is using
    public function convertIdOfType($typeId)
    {
        return TfConvertPoint::where('type_id', $typeId)->where('action', 1)->pluck('convert_id');
    }
}
