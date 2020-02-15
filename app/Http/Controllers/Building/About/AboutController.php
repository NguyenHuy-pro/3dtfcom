<?php namespace App\Http\Controllers\Building\About;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Building\VisitHome\TfBuildingVisitHome;
use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\Users\TfUser;
//use Illuminate\Http\Request;

use Request;
use File;
use Input;

class AboutController extends Controller
{

    public function getAbout($alias = null)
    {
        $modelUser = new TfUser();
        $modelProject = new TfProject();
        $modelBuilding = new TfBuilding();
        $modelBuildingVisitHome = new TfBuildingVisitHome();
        $modelBannerImage = new TfBannerImage();
        $dataBuilding = $modelBuilding->getInfoOfAlias($alias);

        if (count($dataBuilding) > 0) {
            //insert view home
            $modelBuildingVisitHome->insert($dataBuilding->buildingId(), $modelUser->loginUserId());

            $dataBuildingAccess = [
                'accessObject' => 'about',
                'recentBuilding' => $modelBuilding->recentBuilding(5), //only take 5 records
                'recentBannerImage' => $modelBannerImage->recentImage(5), // only take 5 records
                'recentProject' => $modelProject->recentProjectPublished(5),
            ];
            return view('building.about.about', compact('modelUser', 'modelBuilding', 'dataBuilding', 'dataBuildingAccess'));
        } else {
            return redirect()->route('tf.home');
        }

    }

    public function getEditContent($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId)) {
            $dataBuilding = $modelBuilding->getInfo($buildingId);
            if ($modelBuilding->checkBuildingOfUser($dataBuilding->buildingId(), $loginUserId)) {
                return view('building.about.edit-content', compact('dataBuilding'));
            }
        }
    }

    public function postEditContent()
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $buildingId = Request::input('txtBuilding');
        $txtShortDescription = Request::input('txtShortDescription');
        $txtContent = Request::input('txtBuildingDescription');
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId)) {
            $dataBuildingOld = $modelBuilding->getInfo($buildingId);
            if (count($dataBuildingOld) > 0 && $modelBuilding->checkBuildingOfUser($dataBuildingOld->buildingId(), $loginUserId)) {
                $modelBuilding->updateShortDescription($buildingId, $txtShortDescription);
                $modelBuilding->updateDescription($buildingId, $txtContent);
                #refresh info
                $dataBuilding = $modelBuilding->getInfo($buildingId);
                return view('building.about.about-content', compact('modelUser', 'dataBuilding'));
            }
        }

    }
}
