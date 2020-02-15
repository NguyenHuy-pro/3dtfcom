<?php namespace App\Http\Controllers\User\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Banner\LicenseInvite\TfBannerLicenseInvite;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    #---------- ---------- Banner ---------- ----------
    public function index($userId = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUserLogin = $modelUser->loginUserInfo();
        if (empty($userId)) {
            $dataUser = $dataUserLogin;
        } else {
            $dataUser = $modelUser->getInfo($userId);
        }
        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'banner',
                'bannerObject' => 'normal'
            ];
            return view('user.banner.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    //get more banner
    public function moreBanner($accessUserId = '', $skip = null, $take = null)
    {
        $modelUser = new TfUser();
        if (!empty($accessUserId)) {
            $dataUser = $modelUser->getInfo($accessUserId);
            $dataBannerLicense = $dataUser->bannerLicenseOfUser($accessUserId, $skip, $take);
            return view('user.banner.banner.banner-object', compact('modelUser', 'dataUser', 'dataBannerLicense', 'skip', 'take'));
        }
    }

    //invited
    public function getBannerInvited($userId = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUser = $modelUser->loginUserInfo();
        //$userId -> develop public show
        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'banner',
                'bannerObject' => 'invited'
            ];
            return view('user.banner.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    public function getMoreBannerInvited($userId = null)
    {
        $modelUser = new TfUser();

    }

    //cancel invited
    public function cancelInvited($inviteId)
    {
        $modelBannerLicenseInvite = new TfBannerLicenseInvite();
        $modelBannerLicenseInvite->actionDelete($inviteId);
    }
}
