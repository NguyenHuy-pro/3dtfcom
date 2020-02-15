<?php namespace App\Http\Controllers\Manage\Build;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\Map\Banner\TfBanner;
use App\Models\Manage\Content\Map\Banner\Transaction\TfBannerTransaction;
use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\Map\Land\Transaction\TfLandTransaction;
use App\Models\Manage\Content\Map\Project\Build\TfProjectBuild;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\Map\ProvinceArea\TfProvinceArea;
use App\Models\Manage\Content\Map\Publics\TfPublic;
use App\Models\Manage\Content\Sample\Banner\TfBannerSample;
use App\Models\Manage\Content\Sample\ProjectBackground\TfProjectBackground;
use App\Models\Manage\Content\Sample\ProjectSample\TfProjectSample;
use App\Models\Manage\Content\Sample\Publics\TfPublicSample;
use App\Models\Manage\Content\Sample\PublicType\TfPublicType;
use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Country\TfCountry;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\System\Staff\TfStaff;


use DB;
use File;
use Illuminate\Support\Facades\Session;
use Request;

class BuildController extends Controller
{
    public function index($name = '')
    {
        $modelStaff = new TfStaff();
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();
        $modelProvinceArea = new TfProvinceArea();
        $modelBusinessType = new TfBusinessType();
        $modelPublicType = new TfPublicType();

        $dataStaff = $modelStaff->loginStaffInfo();
        $staffLevel = $dataStaff->level();
        if ($staffLevel == 1) { # manager
            # get one Province property
            $dataProvinceProperty = $dataStaff->provincePropertyLogin();
            if (!empty($dataProvinceProperty)) { # co Province
                $dataProvince = $dataProvinceProperty->province;
                # info access map
                $dataMapAccess = [
                    'provinceAccess' => $dataProvince->provinceId(),
                    'areaAccess' => $dataProvince->centerArea(),  # get center of province
                ];
                return view('manage.build.map.map', compact('modelStaff', 'modelCountry', 'modelProvince', 'modelArea', 'modelProvinceArea', 'modelBusinessType', 'modelPublicType', 'dataMapAccess'));
            } else {
                # does exist province
                return view('manage.build.notify.exist-property');
            }
        } elseif ($staffLevel == 2) { # level build
            # get only one Project
            $dataProjectProperty = $dataStaff->projectPropertyLogin();
            if (!empty($dataProjectProperty)) {
                # exist project
                $dataProjectAccess = $dataProjectProperty->project;
                # access info of map
                $dataMapAccess = [
                    'provinceAccess' => $dataProjectAccess->provinceId(),
                    'areaAccess' => $dataProjectAccess->areaId(),
                ];
                return view('manage.build.map.map', compact('modelStaff', 'modelCountry', 'modelProvince', 'modelArea', 'modelProvinceArea', 'modelBusinessType', 'modelPublicType', 'dataMapAccess'));
            } else { # does exist project
                return view('manage.build.notify.exist-property');
            }
        }

    }


    # info filter
    public function getCountry()
    {

    }

    #========== =========== ========== MINI MAP ========== ========== ==========
    public function getMiniMapContent($provinceId = '')
    {
        $modelProject = new TfProject();
        $project = $modelProject->infoOfProvince($provinceId);
        if (count($project) > 0) {
            foreach ($project as $dataProject) {
                echo view('manage.build.control.mini-map.mini-map-content', compact('dataProject'));
            }

        }


    }

    #========== ========== ========== MANAGE TOOL ========== ========== ==========
    # get project list
    public function getProjectMenu($provinceAccessId = '', $provinceFilterId = '')
    {
        $modelStaff = new TfStaff();
        #get staff info
        $dataStaff = $modelStaff->loginStaffInfo();
        $staffLevel = $dataStaff->level();
        # level manage
        if ($staffLevel == 1) {
            $listProvince = $dataStaff->listProvinceId();

            # only show project of province login
            if (!empty($provinceFilterId)) {
                $dataProject = TfProject::where('province_id', $provinceFilterId)->get();
            } else {
                $dataProject = TfProject::whereIn('province_id', $listProvince)->get();
            }
        } elseif ($staffLevel == 2) {
            # level build
            $listProject = $dataStaff->listProjectId();
            # only show project of province login
            if (!empty($provinceFilterId)) {
                $dataProject = TfProject::where('province_id', $provinceFilterId)->whereIn('project_id', $listProject)->get();
            } else {
                $dataProject = TfProject::whereIn('project_id', $listProject)->get();
            }
        }
        return view('manage.build.control.tool-menu.manage-build.manage-project', compact('provinceAccessId', 'provinceFilterId', 'dataProject'));
    }

