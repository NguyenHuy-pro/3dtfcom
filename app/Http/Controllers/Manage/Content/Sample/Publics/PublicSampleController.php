<?php namespace App\Http\Controllers\Manage\Content\Sample\Publics;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\Publics\TfPublic;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Sample\PublicType\TfPublicType;
use App\Models\Manage\Content\Sample\Publics\TfPublicSample;

use Input;
use File;
use DB;
use Request;

class PublicSampleController extends Controller
{

    #=========== ========= ========== GET INFO ============ =========== ==========
    # get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelPublicType = new TfPublicType();
        $modelPublicSample = new TfPublicSample();
        $dataPublicSample = TfPublicSample::where('action', 1)->orderBy('sample_id', 'ASC')->select('*')->paginate(30);
        $accessObject = 'public';
        return view('manage.content.sample.public.list', compact('modelStaff', 'modelPublicType', 'modelPublicSample', 'dataPublicSample', 'accessObject'));
    }

    #view
    public function viewSample($sampleId)
    {
        if (!empty($sampleId)) {
            $dataPublicSample = TfPublicSample::find($sampleId);
            return view('manage.content.sample.public.view', compact('dataPublicSample'));
        }
    }

    # filter
    public function getFilter($filterPublicTypeId = '')
    {
        $modelStaff = new TfStaff();
        $modelPublicType = new TfPublicType();
        $modelPublicSample = new TfPublicSample();
        if (empty($filterPublicTypeId)) { // all country
            return redirect()->route('tf.m.c.sample.public.list');
        } else {  // select an public type
            $dataPublicSample = TfPublicSample::where('type_id', $filterPublicTypeId)->where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
            return view('manage.content.sample.public.list', compact('modelStaff', 'modelPublicType', 'modelPublicSample', 'dataPublicSample', 'filterPublicTypeId'));
        }
    }

    #=========== ========= ========== ADD ============ =========== ==========
    # select sample image
    public function selectImage($sizeId)
    {
        $modelSize = new TfSize();
        $dataSize = $modelSize->getInfo($sizeId);
        return view('manage.content.sample.public.select-image', compact('dataSize'));
    }

    # get form add
    public function getAdd()
    {
        $modelPublicType = new TfPublicType();
        $modelSize = new TfSize();
        $accessObject = 'public';
        return view('manage.content.sample.public.add', compact('modelPublicType', 'modelSize', 'accessObject'));
    }

    # add new
    public function postAdd()
    {
        $modelStaff = new TfStaff();
        $modelPublicSample = new TfPublicSample();
        $hFunction = new \Hfunction();
        $typeId = Request::input('cbPublicType');
        $sizeId = Request::input('cbSize');

        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            $imageName = $file->getClientOriginalName();
            $imageName = "public-" . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
            if ($modelPublicSample->uploadImage($file, $imageName)) {
                if ($modelPublicSample->insert($imageName, $sizeId, $typeId, $modelStaff->loginStaffID())) {
                    Session::put('notifyAddPublicSample', 'Add success, Enter info to continue');
                } else {
                    Session::put('notifyAddPublicSample', 'Add fail, Enter info to try again');
                }
            } else {
                Session::put('notifyAddPublicSample', 'Add fail, Enter info to try again');
            }
        } else {
            Session::put('notifyAddPublicSample', 'Add fail, Enter info to try again');
        }
    }

    #=========== ========= ========== EDIT INFO ============ =========== ==========
    # get form edit
    public function getEdit($sampleId)
    {
        $modelPublicType = new TfPublicType();
        $dataPublicSample = TfPublicSample::find($sampleId);
        if (count($dataPublicSample)) {
            return view('manage.content.sample.public.edit', compact('modelPublicType', 'dataPublicSample'));
        }
    }

    # edit info
    public function postEdit($sampleId)
    {
        $modelAll = new TfPublicSample();
        $modelPublicSample = TfPublicSample::find($sampleId);
        $hFunction = new \Hfunction();
        $typeId = Request::input('cbPublicType');

        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            if (!empty($file)) {
                $oldImage = $modelPublicSample->image($sampleId);
                $image_name = $file->getClientOriginalName();
                $imageName = "public-" . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($image_name);
                if ($modelAll->uploadImage($file, $imageName)) {
                    $modelAll->dropImage($oldImage);
                    $modelPublicSample->image = $imageName;
                }
            }

        }
        $modelPublicSample->type_id = $typeId;
        $modelPublicSample->save();
    }

    # update status
    public function statusUpdate($sampleId)
    {
        $modelSample = new TfPublicSample();
        if (!empty($sampleId)) {
            $currentStatus = $modelSample->getInfo($sampleId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelSample->updateStatus($sampleId, $newStatus);
        }
    }

    # delete
    public function deleteSample($sampleId)
    {
        if (!empty($sampleId)) {
            $modelPublicSample = new TfPublicSample();
            $modelPublicSample->actionDelete($sampleId);
        }
    }

}
