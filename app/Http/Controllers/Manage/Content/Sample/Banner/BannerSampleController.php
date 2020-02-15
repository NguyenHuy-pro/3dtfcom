<?php namespace App\Http\Controllers\Manage\Content\Sample\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Sample\Banner\TfBannerSample;

use Input;
use File;
use DB;
use Request;

class BannerSampleController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    # get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBannerSample = new TfBannerSample();
        $dataBannerSample = TfBannerSample::where('action', 1)->orderBy('sample_id', 'ASC')->select('*')->paginate(30);
        $accessObject = 'banner';
        $dataStaffLogin = $modelStaff->loginStaffInfo();
        return view('manage.content.sample.banner.list', compact('modelBannerSample', 'dataBannerSample', 'accessObject', 'dataStaffLogin'));
    }

    #view
    public function viewSample($sampleId)
    {
        if (!empty($sampleId)) {
            $dataBannerSample = TfBannerSample::find($sampleId);
            if (count($dataBannerSample) > 0) {
                return view('manage.content.sample.banner.view', compact('dataBannerSample'));
            }

        }
    }

    # select sample image
    public function selectImage($sizeId = '')
    {
        $modelSize = new TfSize();
        $dataSize = $modelSize->getInfo($sizeId);
        return view('manage.content.sample.banner.select-image', compact('dataSize'));
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $modelSize = new TfSize();
        $accessObject = 'banner';
        return view('manage.content.sample.banner.add', compact('modelSize', 'accessObject'));
    }

    # add new
    public function postAdd()
    {
        $modelStaff = new TfStaff();
        $modelSize = new TfSize();
        $modelBannerSample = new TfBannerSample();
        $hFunction = new \Hfunction();
        $border = Request::input('txtBorder');
        $sizeId = Request::input('cbSize');
        $sizeName = $modelSize->name($sizeId);

        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            $imageName = $file->getClientOriginalName();
            $imageName = $sizeName . '-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
            if($modelBannerSample->uploadImage($file, $imageName)){
                if ($modelBannerSample->insert($imageName, $border, $sizeId, $modelStaff->loginStaffID())) {
                    Session::put('notifyAddBannerSample', 'Add success, Enter info to continue');
                } else {
                    Session::put('notifyAddBannerSample', 'Add fail, Enter info to try again');
                }
            }else{
                Session::put('notifyAddBannerSample', 'Add fail, Enter info to try again');
            }

        } else {
            Session::put('notifyAddBannerSample', 'Add fail, Enter info to try again');
        }

    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($sampleId)
    {
        $dataBannerSample = TfBannerSample::find($sampleId);
        if (count($dataBannerSample) > 0) {
            return view('manage.content.sample.banner.edit', compact('dataBannerSample'));
        }
    }

    # adit info (only update border and image)
    public function postEdit($sampleId)
    {
        $modelAll = new TfBannerSample();
        $modelBannerSample = TfBannerSample::find($sampleId);
        $hFunction = new \Hfunction();
        $border = Request::input('txtBorder');

        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            $sizeName = $modelBannerSample->size->name();
            $oldImage = $modelBannerSample->image(); # old image
            $imageName = $file->getClientOriginalName();
            $imageName = $sizeName . '-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
            if($modelAll->uploadImage($file, $imageName)){
                $modelAll->dropImage($oldImage);
                $modelBannerSample->image = $imageName;
            }
        }
        $modelBannerSample->border = $border;
        $modelBannerSample->save();
    }


    # update status
    public function statusUpdate($sampleId)
    {
        $modelSample = new TfBannerSample();
        if (!empty($sampleId)) {
            $currentStatus = $modelSample->getInfo($sampleId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelSample->updateStatus($sampleId, $newStatus);
        }
    }

    # delete
    public function deleteSample($sampleId = null)
    {
        if (!empty($sampleId)) {
            $modelBannerSample = new TfBannerSample();
            $modelBannerSample->actionDelete($sampleId);
        }
    }

}
