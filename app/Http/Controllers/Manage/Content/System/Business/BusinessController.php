<?php namespace App\Http\Controllers\Manage\Content\System\Business;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\System\Business\TfBusiness;
//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class BusinessController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBusinessType = new TfBusinessType();
        $modelBusiness = new TfBusiness();
        $dataBusiness = TfBusiness::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'content';
        return view('manage.content.system.business.list', compact('modelStaff', 'modelBusinessType', 'modelBusiness', 'dataBusiness', 'accessObject'));
    }

    #view
    public function viewBusiness($businessId)
    {
        $dataBusiness = TfBusiness::find($businessId);
        if (count($dataBusiness)) {
            return view('manage.content.system.business.view', compact('dataBusiness'));
        }
    }

    # filter
    public function getFilter($filterBusinessTypeId = '')
    {
        $accessObject = 'content';
        if (empty($filterBusinessTypeId)) { // all country
            return redirect()->route('tf.m.c.system.business.list', compact('accessObject'));
        } else {  // select an country
            $dataBusiness = TfBusiness::where('type_id', $filterBusinessTypeId)->where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
            return view('manage.content.system.business.list', compact('dataBusiness', 'filterBusinessTypeId', 'accessObject'));
        }
    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        $modelBusinessType = new TfBusinessType();
        $accessObject = 'content';
        return view('manage.content.system.business.add', compact('modelBusinessType', 'accessObject'));
    }

    # add
    public function postAdd()
    {
        $modelBusiness = new TfBusiness();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');
        $businessTypeId = Request::input('cbBusinessType');

        if ($modelBusiness->existName($name)) {  // check exist of name
            Session::put('notifyAddBusiness', "Add fail, nam <b>'$name'</b> is existing.");
        } else {
            if ($modelBusiness->insert($name, $description, $businessTypeId)) {
                Session::put('notifyAddBusiness', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddBusiness', 'Add fail, Enter info to try again');
            }
        }

    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($businessId)
    {
        $modelBusinessType = new TfBusinessType();
        $dataBusiness = TfBusiness::find($businessId);
        if (count($dataBusiness)) {
            return view('manage.content.system.business.edit', compact('modelBusinessType','dataBusiness'));
        }
    }

    # edit info
    public function postEdit($businessId)
    {
        $modelBusiness = new TfBusiness();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');
        $businessTypeId = Request::input('cbBusinessType');

        // if exist name <> the type is editing
        if ($modelBusiness->existEditName($name, $businessId)) {
            return "Add fail, Name <b> '$name'</b> is existing.";
        } else {
            $modelBusiness->updateInfo($businessId, $name, $description, $businessTypeId);

        }
    }

    # update status
    public function statusUpdate($businessId)
    {
        $modelBusiness = new TfBusiness();
        if (!empty($businessId)) {
            $currentStatus = $modelBusiness->getInfo($businessId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelBusiness->updateStatus($businessId, $newStatus);
        }
    }

    # delete
    public function deleteBusiness($businessId = '')
    {
        if (!empty($businessId)) {
            $modelBusiness = new TfBusiness();
            $modelBusiness->actionDelete($businessId);
        }

    }

}