    # get project publish
    public function getProjectPublish($provinceAccessId = null, $provinceFilterId = null)
    {
        $modelStaff = new TfStaff();
        $modelProvince = new TfProvince();
        $modelProjectBuild = new TfProjectBuild();
        #get staff info
        $dataStaff = $modelStaff->loginStaffInfo();
        $staffLevel = $dataStaff->level();
        if ($staffLevel == 1) {
            # level manage
            $listProject = $modelProjectBuild->listProjectIdWaitingPublish();
            $listProvinceId = $dataStaff->listProvinceId();
            if (!empty($provinceFilterId)) { # only show project of province login
                $dataProject = TfProject::whereIn('project_id', $listProject)->where('province_id', $provinceFilterId)->get();
            } else {
                $dataProject = TfProject::whereIn('project_id', $listProject)->whereIn('province_id', $listProvinceId)->get();
            }
            return view('manage.build.control.tool-menu.manage-build.manage-project-publish', compact('modelStaff', 'modelProvince', 'provinceAccessId', 'provinceFilterId', 'dataProject'));
        }
    }

    #========== ========== ========== BUILD TOOL ========== ========== ==========
    # get banner tool
    public function getBannerTool()
    {
        $modelBannerSample = new TfBannerSample();
        $dataBannerSample = $modelBannerSample->bannerTool();
        return view('manage.build.control.tool-menu.tool-build.build-banner', compact('dataBannerSample'));
    }

    # get land tool
    public function getLandTool()
    {
        $modelSize = new TfSize();
        $dataSize = $modelSize->sizeTool();
        return view('manage.build.control.tool-menu.tool-build.build-land', compact('dataSize'));

    }

    # get public tool
    public function getPublicTool($typeId = '')
    {
        $modelPublicSample = new TfPublicSample();
        $dataPublicSample = $modelPublicSample->publicTool($typeId);
        return view('manage.build.control.tool-menu.tool-build.build-public', compact('dataPublicSample'));
    }

    #----------- get project tool ----------
    public function getProjectTool()
    {
        $modelProjectSample = new TfProjectSample();
        $dataProjectSample = $modelProjectSample->projectTool();
        return view('manage.build.control.tool-menu.tool-build.build-project', compact('dataProjectSample'));
    }

    public function viewProjectSample($projectSampleId)
    {
        $dataProjectSample = TfProjectSample::find($projectSampleId);
        return view('manage.build.control.tool-menu.tool-build.build-project-view', compact('dataProjectSample'));
    }

