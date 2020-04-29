<?php namespace App\Http\Controllers\Map\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Banner\Share\TfBannerShare;
use App\Models\Manage\Content\Map\Banner\ShareNotify\TfBannerShareNotify;

use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
use App\Models\Manage\Content\Map\Banner\TfBanner;

#use Illuminate\Http\Request;
use Request;
use Input;


class BannerShareController extends Controller
{
    //get form
    public function getShare($bannerId)
    {
        $modelUser = new TfUser();
        $modelBanner = new TfBanner();
        $dataBanner = $modelBanner->getInfo($bannerId);
        return view('map.banner.share.share-form', compact('modelUser', 'dataBanner'));
    }

    public function postShare($bannerId)
    {
        $mailObject = new \Mail3dtf();
        $modelUser = new TfUser();
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        $modelUserStatistic = new TfUserStatistic();
        $modelBannerShare = new TfBannerShare();
        $modelBannerShareNotify = new TfBannerShareNotify();
        $shareCode = Request::input('shareCode');
        $email = Request::input('txtEmail');
        $message = Request::input('txtMessage');
        $listFriend = Request::input('shareFriend');

        if ($modelUser->checkLogin()) {
            $dataUserLogin = $modelUser->loginUserInfo();
            $loginUserId = $dataUserLogin->userId();

            $message = (empty($message)) ? null : $message;
            if (!empty($email)) {
                $shareLink = route('tf.map.banner.access', "$bannerId/$shareCode");
            } else {
                $email = null;
                $shareLink = null;
            }

            #---------- notify ----------
            if (count($listFriend) > 0) {
                $emailStatus = false;
                # send email
                if (!empty($email)) {
                    if ($mailObject->checkExist($email)) $emailStatus = true; else $email = null;
                }
                $modelBannerShare->insert($shareCode, $message, $shareLink, $email, $bannerId, $loginUserId);
                $newShareId = $modelBannerShare->insertGetId();

                //share to friend
                if (count($listFriend) > 0) {
                    foreach ($listFriend as $key => $value) {
                        $modelBannerShareNotify->insert($newShareId, $value);
                        $modelUserStatistic->plusActionNotify($value);
                        //insert notify
                        $modelUserNotifyActivity->insert($value, null, null, null, null, null, $newShareId, null);
                    }
                }
                //send mail
                if ($emailStatus) {
                    $userName = $dataUserLogin->fullName();
                    $content = "
                                    Hi
                                    $userName invite you to visit a banner on 3dtf.com.

                                    You click link below to visit.
                                    $shareLink
                                    Thanks!";
                    $mailObject->sendFromGmail("Welcome to system 3DTF.COM", $email, $content);
                }
            } else {
                //share to email
                if (!empty($email)) {
                    if ($mailObject->checkExist($email)) {
                        $modelBannerShare->insert($shareCode, $message, $shareLink, $email, $bannerId, $loginUserId);
                        //send by php mailer
                        $userName = $dataUserLogin->fullName();
                        $content = "
                                    Hi
                                    $userName invite you to visit a banner on 3dtf.com.

                                    You click link below to visit.
                                    $shareLink
                                    Thanks!";
                        $mailObject->sendFromGmail("Welcome to system 3DTF.COM", $email, $content);
                    }

                }
            }
        }
    }

    //get link to share
    public function shareLink($bannerId, $shareCode)
    {
        $modelUser = new TfUser();
        $modelBannerShare = new TfBannerShare();
        if ($modelUser->checkLogin()) {
            if (!$modelBannerShare->existShareCode($shareCode)) {
                $shareLink = route('tf.map.banner.access', "$bannerId/$shareCode");
                $modelBannerShare->insert($shareCode, null, $shareLink, null, $bannerId, $modelUser->loginUserId());
            }

        }
    }
}