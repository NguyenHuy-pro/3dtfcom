<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Building\Post\TfBuildingPost;
use App\Models\Manage\Content\Building\PostNewNotify\TfBuildingPostNewNotify;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\Country\TfCountry;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Building\Comment\TfBuildingComment;
use App\Models\Manage\Content\Building\CommentNotify\TfBuildingCommentNotify;
use App\Models\Manage\Content\Building\Love\TfBuildingLove;
use App\Models\Manage\Content\Building\Notify\TfBuildingNewNotify;
use App\Models\Manage\Content\Building\Share\TfBuildingShare;
use App\Models\Manage\Content\Building\ShareNotify\TfBuildingShareNotify;
use App\Models\Manage\Content\Building\ShareView\TfBuildingShareView;
use App\Models\Manage\Content\Map\Banner\Share\TfBannerShare;
use App\Models\Manage\Content\Map\Banner\ShareNotify\TfBannerShareNotify;
use App\Models\Manage\Content\Map\Land\Share\TfLandShare;
use App\Models\Manage\Content\Map\Land\ShareNotify\TfLandShareNotify;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\Users\Friend\TfUserFriend;
use App\Models\Manage\Content\Users\FriendRequest\TfUserFriendRequest;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\Users\TfUser;
use App\Models\Manage\Content\System\Province\TfProvince;

use Illuminate\Http\Request;

class MainController extends Controller
{

    #========= ========== =========== HOME =========== =========== ===========
    public function index($buildingAlias = null, $shareCode = null)
    {
        $hFunction = new \Hfunction();
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelArea = new TfArea();
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $modelBusinessType = new TfBusinessType();
        $modelBuilding = new TfBuilding();
        $modelBuildingShare = new TfBuildingShare();
        $modelBuildingShareView = new TfBuildingShareView();

        $projectAccess = null; //use set position for map (province)
        $landAccess = null; // use set position for land
        $bannerAccess = null; // use set position for banner

        if (empty($buildingAlias)) {
            //get access project if exist user
            if ($modelUser->checkLogin()) {
                $dataUserLogin = $modelUser->loginUserInfo();

                // get one license of project
                $dataProjectLicense = $dataUserLogin->projectLicenseAccess();
                if (count($dataProjectLicense) > 0) { # exist license
                    $projectAccess = $dataProjectLicense->project;
                } else {
                    // get one license of land
                    $dataLandLicense = $dataUserLogin->landLicenseAccess();
                    // get project id of land
                    if (count($dataLandLicense) > 0) { # exist license of land
                        $landAccess = $dataLandLicense->land;
                        $projectAccess = $dataLandLicense->land->project;
                    } else {
                        // get one license of banner
                        $dataBannerLicense = $dataUserLogin->bannerLicenseAccess();

                        //get project id of banner
                        if (count($dataBannerLicense) > 0) {  # exist banner
                            $bannerAccess = $dataBannerLicense->banner;
                            $projectAccess = $dataBannerLicense->banner->project;
                        }
                    }
                }
            }
        } else {
            $dataBuilding = $modelBuilding->getInfoOfAlias($buildingAlias);
            if (count($dataBuilding) > 0) {
                $landAccess = $dataBuilding->landLicense->land;

                //visitor access building from share link
                if (!empty($shareCode)) {
                    $accessIP = $hFunction->getClientIP();
                    $dataBuildingShare = $modelBuildingShare->getInfoByShareCode($shareCode);
                    if (count($dataBuildingShare) > 0) {
                        $shareId = $dataBuildingShare->shareId();
                        if (!$modelBuildingShareView->existViewOfShareId($shareId)) {
                            $modelBuildingShareView->insert($accessIP, $shareId);
                        }
                    }
                }

                $projectAccess = $dataBuilding->landLicense->land->project;
            }
        }


        //exist access license of project|land|banner
        if (count($projectAccess) > 0) {
            $dataProject = $projectAccess;
            //set access info
            $provinceAccess = $dataProject->provinceId();
            $areaAccess = $dataProject->areaId();
        } else {
            //get default country
            $defaultCountryId = $modelCountry->defaultCountryId();
            //get default province of country
            $centerProvinceId = $modelProvince->centerProvinceOfCountry($defaultCountryId);
            $provinceAccess = $centerProvinceId;

            //get default area of province
            $areaAccess = $modelProvince->centerArea($centerProvinceId);
        }
        $dataMapAccess = [
            'provinceAccess' => $provinceAccess,
            'areaAccess' => $areaAccess,
            'projectAccess' => $projectAccess,
            'landAccess' => $landAccess,
            'bannerAccess' => $bannerAccess,
            'businessTypeAccess' => $modelBusinessType->getAccess()
        ];
        return view('map.map', compact('modelAbout', 'modelUser', 'modelProvince', 'modelArea', 'dataMapAccess'));
    }

    //guide build
    public function getGuideBasicBuild()
    {
        $modelUser = new TfUser();
        return view('components.guide.basic-build', compact('modelUser'));
    }

    public function homeCenter()
    {
        $modelArea = new TfArea();
        //drop current area
        $modelArea->forgetMainHistoryArea();
        return redirect()->route('tf.home');
    }
    #========== ========== ========== Owned ========== ========== ==========
    //building
    public function getBuildingOwned()
    {
        $modelUser = new TfUser();
        if ($modelUser->checkLogin()) {
            $ownedObject = 'building';
            $dataBuilding = $modelUser->buildingInfo($modelUser->loginUserId());
            return view('components.owned.owned-building', compact('dataBuilding', 'ownedObject'));
        }
    }

