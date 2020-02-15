<?php namespace App\Http\Controllers\Map\Land;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Land\Share\TfLandShare;
use App\Models\Manage\Content\Map\Land\ShareNotify\TfLandShareNotify;

use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
//use Illuminate\Http\Request;
use FIle;
use Input;
use DB;
use Request;

class LandShareController extends Controller
{
    // get form
    public function getShare($landId = null)
    {
        $modelUser = new TfUser();
        $modelLand = new TfLand();
        $dataLand = $modelLand->getInfo($landId);
        return view('map.land.share.share-form', compact('modelUser', 'dataLand'));
    }

    public function postShare($landId)
    {
        $mailObject = new \Mail3dtf();
        $modelUser = new TfUser();
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        $modelUserStatistic = new TfUserStatistic();
        $modelLandShare = new TfLandShare();
        $modelLandShareNotify = new TfLandShareNotify();

        $shareCode = Request::input('shareCode');
        $email = Request::input('txtEmail');
        $message = Request::input('txtMessage');
        $listFriend = Request::input('shareFriend');

        $dataUserLogin = $modelUser->loginUserInfo();
        $loginUserId = $dataUserLogin->userId();
        if (!empty($loginUserId)) {
            $message = (empty($message)) ? null : $message;
            if (!empty($email)) {
                $shareLink = route('tf.map.land.access', "$landId/$shareCode");
            } else {
                $email = null;
                $shareLink = null;
            }

            //---------- notify ----------
            if (count($listFriend) > 0) {
                $emailStatus = false;
                if (!empty($email)) {
                    if ($mailObject->checkExist($email)) $emailStatus = true; else $email = null;
                }
                $modelLandShare->insert($shareCode, $message, $shareLink, $email, $landId, $loginUserId);
                $newShareId = $modelLandShare->insertGetId();

                //share to friend
                if (count($listFriend) > 0) {
                    foreach ($listFriend as $key => $value) {
                        $modelLandShareNotify->insert($newShareId, $value);
                        $modelUserStatistic->plusActionNotify($value);
                        //notify activity
                        $modelUserNotifyActivity->insert($value, null, null, null, null, null, null, $newShareId);
                    }
                }
                //send mail
                if ($emailStatus) {
                    $userName = $dataUserLogin->fullName();
                    $content = "
                                Hi
                                $userName invite you to visit a land on 3dtf.com.

                                You click link below to visit land.
                                $shareLink
                                Thanks!";
                    $mailObject->sendFromGmail("Welcome to system 3DTF.COM", $email, $content);
                }

            } else {
                // share to email
                if (!empty($email)) {
                    if ($mailObject->checkExist($email)) {
                        $modelLandShare->insert($shareCode, $message, $shareLink, $email, $landId, $loginUserId);

                        $userName = $dataUserLogin->fullName();
                        $content = "
                                Hi
                                $userName invite you to visit a land on 3dtf.com.

                                You click link below to visit land.
                                $shareLink
                                Thanks!";
                        $mailObject->sendFromGmail("Welcome to system 3DTF.COM", $email, $content);
                    }

                }
            }
        }
    }

    //get link to share
    public function shareLink($landId, $shareCode)
    {
        $modelUser = new TfUser();
        $modelLandShare = new TfLandShare();
        if ($modelUser->checkLogin()) {
            if (!$modelLandShare->existShareCode($shareCode)) {
                $shareLink = route('tf.map.land.access', "$landId/$shareCode");
                $modelLandShare->insert($shareCode, null, $shareLink, null, $landId, $modelUser->loginUserId());
            }

        }
    }

}

