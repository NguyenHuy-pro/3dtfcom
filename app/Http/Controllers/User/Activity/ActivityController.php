<?php namespace App\Http\Controllers\User\Activity;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\Activity\Love\TfUserActivityLove;
use App\Models\Manage\Content\Users\Activity\TfUserActivity;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    #---------- ---------- Activity ---------- ----------
    public function index($alias = null)
    {
        $hFunction = new \Hfunction();
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelUserActivity = new TfUserActivity();
        $dataUserLogin = $modelUser->loginUserInfo();
        if (!empty($alias)) {
            $dataUser = $modelUser->getInfoByAlias($alias);
        } else {
            if (count($dataUserLogin) > 0) {
                $dataUser = $dataUserLogin;
            }else{
                $dataUser = null;
            }
        }


        $take = 5;
        if (count($dataUser) > 0) {
            $dataUserActivity = $modelUserActivity->infoOfUser($dataUser->userId(), $take, $hFunction->carbonNow());
            $dataAccess = [
                'accessObject' => 'activity',
                'takeActivity' => $take
            ];
            return view('user.activity.index', compact('modelAbout', 'modelUser', 'modelUserActivity', 'dataUser', 'dataAccess', 'dataUserActivity'));

        } else {
            return redirect()->route('tf.home');
        }
    }

    # get more building
    public function moreActivity($accessUserId = null, $take = null, $dateTake = null)
    {
        $modelUser = new TfUser();
        $modelUserActivity = new TfUserActivity();
        $dataUserActivity = $modelUserActivity->infoOfUser($accessUserId, $take, $dateTake);
        if (count($dataUserActivity) > 0) {
            foreach ($dataUserActivity as $userActivity) {
                echo view('user.activity.activity.activity-object', compact('modelUser','userActivity'));
            }
        }
    }

    #---------- ---------- Love ---------- ----------
    //love post
    public function love($activityId, $loveStatus)
    {
        $modelUser = new TfUser();
        $modelUserLove = new TfUserActivityLove();
        $loginUserId = $modelUser->loginUserId();
        if (count($loginUserId) > 0) {
            if ($loveStatus == 1) {
                $modelUserLove->insert($activityId, $loginUserId);
            } else {
                $modelUserLove->actionDelete($activityId, $loginUserId);
            }
        }
    }
}
