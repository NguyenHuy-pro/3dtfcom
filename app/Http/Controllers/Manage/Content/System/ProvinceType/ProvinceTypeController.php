<?php namespace App\Http\Controllers\Manage\Content\System\ProvinceType;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\ProvinceType\TfProvinceType;

use DB;
use File;
use Request;

class ProvinceTypeController extends Controller
{
    #=========== =========== =========== GET INFO =========== =========== ===========
    # list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelProvinceType = new TfProvinceType();
        $accessObject = 'content';
        $dataProvinceType = TfProvinceType::orderBy('name', 'ASC')->select('*')->paginate(30);
        return view('manage.content.system.province-type.list', compact('modelStaff', 'modelProvinceType', 'dataProvinceType', 'accessObject'));
    }

    #view
    public function viewProvinceType($typeId)
    {
        if (!empty($typeId)) {
            $dataProvinceType = TfProvinceType::find($typeId);
            return view('manage.content.system.province-type.view', compact('dataProvinceType'));
        }
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $accessObject = 'content';
        return view('manage.content.system.province-type.add', compact('accessObject'));
    }

    # add new
    public function postAdd()
    {
        $modelProvinceType = new TfProvinceType();
        $name = Request::input('txtName');

        // check exist of name
        if ($modelProvinceType->existName($name)) {
            Session::put('notifyAddProvinceType', "Add fail, '$name' exists.");
        } else {
            if ($modelProvinceType->insert($name)) {
                Session::put('notifyAddProvinceType', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddProvinceType', 'Add fail, Enter info to try again');
            }
        }
    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($provinceTypeId)
    {
        $dataProvinceType = TfProvinceType::find($provinceTypeId);
        if (count($dataProvinceType) > 0) {
            return view('manage.content.system.province-type.edit', compact('dataProvinceType'));
        }
    }

    # edit
    public function postEdit($provinceTypeId)
    {
        $modelProvinceType = new TfProvinceType();
        $name = Request::input('txtName');

        // if exist name <> the type is editing
        if ($modelProvinceType->existEditName($provinceTypeId, $name)) {
            return "Add fail, Name '$name' exists.";
        } else {
            $modelProvinceType->updateInfo($provinceTypeId, $name);
        }
    }

    # update status
    public function statusUpdate($typeId)
    {
        $modelType = new TfProvinceType();
        if (!empty($typeId)) {
            $currentStatus = $modelType->status($typeId);
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelType->updateStatus($typeId, $newStatus);
        }
    }

    # delete
    public function deleteProvinceType($provinceTypeId)
    {
        if (!empty($provinceTypeId)) {
            $modelProvinceType = new TfProvinceType();
            $modelProvinceType->actionDelete($provinceTypeId);
        }
    }
}
