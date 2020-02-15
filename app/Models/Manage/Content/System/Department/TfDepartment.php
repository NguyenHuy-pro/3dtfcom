<?php namespace App\Models\Manage\Content\System\Department;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfDepartment extends Model
{

    protected $table = 'tf_departments';
    protected $fillable = ['department_id', 'departmentCode', 'name', 'status', 'created_at'];
    protected $primaryKey = 'department_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($departmentCode, $name)
    {
        $hFunction = new \Hfunction();
        $modelDepartment = new TfDepartment();
        $modelDepartment->departmentCode = $departmentCode;
        $modelDepartment->name = $name;
        $modelDepartment->status = 1;
        $modelDepartment->created_at = $hFunction->createdAt();
        if ($modelDepartment->save()) {
            $this->lastId = $modelDepartment->department_id;
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
    public function updateInfo($departmentId, $code, $name)
    {
        return TfDepartment::where('department_id', $departmentId)->update([
            'departmentCode' => $code,
            'name' => $name
        ]);
    }

    # status
    public function updateStatus($departmentId, $status)
    {
        return TfDepartment::where('department_id', $departmentId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($departmentId = null)
    {
        if (empty($departmentId)) $departmentId = $this->departmentId();
        return TfDepartment::where('department_id', $departmentId)->delete();
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-DEPARTMENT-CONTACT ------------
    public function departmentContact()
    {
        return $this->hasMany('App\Models\Manage\Content\System\DepartmentContact\TfDepartmentContact', 'department_id', 'department_id');
    }

    #----------- TF-STAFF ------------
    public function staff()
    {
        return $this->hasMany('App\Models\Manage\Content\System\Staff\TfStaff', 'department_id', 'department_id');
    }

    #============ =========== ============ GET INFO ============= =========== ==========
    public function getInfo($departmentId = '', $field = '')
    {
        if (empty($departmentId)) {
            return null;
        } else {
            $result = TfDepartment::where('department_id', $departmentId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # create option
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfDepartment::select('department_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    #----------- DEPARTMENT INFO -------------
    public function departmentId()
    {
        return $this->department_id;
    }

    public function name($departmentId = null)
    {
        if (empty($departmentId)) {
            return $this->name;
        } else {
            return $this->getInfo($departmentId, 'name');
        }
    }

    public function departmentCode($departmentId = null)
    {
        if (empty($departmentId)) {
            return $this->departmentCode;
        } else {
            return $this->getInfo($departmentId, 'departmentCode');
        }
    }

    public function status($departmentId = null)
    {
        if (empty($departmentId)) {
            return $this->status;
        } else {
            return $this->getInfo($departmentId, 'status');
        }
    }

    public function codeDepartment($departmentId = null)
    {
        if (empty($departmentId)) {
            return $this->departmentCode;
        } else {
            return $this->getInfo($departmentId, 'departmentCode');
        }
    }

    public function createdAt($departmentId = null)
    {
        if (empty($departmentId)) {
            return $this->created_at;
        } else {
            return $this->getInfo($departmentId, 'created_at');
        }
    }

    # total record
    public function totalRecords()
    {
        return TfDepartment::count();
    }

    #============ =========== ============ CHECK INFO ============= =========== ==========
    # exist name (add new)
    public function existName($name)
    {
        $result = TfDepartment::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    # exist code
    public function existCodeDepartment($departmentCode)
    {
        $result = TfDepartment::where('departmentCode', $departmentCode)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditName($departmentId, $name)
    {
        $result = TfDepartment::where('name', $name)->where('department_id', '<>', $departmentId)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditCode($departmentId, $code)
    {
        $result = TfDepartment::where('departmentCode', $code)->where('department_id', '<>', $departmentId)->count();
        return ($result > 0) ? true : false;
    }
}
