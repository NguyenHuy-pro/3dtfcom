<?php namespace App\Models\Manage\Content\Map\Project\Property;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfProjectProperty extends Model
{

    protected $table = 'tf_project_properties';
    protected $fillable = ['property_id', 'code', 'dateBegin', 'dateEnd', 'status', 'action', 'project_id', 'staff_id', 'created_at'];
    protected $primaryKey = 'property_id';
    #public $incrementing = false;
    public $timestamps = false;

    private $lastId;
    #=========== =========== =========== INSERT && UPDATE =========== ========== ===========
    #----------- Insert ------------
    public function insert($dateBegin, $dateEnd, $projectId, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelProjectProperty = new TfProjectProperty();
        $modelProjectProperty->code = 'PJP' . $hFunction->getTimeCode();
        $modelProjectProperty->dateBegin = $dateBegin;
        $modelProjectProperty->dateEnd = $dateEnd;
        $modelProjectProperty->status = 1;
        $modelProjectProperty->action = 1;
        $modelProjectProperty->project_id = $projectId;
        $modelProjectProperty->staff_id = $staffId;
        $modelProjectProperty->created_at = $hFunction->createdAt();
        if ($modelProjectProperty->save()) {
            $this->listId = $modelProjectProperty->property_id;
            return true;
        } else {
            return false;
        }
    }

    #get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #----------- Update ------------
    public function updateStatus($propertyId, $status)
    {
        return TfProjectProperty::where('property_id', $propertyId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($propertyId=null)
    {
        if(empty($propertyId)) $propertyId = $this->propertyId();
        return TfProjectProperty::where('property_id', $propertyId)->update(['action' => 0]);
    }

    #delete by project (when delete project)
    public function actionDeleteByProject($projectId = null)
    {
        if (!empty($projectId)) {
            $objectId = TfProjectProperty::where(['project_id' => $projectId, 'action' => 1])->pluck('property_id');
            if(!empty($objectId)){
                $this->actionDelete($objectId);
            }
        }
    }

    #============ ============ ============ RELATION =========== ============ ============
    # ---------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'project_id', 'project_id');
    }

    # ---------- TF-STAFF ----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    # ---------- TF-PROJECT-PROPERTY-CANCEL ----------
    public function projectPropertyCancel()
    {
        return $this->hasOne('App\Models\Manage\Content\Map\Project\PropertyCancel\TfProjectPropertyCancel', 'property_id', 'property_id');
    }

    #========= ========= ========= GET INFO ========== ========= =========
    public function getInfo($propertyId = '', $field = '')
    {
        if (empty($propertyId)) {
            return TfProjectProperty::where('action', 1)->get();
        } else {
            $result = TfProjectProperty::where('property_id', $propertyId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # ----------- TF-PROJECT ---------
    # only get property is using of project
    public function infoOfProject($projectId)
    {
        return TfProjectProperty::where('project_id', $projectId)->where('action', 1)->first();
    }

    # ----------- TF-STAFF ---------
    # only get properties are using
    public function infoOfStaff($staffId)
    {
        return TfProjectProperty::where('staff_id', $staffId)->where('action', 1)->get();
    }

    # only get projects ID of staff
    public function listProjectOfStaff($staffId)
    {
        return TfProjectProperty::where('staff_id', $staffId)->where('action', 1)->lists('project_id');
    }

    # -----------PROPERTY INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProjectProperty::where('property_id', $objectId)->pluck($column);
        }
    }

    public function propertyId()
    {
        return $this->property_id;
    }

    public function code($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return $this->pluck('code', $propertyId);
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

    public function projectId($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return $this->pluck('project_id', $propertyId);
    }

    public function staffId($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return $this->pluck('staff_id', $propertyId);
    }

    public function status($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return $this->pluck('status', $propertyId);
    }

    public function createdAt($propertyId = null)
    {
        if (empty($propertyId)) $propertyId = $this->propertyId();
        return $this->pluck('created_at', $propertyId);
    }

    # inspect projects under its management staff.
    public function checkStaffManageProject($staffId, $projectId)
    {
        $result = TfProjectProperty::where('staff_id', $staffId)->where('project_id', $projectId)->where('action', 1)->count();
        return ($result > 0) ? true : false;
    }

    # total records
    public function totalRecords()
    {
        return TfProjectProperty::count();
    }

    #========== ========== ========= ACCESS INFO ========== ========= =========
    public function accessProperty($staffId)
    {
        return TfProjectProperty::where('staff_id', $staffId)->where('action', 1)->orderBy('property_id', 'DESC')->first();
    }

}
