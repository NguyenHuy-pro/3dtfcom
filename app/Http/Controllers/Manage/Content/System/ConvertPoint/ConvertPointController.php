<?php namespace App\Http\Controllers\Manage\Content\System\ConvertPoint;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\System\ConvertPoint\TfConvertPoint;
use App\Models\Manage\Content\System\ConvertType\TfConvertType;
use App\Models\Manage\Content\System\Staff\TfStaff;
#use Illuminate\Http\Request;

use DB;
use File;
use Request;

class ConvertPointController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelConvertPoint = new TfConvertPoint();

        $accessObject = 'point';
        $dataConvertPoint = TfConvertPoint::where('action', 1)->orderBy('created_at', 'DESC')->select('*')->paginate(30);
        return view('manage.content.system.convert-point.list', compact('modelStaff', 'modelConvertPoint', 'dataConvertPoint', 'accessObject'));
    }

    #view
    public function viewConvertPoint($convertId)
    {
        $dataConvertPoint = TfConvertPoint::find($convertId);
        if (count($dataConvertPoint)) {
            return view('manage.content.system.convert-point.view', compact('dataConvertPoint'));
        }
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $modelConvertType = new TfConvertType();
        $accessObject = 'point';
        return view('manage.content.system.convert-point.add', compact('modelConvertType', 'accessObject'));
    }

    # add
    public function postAdd()
    {
        $modelStaff = new TfStaff();
        $modelConvertType = new TfConvertType();
        $modelConvertPoint = new TfConvertPoint();
        $point = Request::input('txtPoint');
        $convertPoint = Request::input('txtConvertValue');
        $convertTypeId = Request::input('cbConvertType');

        $convertPointId = $modelConvertPoint->convertIdOfType($convertTypeId);

        if ($modelConvertPoint->insert($point, $convertPoint, $convertTypeId, $modelStaff->loginStaffID())) {
            if (!empty($convertPointId)) $modelConvertPoint->actionDelete($convertPointId);
            Session::put('notifyAddConvertPoint', 'Add success, Enter info to continue');
        } else {
            Session::put('notifyAddConvertPoint', 'Add fail, Enter info to try again');
        }
    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($convertId = '')
    {
        $dataConvertPoint = TfConvertPoint::find($convertId);
        if (count($dataConvertPoint)) {
            return view('manage.content.system.convert-point.edit', compact('dataConvertPoint'));
        }

    }

    # edit info
    public function postEdit($convertId)
    {
        $modelConvertPoint = new TfConvertPoint();
        $point = Request::input('txtPoint');
        $convertPoint = Request::input('txtConvertValue');

        $modelConvertPoint->updateInfo($convertId, $point, $convertPoint);
    }

    # delete
    public function deleteConvertPoint($convertId = '')
    {
        if (!empty($convertId)) {
            $modelConvertPoint = new TfConvertPoint();
            $modelConvertPoint->actionDelete($convertId);
        }
    }

}
