<?php namespace App\Http\Controllers\Building;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Ads\Banner\TfAdsBanner;
use App\Models\Manage\Content\Building\BadInfoReport\TfBuildingBadInfoReport;
use App\Models\Manage\Content\Building\Follow\TfBuildingFollow;
use App\Models\Manage\Content\Building\Love\TfBuildingLove;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Building\VisitHome\TfBuildingVisitHome;
use App\Models\Manage\Content\Building\VisitWebsite\TfBuildingVisitWebsite;
use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\BadInfo\TfBadInfo;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
#use Illuminate\Http\Request;

use Request;
use File, Input;

class BuildingController extends Controller
{
    public function index($alias = '')
    {
        $modelUser = new TfUser();
        $modelProject = new TfProject();
        $modelBuilding = new TfBuilding();
        $modelBannerImage = new TfBannerImage();
        $modelBuildingVisitHome = new TfBuildingVisitHome();
        $userLoginId = $modelUser->loginUserId();

        $dataBuilding = $modelBuilding->getInfoOfAlias($alias);
        //exist building
        if (!empty($dataBuilding)) {
            //insert visit home
            $modelBuildingVisitHome->insert($dataBuilding->buildingId(), $userLoginId);

            $dataBuildingAccess = [
                'accessObject' => 'activity',
                'recentBuilding' => $modelBuilding->recentBuilding(5), //only take 5 records
                'recentBannerImage' => $modelBannerImage->recentImage(5), // only take 5 records
                'recentProject' => $modelProject->recentProjectPublished(5)
            ];
            //return view('building.posts.posts', compact('modelUser', 'modelBuilding', 'dataBuilding', 'dataBuildingAccess'));
            return view('building.activity.activity', compact('modelUser', 'modelBuilding', 'dataBuilding', 'dataBuildingAccess'));
        } else {
            return redirect()->route('tf.home');
        }

    }

    #---------- ---------- ---------- Report ---------- ---------- ----------
    public function getReport($buildingId = null)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $modelBuildingReport = new TfBuildingBadInfoReport();
        $modelBadInfo = new TfBadInfo();

        $userLoginId = $modelUser->loginUserId();
        if (!empty($userLoginId)) {
            if ($modelBuildingReport->checkUserReported($userLoginId, $buildingId)) {
                return view('building.report.notify');
            } else {
                $dataBadInfo = $modelBadInfo->getInfo();
                $dataBuilding = $modelBuilding->getInfo($buildingId);
                if (count($dataBadInfo) > 0) {
                    return view('building.report.bad-info', compact('dataBuilding', 'dataBadInfo'));
                }
            }
        }

    }

    public function sendReport()
    {
        $modelUser = new TfUser();
        $modelBuildingReport = new TfBuildingBadInfoReport();
        $buildingId = Request::input('building');
        $badInfoId = Request::input('badInfo');
        $userId = $modelUser->loginUserId();
        $modelBuildingReport->insert($buildingId, $userId, $badInfoId);

    }

    #---------- ---------- ---------- follow building ---------- ---------- ----------
    //follow buildings
    public function plusFollow($buildingId = null)
    {
        $modelUser = new TfUser();
        $modelUserStatistic = new TfUserStatistic();
        $modelBuilding = new TfBuilding();
        $modelBuildingFollow = new TfBuildingFollow();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId)) {
            // plus follow
            if ($modelBuildingFollow->insert($buildingId, $loginUserId)) {
                // update statistic info of building
                $modelBuilding->plusFollow($buildingId);

                // add statistic
                $modelUserStatistic->plusBuildingFollow($loginUserId);
            }
        }
    }

    //cancel follow buildings
    public function minusFollow($buildingId = null)
    {
        $modelUser = new TfUser();
        $modelUserStatistic = new TfUserStatistic();
        $modelBuilding = new TfBuilding();
        $modelBuildingFollow = new TfBuildingFollow();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId)) {
            // cancel follow
            if ($modelBuildingFollow->actionDelete($buildingId, $loginUserId)) {
                // update statistic info of building
                $modelBuilding->minusFollow($buildingId);

                // minus statistic
                $modelUserStatistic->minusBuildingFollow($loginUserId);
            }
        }
    }

    #---------- ---------- ---------- Love building ---------- ---------- ----------
    public function plusLove($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $modelBuildingLove = new TfBuildingLove();

        $loginUserId = $modelUser->loginUserId();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        $buildingUserId = $dataBuilding->userId();
        if (!empty($loginUserId)) {
            if ($loginUserId == $buildingUserId) {
                $newInfo = 0;
            } else {
                $newInfo = 1;
            }
            // plus follow
            if ($modelBuildingLove->insert($buildingId, $loginUserId, $newInfo)) {
                // update statistic info of building
                $dataBuilding->plusLove();
            }
        }
    }

    public function minusLove($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $modelBuildingLove = new TfBuildingLove();
        $loginUserId = $modelUser->loginUserId();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (!empty($loginUserId)) {
            // plus love
            if ($modelBuildingLove->actionDelete($buildingId, $loginUserId)) {
                // update statistic info of building
                $dataBuilding->minusLove();
            }
        }
    }

    #---------- ---------- ---------- Visit ---------- ---------- ----------
    // website
    public function plusVisitWebsite($buildingId = null)
    {
        $modelUser = new TfUser();
        $modelBuildingVisitWeb = new TfBuildingVisitWebsite();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($buildingId)) {
            $modelBuildingVisitWeb->insert($buildingId, $loginUserId);
        }
    }

    // home page
    public function plusVisitHome($buildingId = null)
    {
        $modelUser = new TfUser();
        $modelBuildingVisitHome = new TfBuildingVisitHome();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($buildingId)) {
            $modelBuildingVisitHome->insert($buildingId, $loginUserId);
        }
    }
}
