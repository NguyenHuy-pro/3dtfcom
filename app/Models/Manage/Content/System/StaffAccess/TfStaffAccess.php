<?php namespace App\Models\Manage\Content\System\StaffAccess;

use App\Models\Manage\Content\Users\TfUserAccess;
use Illuminate\Database\Eloquent\Model;
use DB;

class TfStaffAccess extends Model
{

    protected $table = 'tf_staff_accesses';
    protected $fillable = ['access_id', 'accessIP', 'accessStatus', 'created_at', 'action', 'staff_id'];
    protected $primaryKey = 'access_id';
    public $timestamps = false;

    #========== ========= ========= INSERT && EDIT ========== ========= =========
    #insert
    public function insert($accessIP, $accessStatus, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelAccess = new TfStaffAccess();
        $modelAccess->accessIP = $accessIP;
        $modelAccess->accessStatus = $accessStatus;
        $modelAccess->action = 1;
        $modelAccess->staff_id = $staffId;
        $modelAccess->created_at = $hFunction->createdAt();
        return $modelAccess->save();
    }

    #--------- Update ----------
    public function updateAction($staffId)
    {
        return TfStaffAccess::where('staff_id', $staffId)->update(['action' => 0]);
    }

    #========== ========= ========= RELATION ========== ========= =========
    #----------- TF-STAFF ----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #========== ========== GET INFO ========== ========== ==========
    public function getInfo($accessId = null, $field = null)
    {
        if (empty($accessId)) {
            return null;
        } else {
            $result = TfStaffAccess::where('access_id', $accessId)->first();
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
            return TfStaffAccess::where('access_id', $objectId)->pluck($column);
        }
    }

    public function accessId()
    {
        return $this->access_id;
    }


    public function accessIP($accessId = null)
    {
        return $this->pluck('accessIP', $accessId);
    }

    public function accessStatus($accessId = null)
    {
        return $this->pluck('accessStatus', $accessId);
    }

    public function createdAt($accessId = null)
    {
        return $this->pluck('created_at', $accessId);
    }
    public function staffId($accessId = null)
    {
        return $this->pluck('staff_id', $accessId);
    }

    # total records
    public function totalRecords()
    {
        return TfStaffAccess::count();
    }

}
