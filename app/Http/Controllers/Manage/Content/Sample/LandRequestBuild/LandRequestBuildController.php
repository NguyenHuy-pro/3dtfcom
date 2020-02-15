<?php namespace App\Http\Controllers\Manage\Content\Sample\LandRequestBuild;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\Land\RequestBuild\TfLandRequestBuild;
use App\Models\Manage\Content\Map\Land\RequestBuildDesign\TfLandRequestBuildDesign;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Sample\LandIcon\TfLandIconSample;

use Input;
use File;
use DB;
use Request;

class LandRequestBuildController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    #get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelLandRequestBuild = new TfLandRequestBuild();
        $dataLandRequestBuild = TfLandRequestBuild::where('action',1)->orderBy('request_id', 'ASC')->select('*')->paginate(20);
        $accessObject = 'land';
        return view('manage.content.sample.land-request-build.list', compact('modelStaff', 'modelLandRequestBuild', 'dataLandRequestBuild', 'accessObject'));
    }

    #view
    public function viewRequest($requestId = null)
    {
        $modelLandRequestBuild = new TfLandRequestBuild();
        if (!empty($requestId)) {
            $dataLandRequestBuild = $modelLandRequestBuild->getInfo($requestId);
            return view('manage.content.sample.land-request-build.view', compact('dataLandRequestBuild'));
        }
    }

    public function getAssignment($requestId)
    {
        $modelLandRequestBuild = new TfLandRequestBuild();
        $modelSize = new TfSize();
        $modelStaff = new TfStaff();
        if ($modelStaff->checkLogin()) {
            $dataStaff = $modelStaff->infoListOfManageStaff($modelStaff->loginStaffID());
            $dataLandRequestBuild = $modelLandRequestBuild->getInfo($requestId);
            $dataLandSize = $dataLandRequestBuild->landLicense->land->size;
            $standardId = $dataLandSize->standardId();
            $dataSize = $modelSize->infoOfStandard($standardId);
            return view('manage.content.sample.land-request-build.design-assignment', compact('modelStaff', 'dataStaff', 'dataSize', 'dataLandRequestBuild'));
        }
    }

    public function postAssignment($requestId)
    {
        $hFunction = new \Hfunction();
        $modelLandRequestDesign = new TfLandRequestBuildDesign();
        $staffId = Request::input('cbDesigner');
        $sizeId = Request::input('cbSize');
        $deliveryDate = $hFunction->carbonNowAddDays(100);
        if (!empty($requestId) && !empty($staffId)) $modelLandRequestDesign->insert(null, $deliveryDate, $requestId, $staffId, $sizeId);

    }

}
