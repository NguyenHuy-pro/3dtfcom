<?php namespace App\Http\Controllers\User\Land;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Land\LicenseInvite\TfLandLicenseInvite;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class LandController extends Controller
{

    #---------- ---------- Land ---------- ----------
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
                'accessObject' => 'land',
                'landObject' => 'list'
            ];
            return view('user.land.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    // get more land
    public function moreLand($accessUserId = null, $skip = null, $take = null)
    {
        $modelUser = new TfUser();
        if (!empty($accessUserId)) {
            $dataUser = $modelUser->getInfo($accessUserId);
            $dataLandLicense = $dataUser->landLicenseOfUser($accessUserId, $skip, $take);
            return view('user.land.land.land-object', compact('modelUser', 'dataUser', 'dataLandLicense', 'skip', 'take'));
        }
    }

    //---------- ---------- invited ---------- ----------
    public function getLandInvited($userId = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUser = $modelUser->loginUserInfo();
        //$userId -> develop public show
        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'land',
                'landObject' => 'invited'
            ];
            return view('user.land.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    public function getMoreLandInvited($userId = null)
    {
        $modelUser = new TfUser();
        if (!empty($userId)) {
            $dataUser = $modelUser->getInfo($userId);
            $dataLandLicenseInvite = $dataUser->landLicenseInviteInfoByUser();
            return view('user.land.invite.invite-object', compact('modelUser', 'dataUser', 'dataLandLicenseInvite', 'skip', 'take'));
        }

    }

    //cancel invited
    public function cancelInvited($inviteId)
    {
        $modelLandLicenseInvite = new TfLandLicenseInvite();
        $modelLandLicenseInvite->actionDelete($inviteId);
    }

}
