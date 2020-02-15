<?php namespace App\Http\Controllers\Manage\Content\User\ImageType;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Users\ImageType\TfUserImageType;
use DB;
use File;
use Request;

class UserImageTypeController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    # get list
    public function getList()
    {
        $modelStaff = new TfStaff();
        $modelUserImageType = new TfUserImageType();
        $dataImageType = TfUserImageType::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'image';
        return view('manage.content.user.image-type.list', compact('modelStaff', 'modelUserImageType', 'dataImageType', 'accessObject'));
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $accessObject = 'image';
        return view('manage.content.user.image-type.add', compact('accessObject'));
    }

    # add new
    public function postAdd()
    {
        $modelImageType = new TfUserImageType();
        $name = Request::input('txtName');
        if ($modelImageType->existName($name)) {  // check exist of name
            Session::put('notifyAddImageType', "Add fail, Name <b>'$name'</b> exists.");
        } else {
            if ($modelImageType->insert($name)) {
                Session::put('notifyAddImageType', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddImageType', 'Add fail, Enter info to try again');
            }
        }
    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($typeId)
    {
        $dataImageType = TfUserImageType::find($typeId);
        if (count($dataImageType) > 0) {
            return view('manage.content.user.image-type.edit', compact('dataImageType'));
        }
    }

    # edit
    public function postEdit($typeId)
    {
        $modelImageType = new TfUserImageType();
        $name = Request::input('txtName');
        if ($modelImageType->existEditName($name, $typeId)) {
            return "Add fail, Name <b> '$name'</b> is existing.";
        } else {
            $modelImageType->updateInfo($typeId, $name);
        }
    }

    # delete
    public function viewImageType($typeId)
    {
        $dataImageType = TfUserImageType::find($typeId);
        if (count($dataImageType) > 0) {
            return view('manage.content.user.image-type.view', compact('dataImageType'));
        }
    }

    # delete
    public function deleteImageType($typeId)
    {
        if (!empty($typeId)) {
            $modelImageType = new TfUserImageType();
            $modelImageType->actionDelete($typeId);
        }
    }

}
