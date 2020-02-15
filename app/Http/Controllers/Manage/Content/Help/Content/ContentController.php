<?php namespace App\Http\Controllers\Manage\Content\Help\Content;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Help\Content\TfHelpContent;
use App\Models\Manage\Content\Help\Detail\TfHelpDetail;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;

#use Illuminate\Http\Request;
use Request;
use Input, DB;

class ContentController extends Controller
{

    public function getList()
    {
        $dataHelpContent = TfHelpContent::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'content';
        return view('manage.content.help.content.list', compact('dataHelpContent', 'accessObject'));
    }

    #========== ========== Add ========== ==========
    public function getAdd()
    {
        return view('manage.content.help.content.add');
    }

    public function postAdd()
    {
        $modelStaff = new TfStaff();
        $modelHelpContent = new TfHelpContent();
        $helpDetailId = Request::input('cbDetail');
        $name = Request::input('txtName');
        $content = Request::input('txtContent');
        $accessObject = 'content';

        $staffId = $modelStaff->loginStaffID();
        if ($modelHelpContent->existName($name)) {  // check exist of name
            Session::put('notifyAddHelpContent', "Add fail, Name <b>'$name'</b> exists.");
            return view('manage.content.help.detail.add', compact('accessObject'));
        }
        if ($modelHelpContent->insert($name, $content, $helpDetailId, $staffId)) {
            Session::put('notifyAddHelpContent', 'Add success, Enter info to continue');
        } else {
            Session::put('notifyAddHelpContent', 'Add fail, Enter info to try again');
        }
        return view('manage.content.help.content.add', compact('accessObject'));

    }

    #========== ========== View ========== ==========
    public function getView($contentId)
    {
        $modelHelpContent = new TfHelpContent();
        $dataHelpContent = $modelHelpContent->getInfo($contentId);
        $accessObject = 'content';
        return view('manage.content.help.content.view', compact('dataHelpContent', 'accessObject'));
    }

    #========== ========== Edit ========== ==========
    public function getEdit($contentId = '')
    {
        $modelHelpContent = new TfHelpContent();
        $dataHelpContent = $modelHelpContent->getInfo($contentId);
        $accessObject = 'content';
        return view('manage.content.help.content.edit', compact('dataHelpContent', 'accessObject'));
    }

    public function postEdit($contentId = '')
    {
        $modelHelpContent = new TfHelpContent();
        $helpDetailId = Request::input('cbDetail');
        $name = Request::input('txtName');
        $content = Request::input('txtContent');
        if ($modelHelpContent->existEditName($name, $contentId)) {
            # if exist name <> the type is editing
            Session::put('notifyEditHelpDetail', "Add fail, Name <b>'$name'</b> exists.");
            return redirect()->back();
        } else {
            $modelHelpContent->updateInfo($contentId, $name, $content, $helpDetailId);
        }
        $dataHelpContent = TfHelpContent::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'content';
        return redirect()->route('tf.m.c.help.content.list.get', compact('dataHelpContent', 'accessObject'));

    }

    #========== ========== Delete ========== ==========
    public function getDelete($contentId = '')
    {
        if (!empty($contentId)) {
            $dataHelpContent = new TfHelpContent();
            $dataHelpContent->getDelete($contentId);
        }
        return redirect()->back();
    }

}
