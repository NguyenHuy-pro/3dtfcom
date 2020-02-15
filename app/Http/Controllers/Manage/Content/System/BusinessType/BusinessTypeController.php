<?php namespace App\Http\Controllers\Manage\Content\System\BusinessType;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use DB;
use File;
use Request;

class BusinessTypeController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    // get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBusinessType = new TfBusinessType();
        $dataBusinessType = TfBusinessType::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'tool';
        return view('manage.content.system.business-type.list', compact('modelStaff', 'modelBusinessType', 'dataBusinessType', 'accessObject'));
    }

    //view
    public function viewBusinessType($typeId)
    {
        $modelBusinessType = new TfBusinessType();
        if (!empty($typeId)) {
            $dataBusinessType = $modelBusinessType->getInfo($typeId);
            return view('manage.content.system.business-type.view', compact('dataBusinessType'));
        }
    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    //get form add
    public function getAdd()
    {
        $accessObject = 'tool';
        return view('manage.content.system.business-type.add', compact('accessObject'));
    }

    //add new
    public function postAdd()
    {
        $modelBusinessType = new TfBusinessType();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');

        // check exist of name
        if ($modelBusinessType->existName($name)) {
            Session::put('notifyAddBusinessType', "Add fail, Name <b>'$name'</b> exists.");
        } else {
            if ($modelBusinessType->insert($name, $description)) {
                Session::put('notifyAddBusinessType', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddBusinessType', 'Add fail, Enter info to try again');
            }
        }

    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    //get form edit
    public function getEdit($typeId)
    {
        $modelBusinessType = new TfBusinessType();
        $dataBusinessType = $modelBusinessType->getInfo($typeId);
        if (count($dataBusinessType) > 0) {
            return view('manage.content.system.business-type.edit', compact('dataBusinessType'));
        }
    }

    //edit
    public function postEdit($businessTypeId)
    {
        $modelBusinessType = new TfBusinessType();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');

        //if exist name <> the type is editing
        if ($modelBusinessType->existEditName($name, $businessTypeId)) {
            return "Add fail, Name <b>'$name'</b> exists.";
        } else {
            $modelBusinessType->updateInfo($businessTypeId, $name, $description);
        }
    }

    //update status
    public function statusUpdate($typeId)
    {
        $modelType = new TfBusinessType();
        if (!empty($typeId)) {
            $currentStatus = $modelType->getInfo($typeId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelType->updateStatus($typeId, $newStatus);
        }
    }

    //delete
    public function deleteBusinessType($businessTypeId = '')
    {
        if (!empty($businessTypeId)) {
            $modelBusinessType = new TfBusinessType();
            $modelBusinessType->actionDelete($businessTypeId);
        }
    }

}
