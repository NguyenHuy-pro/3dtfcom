<?php namespace App\Http\Controllers\Manage;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class ManageController extends Controller
{

    public function index($name = '')
    {
        $modelStaff = new TfStaff();
        if ($modelStaff->checkLogin()) {
            $dataStaff = $modelStaff->loginStaffInfo();
            return view('manage.panel', compact('dataStaff'));
        } else {
            return view('manage.login.login-form');
        }
    }

    #=========== =========== =========== LOGOUT =========== =========== ===========
    public function getLogout()
    {
        $modelStaff = new TfStaff();
        $modelStaff->logout();
        return redirect()->route('tf.m.login.get');
    }
}
