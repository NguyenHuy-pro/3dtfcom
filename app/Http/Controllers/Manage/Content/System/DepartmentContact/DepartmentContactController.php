<?php namespace App\Http\Controllers\Manage\Content\System\DepartmentContact;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Department\TfDepartment;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\DepartmentContact\TfDepartmentContact;
//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class DepartmentContactController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelDepartmentContact = new TfDepartmentContact();
        $dataDepartmentContact = TfDepartmentContact::where('action', 1)->orderBy('contact_id', 'ASC')->select('*')->paginate(30);
        return view('manage.content.system.department-contact.list', compact('modelStaff', 'modelDepartmentContact', 'dataDepartmentContact'));
    }

    #view
    public function viewContact($contactId)
    {
        $dataDepartmentContact = TfDepartmentContact::find($contactId);
        if (count($dataDepartmentContact) > 0) {
            return view('manage.content.system.department-contact.view', compact('dataDepartmentContact'));
        }

    }
    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        $modelDepartment = new TfDepartment();
        return view('manage.content.system.department-contact.add', compact('modelDepartment'));
    }

    # add
    public function postAdd()
    {
        $modelDepartmentContact = new TfDepartmentContact();
        $email = Request::input('txtEmail');
        $phone = Request::input('txtPhone');
        $departmentId = Request::input('cbDepartment');

        if ($modelDepartmentContact->insert($email, $phone, $departmentId)) {
            Session::put('notifyAddDepartmentContact', 'Add success, Enter info to continue');
        } else {
            Session::put('notifyAddDepartmentContact', 'Add fail, Enter info to try again');
        }
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($contactId)
    {
        $dataDepartmentContact = TfDepartmentContact::find($contactId);
        if (count($dataDepartmentContact) > 0) {
            return view('manage.content.system.department-contact.edit', compact('dataDepartmentContact'));
        }
    }

    # edit info
    public function postEdit($contactId)
    {
        $modelContact = new TfDepartmentContact();
        $email = Request::input('txtEmail');
        $phone = Request::input('txtPhone');
        $departmentId = Request::input('cbDepartment');
        $modelContact->updateInfo($contactId, $email, $phone, $departmentId);
    }

    # delete
    public function deleteContact($contactId)
    {
        if (!empty($contactId)) {
            $modelDepartmentContact = new TfDepartmentContact();
            $modelDepartmentContact->actionDelete($contactId);
        }
    }

}
