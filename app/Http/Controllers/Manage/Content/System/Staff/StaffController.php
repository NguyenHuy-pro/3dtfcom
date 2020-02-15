<?php namespace App\Http\Controllers\Manage\Content\System\Staff;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Country\TfCountry;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\System\StaffManage\TfStaffManage;
use App\Models\Manage\Content\System\Department\TfDepartment;
use App\Models\Manage\Content\System\Province\TfProvince;
use Input;
use File;
use DB;
use Request;

class StaffController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    # get list
    public function getList()
    {
        $modelStaff = new TfStaff();
        $dataStaff = TfStaff::where('action', 1)->orderBy('staff_id', 'ASC')->select('*')->paginate(30);
        return view('manage.content.system.staff.list', compact('modelStaff', 'dataStaff'));
    }

    # get detail info
    public function viewStaff($staffId)
    {
        if (!empty($staffId)) {
            $dataStaff = TfStaff::find($staffId);
            return view('manage.content.system.staff.view', compact('dataStaff'));
        }
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # select manage staff
    public function selectMangeStaff($departmentId = '')
    {
        if (Request::ajax()) {
            $dataStaff = TfStaff::where('department_id', $departmentId)->where('level', 1)->select('staff_id as optionKey', 'account as optionValue')->get()->toArray();
            return view('manage.content.system.staff.select-manage-staff', compact('dataStaff'));
        }
    }

    public function selectProvince($countryId = '')
    {
        if (Request::ajax()) {
            $dataProvince = TfProvince::where('country_id', $countryId)->select('province_id as optionKey', 'name as optionValue')->get()->toArray();
            return view('manage.content.system.staff.select-province', compact('dataProvince'));
        }
    }

    # add new
    public function getAdd()
    {
        $modelDepartment = new TfDepartment();
        $modelCountry = new TfCountry();
        return view('manage.content.system.staff.add', compact('modelCountry', 'modelDepartment'));
    }

    public function postAdd()
    {
        $hFunction = new \Hfunction();
        $mailObject = new \Mail3dtf();
        $modelStaff = new TfStaff();
        $firstName = Request::input('txtFirstName');
        $lastName = Request::input('txtLastName');
        $birthDay = Request::input('txtBirthday');
        $gender = Request::input('cbGender');
        $level = Request::input('cbLevel');
        $departmentId = Request::input('cbDepartment');
        $account = Request::input('txtAccount');
        $provinceId = Request::input('cbProvince');
        $address = Request::input('txtAddress');
        $phone = Request::input('txtPhone');
        $token = Request::input('_token');

        $staffAddId = $modelStaff->loginStaffID();

        if ($modelStaff->existAccount($account)) { # exists account
            return Session::put('notifyAddStaff', "Add fail, account '$account' is exists.");
        }
        if (Input::hasFile('txtImage')) { # exist avatar of staff
            $file = Request::file('txtImage');
            $imageName = $file->getClientOriginalName();
            $imageName = $hFunction->alias($firstName . '-' . $lastName) . '-' . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
            $pathFullImage = "public/images/system/staff/full/";
            $pathSmallImage = "public/images/system/staff/small/";
            $hFunction->uploadSave($file, $pathSmallImage, $pathFullImage, $imageName, 200);

        } else {
            $imageName = null;
        }
        if ($modelStaff->insert($firstName, $lastName, $account, $birthDay, $gender, $imageName, $address, $phone, $level, $staffAddId, $departmentId, $provinceId, $token)) {
            $newStaffId = $modelStaff->insertGetId();
            if ($level != 0) {
                $modelStaffManage = new TfStaffManage();
                if ($level == 1) {
                    $managerId = $modelStaff->rootStaffOfDepartment($departmentId);
                } else {
                    $managerId = Request::input('cbManageStaff');
                }
                $modelStaffManage->insert($managerId, $newStaffId);

                #send email to new staff
                $url = route('tf.m.c.system.staff.account.confirm.get');
                $confirmCode = $modelStaff->getInfo($newStaffId, 'password');
                $content = " Welcome $firstName, $lastName to 3DTF.COM
                             Your verification code:  $confirmCode
                             Click $url to verify your account ";
                $mailObject->sendFromGmail('3DTF.COM', $account, $content);
                /*
                $dataNotify = ['verificationCode' => $newPass, 'link' => $url];
                Mail::send('emails.manage.staff.confirm-notify', $dataNotify, function ($msg) use ($account) {
                    $msg->from('hoang3d.com@gmail.com', '3dtf.com');
                    $msg->to($account, 'welcome')->subject('send from 3dtf.com');
                });
                */
            }
            return Session::put('notifyAddStaff', 'Add success, Enter info to continue');
        } else {
            return Session::put('notifyAddStaff', 'Add fail, Enter info to try again');
        }

    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    public function getEdit($staffId)
    {
        $modelStaff = new TfStaff();
        $modelDepartment = new TfDepartment();
        $modelStaffManage = new TfStaffManage();
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();

        $dataStaff = TfStaff::find($staffId);
        if (count($dataStaff) > 0) {
            return view('manage.content.system.staff.edit', compact('modelStaff', 'modelDepartment', 'modelStaffManage', 'modelCountry', 'modelProvince', 'dataStaff'));
        }
    }

    public function postEdit($staffId)
    {
        /*
        $modelStaff = TfStaff::find($staffId);
        $hObject = new \Hfunction();
        $firstName = Request::input('txtFirstName');
        $lastName = Request::input('txtLastName');
        $birthDay = Request::input('txtBirthday');
        $gender = Request::input('cbGender');
        $level = Request::input('cbLevel');
        $departmentId = Request::input('cbDepartment');
        $provinceId = Request::input('cbProvince');
        $address = Request::input('txtAddress');
        $phone = Request::input('txtPhone');
        if (Input::hasFile('txtImage')) {
            $file = Request::file('txtImage');
            if (!empty($file)) {
                $oldImage = $modelStaff->image($staffId);
                $new_image = $file->getClientOriginalName();
                $new_image = $firstName . $lastName . $hObject->getTimeCode() . "." . $hObject->getTypeImg($new_image);
                if ($file->move('public/images/system/staff/image/', $new_image)) {
                    $oldSrc = "public/images/system/staff/image/$oldImage";
                    if (File::exists($oldSrc)) {
                        File::delete($oldSrc);
                    }
                }
                $modelStaff->image = $new_image;
            }

        }
        $modelStaff->firstName = $firstName;
        $modelStaff->lastName = $lastName;
        $modelStaff->alias = $hObject->alias($firstName . ' ' . $lastName, '-') . '-' . $staffId;
        $modelStaff->level = $level;
        $modelStaff->birthday = $birthDay;
        $modelStaff->gender = $gender;
        $modelStaff->address = $address;
        $modelStaff->phone = $phone;
        $modelStaff->department_id = $departmentId;
        $modelStaff->province_id = $provinceId;
        $modelStaff->save();
        return redirect()->route('tf.m.c.system.staff.getList');*/
    }

    # update status
    public function updateStatus($staffId)
    {
        $modelStaff = new TfStaff();
        if (!empty($staffId)) {
            $currentStatus = $modelStaff->getInfo($staffId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelStaff->updateStatus($staffId, $newStatus);
        }
    }

    #=========== =========== =========== CONFIRM =========== =========== ===========
    # confirm account
    public function getConfirmAccount()
    {
        return view('manage.content.system.staff.confirm-account');
    }

    public function postConfirmAccount()
    {
        $modelStaff = new TfStaff();
        $account = Request::input('txtAccount');
        $verificationCode = Request::input('txtVerificationCode');
        $password = Request::input('txtPassword');

        $dataStaff = $modelStaff->getInfoVerification($account, $verificationCode);
        if (empty($dataStaff)) {
            Session::put('notifyConfirmStaff', 'verification fail, wrong account or code');
            return redirect()->back();
        } else {
            $staffId = $dataStaff->staff_id;
            $nameCode = $dataStaff->nameCode;
            $modelStaff->confirmAccount($staffId, $password, $nameCode);
            return redirect()->route('tf.m.login.get');
        }

    }

    public function deleteStaff($staffId)
    {
        $modelStaff = new TfStaff();
        return $modelStaff->actionDelete($staffId);
    }

}
