<?php namespace App\Http\Controllers\Help;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Help\Action\TfHelpAction;
use App\Models\Manage\Content\Help\Detail\TfHelpDetail;
use App\Models\Manage\Content\Help\Object\TfHelpObject;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class HelpController extends Controller {
    public function index($objectAlias='', $actionAlias='')
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelHelpObject = new TfHelpObject();
        $modelHelpAction = new TfHelpAction();
        $modelHelpDetail = new TfHelpDetail();

        if(empty($objectAlias) && empty($actionAlias)){
            $dataHelpDetail = $modelHelpDetail->getInfoDefault();
            $dataHelpObjectAccess = $modelHelpObject->getInfo($dataHelpDetail->helpObject_id);
            $dataHelpActionAccess = $modelHelpAction->getInfo($dataHelpDetail->helpAction_id);
        }else{
            $dataHelpObjectAccess = $modelHelpObject->getInfoOfAlias($objectAlias);
            $dataHelpActionAccess = $modelHelpAction->getInfoOfAlias($actionAlias);
        }
        return view('help.index',compact('modelAbout', 'modelUser', 'dataHelpObjectAccess','dataHelpActionAccess'));
    }

}
