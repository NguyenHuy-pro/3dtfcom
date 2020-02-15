<?php namespace App\Http\Controllers\Map;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Comment\TfBuildingComment;
use App\Models\Manage\Content\Building\CommentNotify\TfBuildingCommentNotify;
use App\Models\Manage\Content\Building\Love\TfBuildingLove;
use App\Models\Manage\Content\Building\Notify\TfBuildingNewNotify;
use App\Models\Manage\Content\Building\Share\TfBuildingShare;
use App\Models\Manage\Content\Building\ShareNotify\TfBuildingShareNotify;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\Map\Banner\Share\TfBannerShare;
use App\Models\Manage\Content\Map\Banner\ShareNotify\TfBannerShareNotify;
use App\Models\Manage\Content\Map\Land\Share\TfLandShare;
use App\Models\Manage\Content\Map\Land\ShareNotify\TfLandShareNotify;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Country\TfCountry;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\Users\Friend\TfUserFriend;
use App\Models\Manage\Content\Users\FriendRequest\TfUserFriendRequest;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class MapController extends Controller
{

    #========== ========== ========== Mini map ========== ========== ==========
    #get mini map
    public function getMiniMap($provinceId=null)
    {
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();
        $modelProject = new TfProject();
        if(!empty($provinceId)){
            $dataProvince = $modelProvince->getInfo($provinceId);
            $dataProject = $modelProject->infoOfProvince($provinceId);
            return view('map.control.mini-map.mini-map', compact('modelCountry','modelProvince', 'modelArea', 'dataProvince','dataProject'));
        }
    }
    #========== ========== ========== Filter ========== ========== ==========
    public function listFilterBusinessType()
    {
        $modelBusinessType = new TfBusinessType();
        $dataBusinessType = $modelBusinessType->getInfo();
        return view('map.components.filter.business-type', compact('dataBusinessType'));
    }

    public function getFilterBusinessType($businessTypeId = null)
    {
        $modelBusinessType = new TfBusinessType();
        if (!empty($businessTypeId)) {
            return $modelBusinessType->setAccess($businessTypeId);
        } else {
            return $modelBusinessType->deleteAccess();
        }
    }

}
