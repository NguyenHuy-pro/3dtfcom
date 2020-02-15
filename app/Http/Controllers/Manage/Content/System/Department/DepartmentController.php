<?php namespace App\Http\Controllers\Manage\Content\System\Department;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\Department\TfDepartment;

//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class DepartmentController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelDepartment = new TfDepartment();
        $dataDepartment = TfDepartment::orderBy('name', 'ASC')->select('*')->paginate(30);
        return view('manage.content.system.department.list', compact('modelStaff', 'modelDepartment', 'dataDepartment'));
    }

    #view
    public function viewDepartment($departmentId)
    {
        if (!empty($departmentId)) {
            $dataDepartment = TfDepartment::find($departmentId);
            return view('manage.content.system.department.view', compact('dataDepartment'));
        }
    }
    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        return view('manage.content.system.department.add');
    }

    # Add
    public function postAdd()
    {
        $modelDepartment = new TfDepartment();
        $name = Request::input('txtName');
        $code = Request::input('txtCodeDepartment');

        #check exist of name
        if ($modelDepartment->existName($name)) {
            Session::put('notifyAddDepartment', "Add fail, Name <b> '$name' </b> exists.");
            die();
        }
        // check exist of name
        if ($modelDepartment->existCodeDepartment($code)) {
            Session::put('notifyAddDepartment', "Add fail, code <b> '$code' </b> exists.");
            die();
        } else {
            if ($modelDepartment->insert($code, $name)) {
                Session::put('notifyAddDepartment', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddDepartment', 'Add fail, Enter info to try again');
            }
        }
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($departmentId)
    {
        if (!empty($departmentId)) {
            $dataDepartment = TfDepartment::find($departmentId);
            if(count($dataDepartment) > 0){
                return view('manage.content.system.department.edit', compact('dataDepartment'));
            }
        }
    }

    # edit info
    public function postEdit($departmentId)
    {
        $modelDepartment = new TfDepartment();
        $name = Request::input('txtName');
        $code = Request::input('txtCodeDepartment');

        // if exist name <> the type is editing
        if ($modelDepartment->existEditName($departmentId, $name)) {
            return "Add fail, Name '$name' exists.";
        }

        // if exist name <> the type is editing
        if ($modelDepartment->existEditCode($departmentId, $code)) {
            return "Add fail, Code '$code' exists.";
        }else{
            $modelDepartment->updateInfo($departmentId, $code,$name);
        }
    }

    # update status
    public function statusUpdate($departmentId)
    {
        $modelDepartment = new TfDepartment();
        if (!empty($departmentId)) {
            $currentStatus = $modelDepartment->getInfo($departmentId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelDepartment->updateStatus($departmentId, $newStatus);
        }
    }

    # delete
    public function deleteDepartment($departmentId)
    {
        if (!empty($departmentId)) {
            $modelDepartment = new TfDepartment();
            $modelDepartment->actionDelete($departmentId);
        }
    }

}
