<?php namespace App\Models\Manage\Content\System\StaffManage;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfStaffManage extends Model
{

    protected $table = 'tf_staff_manages';
    protected $fillable = ['manage_id', 'staff_id', 'manageStaff_id', 'action', 'created_at'];
    protected $primaryKey = 'manage_id';
    public $timestamps = false;

    #========== ========= ========= INSERT && UPDATE ========== ========= =========
    #---------- Insert ----------
    public function insert($staffId, $manageStaffId)
    {
        $hFunction = new \Hfunction();
        $modelManage = new TfStaffManage();
        $modelManage->staff_id = $staffId;
        $modelManage->manageStaff_id = $manageStaffId;
        $modelManage->created_at = $hFunction->createdAt();
        return $modelManage->save();
    }

    #update
    public function actionDelete($manageId)
    {
        return TfStaffManage::where('manage_id', $manageId)->update(['action' => 0]);

    }

    #========== ========= ========= RELATION ========== ========= =========
    #----------- TF-STAFF ----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #========== ========= ========= GET INFO ========== ========= =========
    #get manager of staff
    public function managerOfStaff($staffId)
    {
        return TfStaffManage::where('action', 1)->where('manageStaff_id', $staffId)->pluck('staff_id');
    }

    # select staff manage
    public function staffManage($manageStaffId)
    {
        $manage = TfStaffManage::where('manageStaff_id', $manageStaffId)->where('action', 1)->first();
        return $manage->staff_id;
    }


    # get list manage staff
    public function listStaffManage($staffId)
    {
        $listsStaff = TfStaffManage::where('staff_id', $staffId)->lists('manageStaff_id');
        return $listsStaff;
    }

    public function manageId()
    {
        return $this->manage_id;
    }

    # total manage
    public function totalRecords()
    {
        return TfStaffManage::where('action', 1)->count();
    }
}
