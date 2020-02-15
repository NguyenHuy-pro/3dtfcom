<?php namespace App\Http\Controllers\User\Share\Land;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Land\Share\TfLandShare;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class LandShareController extends Controller
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
                'shareObject' => 'land',
            ];
            return view('user.share.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));

        } else {
            return redirect()->route('tf.home');
        }
    }

    public function getMoreLandShare($userId, $take, $dateTake)
    {
        $modelUser = new TfUser();
        $dataUser = $modelUser->getInfo($userId);
        $shareInfo = $dataUser->infoLandShare($userId, $take, $dateTake);
        if (!empty($shareInfo)) {
            foreach ($shareInfo as $dataLandShare) {
                echo view('user.share.land.share-object', compact('dataLandShare', 'modelUser', 'dataUser'));
            }
        }
    }

    #detail
    public function getDetail($shareId = null)
    {
        $modelLandShare = new TfLandShare();
        if (!empty($shareId)) {
            $dataLandShare = $modelLandShare->getInfo($shareId);
            if (!empty($dataLandShare)) {
                return view('user.share.land.share-view', compact('dataLandShare'));
            }
        }
    }
}
