<?php namespace App\Http\Controllers\Manage\Content\Help\Action;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
#use Illuminate\Http\Request;
use App\Models\Manage\Content\Help\Action\TfHelpAction;
use App\Models\Manage\Content\Help\Object\TfHelpObject;
use Request;
use Input, DB;

class ActionController extends Controller {

    public function getList()
    {
        $dataHelpAction = TfHelpAction::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'action';
        return view('manage.content.help.action.list', compact('dataHelpAction', 'accessObject'));
    }

    #========== ========== Add ========== ==========
    public function getAdd()
    {
        return view('manage.content.help.action.add');
    }

    public function postAdd()
    {
        $modelHelpAction = new TfHelpAction();
        $name = Request::input('txtName');
        $accessObject = 'action';
        if ($modelHelpAction->existName($name)) {  // check exist of name
            Session::put('notifyAddHelpAction', "Add fail, Name <b>'$name'</b> exists.");
            return view('manage.content.help.action.add', compact('accessObject'));
        }
        if ($modelHelpAction->insert($name)) {
            Session::put('notifyAddHelpAction', 'Add success, Enter info to continue');
        } else {
            Session::put('notifyAddHelpAction', 'Add fail, Enter info to try again');
        }
        return view('manage.content.help.action.add', compact('accessObject'));

    }

    #========== ========== View ========== ==========
    public function getView($actionId){
        $dataHelpAction = TfHelpAction::find($actionId);
        $accessObject = 'action';
        if(count($dataHelpAction) > 0){
            return view('manage.content.help.action.view', compact('dataHelpAction', 'accessObject'));
        }

    }

    #========== ========== Edit ========== ==========
    public function getEdit($actionId = '')
    {
        $modelHelpAction = new TfHelpAction();
        $dataHelpAction = $modelHelpAction->getInfo($actionId);
        $accessObject = 'action';
        return view('manage.content.help.action.edit', compact('dataHelpAction', 'accessObject'));
    }

    public function postEdit($actionId = '')
    {
        $modelHelpAction = TfHelpAction::find($actionId);
        $name = Request::input('txtName');
        if ($modelHelpAction->existEditName($name, $actionId)) { # if exist name <> the type is editing
            Session::put('notifyEditHelpAction', "Add fail, Name <b>'$name'</b> exists.");
            return redirect()->back();
        }else{
            $modelHelpAction->updateInfo($actionId, $name);
        }
        $dataHelpAction = TfHelpAction::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'action';
        return redirect()->route('tf.m.c.help.action.list.get', compact('dataHelpAction', 'accessObject'));

    }

    #========== ========== Delete ========== ==========
    public function getDelete($actionId = '')
    {
        if (!empty($actionId)) {
            $dataHelpAction = new TfHelpAction();
            $dataHelpAction->getDelete($actionId);
        }
        return redirect()->back();
    }

}
