<?php namespace App\Http\Controllers\Register;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Share\TfBuildingShare;
use App\Models\Manage\Content\Map\Banner\LicenseInvite\TfBannerLicenseInvite;
use App\Models\Manage\Content\Map\Banner\ShareView\TfBannerShareView;
use App\Models\Manage\Content\Map\Land\LicenseInvite\TfLandLicenseInvite;
use App\Models\Manage\Content\Map\Land\ShareView\TfLandShareView;
use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Users\Socialite\TfUserSocialite;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;

//use Illuminate\Http\Request;
//use Laravel\Socialite\Facades\Socialite;

use Socialite;
use Request;
use Input;

class SocialiteController extends Controller
{

    #======== ======== ========  facebook ======== ======== ========
    public function redirectToProviderFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallbackFacebook()
    {
        $modelUser = new TfUser();
        $modelUserSocialite = new TfUserSocialite();
        if ($modelUser->checkLogin()) {
            return redirect()->route('tf.home');
        } else {
            try {
                $dataFacebookUser = Socialite::driver('facebook')->user();
                if (count($dataFacebookUser) > 0) {
                    $socialiteCode = $dataFacebookUser->id;
                    $infoOfSocialiteCode = $modelUserSocialite->infoOfSocialiteCode($socialiteCode);
                    //not exist socialite (first login)
                    if (count($infoOfSocialiteCode) > 0) {
                        // login in
                        $userId = $infoOfSocialiteCode->userId();
                        // login
                        $modelUser->loginBySocialite($userId, 'facebook');
                        return redirect()->route('tf.home');

                    } else {
                        return view('register.socialite.facebook.register-form', compact('modelUser'), ['dataFacebookUser' => $dataFacebookUser]);
                    }
                } else {
                    return redirect()->route('tf.home');
                }
            } catch (\Exception $e) {
                return redirect()->route('tf.home');
            }

        }

    }

