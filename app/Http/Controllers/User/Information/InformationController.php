<?php namespace App\Http\Controllers\User\Information;

use App\Http\Requests;
use App\Http\Controllers\Controller;

#use Illuminate\Http\Request;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\Country\TfCountry;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\Users\Contact\TfUserContact;
use App\Models\Manage\Content\Users\TfUser;
use Request;
use Input;

class InformationController extends Controller
{

    #---------- ---------- Information ---------- ----------
    public function index($userId = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        if (!empty($userId)) {
            $dataUser = $modelUser->getInfo($userId);
            if (count($dataUser) > 0) {
                $dataAccess = [
                    'accessObject' => 'info'
                ];
                return view('user.information.information', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
            } else {
                return redirect()->route('tf.home');
            }
        } else {
            return redirect()->route('tf.home');
        }
    }

    #---------- Basic info -----------
    public function getInfoBasicEdit()
    {
        $modelUser = new TfUser();
        if ($modelUser->checkLogin()) {
            $dataUser = TfUser::find($modelUser->loginUserId());
            return view('user.information.basic.basic-edit', compact('dataUser'));
        }
    }

    public function postInfoBasicEdit()
    {
        $modelUser = new TfUser();
        if ($modelUser->checkLogin()) {
            $userLoginId = $modelUser->loginUserId();
            $firstName = Request::input('txtFirstName');
            $lastNameName = Request::input('txtLastName');
            $birthdayName = Request::input('txtBirthday');
            $gender = Request::input('cbGender');
            $modelUser->updateBasicInfo($userLoginId, $firstName, $lastNameName, $birthdayName, $gender);
            $modelUser->refreshLoginInfo($userLoginId);
            /*$dataUser = $modelUser->getInfo($userLoginId);
            return view('user.information.basic.basic', compact('dataUser'));*/
        }
    }

    #---------- Contact info -----------
    public function getInfoContactEdit()
    {
        $modelUser = new TfUser();
        $modelProvince = new TfProvince();
        $modelCountry = new TfCountry();
        if ($modelUser->checkLogin()) {
            $dataUserContact = $modelUser->contactInfo($modelUser->loginUserId());
            return view('user.information.contact.contact-edit', compact('dataUserContact', 'modelCountry', 'modelProvince'));
        }
    }

    //get province
    public function contactGetProvince($countryId)
    {
        $modelProvince = new TfProvince();
        return view('user.information.contact.select-province', compact('modelProvince'), ['provinceId' => null, 'countryId' => $countryId]);
    }

    public function postInfoContactEdit()
    {
        $modelUser = new TfUser();
        $modelUserContact = new TfUserContact();
        $address = Request::input('txtAddress');
        $phone = Request::input('txtPhone');
        $email = Request::input('txtEmail');
        $province = Request::input('cbProvince');
        $address = (empty($address)) ? null : $address;
        $phone = (empty($phone)) ? null : $phone;
        $email = (empty($email)) ? null : $email;
        $province = (empty($province)) ? null : $province;
        if ($modelUser->checkLogin()) {
            $userLoginId = $modelUser->loginUserId();
            $modelUserContact->updateInfoOfUser($userLoginId, $address, $phone, $email, $province);
            $modelUser->refreshLoginInfo($userLoginId);
        }
        #return view('user.information.password-edit');
    }

    #---------- Password info -----------
    public function getInfoPasswordEdit()
    {
        return view('user.information.account.account-edit');
    }

    public function postInfoPasswordEdit()
    {
        $modelUser = new TfUser();
        $oldPassword = Request::input('txtOldPassword');
        $newPassword = Request::input('txtNewPassword');
        if ($modelUser->checkLogin()) {
            $dataUserLogin = $modelUser->loginUserInfo();
            $result = array(
                'status' => '',
                'content' => ''
            );
            # check password
            if ($modelUser->createUserPass($oldPassword, $dataUserLogin->nameCode) != $dataUserLogin->password) {
                $result['status'] = 'fail';
                $result['content'] = 'Wrong password, Enter your password';
            } else {
                $result['status'] = 'success';
                $result['content'] = 'You change password success';
                $modelUser->updatePassword($dataUserLogin->userId(), $newPassword);
            }
            die(json_encode($result));
        }
    }

}
