<?php namespace App\Http\Controllers\Manage\Content\Sample\ProjectIcon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Sample\ProjectIcon\TfProjectIconSample;
use Input;
use File;
use DB;
use Request;

class ProjectIconSampleController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    # get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelProjectIconSample = new TfProjectIconSample();
        $dataProjectIconSample = TfProjectIconSample::where('action', 1)->orderBy('sample_id', 'ASC')->select('*')->paginate(20);
        $accessObject = 'project';
        return view('manage.content.sample.project-icon.list', compact('modelStaff', 'modelProjectIconSample', 'dataProjectIconSample', 'accessObject'));
    }

    public function viewSample($sampleId)
    {
        $dataProjectIconSample = TfProjectIconSample::find($sampleId);
        if (count($dataProjectIconSample) > 0) {
            return view('manage.content.sample.project-icon.view', compact('dataProjectIconSample'));
        }
    }

    # select sample image
    public function selectImage($sizeId)
    {
        $modelSize = new TfSize();
        $dataSize = $modelSize->getInfo($sizeId);
        return view('manage.content.sample.project-icon.select-image', compact('dataSize'));
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $accessObject = 'project';
        return view('manage.content.sample.project-icon.add', compact('accessObject'));
    }

    # add new
    public function postAdd()
    {
        $modelStaff = new TfStaff();
        $modelProjectIconSample = new TfProjectIconSample();
        $hFunction = new \Hfunction();
        $sizeId = Request::input('cbSize');
        $price = Request::input('cbPrice');

        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            $imageName = $file->getClientOriginalName();
            $imageName = 'project-icon' . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
            if ($modelProjectIconSample->uploadImage($file, $imageName)) {
                if ($modelProjectIconSample->insert($imageName, $price, 0, $sizeId, null, $modelStaff->loginStaffID())) {
                    Session::put('notifyAddProjectIconSample', 'Add success, Enter info to continue');
                } else {
                    Session::put('notifyAddProjectIconSample', 'Add fail, Enter info to try again');
                }
            } else {
                Session::put('notifyAddProjectIconSample', 'Add fail, Enter info to try again');
            }

        } else {
            Session::put('notifyAddProjectIconSample', 'Add fail, Enter info to try again');
        }

    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($sampleId)
    {
        $dataProjectIconSample = TfProjectIconSample::find($sampleId);
        if (count($dataProjectIconSample) > 0) {
            return view('manage.content.sample.project-icon.edit', compact('dataProjectIconSample'));
        }
    }

    # edit info
    public function postEdit($sampleId)
    {
        $modelAll = new TfProjectIconSample();
        $modelProjectIconSample = TfProjectIconSample::find($sampleId);
        $hFunction = new \Hfunction();
        $price = Request::input('cbPrice');

        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            if (!empty($file)) {
                $oldImage = $modelProjectIconSample->image;
                $imageName = $file->getClientOriginalName();
                $imageName = 'project-icon-' . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
                if($modelAll->uploadImage($file, $imageName)){
                    $modelAll->dropImage($oldImage);
                    $modelProjectIconSample->image = $imageName;
                }
            }

        }
        $modelProjectIconSample->price = $price;
        $modelProjectIconSample->save();

    }

    # update status
    public function statusUpdate($sampleId)
    {
        $modelSample = new TfProjectIconSample();
        if (!empty($sampleId)) {
            $currentStatus = $modelSample->getInfo($sampleId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelSample->updateStatus($sampleId, $newStatus);
        }
    }

    # delete
    public function deleteSample($sampleId = '')
    {
        if (!empty($sampleId)) {
            $modelProjectIconSample = new TfProjectIconSample();
            $modelProjectIconSample->actionDelete($sampleId);
        }

    }

}
