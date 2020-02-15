<?php namespace App\Http\Controllers\Map\Land;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Business\TfBuildingBusiness;
use App\Models\Manage\Content\Building\Notify\TfBuildingNewNotify;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\Map\Land\License\TfLandLicense;
use App\Models\Manage\Content\Map\Land\RequestBuild\TfLandRequestBuild;
use App\Models\Manage\Content\Map\Land\Share\TfLandShare;
use App\Models\Manage\Content\Map\Land\ShareView\TfLandShareView;
use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\Map\RequestBuildPrice\TfRequestBuildPrice;
use App\Models\Manage\Content\Sample\BuildingSampleLicense\TfBuildingSampleLicense;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\System\Relation\TfRelation;
use App\Models\Manage\Content\Users\Activity\TfUserActivity;
use App\Models\Manage\Content\Users\ExchangeBuildingSample\TfUserExchangeBuildingSample;
use App\Models\Manage\Content\Users\ExchangeLand\TfUserExchangeLand;
use App\Models\Manage\Content\Sample\Building\TfBuildingSample;
use App\Models\Manage\Content\System\Business\TfBusiness;
use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
//use Illuminate\Http\Request;
use FIle;
use Input;
use DB;
use Request;

class LandController extends Controller
{
    public function accessLand($landId = null, $shareCode = null)
    {
        $hFunction = new \Hfunction();
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelBusinessType = new TfBusinessType();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();
        $modelLand = new TfLand();
        $modelLandShare = new TfLandShare();
        $modelLandShareView = new TfLandShareView();

        $existStatus = false;
        //check existing land
        if (!empty($landId)) $existStatus = $modelLand->existLand($landId);

        //existing land
        if ($existStatus) {
            //visitor access banner from share link
            if (!empty($shareCode)) {
                $accessIP = $hFunction->getClientIP();
                $dataLandShare = $modelLandShare->getInfoByShareCode($shareCode);
                if (!empty($dataLandShare)) {
                    $shareId = $dataLandShare->shareId();
                    if (!$modelLandShareView->existViewOfShareId($shareId)) {
                        $modelLandShareView->insert($accessIP, $shareId);
                    }
                }
            }

            $dataLand = $modelLand->getInfo($landId);
            $dataProject = $dataLand->project;
            $dataMapAccess = [
                'provinceAccess' => $dataProject->provinceId(),
                'areaAccess' => $dataProject->areaId(),
                'landAccess' => $dataLand,
                'bannerAccess' => null,
                'businessTypeAccess' => $modelBusinessType->getAccess()
            ];

            // set load area into history
            $modelArea->setMainHistoryArea($dataProject->areaId());
            return view('map.map', compact('modelAbout', 'modelUser', 'modelProvince', 'modelArea', 'dataMapAccess'));
        } else {
            return redirect()->back();
        }

    }

    //get menu
    public function getMenu($landId = null)
    {
        $modelUser = new TfUser();
        $modelLand = new TfLand();
        if (!empty($landId)) {
            $dataLand = $modelLand->getInfo($landId);
            return view('map.land.menu.m-land-menu-content', compact('modelUser', 'dataLand'));
        }
    }

    #=========== ========= ========== TRANSACTION ============ ========= =========
    #--------- ----------- SALE ---------- ----------
    // select buy land
    public function getBuy($landId = null)
    {
        $modelUser = new TfUser();
        $modelLand = new TfLand();
        $dataLand = $modelLand->getInfo($landId);
        return view('map.land.transaction.buy-select', compact('modelUser', 'dataLand'));
    }

    // payment
    public function postBuy($landId = null)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserCard = new TfUserCard();
        $modelBusinessType = new TfBusinessType();
        $modelLand = new TfLand();

        //user info
        $dataUserLogin = $modelUser->loginUserInfo();
        $dataLand = $modelLand->getInfo($landId);

