<?php namespace App\Http\Controllers\Manage\Content\System\BadInfo;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\BadInfo\TfBadInfo;
//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class BadInfoController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBadInfo = new TfBadInfo();
        $dataBadInfo = TfBadInfo::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        return view('manage.content.system.bad-info.list', compact('modelStaff', 'modelBadInfo', 'dataBadInfo'));
    }

    #view
    public function viewBadInfo($badInfoId)
    {
        if (!empty($badInfoId)) {
            $dataBadInfo = TfBadInfo::find($badInfoId);
            return view('manage.content.system.bad-info.view', compact('dataBadInfo'));
        }
    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        return view('manage.content.system.bad-info.add');
    }

    # add new
    public function postAdd(Request $request)
    {
        $modelBadInfo = new TfBadInfo();
        $name = Request::input('txtName');
        $modelBadInfo->name = $name;

        // check exist of name
        if ($modelBadInfo->existName($name)) {
            Session::put('notifyAddBadInfo', 'Add fail, This Name exists.');
        } else {
            if ($modelBadInfo->insert($name)) {
                Session::put('notifyAddBadInfo', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddBadInfo', 'Add fail, Enter info to try again');
            }
        }

    }

    #========== ========== ========== EDIT INFO========== ========== ==========
    # get form edit
    public function getEdit($badInfoId)
    {
        $dataBadInfo = TfBadInfo::find($badInfoId);
        if (count($dataBadInfo) > 0) {
            return view('manage.content.system.bad-info.edit', compact('dataBadInfo'));
        }
    }

    # edit info
    public function postEdit($badInfoId = '')
    {
        $modelBadInfo = new TfBadInfo();
        $name = Request::input('txtName');

        // if exist name <> the type is editing
        if ($modelBadInfo->existEditName($badInfoId, $name)) {
            return "Add fail, Name '$name' exists.";
        } else {
            $modelBadInfo->updateInfo($badInfoId, $name);
        }
    }

    # delete
    public function deleteBadInfo($badInfoId = null)
    {
        if (!empty($badInfoId)) {
            $modelBadInfo = new TfBadInfo();
            $modelBadInfo->actionDelete($badInfoId);
        }
    }

}
