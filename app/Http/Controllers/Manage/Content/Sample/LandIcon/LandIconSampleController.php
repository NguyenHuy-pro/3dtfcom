<?php namespace App\Http\Controllers\Manage\Content\Sample\LandIcon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Sample\LandIcon\TfLandIconSample;

use Input;
use File;
use DB;
use Request;

class LandIconSampleController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    #get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelLandIconSample = new TfLandIconSample();
        $dataLandIconSample = TfLandIconSample::orderBy('sample_id', 'ASC')->select('*')->paginate(20);
        $accessObject = 'land';
        return view('manage.content.sample.land-icon.list', compact('modelStaff', 'modelLandIconSample', 'dataLandIconSample', 'accessObject'));
    }

    #view
    public function viewSample($sampleId)
    {
        if (!empty($sampleId)) {
            $dataLandIconSample = TfLandIconSample::find($sampleId);
            return view('manage.content.sample.land-icon.view', compact('dataLandIconSample'));
        }
    }

    # select sample image
    public function selectImage($sizeId = '')
    {
        $modelSize = new TfSize();
        $dataSize = $modelSize->getInfo($sizeId);
        return view('manage.content.sample.land-icon.select-image', compact('dataSize'));
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    #get form add
    public function getAdd()
    {
        $modelSize = new TfSize();
        $modelTransactionStatus = new TfTransactionStatus();
        $accessObject = 'land';
        return view('manage.content.sample.land-icon.add', compact('modelSize', 'modelTransactionStatus', 'accessObject'));
    }

    #add new
    public function postAdd()
    {
        $modelStaff = new TfStaff();
        $modelSize = new TfSize();
        $modelLandIconSample = new TfLandIconSample();
        $hFunction = new \Hfunction();
        $transactionStatusId = Request::input('cbTransactionStatus');
        $sizeId = Request::input('cbSize');
        $ownStatus = Request::input('cbOwnStatus');
        $sizeName = $modelSize->name($sizeId);

        if ($modelLandIconSample->existSizeAndStatusAndOwner($sizeId, $transactionStatusId, $ownStatus)) {
            Session::put('notifyAddLandIconSample', 'Add fail, Enter this info');
            return redirect()->back();
        }
        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            $imageName = $file->getClientOriginalName();
            $imageName = $sizeName . '-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
            if ($modelLandIconSample->uploadImage($file, $imageName)) {
                if ($modelLandIconSample->insert($imageName, $ownStatus, $sizeId, $transactionStatusId, $modelStaff->loginStaffID())) {
                    Session::put('notifyAddLandIconSample', 'Add success, Enter info to continue');
                } else {
                    Session::put('notifyAddLandIconSample', 'Add fail, Enter info to try again');
                }
            } else {
                Session::put('notifyAddLandIconSample', 'Add fail, Enter info to try again');
            }

        } else {
            Session::put('notifyAddLandIconSample', 'Add fail, Enter info to try again');
        }

    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($sampleId = '')
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $dataLandIconSample = TfLandIconSample::find($sampleId);
        if (count($dataLandIconSample) > 0) {
            return view('manage.content.sample.land-icon.edit', compact('modelTransactionStatus', 'dataLandIconSample'));
        }
    }

    # edit info
    public function postEdit($sampleId)
    {
        $modelAll = new TfLandIconSample();
        $modelLandIconSample = TfLandIconSample::find($sampleId);
        $hFunction = new \Hfunction();
        $transactionStatusId = Request::input('cbTransactionStatus');
        $ownStatus = Request::input('cbOwnStatus');

        if ($modelLandIconSample->existEditSizeAndStatusAndOwner($modelLandIconSample->size_id, $transactionStatusId, $ownStatus)) {
            return 'Add fail, Enter this info';
        }
        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            if (!empty($file)) {
                $sizeName = $modelLandIconSample->size->name();
                $oldImage = $modelLandIconSample->image();
                $imageName = $file->getClientOriginalName();
                $imageName = $sizeName . '-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
                if ($modelAll->uploadImage($file, $imageName)) {
                    $modelAll->dropImage($oldImage);
                    $modelLandIconSample->image = $imageName;
                }
            }

        }
        $modelLandIconSample->ownStatus = $ownStatus;
        $modelLandIconSample->transactionStatus_id = $transactionStatusId;
        $modelLandIconSample->save();
    }

    # delete
    /*
    public function deleteSample($sampleId = '')
    {
        if (!empty($sampleId)) {
            $modelLandIconSample = new TfLandIconSample();
            $modelLandIconSample->actionDelete($sampleId);
        }
    }*/

}
