<?php namespace App\Http\Controllers\Manage\Content\System\ConvertType;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\ConvertType\TfConvertType;
use DB;
use File;
use Request;

class ConvertTypeController extends Controller
{
    #========== ========== ========== GET INFO ========== ========== ==========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelConvertType = new TfConvertType();
        $accessObject = 'point';
        $dataConvertType = TfConvertType::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        return view('manage.content.system.convert-type.list', compact('modelStaff', 'modelConvertType', 'dataConvertType', 'accessObject'));
    }

    #view
    public function viewPointType($convertTypeId = null)
    {
        $dataConvertType = TfConvertType::find($convertTypeId);
        if (count($dataConvertType)) {
            return view('manage.content.system.convert-type.view', compact('dataConvertType'));
        }

    }
    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        $accessObject = 'point';
        return view('manage.content.system.convert-type.add', compact('accessObject'));
    }

    # add
    public function postAdd()
    {
        $dataConvertType = new TfConvertType();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');

        // check exist of name
        if ($dataConvertType->existName($name)) {
            Session::put('notifyAddConvertType', "Add fail, Name <b>'$name'</b> exists.");

        } else {
            if ($dataConvertType->insert($name, $description)) {
                Session::put('notifyAddConvertType', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddConvertType', 'Add fail, Enter info to try again');
            }
        }
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($convertTypeId = null)
    {
        $dataConvertType = TfConvertType::find($convertTypeId);
        if (count($dataConvertType)) {
            return view('manage.content.system.convert-type.edit', compact('dataConvertType'));
        }

    }

    # edit
    public function postEdit($convertTypeId = '')
    {
        $modelConvertType = new TfConvertType();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');

        // if exist name <> the type is editing
        if ($modelConvertType->existEditName($convertTypeId, $name)) {
            return "Add fail, Name <b>'$name'</b> exists.";
        } else {
            $modelConvertType->updateInfo($convertTypeId, $name, $description);
        }
    }

    # delete
    public function deleteConvertType($convertTypeId = '')
    {
        if (!empty($convertTypeId)) {
            $modelConvertType = new TfConvertType();
            $modelConvertType->actionDelete($convertTypeId);
        }
    }


}