    public function selectProjectSample($projectSampleId, $projectSetupId)
    {
        $modelProject = new TfProject();

        $modelBannerTransaction = new TfBannerTransaction();


        $modelLandTransaction = new TfLandTransaction();


        $dataProjectSample = TfProjectSample::find($projectSampleId);
        $dataProjectSampleBanner = $dataProjectSample->bannerInfo();
        $dataProjectSampleLand = $dataProjectSample->landInfo();
        $dataProjectSamplePublic = $dataProjectSample->publicInfo();
        $backgroundId = $dataProjectSample->backgroundId();

        #have to use background
        if (!empty($backgroundId)) {
            $modelProject->updateBackground($backgroundId, $projectSetupId);
        }

        # add banner
        if (count($dataProjectSampleBanner) > 0) {
            foreach ($dataProjectSampleBanner as $bannerObject) {
                $topPosition = $bannerObject->topPosition();
                $leftPosition = $bannerObject->leftPosition();
                $zIndex = $bannerObject->zIndex();
                $sampleId = $bannerObject->sampleId();
                $transactionStatusId = $bannerObject->transactionStatusId();

                $modelBanner = new TfBanner();
                $modelBanner->name = 'BANNER-' . ($modelBanner->lastId() + 1);
                $modelBanner->topPosition = $topPosition;
                $modelBanner->leftPosition = $leftPosition;
                $modelBanner->zindex = $zIndex;
                $modelBanner->pointValue = 0;
                $modelBanner->publish = 0;
                $modelBanner->project_id = $projectSetupId;
                $modelBanner->sample_id = $sampleId;
                if ($modelBanner->save()) {
                    $newBannerId = $modelBanner->banner_id;
                    $modelBannerTransaction->insert($newBannerId, $transactionStatusId);
                }
                /*
                if ($modelBanner->insert($topPosition, $leftPosition, $zIndex, 0, 0, $projectSetupId, $sampleId)) {
                    $newBannerId = $modelBanner->insertGetId();
                    $modelBannerTransaction->insert($newBannerId, $transactionStatusId);
                }
                */
            }
        }
        # add land
        if (count($dataProjectSampleLand) > 0) {
            foreach ($dataProjectSampleLand as $landObject) {
                $topPosition = $landObject->topPosition();
                $leftPosition = $landObject->leftPosition();
                $zIndex = $landObject->zIndex();
                $sizeId = $landObject->sizeId();
                $transactionStatusId = $landObject->transactionStatusId();

                $modelLand = new TfLand();
                $modelLand->name = 'LAND' . ($modelLand->lastId() + 1);
                $modelLand->topPosition = $topPosition;
                $modelLand->leftPosition = $leftPosition;
                $modelLand->zindex = $zIndex;
                $modelLand->publish = 0;
                $modelLand->project_id = $projectSetupId;
                $modelLand->size_id = $sizeId;
                if ($modelLand->save()) {
                    $newLandId = $modelLand->land_id;
                    $modelLandTransaction->insert($newLandId, $transactionStatusId);
                }
                /*
                if ($modelLand->insert($topPosition, $leftPosition, $zIndex, 0,$projectSetupId, $sizeId)) {
                    $newLandId = $modelLand->insertGetId();
                    $modelLandTransaction->insert($newLandId, $transactionStatusId);
                }
                */
            }
        }

        # add public
        if (count($dataProjectSamplePublic) > 0) {
            foreach ($dataProjectSamplePublic as $value => $publicObject) {
                $topPosition = $publicObject->topPosition();
                $leftPosition = $publicObject->leftPosition();
                $zIndex = $publicObject->zIndex();
                $sampleId = $publicObject->sampleId();

                $modelPublic = new TfPublic();
                $modelPublic->name = 'PUBLIC' . ($modelPublic->lastId() + 1);
                $modelPublic->topPosition = $topPosition;
                $modelPublic->leftPosition = $leftPosition;
                $modelPublic->zindex = $zIndex;
                $modelPublic->publish = 1;
                $modelPublic->project_id = $projectSetupId;
                $modelPublic->sample_id = $sampleId;
                $modelPublic->save();
                #$modelPublic->insert($topPosition, $leftPosition, $zIndex, 1, $projectSetupId, $sampleId);
            }
        }
    }

    #----------- project background -----------
    public function getBackgroundTool()
    {
        $modelProjectBackground = new TfProjectBackground();
        $dataProjectBackground = $modelProjectBackground->backgroundTool();
        return view('manage.build.control.tool-menu.tool-build.build-background', compact('dataProjectBackground'));
    }

    public function viewProjectBackground($backgroundId = null)
    {
        $dataProjectBackground = TfProjectBackground::find($backgroundId);
        return view('manage.build.control.tool-menu.tool-build.build-background-view', compact('dataProjectBackground'));
    }

    public function selectProjectBackground($backgroundId = null, $projectId = null)
    {
        $modelProject = new TfProject();
        if (!empty($backgroundId) && !empty($projectId)) {
            $modelProject->updateBackground($backgroundId, $projectId);
        }

    }

    public function dropProjectBackground($projectId = null)
    {
        $modelProject = new TfProject();
        if (!empty($projectId)) {
            $modelProject->updateBackground(null, $projectId);
        }
    }
}
