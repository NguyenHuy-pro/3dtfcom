<?php namespace App\Http\Controllers\Register;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Mail;
use App\Models\Manage\Content\Building\ShareView\TfBuildingShareView;
use App\Models\Manage\Content\Map\Banner\LicenseInvite\TfBannerLicenseInvite;
use App\Models\Manage\Content\Map\Banner\ShareView\TfBannerShareView;
use App\Models\Manage\Content\Map\Land\LicenseInvite\TfLandLicenseInvite;
use App\Models\Manage\Content\Map\Land\ShareView\TfLandShareView;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\ImageType\TfUserImageType;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Users\Image\TfUserImage;
use Illuminate\Support\Facades\Session;

//use Illuminate\Http\Request;
use Input;
use File;
use Request;
use DB, Mail;

class RegisterController extends Controller
{
    public function getRegister($fromObject = null, $fromObjectId = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        if ($modelUser->checkLogin()) {
            return redirect()->route('tf.home');
        } else {
            return view('register.register', compact('modelAbout', 'modelUser', 'fromObject', 'fromObjectId'));
        }

    }

    public function postRegister()
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $hFunction = new \Hfunction();
        $mailObject = new \Mail3dtf();
        $modelUserImageType = new TfUserImageType();
        $modelUserImage = new TfUserImage();
        $modelBannerShareView = new TfBannerShareView();
        $modelBannerLicenseInvite = new TfBannerLicenseInvite();
        $modelLandShareView = new TfLandShareView();
        $modelLandLicenseInvite = new TfLandLicenseInvite();
        $modelBuildingShareView = new TfBuildingShareView();

        $firstName = Request::input('txtFirstName');
        $lastName = Request::input('txtLastName');
        $account = Request::input('txtAccount');
        $password = Request::input('txtPassword');
        $birthday = Request::input('txtBirthday');
        $gender = Request::input('txtGender');
        $avatar = Request::file('txtImage');
        $reserveObjectName = Request::input('reserveObjectName');
        $reserveObjectId = Request::input('reserveObjectID');
        $token = null;// Request::input('_token');

        // check exist account
        if ($modelUser->existAccount($account)) { // have exists account
            Session::put('notifyAddUser', "Add fail, account '$account' is exists.");
            return redirect()->back();
        } else {
            if ($mailObject->checkExist($account)) {
                if ($modelUser->insert($firstName, $lastName, $account, $password, $birthday, $gender, $token)) {
                    $newUserId = $modelUser->insertGetId();

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

                    ##------------- begin reserve object   (develop later) -------------
                    if (!empty($reserveObjectName)) {
                        /*
                        // have select a land before register
                        if ($fromObject == 'reserve-land') {

                        }

                        // have select a banner before register
                        if ($fromObject == 'reserve-banner') {

                        }

                        // register from share link of the land
                        if ($fromObject == 'share-land') {

                        }

                        // register from share link of the banner
                        if ($fromObject == 'share-banner') {

                        }
                        */
                    }
                    ##------------- end reserve object   (develop later) -------------

                    $nameCode = $modelUser->nameCode($newUserId);
                    // check send email
                    $url = route('tf.register.account.verify', $nameCode);

                    //send mail by swithmailer
                    /*
                    $dataNotice = ['name' => $lastName, 'link' => $url];
                    Mail::send('emails.register.register', $dataNotice, function ($msg) use ($account) {
                        $msg->from('3dtf.training@gmail.com', '3dtf.com');
                        $msg->to($account, 'welcome')->subject('send from 3dtf.com');
                    });*/

                    //send by php mailer
                    $content = "
                    Welcome $firstName $lastName!

                    Thank-you for creating an account On 3dtf.com,
                    Click link below to confirm your account:

                    $url

                    or copy and paste the link below into your browsers address bar.

                    Thanks!";
                    $mailObject->sendFromGmail("Welcome to system 3DTF.COM", $account, $content);

                    ##------------- ------------ process avatar ------------- ------------
                    if (!empty($avatar)) { // have select avatar
                        $file = Request::file('txtImage');
                        $imageName = $file->getClientOriginalName();
                        $imageName = $hFunction->alias($firstName . '-' . $lastName) . '-' . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
                        if ($modelUserImage->uploadImage($file, $imageName, 200)) {
                            // insert into image table of user
                            $imageTypeId = $modelUserImageType->typeIdAvatar();
                            $highlight = 1;
                            $modelUserImage->insert($imageName, $highlight, $imageTypeId, $newUserId);
                        }
                    }

                    $modelUserStatistic = new TfUserStatistic();
                    $totalImage = (!empty($avatar)) ? 1 : 0;
                    $modelUserStatistic->insert($newUserId, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, $totalImage);

                    return view('register.register-success', compact('modelAbout', 'modelUser'));
                } else {
                    Session::put('notifyAddUser', "Add fail, enter info to again");
                    return redirect()->back();
                }
            } else {
                Session::put('notifyAddUser', "Add fail, $account is not exists.");
                return redirect()->back();
            }
        }

    }

    //=========== =========== =========== verify =========== =========== ===========
    public function verifyAccount($nameCode = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        if (empty($nameCode)) {
            return redirect()->route('tf.home');
        } else {
            $dataUser = $modelUser->getInfoByNameCode($nameCode);
            if (count($dataUser) > 0) {   // exist user
                if ($dataUser->confirm == 1) {  // confirmed
                    return redirect()->route('tf.home');
                } else {
                    $userId = $dataUser->user_id;
                    if ($modelUser->updateConfirm($userId)) {  //  update confirm
                        // add point card for user
                        $modelUserCard = new TfUserCard();
                        if (!$modelUserCard->existCardOfUser($userId)) {
                            $pointValue = 150; // default new user
                            $modelUserCard->insert($pointValue, $userId);
                        }
                    }
                    return view('register.verify-notify', compact('modelAbout', 'modelUser', 'dataUser'));
                }
            } else {
                return redirect()->route('tf.home');
            }
        }

    }
}
