<?php namespace App\Http\Controllers\Manage\Content\System\Country;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\System\Country\TfCountry;
use App\Models\Manage\Content\System\Province\TfProvince;
use Input;
use File;
use DB;
use Request;

class CountryController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelCountry = new TfCountry();
        $dataCountry = TfCountry::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        return view('manage.content.system.country.list', compact('modelStaff', 'modelCountry','dataCountry'),
            [
                'accessObject' => 'content'
            ]);
    }

    #view
    public function viewCountry($countryId)
    {
        $dataCountry = TfCountry::find($countryId);
        if (count($dataCountry)) {
            return view('manage.content.system.country.view', compact('dataCountry'));
        }
    }
    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        $accessObject = 'content';
        return view('manage.content.system.country.add', compact('accessObject'));
    }

    # add new
    public function postAdd()
    {
        $modelCountry = new TfCountry();
        $hObject = new \Hfunction();
        $name = Request::input('txtName');
        $code = Request::input('txtCode');
        $money = Request::input('txtMoney');

        #check exist name
        if ($modelCountry->existName($name)) {
            Session::put('notifyAddCountry', 'Add fail, This Name exists.');
        } elseif ($modelCountry->existCodeCountry($code)) {
            Session::put('notifyAddCountry', 'Add fail, This Code exists.');
        } else {
            if (Input::hasFile('txtFlag')) {
                $file = Request::file('txtFlag');
                $flag_name = $file->getClientOriginalName();
                $flagName = $name . $hObject->getTimeCode() . "." . $hObject->getTypeImg($flag_name);
                $file->move('public/images/system/country/flag/', $flagName);
            } else {
                $flagName = null;
            }
            if ($modelCountry->insert($name, $code, $flagName, $money, null)) {
                Session::put('notifyAddCountry', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddCountry', 'Add fail, Enter info to try again');
            }
        }
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($countryId)
    {
        $dataCountry = TfCountry::find($countryId);
        if (count($dataCountry) > 0) {
            return view('manage.content.system.country.edit', compact('dataCountry'));
        }
    }

    # edit info
    public function postEdit($countryId)
    {
        $modelCountry = new TfCountry();
        $hObject = new \Hfunction();
        $name = Request::input('txtName');
        $code = Request::input('txtCode');
        $money = Request::input('txtMoney');
        $oldFlag = $modelCountry->flagImage($countryId);

        # if exist name <> the country is editing
        if ($modelCountry->existEditName($name, $countryId)) {
            return "Add fail, Name '$name' exists.";
        }

        # if exist code <> the country is editing
        if ($modelCountry->existEditCodeCountry($code, $countryId)) {
            return "Add fail, Code '$code' exists.";
        } else {
            if (Input::hasFile('txtFlag')) {
                $file = Request::file('txtFlag');
                if (!empty($file)) {
                    $flag_name = $file->getClientOriginalName();
                    $flag_name = $name . $hObject->getTimeCode() . "." . $hObject->getTypeImg($flag_name);
                    if ($file->move('public/images/system/country/flag/', $flag_name)) {
                        $oldSrc = "public/images/system/country/flag/$oldFlag";
                        if (File::exists($oldSrc)) {
                            File::delete($oldSrc);
                        }
                    }
                }

            } else {
                $flag_name = $oldFlag;
            }
            $modelCountry->updateInfo($countryId, $name, $code, $flag_name, $money);
        }

    }

    #========== ========== ========== BUILD 3D ========== ========== ==========
    # get form build 3d
    public function getBuild3d($countryId = '')
    {
        $modelCountry = new TfCountry();
        $dataStaff = TfStaff::where([
            'department_id' => 5,
            'level' => 1,
            'confirm' => 1,
            'action' => 1
        ])->select('staff_id as optionKey', 'account as optionValue')->get()->toArray();
        $dataProvince = TfProvince::where('country_id', $countryId)->where('action', 1)->select('province_id as optionKey', 'name as optionValue')->get()->toArray();
        $dataCountry = $modelCountry->getInfo($countryId);
        return view('manage.content.system.country.build-3d', compact('dataCountry', 'dataStaff', 'dataProvince'));
    }

    # build 3d
    public function postBuild3d($provinceId)
    {
        $modelCountry = new TfCountry();
        $staffManageId = Request::input('cbManager');
        $defaultProvinceId = Request::input('cbProvince');
        $modelCountry->build3d($provinceId, $staffManageId, $defaultProvinceId);
    }

    # update status
    public function statusUpdate($countryId)
    {
        $modelCountry = new TfCountry();
        if (!empty($countryId)) {
            $currentStatus = $modelCountry->getInfo($countryId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelCountry->updateStatus($countryId, $newStatus);
        }
    }

    # delete
    public function deleteCountry($countryId = null)
    {
        if (!empty($countryId)) {
            $modelCountry = new TfCountry();
            $modelCountry->actionDelete($countryId);
        }
    }

}
