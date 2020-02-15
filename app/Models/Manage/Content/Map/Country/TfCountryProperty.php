<?php namespace App\Models\Manage\Content\Map\Country;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfCountryProperty extends Model
{

    protected $table = 'tf_country_properties';
    protected $fillable = ['property_id','code', 'dateBegin', 'dateEnd', 'status', 'action', 'created_at', 'country_id', 'staff_id'];
    protected $primaryKey = 'property_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;
    //========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($dateBegin, $dateEnd, $countryId, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelProperty = new TfCountryProperty();
        $modelProperty->code = 'CP' . $hFunction->getTimeCode();
        $modelProperty->dateBegin = $dateBegin;
        $modelProperty->dateEnd = $dateEnd;
        $modelProperty->status = 1;
        $modelProperty->action = 1;
        $modelProperty->country_id = $countryId;
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
    # update status
    public function updateStatus($propertyId, $status)
    {
        return TfCountryProperty::where('property_id', $propertyId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($propertyId)
    {
        return TfCountryProperty::where('property_id', $propertyId)->update(['action' => 0, 'status' => 0]);
    }

    #when delete country
    public function actionDeleteByCountry($countryId = null)
    {
        if (!empty($countryId)) {
            TfCountryProperty::where(['country_id' => $countryId, 'action' => 1])->update(['action' => 0]);
        }
    }

    //========== ========== ========== RELATION ========== ========== ==========
    public function country()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Country\TfCountry', 'country_id', 'country_id');
    }

    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    //========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($propertyId = '', $field = '')
    {
        if (empty($propertyId)) {
            return null;
        } else {
            $result = TfCountryProperty::where('property_id', $propertyId)->first();
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
            return TfCountryProperty::where('property_id', $objectId)->pluck($column);
        }
    }

    public function propertyId()
    {
        return $this->property_id;
    }

    public function code($propertyId = null)
    {
        return $this->pluck('code', $propertyId);
    }

    public function dateBegin($propertyId = null)
    {
        return $this->pluck('dateBegin', $propertyId);
    }

    public function dateEnd($propertyId = null)
    {
        return $this->pluck('dateEnd', $propertyId);
    }

    public function status($propertyId = null)
    {
        return $this->pluck('status', $propertyId);
    }

    public function createdAt($propertyId = null)
    {
        return $this->pluck('created_at', $propertyId);
    }

    public function countryId($propertyId = null)
    {
        return $this->pluck('country_id', $propertyId);
    }

    public function staffId($propertyId = null)
    {
        return $this->pluck('staff_id', $propertyId);
    }

}
