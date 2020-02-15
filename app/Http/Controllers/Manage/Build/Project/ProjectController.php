<?php namespace App\Http\Controllers\Manage\Build\Project;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\Map\Project\Build\TfProjectBuild;
use App\Models\Manage\Content\Sample\PublicType\TfPublicType;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Country\TfCountry;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\System\StaffManage\TfStaffManage;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Map\Banner\TfBanner;
use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\Map\ProvinceArea\TfProvinceArea;
use App\Models\Manage\Content\Map\Project\Icon\TfProjectIcon;
use App\Models\Manage\Content\Map\Project\Rank\TfProjectRank;
use App\Models\Manage\Content\Map\Project\Transaction\TfProjectTransaction;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\Map\Project\Property\TfProjectProperty;
use App\Models\Manage\Content\Sample\ProjectIcon\TfProjectIconSample;
use App\Models\Manage\Content\System\Staff\TfStaff;

use DB;
use File;
use Request;

class ProjectController extends Controller
{

    #=========== ========== ========== ADD  PROJECT ========== ========== =========
    # check exist name
    public function checkExistName($name = '')
    {
        $modelProject = new TfProject();
        $result = $modelProject->existName($name);
        return ($result) ? 'yes' : 'no';
    }

    # get form add
    public function getAddProject($provinceId, $areaId)
    {
        $modelStaff = new TfStaff();
        $modelProvince = new TfProvince();
        $modelProjectIconSample = new TfProjectIconSample();
        $dataProvince = TfProvince::find($provinceId);

        $dataStaffLogin = $modelStaff->loginStaffInfo();
        $listStaff = $dataStaffLogin->listStaffManage();
        $dataStaff = TfStaff::whereIn('staff_id', $listStaff)->select('staff_id as optionKey', 'account as optionValue')->get()->toArray();
        $dataProjectIconSample = $modelProjectIconSample->sampleIsUsing();
        return view('manage.build.map.project.project-add', compact('modelProvince', 'dataProvince', 'areaId', 'dataStaff', 'dataProjectIconSample'));
    }

    # add new
    public function postAddProject($provinceId, $areaId)
    {
        $hFunction = new \Hfunction();
        $modelStaff = new TfStaff();
        $modelProvinceArea = new TfProvinceArea();
        $modelProject = new TfProject();
        $modelProjectProperty = new TfProjectProperty();
        $modelProjectTransaction = new TfProjectTransaction();
        $modelProjectRank = new TfProjectRank();

        $name = Request::input('txtName');
        $staffId = Request::input('cbStaffManager');
        $iconSampleId = Request::input('radIconSample');
        $shortDescription = Request::input('txtShortDescription');
        $transactionStatusId = Request::input('cbTransactionStatus');

        if ($modelProject->insert($name, $shortDescription, null, 0, $provinceId, $areaId)) {
            $newProjectId = $modelProject->insertGetId();
            #add rank
            $modelProjectRank->insert($newProjectId, 1);

            # add icon for project
            $modelProjectIcon = new TfProjectIcon();
            $dataProjectIconSample = TfProjectIconSample::find($iconSampleId);
            $sampleHeight = $dataProjectIconSample->size->height();
            $sampleWidth = $dataProjectIconSample->size->width();
            # set zIndex
            $topPosition = 0;   #default
            $leftPosition = 0;
            $zIndexTop = $topPosition + $sampleHeight;
            $zIndexLeft = $leftPosition + $sampleWidth;
            $zIndexDefault = 802817;
            for ($y = 0; $y <= 896; $y++) {
                for ($x = 0; $x <= 896; $x++) {
                    if ($y == $zIndexTop && $x == $zIndexLeft) $zIndexIcon = $zIndexDefault;
                    $zIndexDefault = $zIndexDefault + 1;
                }
            }
            $zIndexIcon = (!isset($zIndexIcon)) ? $zIndexDefault : $zIndexIcon;
            $modelProjectIcon->insert(0, 0, $newProjectId, $iconSampleId, $zIndexIcon);


            #add info sale
            $modelProjectTransaction->insert($newProjectId, $transactionStatusId);

            #add property
            $dateBegin = $hFunction->carbonNow();
            $dateEnd = $hFunction->carbonNowAddYears(10);
            $modelProjectProperty->insert($dateBegin, $dateEnd, $newProjectId, $staffId);

            $dataProject = TfProject::find($newProjectId);
            $dataMapAccess = [
                'provinceAccess' => $provinceId,
                'areaAccess' => $areaId,
            ];
            return view('manage.build.map.project.project', compact('modelStaff', 'modelProvinceArea', 'dataMapAccess', 'dataProject'));
        }
    }

