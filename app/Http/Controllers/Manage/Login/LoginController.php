<?php namespace App\Http\Controllers\Manage\Login;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\System\StaffAccess\TfStaffAccess;
use Request;
use Input;

class LoginController extends Controller
{

    # get form login
    public function getLogin()
    {
        return view('manage.login.login-form');
    }

    # login
    public function postLogin()
    {
        $hFunction = new \Hfunction();
        $modelStaff = new TfStaff();
        $modelStaffAccess = new TfStaffAccess();
        $account = Request::input('txtAccount');
        $pass = Request::input('txtPass');

        if ($modelStaff->login($account, $pass)) {
            $loginStaffId = $modelStaff->loginStaffID();
            $modelStaffAccess->updateAction($loginStaffId); # disable old access status
            $modelStaffAccess->insert($hFunction->getClientIP(), 1,$loginStaffId );
            return redirect()->route('tf.m.index');
        } else {
            Session::put('notifyLoginManage', "Login fail, Enter info to try again.");
            return redirect()->back();
        }
    }

}
