<?php namespace App\Http\Controllers\User\Share\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Banner\Share\TfBannerShare;
use App\Models\Manage\Content\Map\Banner\ShareView\TfBannerShareView;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class BannerShareController extends Controller
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
                'shareObject' => 'banner',
            ];
            return view('user.share.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    public function getMoreBannerShare($userId, $take, $dateTake)
    {
        $modelUser = new TfUser();
        $dataUser = $modelUser->getInfo($userId);
        $shareInfo = $dataUser->infoBannerShare($userId, $take, $dateTake);
        if (!empty($shareInfo)) {
            foreach ($shareInfo as $dataBannerShare) {
                echo view('user.share.banner.share-object', compact('dataBannerShare', 'modelUser', 'dataUser'));
            }
        }
    }

    #detail
    public function getDetail($shareId = null)
    {
        $modelBannerShare = new TfBannerShare();
        if (!empty($shareId)) {
            $dataBannerShare = $modelBannerShare->getInfo($shareId);
            if (!empty($dataBannerShare)) {
                return view('user.share.banner.share-view', compact('dataBannerShare'));
            }
        }
    }
}
