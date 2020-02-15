<?php namespace App\Http\Controllers\Map\Building;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Follow\TfBuildingFollow;
use App\Models\Manage\Content\Building\Love\TfBuildingLove;
use App\Models\Manage\Content\Building\Share\TfBuildingShare;
use App\Models\Manage\Content\Building\ShareNotify\TfBuildingShareNotify;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
//use Illuminate\Http\Request;
use Request;
use File, Input;

class BuildingController extends Controller
{
    public function getMobileMenu($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            return view('map.building.menu.m-menu-content', compact('modelUser', 'dataBuilding'));
        }
    }

    #---------- ---------- ---------- follow building ---------- ---------- ----------
    public function plusFollow($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $modelUserStatistic = new TfUserStatistic();
        $modelBuildingFollow = new TfBuildingFollow();

        $dataUserLogin = $modelUser->loginUserInfo();

        $dataBuilding = $modelBuilding->find($buildingId);
        if (count($dataUserLogin) > 0) {
            $loginUserId = $dataUserLogin->userId();
            // plus follow
            if ($modelBuildingFollow->insert($buildingId, $loginUserId)) {
                // update statistic info of building
                $dataBuilding->plusFollow();

                // add statistic
                $modelUserStatistic->plusBuildingFollow($loginUserId);

            }
            //refresh follow
            $dataBuilding = $modelBuilding->getInfo($buildingId);
            return view('map.building.information.information', compact('modelUser', 'dataBuilding'));
        } else {
            return view('map.building.notify.notify-login', compact('dataBuilding'));
        }


    }

    public function minusFollow($buildingId)
    {
        $modelUser = new TfUser();
        $modelUserStatistic = new TfUserStatistic();
        $modelBuilding = new TfBuilding();
        $modelBuildingFollow = new TfBuildingFollow();
        $dataUserLogin = $modelUser->loginUserInfo();

        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataUserLogin) > 0) {
            $loginUserId = $dataUserLogin->userId();

            // cancel follow
            if ($modelBuildingFollow->actionDelete($buildingId, $loginUserId)) {
                // update statistic info of building
                $dataBuilding->minusFollow();

                // minus statistic
                $modelUserStatistic->minusBuildingFollow($loginUserId);
            }
        }

        //refresh follow
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        return view('map.building.information.information', compact('modelUser', 'dataBuilding'));
    }

    #---------- ---------- ---------- Love building ---------- ---------- ----------
    public function plusLove($buildingId)
    {
        $modelUser = new TfUser();
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        $modelUserStatistic = new TfUserStatistic();
        $modelBuilding = new TfBuilding();
        $modelBuildingLove = new TfBuildingLove();

        $dataUserLogin = $modelUser->loginUserInfo();

        $dataBuilding = $modelBuilding->getInfo($buildingId);
        $dataUserBuilding = $dataBuilding->userInfo();

        $userBuildingId = $dataUserBuilding->userId();
        if (count($dataUserLogin) > 0) {
            $userLoginId = $dataUserLogin->userId();
            $newInfo = ($userLoginId == $userBuildingId) ? 0 : 1;
            // plus follow
            if ($modelBuildingLove->insert($buildingId, $userLoginId, $newInfo)) {
                // update statistic info of building
                $dataBuilding->plusLove();
                if ($newInfo == 1) {
                    //notify to owner of building
                    $modelUserStatistic->plusActionNotify($userBuildingId);
                    //insert notify
                    $modelUserNotifyActivity->insert($userBuildingId, null, null, $modelBuildingLove->insertGetId(), null, null, null, null);
                }
            }
            //refresh love
            $dataBuilding = $modelBuilding->getInfo($buildingId);
            return view('map.building.information.information', compact('modelUser', 'dataBuilding'));
        } else {
            return view('map.building.notify.notify-login', compact('dataBuilding'));
        }


    }

    public function minusLove($buildingId)
    {
        $modelUser = new TfUser();
        $modelUserStatistic = new TfUserStatistic();
        $modelBuildingLove = new TfBuildingLove();
        $modelBuilding = new TfBuilding();

        $dataUserLogin = $modelUser->loginUserInfo();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        $dataUserBuilding = $dataBuilding->userInfo();

        $userBuildingId = $dataUserBuilding->userId();
        if (count($dataUserLogin) > 0) {
            $userLoginId = $dataUserLogin->userId();
            // plus love
            if ($modelBuildingLove->actionDelete($buildingId, $userLoginId)) {
                // update statistic info of building
                $dataBuilding->minusLove();

                // cancel notify
                if ($userLoginId != $userBuildingId) {
                    $modelUserStatistic->minusActionNotify($userBuildingId);
                }
            }
        }

        //refresh love
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        return view('map.building.information.information', compact('modelUser', 'dataBuilding'));
    }

    #---------- ---------- ---------- Share building ---------- ---------- ----------
    // get form share
    public function getShare($buildingId = null)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        if (!empty($buildingId)) {
            $dataBuilding = $modelBuilding->getInfo($buildingId);
            if (count($dataBuilding) > 0) {
                return view('map.building.share.share-form', compact('modelUser', 'dataBuilding'));
            }
        }
    }

    public function postShare($buildingId)
    {
        $mailObject = new \Mail3dtf();
        $modelUser = new TfUser();
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        $modelUserStatistic = new TfUserStatistic();
        $modelBuildingShare = new TfBuildingShare();
        $modelBuilding = new TfBuilding();
        $modelBuildingShareNotify = new TfBuildingShareNotify();

        $shareCode = Request::input('shareCode');
        $email = Request::input('txtEmail');
        $message = Request::input('txtMessage');
        $listFriend = Request::input('shareFriend');

        $dataBuilding = $modelBuilding->getInfo($buildingId);
        $dataUserLogin = $modelUser->loginUserInfo();

        $loginUserId = $dataUserLogin->userId();
        if (!empty($loginUserId)) {
            $message = (empty($message)) ? null : $message;

            if (!empty($email)) {
                $buildingAlias = $dataBuilding->alias();
                $shareLink = route('tf.home', "$buildingAlias/$shareCode");
            } else {
                $email = null;
                $shareLink = null;
            }
            $modelBuildingShare->insert($shareCode, $message, $shareLink, $email, $buildingId, $loginUserId);
            $newShareId = $modelBuildingShare->insertGetId();

            $dataBuilding->plusShare();

            //nottify
            // share to email
            if (!empty($email)) {
                $userName = $dataUserLogin->fullName();
                $content = "
                    Hi
                    $userName invite you to visit a building on 3dtf.com.

                    You click link below to visit building.
                    $shareLink
                    Thanks!";
                $mailObject->sendFromGmail("Welcome to system 3DTF.COM", $email, $content);
            }

            //share to friend
            if (count($listFriend) > 0) {
                foreach ($listFriend as $key => $value) {
                    $modelBuildingShareNotify->insert($newShareId, $value);
                    $modelUserStatistic->plusActionNotify($value);

                    //insert notify
                    $modelUserNotifyActivity->insert($value, null, $newShareId, null, null, null, null, null);
                }
            }

            //refresh love
            $dataBuilding = $modelBuilding->getInfo($buildingId);
            return view('map.building.information.information', compact('modelUser', 'dataBuilding'));
        }

    }

    //get link to share
    public function shareLink($buildingId, $shareCode)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $modelBuildingShare = new TfBuildingShare();
        $dataUserLogin = $modelUser->loginUserInfo();
        if (count($dataUserLogin) > 0) {
            if (!$modelBuildingShare->existShareCode($shareCode)) {
                $dataBuilding = $modelBuilding->getInfo($buildingId);
                $buildingAlias = $dataBuilding->alias();
                $shareLink = route('tf.home', "$buildingAlias/$shareCode");
                $userId = $dataUserLogin->userId();
                $modelBuildingShare->insert($shareCode, null, $shareLink, null, $buildingId, $userId);
                $dataBuilding->plusShare();
            }

            //refresh love
            $dataBuilding = $modelBuilding->getInfo($buildingId);
            return view('map.building.information.information', compact('modelUser', 'dataBuilding'));
        }

    }

    //delete building
    public function deleteBuilding($buildingId)
    {
        $modelUser = new TfUser();
        $modelLand = new TfLand();
        $modelBuilding = new TfBuilding();
        $modelBusinessType = new TfBusinessType();
        $dataUserLogin = $modelUser->loginUserInfo();
        $dataBuilding = $modelBuilding->getInfo($buildingId);

        if ($modelUser->checkLogin()) {

            //  building  of user login
            if ($modelBuilding->checkBuildingOfUser($buildingId, $dataUserLogin->userId())) {
                $dataLandLicense = $dataBuilding->landLicense;
                $landId = $dataLandLicense->landId();

                // delete
                $modelBuilding->actionDelete($buildingId);

                // set access info
                //refresh info
                $dataLand = $modelLand->getInfo($landId);
                $dataProject = $dataLand->project;
                // set access project info

                $dataMapAccess = [
                    'provinceAccess' => $dataProject->provinceId(),
                    'areaAccess' => $dataProject->areaId(),
                    'landAccess' => $dataLand,
                    'bannerAccess' => 0,
                    'businessTypeAccess' => $modelBusinessType->getAccess(),
                    'projectOwnStatus' => 0, // undeveloped project sale,
                    'settingStatus' => 0, // undeveloped project sale (not setup)
                    'projectRankId' => $dataProject->getRankId()
                ];

                return view('map.land.land', compact('modelUser', 'dataLand', 'dataMapAccess'));

            }
        }
    }
}
