<?php namespace App\Http\Controllers\Manage\Content\System\LinkRun;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\System\LinkRun\TfLinkRun;
use DB;
use File;
use Request;

class LinkRunController extends Controller
{
    #========== ========== ========== GET INFO ========== ========== ==========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelLinkRun = new TfLinkRun();
        $dataLinkRun = TfLinkRun::where('action', 1)->orderBy('created_at', 'DESC')->select('*')->paginate(30);
        $accessObject = 'content';
        return view('manage.content.system.link-run.list', compact('modelStaff', 'modelLinkRun', 'dataLinkRun', 'accessObject'));
    }

    #view
    public function viewLink($linkId)
    {
        $modelLink = new TfLinkRun();
        if (!empty($linkId)) {
            $dataLinkRun = $modelLink->getInfo($linkId);
            return view('manage.content.system.link-run.view', compact('dataLinkRun'));
        }
    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        $accessObject = 'content';
        return view('manage.content.system.link-run.add', compact('accessObject'));
    }

    # add new
    public function postAdd()
    {
        $modelStaff = new TfStaff();
        $modelLinkRun = new TfLinkRun();
        $staffId = $modelStaff->loginStaffID();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');
        $link = Request::input('txtLink');

        $newLink = str_replace("http://", "", str_replace("https://", "", $link));
        // check exist of name
        if ($modelLinkRun->existName($name)) {
            Session::put('notifyAddLinkRun', "Add fail, Name <b>'$name'</b> exists.");
        }else{
            if ($modelLinkRun->insert($name, $description, $newLink, $staffId)) {
                Session::put('notifyAddLinkRun', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddLinkRun', 'Add fail, Enter info to try again');
            }
        }
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($linkId=null)
    {
        $modelLink = new TfLinkRun();
        $dataLinkRun = $modelLink->getInfo($linkId);
        if(count($dataLinkRun) > 0){
            return view('manage.content.system.link-run.edit', compact('dataLinkRun'));
        }
    }

    # edit
    public function postEdit($linkId = null)
    {
        $modelLinkRun = new TfLinkRun();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');
        $link = Request::input('txtLink');

        # if exists name <> the link is editing
        if ($modelLinkRun->existEditName($name, $linkId)) {
            return "Add fail, Name <b>'$name'</b> exists.";
        }else{
            $newLink = str_replace("http://", "", str_replace("https://", "", $link));
            $modelLinkRun->updateInfo($linkId, $name, $description, $newLink);

        }
    }

    # update status
    public function statusUpdate($linkId)
    {
        $modelLink = new TfLinkRun();
        if (!empty($linkId)) {
            $currentStatus = $modelLink->getInfo($linkId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelLink->updateStatus($linkId, $newStatus);
        }
    }

    # delete
    public function deleteLink($linkId = '')
    {
        if (!empty($linkId)) {
            $modelLinkRun = new TfLinkRun();
            $modelLinkRun->actionDelete($linkId);
        }
    }

}
