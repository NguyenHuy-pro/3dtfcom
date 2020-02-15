<?php namespace App\Http\Controllers\Manage\Content\Sample\LandRequestBuildDesign;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\Land\RequestBuildDesign\TfLandRequestBuildDesign;
use App\Models\Manage\Content\Sample\Building\TfBuildingSample;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\System\Staff\TfStaff;

use Input;
use File;
use DB;
use Request;

class LandRequestBuildDesignController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    #get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelLandRequestBuildDesign = new tfLandRequestBuildDesign();
        $dataStaffLogin = $modelStaff->loginStaffInfo();
        if (count($dataStaffLogin) > 0) {
            if ($dataStaffLogin->level() == 2) {
                $staffId = $dataStaffLogin->staffId();
                $dataLandRequestBuildDesign = TfLandRequestBuildDesign::where(['staff_id' => $staffId, 'action' => 1])->orderBy('request_id', 'DESC')->select('*')->paginate(20);
            } else {
                //feature  for other level 1 develop later
                $dataLandRequestBuildDesign = TfLandRequestBuildDesign::where('action', 1)->orderBy('request_id', 'DESC')->select('*')->paginate(20);
            }

            $accessObject = 'land';
            return view('manage.content.sample.land-request-build-design.list', compact('modelStaff', 'modelLandRequestBuildDesign', 'dataLandRequestBuildDesign', 'accessObject'));
        }

    }

    #view
    public function viewDesign($designId = null)
    {
        $modelLandRequestBuildDesign = new TfLandRequestBuildDesign();
        if (!empty($designId)) {
            $dataLandRequestBuildDesign = $modelLandRequestBuildDesign->getInfo($designId);
            return view('manage.content.sample.land-request-build-design.view', compact('dataLandRequestBuildDesign'));
        }
    }

    public function getUpDesign($designId)
    {
        $modelStaff = new TfStaff();
        $modelLandRequestBuildDesign = new TfLandRequestBuildDesign();
        if ($modelStaff->checkLogin()) {
            $dataLandRequestBuildDesign = $modelLandRequestBuildDesign->getInfo($designId);
            return view('manage.content.sample.land-request-build-design.design-upload', compact('modelStaff', 'dataLandRequestBuildDesign'));
        }
    }

    public function postDesign($designId)
    {
        $hFunction = new \Hfunction();
        $modelLandRequestBuildDesign = new TfLandRequestBuildDesign();
        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            $imageName = $file->getClientOriginalName();
            $imageName = 'request-build-design-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
            if ($modelLandRequestBuildDesign->uploadImage($file, $imageName)) {
                $modelLandRequestBuildDesign->updateImage($imageName, $designId);
            } else {
                //return "Add fail, Please try again";
            }

        }
        //process error later
    }

    #add new
    public function confirmDesign($designId, $confirmStatus)
    {
        $hFunction = new \Hfunction();
        $modelStaff = new TfStaff();
        $modelSize = new TfSize();
        $modelBuildingSample = new TfBuildingSample();
        $modelLandRequestBuildDesign = new TfLandRequestBuildDesign();


        if ($confirmStatus == 'y') {
            $modelLandRequestBuildDesign->publishYes($designId);
        } else {
            $modelLandRequestBuildDesign->publishNo($designId);
        }


    }

}