    public function handleProviderConnectFacebook()
    {
        $modelSendMail = new \Mail3dtf();
        $modelUser = new TfUser();
        $modelUserCard = new TfUserCard();
        $modelUserStatistic = new TfUserStatistic();
        $modelUserSocialite = new TfUserSocialite();
        $modelBannerLicenseInvite = new TfBannerLicenseInvite();
        $modelBannerShareView = new TfBannerShareView();
        $modelLandLicenseInvite = new TfLandLicenseInvite();
        $modelLandShareView = new TfLandShareView();
        $modelBuildingShareView = new TfBuildingShare();

        $txtFirstName = Request::input('txtFirstName');
        $txtLastName = Request::input('txtLastName');
        $txtAccount = Request::input('txtAccount');
        $txtPassword = Request::input('txtPassword');
        $gender = Request::input('txtGender');

        //facebook
        $fb_id = Request::input('fb_id');
        $fb_name = Request::input('fb_name');
        $fb_email = Request::input('fb_email');
        $fb_avatar = Request::input('fb_avatar');

        if ($modelUser->existAccount($txtAccount)) {
            return "<b>$txtAccount registered</b> ";
        } else {
            $fromEmail = $modelSendMail->getServiceMail();
            $mailValidate = new \SMTP_Validate_Email($txtAccount, $fromEmail);
            $smtp_results = $mailValidate->validate();
            if ($smtp_results[$txtAccount]) {
                if ($modelUser->insert($txtFirstName, $txtLastName, $txtAccount, $txtPassword, null, $gender, null)) {
                    $newUserId = $modelUser->insertGetId();

                    //confirm account
                    $modelUser->updateConfirm($newUserId);

                    //insert point
                    $pointValue = 150; // default new user
                    $modelUserCard->insert($pointValue, $newUserId);

                    //inset statistic
                    $modelUserStatistic->insert($newUserId, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

                    ##-------- -------- begin check share -------- --------
                    //check register users from sharing system.
                    //from share banner
                    if ($modelBannerShareView->existAccessCode()) {
                        $modelBannerShareView->updateRegister($newUserId, $modelBannerShareView->newAccessCode());
                    }
                    //from share land
                    if ($modelLandShareView->existAccessCode()) {
                        $modelLandShareView->updateRegister($newUserId, $modelLandShareView->newAccessCode());
                    }
                    //from share building
                    if ($modelBuildingShareView->existAccessCode()) {
                        $modelBuildingShareView->updateRegister($newUserId, $modelBuildingShareView->newAccessCode());
                    }
                    ##--------- -------- end check share--------- --------

                    ##-------- -------- begin check invite -------- --------
                    //invite banner
                    $modelBannerLicenseInvite->checkNewMember($newUserId);
                    //invite land
                    $modelLandLicenseInvite->checkNewMember($newUserId);
                    ##-------- -------- end check invite -------- --------

                    //insert info for socialite access
                    $modelUserSocialite->insert($fb_id, $fb_name, $fb_email, $fb_avatar, 'facebook', $newUserId);

                    //login for new user
                    $modelUser->loginBySocialite($newUserId, 'facebook');

                }
            } else {
                return 'This email does not exist';
            }

        }


    }

    //======== ======== ========  Google ======== ======== ========
    public function redirectToProviderGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallbackGoogle()
    {
        $modelUser = new TfUser();
        $modelUserSocialite = new TfUserSocialite();
        if ($modelUser->checkLogin()) {
            return redirect()->route('tf.home');
        } else {
            try {
                $dataGoogleUser = Socialite::driver('google')->user();
                if (count($dataGoogleUser) > 0) {
                    $socialiteCode = $dataGoogleUser->id;
                    $infoOfSocialiteCode = $modelUserSocialite->infoOfSocialiteCode($socialiteCode);
                    //not exist socialite (first login)
                    if (count($infoOfSocialiteCode) > 0) {
                        // login in
                        $userId = $infoOfSocialiteCode->userId();
                        // login
                        $modelUser->loginBySocialite($userId, 'google');
                        return redirect()->route('tf.home');

                    } else {
                        return view('register.socialite.google.register-form', compact('modelUser'), ['dataGoogleUser' => $dataGoogleUser]);
                    }
                } else {
                    return redirect()->route('tf.home');
                }
            } catch (\Exception $e) {
                return redirect()->route('tf.home');
            }

        }
    }

    public function handleProviderConnectGoogle()
    {
        $modelSendMail = new \Mail3dtf();
        $modelUser = new TfUser();
        $modelUserCard = new TfUserCard();
        $modelUserStatistic = new TfUserStatistic();
        $modelUserSocialite = new TfUserSocialite();
        $modelBannerLicenseInvite = new TfBannerLicenseInvite();
        $modelBannerShareView = new TfBannerShareView();
        $modelLandLicenseInvite = new TfLandLicenseInvite();
        $modelLandShareView = new TfLandShareView();
        $modelBuildingShareView = new TfBuildingShare();

        $txtFirstName = Request::input('txtFirstName');
        $txtLastName = Request::input('txtLastName');
        $txtAccount = Request::input('txtAccount');
        $txtPassword = Request::input('txtPassword');
        $gender = Request::input('txtGender');

        //facebook
        $g_id = Request::input('g_id');
        $g_name = Request::input('g_name');
        $g_email = Request::input('g_email');
        $g_avatar = Request::input('g_avatar');

        if ($modelUser->existAccount($txtAccount)) {
            return "<b>$txtAccount registered</b> ";
        } else {
            $fromEmail = $modelSendMail->getServiceMail();
            $mailValidate = new \SMTP_Validate_Email($txtAccount, $fromEmail);
            $smtp_results = $mailValidate->validate();
            if ($smtp_results[$txtAccount]) {
                if ($modelUser->insert($txtFirstName, $txtLastName, $txtAccount, $txtPassword, null, $gender, null)) {
                    $newUserId = $modelUser->insertGetId();

                    //confirm account
                    $modelUser->updateConfirm($newUserId);

                    //insert point
                    $pointValue = 150; // default new user
                    $modelUserCard->insert($pointValue, $newUserId);

                    //inset statistic
                    $modelUserStatistic->insert($newUserId, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

                    ##-------- -------- begin check share -------- --------
                    //check register users from sharing system.
                    //from share banner
                    if ($modelBannerShareView->existAccessCode()) {
                        $modelBannerShareView->updateRegister($newUserId, $modelBannerShareView->newAccessCode());
                    }
                    //from share land
                    if ($modelLandShareView->existAccessCode()) {
                        $modelLandShareView->updateRegister($newUserId, $modelLandShareView->newAccessCode());
                    }
                    //from share building
                    if ($modelBuildingShareView->existAccessCode()) {
                        $modelBuildingShareView->updateRegister($newUserId, $modelBuildingShareView->newAccessCode());
                    }
                    ##--------- -------- end check share--------- --------

                    ##-------- -------- begin check invite -------- --------
                    //invite banner
                    $modelBannerLicenseInvite->checkNewMember($newUserId);
                    //invite land
                    $modelLandLicenseInvite->checkNewMember($newUserId);
                    ##-------- -------- end check invite -------- --------

                    //insert info for socialite access
                    $modelUserSocialite->insert($g_id, $g_name, $g_email, $g_avatar, 'google', $newUserId);

                    //login for new user
                    $modelUser->loginBySocialite($newUserId, 'google');
                }
            } else {
                return 'This email does not exist';
            }

        }

    }

}
