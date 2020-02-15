<?php namespace App\Http\Controllers\Building\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Banner\TfBuildingBanner;
use App\Models\Manage\Content\Building\TfBuilding;
#use Illuminate\Http\Request;
use App\Models\Manage\Content\Users\Activity\TfUserActivity;
use App\Models\Manage\Content\Users\TfUser;
use Request;
use Input, File;

class BuildingBannerController extends Controller
{

    //get form upload
    public function getAddBanner($buildingId = null)
    {
        $modelBuilding = new TfBuilding();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        return view('building.banner.banner-upload', compact('dataBuilding'));
    }

    // add from upload
    public function postAddBanner($buildingId = null)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserActivity = new TfUserActivity();
        $modelBuilding = new TfBuilding();
        $modelBuildingBanner = new TfBuildingBanner();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        $buildingAlias = $dataBuilding->alias();

        if ($modelUser->checkLogin()) {
            if (Input::hasFile('fileImage')) {
                $file = Request::file('fileImage');
                $imageName = $file->getClientOriginalName();
                $imageName = "$buildingAlias-" . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
                if ($modelBuildingBanner->uploadImage($file, $imageName)) {
                    //insert banner image of building
                    if ($modelBuildingBanner->insert($imageName, $buildingId)) {
                        $newBannerId = $modelBuildingBanner->insertGetId();
                        $modelUserActivity->insert(null, null, $newBannerId, $modelUser->loginUserId(), null);
                    } else {
                        $modelBuildingBanner->dropImage($imageName);
                    }
                }
            }
        }

    }

    //view full banner
    public function viewFullBanner($buildingBannerId)
    {
        $modelBuildingBanner = new TfBuildingBanner();
        $dataBuildingBanner = $modelBuildingBanner->getInfo($buildingBannerId);
        return view('building.components.banner.banner-view', compact('dataBuildingBanner'));
    }

    #delete banner
    public function deleteBanner($bannerId)
    {
        $modelBuildingBanner = new TfBuildingBanner();
        return $modelBuildingBanner->actionDelete($bannerId);
    }

}
