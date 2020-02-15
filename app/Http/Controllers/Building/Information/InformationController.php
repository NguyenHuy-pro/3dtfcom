<?php namespace App\Http\Controllers\Building\Information;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Building\VisitHome\TfBuildingVisitHome;
use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\Sample\Building\TfBuildingSample;
use App\Models\Manage\Content\Sample\BuildingSampleLicense\TfBuildingSampleLicense;
use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
//use Illuminate\Http\Request;

use Request;
use File;
use Input;

class InformationController extends Controller
{
    public function index($alias)
    {
        $modelUser = new TfUser();
        $modelProject = new TfProject();
        $modelBuilding = new TfBuilding();
        $modelBannerImage = new TfBannerImage();
        $dataBuilding = $modelBuilding->getInfoOfAlias($alias);

        # info of user login
        $dataUserLogin = $modelUser->loginUserInfo();
        $accessStatus = false;
        if (count($dataUserLogin) > 0) {
            $userLoginId = $dataUserLogin->userId();
            if (count($dataBuilding) > 0) {
                $dataUserBuilding = $dataBuilding->userInfo();
                $userBuildingId = $dataUserBuilding->userId();
                if ($userLoginId == $userBuildingId) {
                    $dataBuildingAccess = [
                        'accessObject' => 'information',
                        'recentBuilding' => $modelBuilding->recentBuilding(5), //only take 5 records
                        'recentBannerImage' => $modelBannerImage->recentImage(5), // only take 5 records
                        'recentProject' => $modelProject->recentProjectPublished(5),
                    ];
                    $accessStatus = true;
                }
            }
        }
        if ($accessStatus) {
            return view('building.information.information', compact('modelUser', 'modelBuilding', 'dataBuilding', 'dataBuildingAccess'));
        } else {
            return redirect()->route('tf.home');
        }

    }

    //============ ============ ============ edit name ============ ============ ============
    public function getEditName($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            return view('building.information.name-edit', compact('modelUser', 'dataBuilding'));
        }

    }

    public function postEditName($buildingId)
    {
        $modelBuilding = new TfBuilding();
        $txtName = Request::input('txtName');
        if ($modelBuilding->updateName($buildingId, $txtName)) {
            return route('tf.building.information.get', $modelBuilding->alias($buildingId));
        }
    }

    //============ ============ ============ edit phone ============ ============ ============
    public function getEditPhone($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            return view('building.information.phone-edit', compact('modelUser', 'dataBuilding'));
        }

    }

    public function postEditPhone($buildingId)
    {
        $modelBuilding = new TfBuilding();
        $txtPhone = Request::input('txtPhone');
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            $modelBuilding->updatePhone($buildingId, $txtPhone);
        }
    }

    //============ ============ ============ edit email ============ ============ ============
    public function getEditEmail($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            return view('building.information.email-edit', compact('modelUser', 'dataBuilding'));
        }

    }

    public function postEditEmail($buildingId)
    {
        $mailObject = new \Mail3dtf();
        $modelBuilding = new TfBuilding();
        $txtEmail = Request::input('txtEmail');
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            if (strlen($txtEmail) > 0) {
                if ($mailObject->checkExist($txtEmail)) {
                    $modelBuilding->updateEmail($buildingId, $txtEmail);
                } else {
                    return trans('frontend_building.info_setting_edit_email_notify');
                }
            } else {
                $modelBuilding->updateEmail($buildingId, null);
            }
        }
    }

    //============ ============ ============ edit website ============ ============ ============
    public function getEditWebsite($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            return view('building.information.website-edit', compact('modelUser', 'dataBuilding'));
        }

    }

    public function postEditWebsite($buildingId)
    {
        $modelBuilding = new TfBuilding();
        $txtWebsite = Request::input('txtWebsite');
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            $modelBuilding->updateWebsite($buildingId, $txtWebsite);
        }
    }

    //============ ============ ============ edit address ============ ============ ============
    public function getEditAddress($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            return view('building.information.address-edit', compact('modelUser', 'dataBuilding'));
        }

    }

    public function postEditAddress($buildingId)
    {
        $modelBuilding = new TfBuilding();
        $txtAddress = Request::input('txtAddress');
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            $modelBuilding->updateAddress($buildingId, $txtAddress);
        }
    }

    //============ ============ ============ edit short description ============ ============ ============
    public function getEditShortDescription($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            return view('building.information.short-description-edit', compact('modelUser', 'dataBuilding'));
        }

    }

    public function postEditShortDescription($buildingId)
    {
        $modelBuilding = new TfBuilding();
        $content = Request::input('txtShortDescription');
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            $modelBuilding->updateShortDescription($buildingId, $content);
        }
    }

    //============ ============ ============ edit description ============ ============ ============
    public function getEditDescription($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            return view('building.information.description-edit', compact('modelUser', 'dataBuilding'));
        }

    }

    public function postEditDescription($buildingId)
    {
        $modelBuilding = new TfBuilding();
        $content = Request::input('txtDescription');
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataBuilding) > 0) {
            $modelBuilding->updateDescription($buildingId, $content);
        }
    }

    #========== ========== ========== Edit Sample ========== ==========
    public function getEditSample($buildingId, $privateStatus = '')
    {
        $modelBuilding = new TfBuilding();
        $modelBuildingSample = new TfBuildingSample();

        $dataBuilding = $modelBuilding->findInfo($buildingId);
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
        return view('building.information.sample-edit', compact('dataSelectInfo', 'dataBuildingSample'));
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
            $dataUserCard = $dataUserLogin->userCard;
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
                } else {
                    return view('point.components.buy-notify.buy-notify');
                }

            } else {
                $modelBuilding->updateSample($buildingId, $sampleId);
            }
        }

    }

}
