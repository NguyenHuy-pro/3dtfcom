<?php namespace App\Models\Manage\Content\System\DepartmentContact;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfDepartmentContact extends Model
{

    protected $table = 'tf_department_contacts';
    protected $fillable = ['contact_id', 'email', 'phone', 'action', 'created_at', 'department_id'];
    protected $primaryKey = 'contact_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($email, $phone, $departmentId)
    {
        $hFunction = new \Hfunction();
        $modelContact = new TfDepartmentContact();
        $modelContact->email = $email;
        $modelContact->phone = $phone;
        $modelContact->action = 1;
        $modelContact->department_id = $departmentId;
        $modelContact->created_at = $hFunction->createdAt();
        if ($modelContact->save()) {
            $this->lastId = $modelContact->contact_id;
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

    #----------- Update ----------
    public function updateInfo($contactId, $email, $phone, $departmentId)
    {
        return TfDepartmentContact::where('contact_id', $contactId)->update([
            'email' => $email,
            'phone' => $phone,
            'department_id' => $departmentId
        ]);
    }

    # delete
    public function actionDelete($contactId=null)
    {
        if(empty($contactId)) $contactId = $this->contactId();
        return TfDepartmentContact::where('contact_id', $contactId)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-DEPARTMENT ------------
    public function department()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Department\TfDepartment', 'department_id', 'department_id');
    }

    # ========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($contactId = '', $field = '')
    {
        if (empty($contactId)) {
            return TfDepartmentContact::where('action', 1)->get();
        } else {
            $result = TfDepartmentContact::where('contact_id', $contactId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function contactId()
    {
        return $this->contact_id;
    }

    public function email($contactId = null)
    {
        if (empty($contactId)) {
            return $this->email;
        } else {
            return $this->getInfo($contactId, 'email');
        }
    }

    public function phone($contactId = null)
    {
        if (empty($contactId)) {
            return $this->phone;
        } else {
            return $this->getInfo($contactId, 'phone');
        }
    }

    public function departmentId($contactId = null)
    {
        if (empty($contactId)) {
            return $this->department_id;
        } else {
            return $this->getInfo($contactId, 'department_id');
        }
    }

    public function createdAt($contactId = null)
    {
        if (empty($contactId)) {
            return $this->created_at;
        } else {
            return $this->getInfo($contactId, 'created_at');
        }
    }

    # total records
    public function totalRecords()
    {
        return TfDepartmentContact::where('action', 1)->count();
    }


}
