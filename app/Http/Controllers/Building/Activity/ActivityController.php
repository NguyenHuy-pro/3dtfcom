<?php namespace App\Http\Controllers\Building\Activity;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Building\VisitHome\TfBuildingVisitHome;
use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    public function index($alias = null)
    {
        $modelUser = new TfUser();
        $modelProject = new TfProject();
        $modelBuilding = new TfBuilding();
        $modelBuildingVisitHome = new TfBuildingVisitHome();

        $dataBuilding = $modelBuilding->getInfoOfAlias($alias);
        $modelBannerImage = new TfBannerImage();
        if (count($dataBuilding) > 0) {
            //insert visit home
            $modelBuildingVisitHome->insert($dataBuilding->buildingId(), $modelUser->loginUserId());

            $dataBuildingAccess = [
                'accessObject' => 'activity',
                'recentBuilding' => $modelBuilding->recentBuilding(5),
                'recentBannerImage' => $modelBannerImage->recentImage(5), // only take 5 records
                'recentProject' => $modelProject->recentProjectPublished(5)
            ];
            return view('building.activity.activity', compact('modelUser', 'modelBuilding', 'dataBuilding', 'dataBuildingAccess'));
        } else {
            return redirect()->route('tf.home');
        }

    }

    // get more posts
    public function  moreActivity($buildingId, $take = null, $dateTake = null)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();

        // building info
        $dataBuilding = $modelBuilding->findInfo($buildingId);

        // info of building owner
        $dataUserBuilding = $dataBuilding->userInfo();

        // info posts of building
        $listBuildingActivity = $dataBuilding->activityOfBuilding($buildingId, $take, $dateTake);
        if (count($listBuildingActivity) > 0) {
            foreach ($listBuildingActivity as $dataBuildingActivity) {
                if ($dataBuildingActivity->checkActivityPost()) {
                    echo view('building.posts.content-posts.posts-object', compact('modelUser', 'dataUserBuilding', 'dataBuildingActivity'));
                } elseif ($dataBuildingActivity->checkActivityArticles()) {
                    echo view('building.activity.articles.articles-object', compact('modelUser','dataBuildingActivity'));
                }

            }
        }
    }

}
