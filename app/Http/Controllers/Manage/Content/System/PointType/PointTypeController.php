<?php namespace App\Http\Controllers\Manage\Content\System\PointType;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\PointType\TfPointType;

use DB;
use File;
use Request;

class PointTypeController extends Controller
{
    #=========== =========== =========== GET INFO =========== =========== ===========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelPointType = new TfPointType();
        $accessObject = 'point';
        $dataPointType = TfPointType::orderBy('name', 'ASC')->select('*')->paginate(30);
        return view('manage.content.system.point-type.list', compact('modelStaff', 'modelPointType', 'dataPointType', 'accessObject'));
    }

    #view
    public function viewPointType($typeId)
    {
        if (!empty($typeId)) {
            $dataPointType = TfPointType::find($typeId);
            if (count($dataPointType)) {
                return view('manage.content.system.point-type.view', compact('dataPointType'));
            }
        }
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $accessObject = 'point';
        return view('manage.content.system.point-type.add', compact('accessObject'));
    }

    # add
    public function postAdd()
    {
        $modelPointType = new TfPointType();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');

        // check exist of name
        if ($modelPointType->existName($name)) {
            Session::put('notifyAddPointType', "Add fail, Name <b>'$name'</b> exists.");
        } else {
            if ($modelPointType->insert($name, $description)) {
                Session::put('notifyAddPointType', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddPointType', 'Add fail, Enter info to try again');
            }
        }
    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($pointTypeId = '')
    {
        $dataPointType = TfPointType::find($pointTypeId);
        if (count($dataPointType)) {
            return view('manage.content.system.point-type.edit', compact('dataPointType'));
        }
    }

    # edit
    public function postEdit($pointTypeId)
    {
        $modelPointType = new TfPointType();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');

        // if exist name <> the type is editing
        if ($modelPointType->existEditName($pointTypeId, $name)) {
            return "Add fail, Name <b>'$name'</b> exists.";
        } else {
            $modelPointType->updateInfo($pointTypeId, $name, $description);
        }

    }

    # update status
    public function statusUpdate($typeId)
    {
        $modelType = new TfPointType();
        if (!empty($typeId)) {
            $currentStatus = $modelType->status($typeId);
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelType->updateStatus($typeId, $newStatus);
        }
    }

    # delete
    public function deletePointType($pointTypeId = null)
    {
        if (!empty($pointTypeId)) {
            $modelPointType = new TfPointType();
            $modelPointType->actionDelete($pointTypeId);
        }
    }

}
