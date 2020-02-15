<?php namespace App\Http\Controllers\System;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
#use Illuminate\Http\Request;

use App\Models\Manage\Content\System\Advisory\TfAdvisory;
use App\Models\Manage\Content\System\Notify\TfNotify;
use App\Models\Manage\Content\Users\TfUser;
use Request;
use Input;

class SystemController extends Controller
{
    public function getAbout()
    {
        $modelUser = new TfUser();
        $modelAbout = new TfAbout();
        $dataSystemAccess = [
            'accessObject' => 'about',
        ];
        $dataAbout = $modelAbout->getInfoActive();
        return view('system.about.about', compact('modelAbout', 'modelUser', 'dataSystemAccess', 'dataAbout'));
    }

    #========== ========== ========== Notification ========== ========== ==========
    public function getNotify()
    {
        $modelUser = new TfUser();
        $modelAbout = new TfAbout();
        $modelNotify = new TfNotify();
        $dataSystemAccess = [
            'accessObject' => 'notify',
        ];
        return view('system.notify.notify', compact('modelAbout', 'modelUser', 'modelNotify', 'dataSystemAccess'));
    }

    public function getMoreNotify($take = null, $dataTake = null)
    {
        $modelNotify = new TfNotify();
        if (!empty($take) && !empty($dataTake)) {
            $notifyInfo = $modelNotify->infoIsUsing($take, $dataTake);
            if (count($notifyInfo) > 0) {
                foreach ($notifyInfo as $dataNotify) {
                    echo view('system.notify.notify-object', compact('modelNotify', 'dataNotify'));
                }
            }
        }
    }

    public function viewNotify($notifyId = null)
    {
        if (!empty($notifyId)) {
            $dataNotify = TfNotify::find($notifyId);
            if (!empty($dataNotify)) {
                return view('system.notify.notify-view', compact('dataNotify'));
            }
        }
    }

    #========== ========== ========== Contact ========== ========== ==========
    # to contact
    public function getContact()
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataSystemAccess = [
            'accessObject' => 'contact',
        ];
        return view('system.contact.contact', compact('modelAbout', 'modelUser', 'dataSystemAccess'));
    }

    #add contact
    public function addContact()
    {
        $modelUser = new TfUser();
        $modeAdvisory = new TfAdvisory();
        $content = Request::input('txtContent');
        $name = Request::input('txtName');
        $email = Request::input('txtEmail');
        $phone = Request::input('txtPhone');

        $notifyAdd = array(
            'error' => 'success',
            'login' => '',
            'notifyContent' => ''
        );
        if (!$modelUser->checkLogin()) {
            $notifyAdd['error'] = 'fail';
            $notifyAdd['login'] = 'fail';
            $notifyAdd['notifyContent'] = 'You must login to use this function';
        } else {
            $loginId = $modelUser->loginUserID();
            $modeAdvisory->insert($content, $name, $phone, $email, $loginId);
            $notifyAdd['error'] = 'success';
            $notifyAdd['notifyContent'] = 'Information Contact send success';
        }

        die(json_encode($notifyAdd));
    }
}
