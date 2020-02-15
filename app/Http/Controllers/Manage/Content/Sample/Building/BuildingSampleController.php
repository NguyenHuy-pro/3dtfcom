<?php namespace App\Http\Controllers\Manage\Content\Sample\Building;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\Sample\Building\TfBuildingSample;

use Input;
use File;
use DB;
use Request;

class BuildingSampleController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    //get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBuildingSample = new TfBuildingSample();
        $modelBusinessType = new TfBusinessType();
        $dataBuildingSample = TfBuildingSample::where('action', 1)->orderBy('sample_id', 'ASC')->select('*')->paginate(20);
        $accessObject = 'building';
        return view('manage.content.sample.building.list', compact('modelStaff', 'modelBusinessType', 'modelBuildingSample', 'dataBuildingSample', 'accessObject'));
    }

    //view
    public function viewSample($sampleId)
    {
        $modelBuildingSample = new TfBuildingSample();
        if (!empty($sampleId)) {
            $dataBuildingSample = $modelBuildingSample->getInfo($sampleId);
            return view('manage.content.sample.building.view', compact('dataBuildingSample'));
        }
    }

    //filter
    public function getFilter($filterBusinessTypeId = '')
    {
        $modelStaff = new TfStaff();
        $modelBuildingSample = new TfBuildingSample();
        $modelBusinessType = new TfBusinessType();
        $accessObject = 'building';
        if (empty($filterBusinessTypeId)) { # all country
            return redirect()->route('tf.m.c.sample.building.list');
        } else {  # select an public type
            $dataBuildingSample = TfBuildingSample::where('businessType_id', $filterBusinessTypeId)->where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(20);
            return view('manage.content.sample.building.list', compact('modelStaff', 'modelBusinessType', 'modelBuildingSample', 'dataBuildingSample', 'accessObject', 'filterBusinessTypeId'));
        }
    }

    //select sample image
    public function selectImage($sizeId = '')
    {
        $modelSize = new TfSize();
        $dataSize = $modelSize->getInfo($sizeId);
        return view('manage.content.sample.building.select-image', compact('dataSize'));
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $modelSize = new TfSize();
        $modelBusinessType = new TfBusinessType();
        $accessObject = 'building';
        return view('manage.content.sample.building.add', compact('modelSize', 'modelBusinessType', 'accessObject'));
    }

    # add new
    public function postAdd()
    {
        $modelStaff = new TfStaff();
        $modelBusinessType = new TfBusinessType();
        $modelBuildingSample = new TfBuildingSample();
        $hFunction = new \Hfunction();
        $businessTypeId = Request::input('cbBusinessType');
        $sizeId = Request::input('cbSize');
        $price = Request::input('cbPrice');
        $businessName = $modelBusinessType->name($businessTypeId);

        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            $imageName = $file->getClientOriginalName();
            $imageName = '3d-ads-social-virtual-city-virtual-land-online-marketing-'.$businessName . '-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
            if($modelBuildingSample->uploadImage($file, $imageName)){
                if ($modelBuildingSample->insert($imageName, $price, 0, $sizeId, null, $businessTypeId, $modelStaff->loginStaffID())) {
                    Session::put('notifyAddBuildingSample', 'Add success, Enter info to continue');
                } else {
                    Session::put('notifyAddBuildingSample', 'Add fail, Enter info to try again');
                }
            }else{
                Session::put('notifyAddBuildingSample', 'Add fail, Enter info to try again');
            }

        } else {
            Session::put('notifyAddBuildingSample', 'Add fail, Enter info to try again');
        }


    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($sampleId)
    {
        $modelBuildingSample = new TfBuildingSample();
        $modelBusinessType = new TfBusinessType();
        $dataBuildingSample = $modelBuildingSample->getInfo($sampleId);
        if (count($dataBuildingSample) > 0) {
            return view('manage.content.sample.building.edit', compact('modelBusinessType', 'dataBuildingSample'));
        }
    }

    # adit info
    public function postEdit($sampleId = '')
    {

        $modelAll = new TfBuildingSample();
        $modelBuildingSample = TfBuildingSample::find($sampleId);
        $hFunction = new \Hfunction();
        $businessTypeId = Request::input('cbBusinessType');
        $price = Request::input('cbPrice');

        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            if (!empty($file)) {
                $businessName = $modelBuildingSample->businessType->name();
                $oldImage = $modelBuildingSample->image;
                $imageName = $file->getClientOriginalName();
                $imageName = '3d-ads-social-virtual-city-virtual-land-online-marketing-'.$businessName . '-' . $hFunction->getTimeCode() . $hFunction->getTypeImg($imageName);
                if($modelAll->uploadImage($file, $imageName)){
                    $modelAll->dropImage($oldImage);
                    $modelBuildingSample->image = $imageName;
                }
            }

        }
        $modelBuildingSample->price = $price;
        $modelBuildingSample->businessType_id = $businessTypeId;
        $modelBuildingSample->save();

    }

    # update status
    public function statusUpdate($sampleId)
    {
        $modelSample = new TfBuildingSample();
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
            $modelBuildingSample = new TfBuildingSample();
            $modelBuildingSample->actionDelete($sampleId);
        }
    }

}
