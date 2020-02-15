<?php namespace App\Http\Controllers\Manage\Content\Sample\ProjectBackground;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Sample\ProjectBackground\TfProjectBackground;
use App\Models\Manage\Content\System\Staff\TfStaff;
//use Illuminate\Http\Request;

use Request;
use Input, File;

class ProjectBackgroundController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    # get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelProjectBackground = new TfProjectBackground();
        $dataProjectBackground = TfProjectBackground::where('action', 1)->orderBy('background_id', 'ASC')->select('*')->paginate(30);
        $accessObject = 'project';
        return view('manage.content.sample.project-background.list', compact('modelStaff', 'modelProjectBackground', 'dataProjectBackground', 'accessObject'));
    }

    #view
    public function viewProjectBackground($backgroundId = null)
    {
        if (!empty($backgroundId)) {
            $dataProjectBackground = TfProjectBackground::find($backgroundId);
            if (count($dataProjectBackground) > 0) {
                return view('manage.content.sample.project-background.view', compact('dataProjectBackground'));
            }

        }
    }

    #=========== ADD NEW ===========
    # get form add
    public function getAdd()
    {
        $accessObject = 'project';
        return view('manage.content.sample.project-background.add', compact('accessObject'));
    }

    # add new
    public function postAdd()
    {
        $modelProjectBackground = new TfProjectBackground();
        $hFunction = new \Hfunction();
        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            $imageName = $file->getClientOriginalName();
            $imageName =$hFunction->getTimeCode() . "_bg." . $hFunction->getTypeImg($imageName);
            if($modelProjectBackground->uploadImage($file, $imageName)){
                if ($modelProjectBackground->insert($imageName)) {
                    Session::put('notifyAddProjectBackground', 'Add success, Enter info to continue');
                } else {
                    Session::put('notifyAddProjectBackground', 'Add fail, Enter info to try again');
                }
            }else{
                Session::put('notifyAddProjectBackground', 'Add fail, Enter info to try again');
            }

        } else {
            Session::put('notifyAddProjectBackground', 'Add fail, Enter info to try again');
        }

    }

    #===========  EDIT INFO ===========
    # get form edit
    public function getEdit($backgroundId)
    {
        $dataProjectBackground = TfProjectBackground::find($backgroundId);
        if (count($dataProjectBackground) > 0) {
            return view('manage.content.sample.project-background.edit', compact('dataProjectBackground'));
        }
    }

    # edit info
    public function postEdit($backgroundId)
    {
        $modelAll = new TfProjectBackground();
        $dataProjectBackground = TfProjectBackground::find($backgroundId);
        $hFunction = new \Hfunction();
        $oldImage = $dataProjectBackground->image(); # old image
        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            if (!empty($file)) {
                $imageName = $file->getClientOriginalName();
                $imageName = 'sample' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
                if($modelAll->uploadImage($file, $imageName)){
                    $modelAll->dropImage($oldImage);
                }
            }

        } else {
            $imageName = $oldImage;
        }
        $dataProjectBackground->updateInfo($imageName);
    }

    # update status
    public function statusUpdate($backgroundId)
    {
        $modelProjectBackground = new TfProjectBackground();
        if (!empty($backgroundId)) {
            $dataProjectBackground = TfProjectBackground::find($backgroundId);
            $newStatus = ($dataProjectBackground->status() == 0) ? 1 : 0;
            $modelProjectBackground->updateStatus($newStatus,$backgroundId);
        }
    }

    # delete
    public function deleteProjectBackground($backgroundId = null)
    {
        if (!empty($backgroundId)) {
            $dataProjectBackground = TfProjectBackground::find($backgroundId);
            $dataProjectBackground->actionDelete();
        }
    }

}