    #========== ========== ========== BUILD ========== ========== ==========
    #open build Project of area
    public function openSetup($projectId)
    {
        $modelStaff = new TfStaff();
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();
        $modelProvinceArea = new TfProvinceArea();
        $modelBusinessType = new TfBusinessType();
        $modelPublicType = new TfPublicType();
        $modelProjectBuild = new TfProjectBuild();

        $dataProject = TfProject::find($projectId);
        $areaId = $dataProject->areaId();
        $provinceId = $dataProject->provinceId();
        $modelProvinceArea->openSetup($areaId);

        #build info
        if (!$modelProjectBuild->existBuildOfProject($projectId)) {
            $firstBPublishStatus = (!$modelProjectBuild->existFirstPublishOfProject($projectId)) ? 1 : 0;
            $modelProjectBuild->insert($projectId, $firstBPublishStatus);
        }
        #access info
        $dataMapAccess = [
            'provinceAccess' => $provinceId,
            'areaAccess' => $areaId,
        ];
        return view('manage.build.map.map', compact('modelStaff', 'modelCountry', 'modelProvince', 'modelArea', 'modelProvinceArea', 'modelBusinessType', 'modelPublicType', 'dataMapAccess'));
    }

    #close build Project of area
    public function closeSetup($projectId)
    {
        $modelStaff = new TfStaff();
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();
        $modelProvinceArea = new TfProvinceArea();
        $modelBusinessType = new TfBusinessType();
        $modelPublicType = new TfPublicType();

        $dataProject = TfProject::find($projectId);
        $areaId = $dataProject->areaId();
        $provinceId = $dataProject->provinceId();
        $modelProvinceArea->closeSetup();
        $dataMapAccess = [
            'provinceAccess' => $provinceId,
            'areaAccess' => $areaId,
        ];
        return view('manage.build.map.map', compact('modelStaff', 'modelCountry', 'modelProvince', 'modelArea', 'modelProvinceArea', 'modelBusinessType', 'modelPublicType', 'dataMapAccess'));
    }

    # finish build
    public function finishBuild($projectId, $buildId)
    {
        $modelStaff = new TfStaff();
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();
        $modelProvinceArea = new TfProvinceArea();
        $modelBusinessType = new TfBusinessType();
        $modelPublicType = new TfPublicType();
        $modelProjectBuild = new TfProjectBuild();

        if (!empty($projectId) and !empty($buildId)) {

            $modelProjectBuild->finishBuild($buildId);
            $modelProvinceArea->closeSetup();

            # access info
            $dataProject = TfProject::find($projectId);
            $areaId = $dataProject->areaId();
            $provinceId = $dataProject->provinceId();
            $dataMapAccess = [
                'provinceAccess' => $provinceId,
                'areaAccess' => $areaId,
            ];
            return view('manage.build.map.map', compact('modelStaff', 'modelCountry', 'modelProvince', 'modelArea', 'modelProvinceArea', 'modelBusinessType', 'modelPublicType', 'dataMapAccess'));
        } else {
            return redirect()->back();
        }
    }

    #========== ========== ========== PUBLISH ========== ========== ==========
    # agree publish project
    public function getPublishYes($projectId, $buildId)
    {
        return view('manage.build.map.project.project-publish-day-select', compact('projectId', 'buildId'));
    }

    # first agree publish project
    public function postPublishYes()
    {
        $modelStaff = new TfStaff();
        $modelProvinceArea = new TfProvinceArea();
        $modelProjectBuild = new TfProjectBuild();
        $projectId = Request::input('txtProjectPublish');
        $buildId = Request::input('txtPublish');
        $day = Request::input('cbPublishDay');

        #update publish
        $modelProjectBuild->publishYes($buildId, $day);

        #access info
        $dataProject = TfProject::find($projectId);
        $dataMapAccess = [
            'provinceAccess' => $dataProject->provinceId(),
            'areaAccess' => $dataProject->areaId(),
        ];
        return view('manage.build.map.project.project', compact('modelStaff', 'modelProvinceArea', 'dataMapAccess', 'dataProject'));
    }

    # does not agree publish project
    public function getPublishNo($projectId, $buildId)
    {
        $modelStaff = new TfStaff();
        $modelProvinceArea = new TfProvinceArea();
        $modelProjectBuild = new TfProjectBuild();
        $modelProjectBuild->publishFail($buildId);

        #access info
        $dataProject = TfProject::find($projectId);
        $dataMapAccess = [
            'provinceAccess' => $dataProject->provinceId(),
            'areaAccess' => $dataProject->areaId(),
        ];
        return view('manage.build.map.project.project', compact('modelStaff', 'modelProvinceArea', 'dataMapAccess', 'dataProject'));
    }

}