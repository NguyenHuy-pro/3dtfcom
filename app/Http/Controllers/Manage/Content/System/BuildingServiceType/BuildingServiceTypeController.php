<?php namespace App\Http\Controllers\Manage\Content\System\BuildingServiceType;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Models\Manage\Content\System\BuildingServiceType\TfBuildingServiceType;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use DB;
use File;
use Request;

class BuildingServiceTypeController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    // get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBuildingServiceType = new TfBuildingServiceType();
        $dataBuildingServiceType = TfBuildingServiceType::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'tool';
        return view('manage.content.system.building-service-type.list', compact('modelStaff', 'modelBuildingServiceType', 'dataBuildingServiceType', 'accessObject'));
    }

    //view
    public function viewBuildingServiceType($typeId)
    {
        $modelBuildingServiceType = new TfBuildingServiceType();
        if (!empty($typeId)) {
            $dataBuildingServiceType = $modelBuildingServiceType->getInfo($typeId);
            return view('manage.content.system.building-service-type.view', compact('dataBuildingServiceType'));
        }
    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    //get form add
    public function getAdd()
    {
        $accessObject = 'tool';
        return view('manage.content.system.building-service-type.add', compact('accessObject'));
    }

    //add new
    public function postAdd()
    {
        $modelBuildingServiceType = new TfBuildingServiceType();
        $name = Request::input('txtName');

        if ($modelBuildingServiceType->existName($name)) {
            Session::put('notifyAddBuildingServiceType', "Add fail, Name <b>'$name'</b> exists.");
        } else {
            if ($modelBuildingServiceType->insert($name)) {
                Session::put('notifyAddBuildingServiceType', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddBuildingServiceType', 'Add fail, Enter info to try again');
            }
        }

    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    //get form edit
    public function getEdit($typeId)
    {
        $modelBuildingServiceType = new TfBuildingServiceType();
        $dataBuildingServiceType = $modelBuildingServiceType->getInfo($typeId);
        if (count($dataBuildingServiceType) > 0) {
            return view('manage.content.system.building-service-type.edit', compact('dataBuildingServiceType'));
        }
    }

    //edit
    public function postEdit($typeId)
    {
        $modelBuildingServiceType = new TfBuildingServiceType();
        $name = Request::input('txtName');

        //if exist name <> the type is editing
        if ($modelBuildingServiceType->existEditName($name, $typeId)) {
            return "Add fail, Name <b>'$name'</b> exists.";
        } else {
            $modelBuildingServiceType->updateInfo($typeId, $name);
        }
    }

    //delete
    public function deleteBuildingServiceType($typeId = '')
    {
        if (!empty($typeId)) {
            $modelBuildingServiceType = new TfBuildingServiceType();
            $modelBuildingServiceType->actionDelete($typeId);
        }
    }


}