        $loginUserId = $dataUserLogin->userId();
        $userPoint = $modelUser->point($loginUserId);
        //exist license
        if (!$dataLand->existLicense()) {
            $projectRankId = $dataLand->project->getRankId();

            // transaction info
            $transactionStatusId = $dataLand->transactionStatusId();
            $sizeId = $dataLand->sizeId();
            $dataRuleLand = $dataLand->ruleOfSizeAndRank($sizeId, $projectRankId);
            $paymentPoint = $dataRuleLand->salePrice();
            $saleMonth = $dataRuleLand->saleMonth();

            //the user enough point to payment
            if ($userPoint >= $paymentPoint) {
                $cardId = $dataUserLogin->cardId();
                if ($modelUserCard->decreasePoint($cardId, $paymentPoint, 'buy land')) {
                    // add license for land
                    $modelLandLicense = new TfLandLicense();
                    //use datetime
                    $dateBegin = $hFunction->carbonNow();
                    $dateEnd = $hFunction->carbonNowAddMonths($saleMonth);

                    if ($modelLandLicense->insert($dateBegin, $dateEnd, $landId, $loginUserId, $transactionStatusId)) {
                        $newLandLicenseId = $modelLandLicense->insertGetId();
                        // insert table land exchange
                        $modelUserExchangeLand = new TfUserExchangeLand();
                        $modelUserExchangeLand->insert($paymentPoint, $cardId, $newLandLicenseId);

                        $modelUserStatistic = new TfUserStatistic();
                        if ($modelUserStatistic->existUser($loginUserId)) {
                            $modelUserStatistic->plusLand($loginUserId);
                        } else {
                            $modelUserStatistic->insert($loginUserId, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0);
                        }
                    }
                }
            }

            //refresh info
            $dataLand = $modelLand->getInfo($landId);
            $dataProject = $dataLand->project;
            // set access project info
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

    #--------- ---------- FREE ---------- ----------
    // info of free land
    public function getFree($landId)
    {
        $modelUser = new TfUser();
        $modelLand = new TfLand();
        $dataLand = $modelLand->getInfo($landId);
        return view('map.land.transaction.free-select', compact('modelUser', 'dataLand'));
    }

    // agree select free land
    public function postFree($landId)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelLand = new TfLand();
        $modelBusinessType = new TfBusinessType();
        $dataLand = $modelLand->getInfo($landId);
        //user info
        $dataUserLogin = $modelUser->loginUserInfo();
        $loginUserId = $dataUserLogin->userId();
        $cardId = $dataUserLogin->cardId();

        //exist license
        if (!$dataLand->existLicense()) {
            $projectRankId = $dataLand->project->getRankId();


            // transaction info
            $transactionStatusId = $dataLand->transactionStatusId();
            $sizeId = $dataLand->sizeId();
            $dataRuleLand = $dataLand->ruleOfSizeAndRank($sizeId, $projectRankId);
            $freeMonth = $dataRuleLand->freeMonth();
            // add license for land
            $modelLandLicense = new TfLandLicense();

            //use datetime
            $dateBegin = $hFunction->carbonNow();
            $dateEnd = $hFunction->carbonNowAddMonths($freeMonth);
            if ($modelLandLicense->insert($dateBegin, $dateEnd, $landId, $loginUserId, $transactionStatusId)) {
                $newLandStatusId = $modelLandLicense->insertGetId();
                // insert table land exchange
                $modelUserExchangeLand = new TfUserExchangeLand();
                $modelUserExchangeLand->insert(0, $cardId, $newLandStatusId);

                $modelUserStatistic = new TfUserStatistic();
                if ($modelUserStatistic->existUser($loginUserId)) {
                    $modelUserStatistic->plusLand($loginUserId);
                } else {
                    $modelUserStatistic->insert($loginUserId, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0);
                }
            }

            //refresh info
            $dataLand = $modelLand->getInfo($landId);
            $dataProject = $dataLand->project;
            // set access project info
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

    #=========== ========= ========== BUILD ============ ========= =========
    //---------- get public building sample ----------
    public function getBuildingSample($landId = null, $privateStatus = 0, $businessTypeId = 999999999)
    {
        $modelLand = new TfLand();
        $modelBuildingSample = new TfBuildingSample();
        $modelBusinessType = new TfBusinessType();

        // info of land
        $dataLand = $modelLand->getInfo($landId);
        $sizeId = $dataLand->sizeId();

        if ($businessTypeId == 999999999 && $privateStatus == 0) {
            $businessTypeId = $modelBusinessType->defaultTypeId();
        }

        //get building sample
        $dataBuildingSample = $modelBuildingSample->getBuildingSampleForBuild($sizeId, $privateStatus, $businessTypeId);
        $dataSelectInfo = [
            'landId' => $landId,
            'privateStatus' => $privateStatus,
            'businessTypeId' => $businessTypeId,
        ];
        return view('map.land.build.select-building-sample', compact('dataSelectInfo', 'dataBuildingSample', 'modelBusinessType'));
    }

    //---------- ---------- add building ----------- ----------
    // form add
    public function getAddBuilding($landId, $sampleId)
    {
        $modelUser = new TfUser();
        $modelBusinessType = new TfBusinessType();
        $modelBusiness = new TfBusiness();
        $modelBuildingSample = new TfBuildingSample();
        $modelBuildingSampleLicense = new TfBuildingSampleLicense();
        $modelLand = new TfLand();


        $dataLand = $modelLand->getInfo($landId);

        // sample info
        $dataBuildingSample = $modelBuildingSample->getInfo($sampleId);
        $businessTypeId = $dataBuildingSample->businessTypeId();

        // filter info  business follow business type
        $dataBusiness = $modelBusiness->infoOfBusinessType($businessTypeId);
        return view('map.land.build.add-building', compact('modelUser', 'dataLand', 'dataBuildingSample', 'dataBusiness', 'modelBusinessType', 'modelBuildingSampleLicense'));
    }

    // add new building
    public function postAddBuilding($landId, $sampleId)
    {
        $modelRelation = new TfRelation();
        $modelUser = new TfUser();
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        $modelUserActivity = new TfUserActivity();
        $modelUserCard = new TfUserCard();
        $modelLand = new TfLand();
        $modelLandLicense = new TfLandLicense();
        $modelBuilding = new TfBuilding();
        $modelBuildingSample = new TfBuildingSample();
        $modelBusinessType = new TfBusinessType();
        $modelExchangeSample = new TfUserExchangeBuildingSample();

        $name = Request::input('txtName');
        $displayName = Request::input('txtDisplayName');
        $listBusiness = Request::input('buildingBusiness');
        $shortDescription = Request::input('txtShortDescription');
        $description = Request::input('txtDescription');
        $website = Request::input('txtWebsite');
        $address = Request::input('txtAddress');
        $phone = Request::input('txtPhone');
        $email = Request::input('txtEmail');

        $dataUserLogin = $modelUser->loginUserInfo();
        if (count($dataUserLogin) > 0) {
            $loginUserId = $dataUserLogin->userId();
            $dataBuildingSample = $modelBuildingSample->getInfo($sampleId);
            $postRelationId = $modelRelation->publicRelationId(); //default public = 1
            $metaKeyword = null; //develop later
            $landLicenseId = $modelLandLicense->licenseIdViableOfLand($landId);
            if ($modelBuilding->insert($name, $displayName, $shortDescription, $description, $website, $phone, $address, $email, $sampleId, $landLicenseId, $postRelationId, $metaKeyword)) {
                //insert success
                $newBuildingId = $modelBuilding->insertGetId();

                //update activity of user
                $modelUserActivity->insert(null, $newBuildingId, null, $loginUserId, null);

                // field work of building
                if (count($listBusiness) > 0) {
                    foreach ($listBusiness as $key => $value) {
                        $modelBuildingBusiness = new TfBuildingBusiness();
                        $modelBuildingBusiness->insert($newBuildingId, $value);
                    }
                }

                $modelUserStatistic = new TfUserStatistic();
                $modelBuildingSampleLicense = new TfBuildingSampleLicense();
                if ($modelUserStatistic->existUser($loginUserId)) {
                    $modelUserStatistic->plusBuilding($loginUserId);
                } else {
                    $modelUserStatistic->insert($loginUserId, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0);
                }

                if (!$modelBuildingSampleLicense->existSampleOfUser($sampleId, $loginUserId)) {
                    $modelUserStatistic->plusBuildingSample($loginUserId);
                    //user did not have this sample.
                    // user must payment
                    $paymentPoint = $dataBuildingSample->price();
                    $cardId = $dataUserLogin->cardId();
                    if ($modelUserCard->decreasePoint($cardId, $paymentPoint, 'buy building sample')) {
                        // payment success
                        // add license for user
                        $modelBuildingSampleLicense->insert($sampleId, $loginUserId);

                        $modelExchangeSample->insert($cardId, $sampleId, $paymentPoint);
                    }
                }

                //notify for friend
                $listFriend = $dataUserLogin->listFriendId();
                if (!empty($listFriend)) {
                    foreach ($listFriend as $key => $value) {
                        $modelBuildingNewNotify = new TfBuildingNewNotify();
                        $modelBuildingNewNotify->insert($newBuildingId, $value);
                        $modelUserStatistic->plusActionNotify($value);
                        //insert notify
                        $modelUserNotifyActivity->insert($value, null, null, null, null, $newBuildingId, null, null);
                    }
                }

                // set access info
                //refresh info
                $dataLand = $modelLand->getInfo($landId);
                $dataProject = $dataLand->project;
                // set access project info
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

    //---------- ---------- request build ----------- ----------
    public function getRequestBuild($licenseId)
    {
        $modelUser = new TfUser();
        $modelRequestBuildPrice = new TfRequestBuildPrice();
        $modelBusinessType = new TfBusinessType();
        $modelLandLicense = new TfLandLicense();
        $modelLandRequestBuild = new TfLandRequestBuild();
        if ($modelUser->checkLogin()) {
            if (!$modelLandRequestBuild->existLandLicense($licenseId)) {
                $loginUserId = $modelUser->loginUserId();
                $userPoint = $modelUser->point($loginUserId);
                $dataLandLicense = $modelLandLicense->getInfo($licenseId);
                $dataRequestBuildPrice = $modelRequestBuildPrice->infoEnableOfSize($dataLandLicense->land->sizeId());
                if (count($dataRequestBuildPrice) > 0) {
                    if ($userPoint >= $dataRequestBuildPrice->price()) {
                        return view('map.land.request-build.request-build', compact('modelUser', 'dataLandLicense', 'modelBusinessType', 'dataRequestBuildPrice'));
                    } else {
                        return view('map.land.request-build.request-build-notify-point', compact('modelUser', 'dataLandLicense', 'dataRequestBuildPrice'));
                    }
                } else {
                    return view('map.land.request-build.request-build-notify-price');
                }

            } else {
                return view('map.land.request-build.request-build-notify-success');
            }

        }

    }

    public function sendRequestBuild($licenseId)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserCard = new TfUserCard();
        $modelRequestBuildPrice = new TfRequestBuildPrice();
        $modelLandLicense = new TfLandLicense();
        $modelLandRequestBuild = new TfLandRequestBuild();
        $txtDesignDescription = Request::input('txtDesignDescription');
        $cbBusinessType = Request::input('cbBusinessType');
        $txtFullName = Request::input('txtFullName');
        $txtDisplayName = Request::input('txtDisplayName');
        $txtShortDescription = Request::input('txtShortDescription');
        $txtDescription = Request::input('txtDescription');
        $website = Request::input('txtWebsite');
        $address = Request::input('txtAddress');
        $phone = Request::input('txtPhone');
        $email = Request::input('txtEmail');
        if ($modelUser->checkLogin()) {
            $dataUserLogin = $modelUser->loginUserInfo();
            $loginUserId = $dataUserLogin->userId();
            $userPoint = $modelUser->point($loginUserId);
            $dataLandLicense = $modelLandLicense->getInfo($licenseId);

            $dataRequestBuildPrice = $modelRequestBuildPrice->infoEnableOfSize($dataLandLicense->land->sizeId());
            $requestPoint = $dataRequestBuildPrice->price();
            if ($userPoint < $requestPoint) {
                return view('map.land.request-build.request-build-notify-point', compact('modelUser', 'dataLandLicense', 'dataRequestBuildPrice'));
            } else {
                if (Input::hasFile('txtImage')) {
                    $file = Request::file('txtImage');
                    $imageName = $file->getClientOriginalName();
                    $imageName = "request-build-" . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
                    if ($modelLandRequestBuild->uploadImage($file, $imageName)) {
                        //insert request
                        if (!$modelLandRequestBuild->insert($imageName, $txtDesignDescription, $txtFullName, $txtDisplayName, $phone, $email, $address, $website, $txtShortDescription, $txtDescription, $requestPoint, $cbBusinessType, $licenseId)) {
                            $modelLandRequestBuild->dropImage($imageName);
                        } else {
                            $cardId = $dataUserLogin->cardId();
                            $modelUserCard->decreasePoint($cardId, $requestPoint, 'request build');
                            return view('map.land.request-build.request-build-notify-success');
                        }
                    }
                }
            }
        }
    }

    //cancel the build request
    public function cancelRequestBuild($requestId)
    {
        $modelUser = new TfUser();
        $modelBusinessType = new TfBusinessType();
        $modelLand = New TfLand();
        $modelLandRequestBuild = new TfLandRequestBuild();
        $dataLandRequestBuild = $modelLandRequestBuild->getInfo($requestId);

        $dataLandLicense = $dataLandRequestBuild->landLicense;
        if ($modelLandRequestBuild->actionDelete($requestId)) {
            $dataLand = $modelLand->getInfo($dataLandLicense->landId());
            $dataProject = $dataLand->project;
            // set access project info
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

