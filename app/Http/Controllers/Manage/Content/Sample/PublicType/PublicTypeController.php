<?php namespace App\Http\Controllers\Manage\Content\Sample\PublicType;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Sample\PublicType\TfPublicType;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;

use DB;
use File;
use Request;

class PublicTypeController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelPublicType = new TfPublicType();
        $dataPublicType = TfPublicType::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        return view('manage.content.sample.public-type.list', compact('modelStaff', 'modelPublicType', 'dataPublicType'));
    }

    #view
    public function viewPublicType($typeId)
    {
        if (!empty($typeId)) {
            $dataPublicType = TfPublicType::find($typeId);
            return view('manage.content.sample.public-type.view', compact('dataPublicType'));
        }
    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        return view('manage.content.sample.public-type.add');
    }

    # add new
    public function postAdd()
    {
        $modelPublicType = new TfPublicType();
        $name = Request::input('txtName');

        // check exist of name
        if ($modelPublicType->existName($name)) {
            Session::put('notifyAddPublicType', "Add fail, Name <b>'$name'</b> exists.");
        } else {
            if ($modelPublicType->insert($name)) {
                Session::put('notifyAddPublicType', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddPublicType', 'Add fail, Enter info to try again');
            }
        }
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($typeId)
    {
        $dataPublicType = TfPublicType::find($typeId);
        if (count($dataPublicType)) {
            return view('manage.content.sample.public-type.edit', compact('dataPublicType'));
        }
    }

    # edit
    public function postEdit($typeId)
    {
        $modelPublicType = new TfPublicType();
        $name = Request::input('txtName');

        # if exist name <> the type is editing
        if ($modelPublicType->existEditName($name, $typeId)) {
            return "Add fail, Name <b>'$name'</b> exists.";
        } else {
            $modelPublicType->updateInfo($typeId, $name);
        }
    }

    # update status
    public function statusUpdate($typeId)
    {
        $modelType = new TfPublicType();
        if (!empty($typeId)) {
            $currentStatus = $modelType->getInfo($typeId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelType->updateStatus($typeId, $newStatus);
        }
    }

    # delete
    public function deletePublicType($typeId)
    {
        if (!empty($typeId)) {
            $modelPublicType = new TfPublicType();
            $modelPublicType->actionDelete($typeId);
        }
    }

}
