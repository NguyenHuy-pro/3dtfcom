<?php namespace App\Http\Controllers\Manage\Content\Help\Detail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

#use App\Models\Manage\Content\Help\Detail\TfHelpDetail;
use App\Models\Manage\Content\Help\Detail\TfHelpDetail;
use Illuminate\Support\Facades\Session;

#use Illuminate\Http\Request;
use Request;
use Input;
use DB;

class DetailController extends Controller
{

    public function getList()
    {
        $dataHelpDetail = TfHelpDetail::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'detail';
        return view('manage.content.help.detail.list', compact('dataHelpDetail', 'accessObject'));
    }

    #========== ========== Add ========== ==========
    public function getAdd()
    {
        return view('manage.content.help.detail.add');
    }

    public function postAdd()
    {
        $modelHelpDetail = new TfHelpDetail();
        $helpObjectId = Request::input('cbObject');
        $helpActionId = Request::input('cbAction');
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');
        $accessObject = 'detail';
        if ($modelHelpDetail->existName($name, $helpObjectId, $helpActionId)) {  // check exist of name
            Session::put('notifyAddHelpDetail', "Add fail, Name <b>'$name'</b> exists.");
            return view('manage.content.help.detail.add', compact('accessObject'));
        }
        if ($modelHelpDetail->insert($name, $description, $helpObjectId, $helpActionId)) {
            Session::put('notifyAddHelpDetail', 'Add success, Enter info to continue');
        } else {
            Session::put('notifyAddHelpDetail', 'Add fail, Enter info to try again');
        }
        return view('manage.content.help.detail.add', compact('accessObject'));

    }

    #========== ========== View ========== ==========
    public function getView($detailId)
    {
        $modelHelpDetail = new TfHelpDetail();
        $dataHelpDetail = $modelHelpDetail->getInfo($detailId);
        $accessObject = 'detail';
        return view('manage.content.help.detail.view', compact('dataHelpDetail', 'accessObject'));
    }

    #========== ========== Edit ========== ==========
    public function getEdit($detailId = '')
    {
        $modelHelpDetail = new TfHelpDetail();
        $dataHelpDetail = $modelHelpDetail->getInfo($detailId);
        $accessObject = 'detail';
        return view('manage.content.help.detail.edit', compact('dataHelpDetail', 'accessObject'));
    }

    public function postEdit($detailId = '')
    {
        $modelHelpDetail = new TfHelpDetail();
        $helpObjectId = Request::input('cbObject');
        $helpActionId = Request::input('cbAction');
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');
        if ($modelHelpDetail->existEditName($name, $helpObjectId, $helpActionId, $detailId)) {
            # if exist name <> the type is editing
            Session::put('notifyEditHelpDetail', "Add fail, Name <b>'$name'</b> exists.");
            return redirect()->back();
        } else {
            $modelHelpDetail->updateInfo($detailId, $name, $description, $helpObjectId, $helpActionId);
        }
        $dataHelpDetail = TfHelpDetail::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'detail';
        return redirect()->route('tf.m.c.help.detail.list.get', compact('dataHelpDetail', 'accessObject'));

    }

    #========== ========== Delete ========== ==========
    public function getDelete($detailId = '')
    {
        if (!empty($detailId)) {
            $dataHelpDetail = new TfHelpDetail();
            $dataHelpDetail->getDelete($detailId);
        }
        return redirect()->back();
    }

}
