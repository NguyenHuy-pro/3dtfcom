<?php namespace App\Http\Controllers\Manage\Content\System\Province;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Country\TfCountry;
use App\Models\Manage\Content\System\ProvinceType\TfProvinceType;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\System\Province\TfProvince;
//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class ProvinceController extends Controller
{
    #=========== =========== =========== GET INFO =========== =========== ===========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelProvince = new TfProvince();
        $modelCountry = new TfCountry();
        $dataProvince = TfProvince::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        return view('manage.content.system.province.list', compact('modelStaff','modelProvince','modelCountry','dataProvince'),
            [
                '$accessObject' => 'content'
            ]);
    }

    #view
    public function viewProvince($provinceId)
    {
        $dataProvince = TfProvince::find($provinceId);
        if (count($dataProvince) > 0) {
            return view('manage.content.system.province.view', compact('dataProvince'));
        }
    }

    # filter
    public function getFilter($filterCountryId = '')
    {
        $modelStaff = new TfStaff();
        $modelProvince = new TfProvince();
        $modelCountry = new TfCountry();
        if (empty($filterCountryId)) { // all country
            return redirect()->route('tf.m.c.system.province.list');
        } else {  // select an country
            $dataProvince = TfProvince::where('country_id', $filterCountryId)->where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
            return view('manage.content.system.province.list', compact('modelStaff','modelProvince','modelCountry','dataProvince', 'filterCountryId'));
        }
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $modelStaff = new TfStaff();
        $modelProvinceType = new TfProvinceType();
        $modelCountry = new TfCountry();

        return view('manage.content.system.province.add', compact('modelStaff','modelCountry','modelProvinceType'),
            [
                'accessObject' => 'content'
            ]);
    }

    # add new
    public function postAdd()
    {
        $modelProvince = new TfProvince();
        $name = Request::input('txtName');
        $countryId = Request::input('cbCountry');
        $provinceTypeId = Request::input('cbProvinceType');

        if ($modelProvince->existName($name)) {  # check exist of name
            Session::put('notifyAddProvince', "Add fail, nam <b>'$name'</b> is existing.");
        } else {
            if ($modelProvince->insert($name, 0, 0, $countryId, $provinceTypeId)) {
                Session::put('notifyAddProvince', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddProvince', 'Add fail, Enter info to try again');
            }
        }
    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($provinceId)
    {
        $modelProvinceType = new TfProvinceType();
        $modelCountry = new TfCountry();
        $dataProvince = TfProvince::find($provinceId);
        if (count($dataProvince)) {
            return view('manage.content.system.province.edit', compact('modelStaff','modelCountry','modelProvinceType','dataProvince'));
        }
    }

    # edit info
    public function postEdit($provinceId = '')
    {
        $modelProvince = new TfProvince();
        $name = Request::input('txtName');
        $countryId = Request::input('cbCountry');
        $provinceTypeId = Request::input('cbProvinceType');
        if ($modelProvince->existEditName($name, $provinceId)) { # if exist name <> the type is editing
            Session::put('notifyEditProvince', "Add fail, Name <b> '$name'</b> is existing.");
            return redirect()->back();
        } else {
            $modelProvince->updateInfo($provinceId, $name,$provinceTypeId, $countryId);
        }
    }

    #=========== =========== =========== BUILD 3D =========== =========== ===========
    # get form build 3d
    public function getBuild3d($provinceId)
    {
        $dataStaff = TfStaff::where([
            'department_id' => 5,
            'level' => 1,
            'status' => 1,
            'action' => 1
        ])->select('staff_id as optionKey', 'account as optionValue')->get()->toArray();
        return view('manage.content.system.province.build-3d', compact('provinceId', 'dataStaff'));
    }

    # build 3d
    public function postBuild3d($provinceId = '')
    {
        $modelProvinces = new TfProvince();
        $staffManageId = Request::input('cbManager');
        $modelProvinces->build3d($provinceId, $staffManageId);
    }

    # update status
    public function statusUpdate($provinceId)
    {
        $modelProvince = new TfProvince();
        if (!empty($provinceId)) {
            $currentStatus = $modelProvince->getInfo($provinceId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelProvince->updateStatus($provinceId, $newStatus);
        }
    }

    # delete
    public function deleteProvince($provinceId = '')
    {
        if (!empty($provinceId)) {
            $modelProvince = new TfProvince();
            $modelProvince->actionDelete($provinceId);
        }
    }

}
