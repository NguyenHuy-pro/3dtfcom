<?php namespace App\Http\Controllers\Manage\Content\System\Notify;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\System\NotifyUser\TfNotifyUser;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\System\Notify\TfNotify;
use App\Models\Manage\Content\System\Staff\TfStaff;
#use Illuminate\Http\Request;

use Request;
use Input;

class NotifyController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelNotify = new TfNotify();
        $dataNotify = TfNotify::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'content';
        return view('manage.content.system.notify.list', compact('modelStaff', 'modelNotify', 'dataNotify', 'accessObject'));
    }

    #view
    public function viewNotify($notifyId = null)
    {
        if (!empty($notifyId)) {
            $dataNotify = TfNotify::find($notifyId);
            if (!empty($dataNotify)) {
                return view('manage.content.system.notify.view', compact('dataNotify'));
            }
        }

    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        return view('manage.content.system.notify.add');
    }

    # add
    public function postAdd(Request $request)
    {
        $modelStaff = new TfStaff();
        $modelUser = new TfUser();
        $modelNotify = new TfNotify();
        $modelNotifyUser = new TfNotifyUser();
        $name = Request::input('txtName');
        $content = Request::input('txtContent');
        $staffLoginId = $modelStaff->loginStaffID();
        if ($modelNotify->insert($name, $content, $staffLoginId)) {
            $newNotifyId = $modelNotify->insertGetId();
            $listUserId = $modelUser->idListIsUsing();
            if (count($listUserId) > 0) {
                foreach ($listUserId as $id) {
                    $modelNotifyUser->insert($newNotifyId, $id);
                }
            }
            return Session::put('notifyAddNotify', 'Add success, Enter info to continue');
        } else {
            return Session::put('notifyAddNotify', 'Add fail, Enter info to try again');
        }
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($notifyId = null)
    {
        if (!empty($notifyId)) {
            $dataNotify = TfNotify::find($notifyId);
            if (!empty($notifyId)) {
                return view('manage.content.system.notify.edit', compact('dataNotify'));
            }
        }

    }

    # edit info
    public function postEdit($notifyId = null)
    {
        $modelNotify = new TfNotify();
        $name = Request::input('txtName');
        $content = Request::input('txtContent');
        if (!empty($notifyId)) {
            $modelNotify->updateInfo($name, $content, $notifyId);
        }

    }

    # delete
    public function deleteNotify($notifyId = null)
    {
        if (!empty($notifyId)) {
            $modelNotify = new TfNotify();
            $modelNotify->drop($notifyId);
        }
        return redirect()->back();
    }

}
