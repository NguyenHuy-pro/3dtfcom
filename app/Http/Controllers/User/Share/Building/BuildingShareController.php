<?php namespace App\Http\Controllers\User\Share\Building;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Share\TfBuildingShare;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class BuildingShareController extends Controller
{

    public function index($userId = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        //$userId -> develop public show
        $dataUser = $modelUser->loginUserInfo();
        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'share',
                'shareObject' => 'building',
            ];
            return view('user.share.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    public function getMoreBuildingShare($userId, $take, $dateTake)
    {
        $modelUser = new TfUser();
        $dataUser = $modelUser->getInfo($userId);
        $shareInfo = $dataUser->infoBuildingShare($userId, $take, $dateTake);
        if (!empty($shareInfo)) {
            foreach ($shareInfo as $dataBuildingShare) {
                echo view('user.share.building.share-object', compact('dataBuildingShare', 'modelUser', 'dataUser'));
            }
        }
    }

    #detail
    public function getDetail($shareId = null)
    {
        $modelBuildingShare = new TfBuildingShare();
        if (!empty($shareId)) {
            $dataBuildingShare = $modelBuildingShare->getInfo($shareId);
            if (!empty($dataBuildingShare)) {
                return view('user.share.building.share-view', compact('dataBuildingShare'));
            }
        }
    }
}
