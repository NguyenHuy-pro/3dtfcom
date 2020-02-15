<?php namespace App\Http\Controllers\Manage\Content\Help\Object;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Help\Object\TfHelpObject;
#use Illuminate\Http\Request;

use Request;
use Input;

class ObjectController extends Controller
{

    public function getList()
    {
        $dataHelpObject = TfHelpObject::where('action', 1)->orderBy('displayRank', 'ASC')->select('*')->paginate(30);
        $accessObject = 'object';
        return view('manage.content.help.object.list', compact('dataHelpObject', 'accessObject'));
    }

    #========== ========== Add ========== ==========
    public function getAdd()
    {
        return view('manage.content.help.object.add');
    }

    public function postAdd()
    {
        $modelHelpObject = new TfHelpObject();
        $name = Request::input('txtName');
        $accessObject = 'object';

        $maxRank = $modelHelpObject->maxRank();
        $rank = (empty($maxRank))?1:$maxRank + 1;
        if ($modelHelpObject->existName($name)) {  // check exist of name
            Session::put('notifyAddHelpObject', "Add fail, Name <b>'$name'</b> exists.");
            return view('manage.content.help.object.add', compact('accessObject'));
        }
        if ($modelHelpObject->insert($name, $rank)) {
            Session::put('notifyAddHelpObject', 'Add success, Enter info to continue');
        } else {
            Session::put('notifyAddHelpObject', 'Add fail, Enter info to try again');
        }
        return view('manage.content.help.object.add', compact('accessObject'));

    }

    #========== ========== View ========== ==========
    public function getView($objectId){
        $modelHelpObject = new TfHelpObject();
        $dataHelpObject = $modelHelpObject->getInfo($objectId);
        $accessObject = 'object';
        return view('manage.content.help.object.view', compact('dataHelpObject', 'accessObject'));
    }

    #========== ========== Edit ========== ==========
    public function getEdit($objectId = '')
    {
        $modelHelpObject = new TfHelpObject();
        $dataHelpObject = $modelHelpObject->getInfo($objectId);
        $accessObject = 'object';
        return view('manage.content.help.object.edit', compact('dataHelpObject', 'accessObject'));
    }

    public function postEdit($objectId = '')
    {
        $modelHelpObject = TfHelpObject::find($objectId);
        $name = Request::input('txtName');
        if ($modelHelpObject->existEditName($name, $objectId)) { # if exist name <> the type is editing
            Session::put('notifyEditHelpObject', "Add fail, Name <b>'$name'</b> exists.");
            return redirect()->back();
        }else{
            $modelHelpObject->updateInfo($objectId, $name);
        }
        $dataHelpObject = TfHelpObject::where('action', 1)->orderBy('displayRank', 'ASC')->select('*')->paginate(30);
        $accessObject = 'object';
        return redirect()->route('tf.m.c.help.object.list.get', compact('dataHelpObject', 'accessObject'));

    }

    #========== ========== Delete ========== ==========
    public function getDelete($objectId = null)
    {
        if (!empty($objectId)) {
            $dataHelpObject = new TfHelpObject();
            $dataHelpObject->actionDelete($objectId);
        }
        return redirect()->back();
    }

}
