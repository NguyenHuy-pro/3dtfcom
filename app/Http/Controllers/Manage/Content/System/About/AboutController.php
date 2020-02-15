<?php namespace App\Http\Controllers\Manage\Content\System\About;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\System\About\TfAbout;

//use Illuminate\Http\Request;
use DB;
use File, Input;
use Request;

class AboutController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # get list
    public function getList()
    {
        $modelAbout = new TfAbout();
        $modelStaff = new TfStaff();
        $dataAbout = TfAbout::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'content';
        return view('manage.content.system.about.list', compact('modelStaff', 'modelAbout', 'dataAbout', 'accessObject'));
    }

    #view
    public function viewAbout($aboutId)
    {
        $modelAbout = new TfAbout();
        $dataAbout = $modelAbout->getInfo($aboutId);
        if (count($dataAbout) > 0) {
            return view('manage.content.system.about.view', compact('dataAbout'));
        }
    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        return view('manage.content.system.about.add');
    }

    # add
    public function postAdd(Request $request)
    {
        $hFunction = new \Hfunction();
        $modelStaff = new TfStaff();
        $modelAbout = new TfAbout();
        $name = Request::input('txtName');
        $content = Request::input('txtContent');
        $keyword = Request::input('txtKeyword');
        $description = Request::input('txtDescription');

        $imageName = null;
        $staffLoginId = $modelStaff->loginStaffID();
        if ($modelAbout->existName($name)) {  // check exist of name
            Session::put('notifyAddAbout', "Add fail, nam <b>'$name'</b> is existing.");
            return view('manage.content.system.about.add');
        }
        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            $image = $file->getClientOriginalName();
            $image = '3dtf' . '-' . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($image);
            if ($modelAbout->uploadImage($file, $image)) {
                $imageName = $image;
            }
        }
        if ($modelAbout->insert($name, $content, $imageName, $keyword, $description, $staffLoginId)) {
            return redirect()->route('tf.m.c.system.about.list');
        } else {
            Session::put('notifyAddAbout', 'Add fail, Enter info to try again');
            return view('manage.content.system.about.add');
        }
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($aboutId)
    {
        $modelAbout = new TfAbout();
        $dataAbout = $modelAbout->findInfo($aboutId);
        if (count($dataAbout) > 0) {
            return view('manage.content.system.about.edit', compact('dataAbout'));
        }

    }

    # edit info
    public function postEdit($aboutId)
    {
        $hFunction = new \Hfunction();
        $modelAbout = new TfAbout();
        $name = Request::input('txtName');
        $content = Request::input('txtContent');
        $keyword = Request::input('txtKeyword');
        $description = Request::input('txtDescription');
        if ($modelAbout->existEditName($name, $aboutId)) {
            // if exist name <> the type is editing
            return "Add fail, Name <b> '$name'</b> is existing.";
        } else {
            $dataAbout = $modelAbout->findInfo($aboutId);
            $oldImage = $dataAbout->image(); # old image
            if (Input::hasFile('fileImage')) {
                $file = Request::file('fileImage');
                if (!empty($file)) {
                    $imageName = $file->getClientOriginalName();
                    $imageName = '3dtf-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
                    if ($modelAbout->uploadImage($file, $imageName)) {
                        if (!empty($oldImage)) {
                            $modelAbout->dropImage($oldImage);
                        }

                    }
                }

            } else {
                $imageName = $oldImage;
            }
            $modelAbout->updateInfo($name, $content, $imageName, $keyword, $description, $aboutId);
        }

    }

    # delete
    public function getDelete($aboutId)
    {
        if (!empty($aboutId)) {
            $modelAbout = new TfAbout();
            $modelAbout->actionDelete($aboutId);
        }
        return redirect()->back();
    }

}
