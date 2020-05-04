<?php namespace App\Http\Controllers\Login;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Users\TfUser;
use Request;
use File;

class LoginController extends Controller
{

    #========== ========== ========== login =========== ========= ==========
    public function checkStatus()
    {
        $modelUser = new TfUser();
        $result = $modelUser->checkLogin();
        return ($result == true) ? 1 : 0;
    }

    public function getLogin($returnUrl = null)
    {
        return view('components.login.login-form', compact('returnUrl'));
    }

    public function postLogin($account=null,$password=null)
    {
        $modelUser = new TfUser();
        //---temporary solution
        if (!$modelUser->login($account, $password)) {
            echo "Sorry!, wrong your account or password";
        } else {
            if ($modelUser->loginUserInfo('confirm') == 0) {
                echo "Sorry!, this account unconfirmed <br/>Please check mail to Conform";
                $modelUser->logout();
            }
        }
    }
    /*public function postLogin()
    {
        $modelUser = new TfUser();
        $account = Request::input('txtAccount');
        $password = Request::input('txtPass');
        //---temporary solution
        if (!$modelUser->login($account, $password)) {
            echo "Sorry!, wrong your account or password";
        } else {
            if ($modelUser->loginUserInfo('confirm') == 0) {
                echo "Sorry!, this account unconfirmed";
                $modelUser->logout();
            }
        }
    }*/

    #========== ========== ========== FORGET PASSWORD =========== ========= ==========
    public function getForgetPassword()
    {
        return view('components.login.forget-password.password-get');
    }

    public function postForgetPassword()
    {
        $hFunction = new \Hfunction();
        $mailObject = new \Mail3dtf();
        $modelUser = new TfUser();
        $account = Request::input('txtAccount');
        $result = array(
            'status' => '',
            'content' => ''
        );
        $dataUser = $modelUser->getInfoOfAccount($account);
        if (count($dataUser) > 0) {
            $newPassword = $hFunction->random(6, 'int');
            if ($modelUser->updatePassword($dataUser->user_id, $newPassword)) {
                $userName = $dataUser->firstName . ' ' . $dataUser->lastName;
                $href = route('tf.home');
                $message = "Hi $userName
                            New your password to login on 3dtf.com : $newPassword.
                            Click the link below to access 3dtf.com
                            $href";
                $mailObject->sendEmailInfo3D('3DTF.COM', $account, $message);
                $result['status'] = 'success';
                $result['content'] = "<h3>New password sent to your email.</h3>";
            } else {
                $result['status'] = 'fail';
                $result['content'] = 'Fail. Please, Enter info to again';
            }

        } else {
            $result['status'] = 'fail';
            $result['content'] = 'This account is not exist. Please, Enter your account';
        }
        die(json_encode($result));
    }
}
