<?php namespace App\Models\Manage\Content\Map\ProvinceProperty;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfProvinceProperty extends Model
{

    protected $table = 'tf_province_properties';
    protected $fillable = ['property_id', 'code', 'dateBegin', 'dateEnd', 'created_at', 'status', 'action', 'province_id', 'staff_id'];
    protected $primaryKey = 'property_id';
    # public $incrementing = false;
    public $timestamps = false;

    private $lastId;
    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($dateBegin, $dateEnd, $provinceId, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelProperty = new TfProvinceProperty();
        $modelProperty->code = 'PP' . $hFunction->getTimeCode();
        $modelProperty->dateBegin = $dateBegin;
        $modelProperty->dateEnd = $dateEnd;
        $modelProperty->province_id = $provinceId;
        $modelProperty->staff_id = $staffId;
        $modelProperty->created_at = $hFunction->createdAt();
        if ($modelProperty->save()) {
            $this->lastId = $modelProperty->property_id;
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

    #----------  Update ----------
    public function updateStatus($propertyId, $status)
    {
        return TfProvinceProperty::where('property_id', $propertyId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return TfProvinceProperty::where('property_id', $propertyId)->update(['action' => 0, 'status' => 0]);
    }

    #when delete province
    public function actionDeleteByProvince($provinceId = null)
    {
        if (!empty($provinceId)) {
            TfProvinceProperty::where(['province_id' => $provinceId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-PROVINCE -----------
    public function province()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Province\TfProvince', 'province_id', 'province_id');
    }

    #---------- TF_STAFF ----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($propertyId = null, $field = null)
    {
        if (empty($propertyId)) {
            return TfProvinceProperty::where('action', 1)->get();
        } else {
            $result = TfProvinceProperty::where('property_id', $propertyId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #---------- TF-PROVINCE ----------
    # only get province id of staff
    public function listProvinceOfStaff($staffId)
    {
        return TfProvinceProperty::where('staff_id', $staffId)->where('action', 1)->lists('province_id');
    }

    public function infoOfProvince($provinceId)
    {
        return TfProvinceProperty::where('province_id', $provinceId)->where('action', 1)->first();
    }

    #---------- PROPERTY INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProvinceProperty::where('property_id', $objectId)->pluck($column);
        }
    }

    public function propertyId()
    {
        return $this->property_id;
    }

    public function dateBegin($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return $this->pluck('dateBegin', $propertyId);
    }

    public function dateEnd($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return $this->pluck('dateEnd', $propertyId);
    }

    public function provinceId($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return $this->pluck('province_id', $propertyId);
    }

    public function staffId($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return $this->pluck('staff_id', $propertyId);
    }

    public function code($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return $this->pluck('code', $propertyId);
    }

    public function createdAtt($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return $this->pluck('created_at', $propertyId);
    }

    # total records
    public function totalRecords()
    {
        return TfProvinceProperty::where('action', 1)->count();
    }

    #========== ========== ========= ACCESS INFO ========== ========= =========
    public function accessProperty($staffId)
    {
        return TfProvinceProperty::where('staff_id', $staffId)->where('action', 1)->orderBy('property_id', 'DESC')->first();
    }
}
