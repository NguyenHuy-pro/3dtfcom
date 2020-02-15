<?php namespace App\Http\Controllers\Map\Building\Information;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Business\TfBuildingBusiness;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\Sample\Building\TfBuildingSample;
use App\Models\Manage\Content\Sample\BuildingSampleLicense\TfBuildingSampleLicense;
use App\Models\Manage\Content\System\Business\TfBusiness;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
#use Illuminate\Http\Request;
use Request;
use Input;

class InformationController extends Controller
{

    #========== ========== ========== Edit information ========== ========== ==========
    public function getEditInfo($buildingId)
    {
        $modelBuilding = new TfBuilding();
        $modelBusiness = new TfBusiness();
        $dataBuilding = $modelBuilding->findInfo($buildingId);

        //sample info
        $businessTypeId = $dataBuilding->buildingSample->businessTypeId();

        //filter info  business follow business type
        $dataBusiness = $modelBusiness->infoOfBusinessType($businessTypeId);
        return view('map.building.information.info-edit', compact('modelBuilding', 'dataBuilding', 'dataBusiness'));
    }

    public function postEditInfo($buildingId)
    {
        $modelUser = new TfUser();
        $modelLand = new TfLand();
        $modelBuilding = new TfBuilding();
        $modelBusinessType = new TfBusinessType();

        $dataBuilding = $modelBuilding->findInfo($buildingId);
        if ($modelUser->checkLogin()) {
            if ($dataBuilding->checkBuildingOfUser($buildingId, $modelUser->loginUserId())) {
                $name = Request::input('txtName');
                $displayName = Request::input('txtDisplayName');
                $listBusiness = Request::input('buildingBusiness');
                $shortDescription = Request::input('txtShortDescription');
                $description = Request::input('txtDescription');
                $website = Request::input('txtWebsite');
                $address = Request::input('txtAddress');
                $phone = Request::input('txtPhone');
                $email = Request::input('txtEmail');

                $modelBuilding->updateInfo($buildingId, $name, $displayName, $shortDescription, $description, $website, $phone, $address, $email);
                //field work of building
                if (count($listBusiness) > 0) {
                    $oldListBusinessId = $dataBuilding->listBusinessId();

                    //add new business for building
                    foreach ($listBusiness as $key => $newBusiness) {
                        $modelBuildingBusiness = new TfBuildingBusiness();
                        if (!in_array($newBusiness, $oldListBusinessId)) $modelBuildingBusiness->insert($buildingId, $newBusiness);
                    }

                    //delete business of building
                    foreach ($oldListBusinessId as $oldBusiness) {
                        $modelBuildingBusiness = new TfBuildingBusiness();
                        if (!in_array($oldBusiness, $listBusiness)) $modelBuildingBusiness->actionDelete($buildingId, $oldBusiness);
                    }
                }

                //refresh info
                $landId = $dataBuilding->landId();
                $dataLand = $modelLand->getInfo($landId);
                $dataProject = $dataLand->project;
                //set access project info
                $dataMapAccess = [
                    'provinceAccess' => $dataProject->provinceId(),
                    'areaAccess' => $dataProject->areaId(),
                    'landAccess' => $dataLand,
                    'bannerAccess' => null,
                    'businessTypeAccess' => $modelBusinessType->getAccess(),
                    'projectOwnStatus' => 0, // undeveloped project sale,
                    'settingStatus' => 0, // undeveloped project sale (not setup)
                    'projectRankId' => $dataProject->getRankId()
                ];
                return view('map.land.land', compact('modelUser', 'dataLand', 'dataMapAccess'));
            }
        }

    }

    #========== ========== ========== Edit building sample ========== ==========
    public function getEditSample($buildingId, $privateStatus = '')
    {
        $modelBuilding = new TfBuilding();
        $modelBuildingSample = new TfBuildingSample();

        $dataBuilding = $modelBuilding->findInfo($buildingId);

        //info building
        //$sampleId = $modelBuilding->sampleId($buildingId);

        //ample info of building is using
        $oldDataSample = $dataBuilding->buildingSample;
        $sizeId = $oldDataSample->sizeId();
        $businessTypeId = $oldDataSample->businessTypeId();

        $privateStatus = (($privateStatus == '')) ? 0 : $privateStatus;
        # get building sample

        $dataBuildingSample = $modelBuildingSample->getBuildingSampleForBuild($sizeId, $privateStatus, $businessTypeId);
        $dataSelectInfo = [
            'buildingId' => $buildingId,
            'privateStatus' => $privateStatus,
        ];
        return view('map.building.information.building-sample-select', compact('dataSelectInfo', 'dataBuildingSample'));
    }

    public function changeSample($buildingId, $sampleId)
    {
        $modelUser = new TfUser();
        $modelUserCard = new TfUserCard();
        $modelUserStatistic = new TfUserStatistic();
        $modelBuilding = new TfBuilding();
        $modelBuildingSample = new TfBuildingSample();
        $modelBuildingSampleLicense = new TfBuildingSampleLicense();

        $dataUserLogin = $modelUser->loginUserInfo();
        if (count($dataUserLogin) > 0) {
            $loginUserId = $dataUserLogin->userId();
            $dataUserCard = $modelUserCard->infoOfUser($loginUserId);
            $cardId = $dataUserCard->cardId();
            $userPoint = $dataUserCard->pointValue();
            if (!$modelBuildingSampleLicense->existSampleOfUser($sampleId, $loginUserId)) {
                //user must payment
                $paymentPoint = $modelBuildingSample->price($sampleId);
                if ($userPoint >= $paymentPoint) {
                    if ($modelUserCard->decreasePoint($cardId, $paymentPoint, 'buy building sample')) {
                        //payment success
                        //add license for user
                        if ($modelBuildingSampleLicense->insert($sampleId, $loginUserId)) {
                            $modelUserStatistic->plusBuildingSample($loginUserId);
                        }
                        $modelBuilding->updateSample($buildingId, $sampleId);
                    }
                }

            } else {
                $modelBuilding->updateSample($buildingId, $sampleId);
            }
            $dataBuilding = $modelBuilding->findInfo($buildingId);
            return view('map.building.building', compact('modelUser', 'dataBuilding'));
        }

        /*
        if ($modelUser->checkLogin()) {
            $dataUserLogin = $modelUser->loginUserInfo();
            $loginUserId = $dataUserLogin->userId();
            if ($modelBuilding->updateSample($buildingId, $sampleId)) {

                if (!$modelBuildingSampleLicense->existSampleOfUser($sampleId, $loginUserId)) {
                    $modelUserStatistic->plusBuildingSample($loginUserId);
                    //user did not have this sample.
                    //user must payment
                    $paymentPoint = $modelBuildingSample->price($sampleId);
                    $cardId = $dataUserLogin->cardId();

                    if ($modelUserCard->decreasePoint($cardId, $paymentPoint, 'buy building sample')) {
                        //payment success
                        //add license for user
                        $modelBuildingSampleLicense->insert($sampleId, $loginUserId);
                    }
                }
            }
        }
        */

    }

    public function checkPointEditSample($sampleId)
    {
        $modelUser = New TfUser();
        $modelBuildingSample = new TfBuildingSample();
        $dataUserLogin = $modelUser->loginUserInfo();
        if (count($dataUserLogin) > 0) {
            //user does not enough point to pay
            if ($dataUserLogin->point() < $modelBuildingSample->price($sampleId)) {
                return view('point.components.buy-notify.buy-notify');
            }
        } else {
            return view('components.login.login-notify');
        }

    }

}