    //land
    public function getLandOwned()
    {
        $modelUser = new TfUser();
        if ($modelUser->checkLogin()) {
            $ownedObject = 'land';
            $dataLandLicense = $modelUser->landLicenseOfUser($modelUser->loginUserId());
            return view('components.owned.owned-land', compact('dataLandLicense', 'ownedObject'));
        }
    }

    //banner
    public function getBannerOwned()
    {
        $modelUser = new TfUser();
        if ($modelUser->checkLogin()) {
            $ownedObject = 'banner';
            $dataBanner = $modelUser->bannerInfoOfUser($modelUser->loginUserId());
            return view('components.owned.owned-banner', compact('dataBanner', 'ownedObject'));
        }
    }

    #========== ========== ========== Notify ========== ========== ==========
    #---------- friend ----------
    public function getNotifyFriend()
    {
        $modelUser = new TfUser();
        $modelUserFriend = new TfUserFriend();
        $modelUserFriendRequest = new TfUserFriendRequest();
        if ($modelUser->checkLogin()) {
            $dataUserLogin = $modelUser->loginUserInfo();
            $loginUserId = $modelUser->userId();

            // off notify about friend
            $dataUserLogin->userStatistic->formatFriendNotify($dataUserLogin->userId());

            //off new status of friend
            $modelUserFriend->updateNewInfoAll($loginUserId);

            $dataNotifyFriend = $dataUserLogin->notifyAboutFriend();
            return view('components.notify.friend.content', compact('modelUser', 'modelUserFriendRequest', 'dataNotifyFriend'));
        }
    }

    //hide notify
    public function hideNotifyFriendObject($userFriendId)
    {
        $modelUser = new TfUser();
        $modelUserFriend = new TfUserFriend();
        if ($modelUser->checkLogin()) {
            $modelUserFriend->updateStatus($modelUser->loginUserId(), $userFriendId);
        }
    }

    #---------- ---------- Action ---------- ----------
    public function getNotifyAction()
    {
        $modelBuilding = new TfBuilding();
        $modelBuildingShare = new TfBuildingShare();
        $modelBuildingComment = new TfBuildingComment();
        $modelBannerShare = new TfBannerShare();
        $modelLandShare = new TfLandShare();;
        $modelBuildingLove = new TfBuildingLove();
        $modelBuildingPost = new TfBuildingPost();
        $modelUser = new TfUser();
        if ($modelUser->checkLogin()) {
            $dataUserLogin = $modelUser->loginUserInfo();
            $userLoginId = $dataUserLogin->userId();

            $modelUser->offNewNotifyOfActivity($userLoginId);
            //off notify about activity
            $dataUserLogin->userStatistic->formatActionNotify($userLoginId);

            $dataNotifyAction = $dataUserLogin->notifyAboutAction();
            return view('components.notify.activity.content', compact('modelBuilding', 'modelBuildingPost', 'modelBuildingShare', 'modelBuildingComment', 'modelBuildingLove', 'modelBannerShare', 'modelLandShare', 'dataNotifyAction'));
        }
    }

    //hide notify new building
    public function hideNotifyActionBuildingNew($buildingId)
    {
        $modelUser = new TfUser();
        $modelNewNotify = new TfBuildingNewNotify();
        if ($modelUser->checkLogin()) {
            $modelNewNotify->updateStatus($buildingId, $modelUser->loginUserId());
        }
    }

    //hide notify of comment
    public function hideNotifyActionComment($commentId)
    {
        $modelUser = new TfUser();
        $modelCommentNotify = new TfBuildingCommentNotify();
        if ($modelUser->checkLogin()) {
            $modelCommentNotify->actionDelete($commentId, $modelUser->loginUserId());
        }
    }

    //hide notify love on building
    public function hideNotifyActionBuildingLove($loveId)
    {
        $modelUser = new TfUser();
        $modelBuildingLove = new TfBuildingLove();
        if ($modelUser->checkLogin()) {
            $modelBuildingLove->disableStatus($loveId);
        }
    }

    //hide notify share on building
    public function hideNotifyActionBuildingShare($shareId)
    {
        $modelUser = new TfUser();
        $modelShareNotify = new TfBuildingShareNotify();
        if ($modelUser->checkLogin()) {
            $modelShareNotify->updateStatus($shareId, $modelUser->loginUserId());
        }
    }

    //hide notify share on banner
    public function hideNotifyActionBannerShare($shareId)
    {
        $modelUser = new TfUser();
        $modelShareNotify = new TfBannerShareNotify();
        if ($modelUser->checkLogin()) {
            $modelShareNotify->updateStatus($shareId, $modelUser->loginUserId());
        }
    }

    //hide notify share on land
    public function hideNotifyActionLandShare($shareId)
    {
        $modelUser = new TfUser();
        $modelShareNotify = new TfLandShareNotify();
        if ($modelUser->checkLogin()) {
            $modelShareNotify->updateStatus($shareId, $modelUser->loginUserId());
        }
    }

    //hide notify of the post
    public function hideNotifyActionBuildingPost($postId)
    {
        $modelUser = new TfUser();
        $modelBuildingPostNewNotify = new TfBuildingPostNewNotify();
        if ($modelUser->checkLogin()) {
            $modelBuildingPostNewNotify->updateDisplayNotify($postId, $modelUser->loginUserId());
        }
    }

    #=========== =========== =========== LOGOUT =========== =========== ===========
    public function logout()
    {
        $modelUser = new TfUser();
        $modelUser->logout();
        return redirect()->route('tf.home');
    }
}
