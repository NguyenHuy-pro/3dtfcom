<?php namespace App\Http\Controllers\User\Friend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\Friend\TfUserFriend;
use App\Models\Manage\Content\Users\FriendRequest\TfUserFriendRequest;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class FriendController extends Controller
{

    #========== ========== ========== Friend ========== ========== ==========
    #list friend
    public function index($userId = '')
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUserLogin = $modelUser->loginUserInfo();
        if (empty($userId)) {
            $dataUser = $dataUserLogin;
        } else {
            $dataUser = TfUser::find($userId);
        }
        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'friend',
                'friendObject' => 'list'
            ];
            return view('user.friend.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }

    }

    # get more friend
    public function moreFriend($accessUserId = '', $skip = '', $take = '')
    {
        $modelUser = new TfUser();
        #$dataUserLogin = $modelUser->loginUserInfo();
        if (!empty($accessUserId)) {
            $dataUser = TfUser::find($accessUserId);
            $dataUserFriend = $dataUser->infoFriend($accessUserId, $skip, $take);
            return view('user.friend.friend.friend-object', compact('modelUser', 'dataUser', 'dataUserFriend', 'skip', 'take'));
        }
    }

    #delete friend
    public function deleteFriend($friendUserId)
    {
        $modelUserStatistic = new TfUserStatistic();
        if (!empty($friendUserId)) {
            $modelUser = new TfUser();
            if ($modelUser->checkLogin()) {
                #logged
                $loginUserId = $modelUser->loginUserId();
                $modelUserFriend = new TfUserFriend();
                $modelUserFriend->actionDelete($loginUserId, $friendUserId);

                #update total friend
                $modelUserStatistic->minusFriend($loginUserId);
                $modelUserStatistic->minusFriend($friendUserId);
            }
        }
    }

    #========== ========== ========== Request ========== ========== ==========
    # cancel friend request
    public function cancelFriendRequest($requestUserId = '')
    {
        $modelUserStatistic = new TfUserStatistic();
        if (!empty($requestUserId)) {
            $modelUser = new TfUser();
            if ($modelUser->checkLogin()) {
                #logged
                $loginUserId = $modelUser->loginUserId();
                if (!empty($loginUserId)) {
                    $modelFriendRequest = new TfUserFriendRequest();
                    $modelFriendRequest->deleteByUser($loginUserId, $requestUserId);
                    $modelUserStatistic->minusFriendNotify($requestUserId);
                }
            }
        }
    }

    #----------- Sent -----------
    # send  friend request
    public function sendFriendRequest($userId = '')
    {
        $modelUserStatistic = new TfUserStatistic();
        if (!empty($userId)) {
            $modelUser = new TfUser();
            if ($modelUser->checkLogin()) {
                #logged
                $loginUserId = $modelUser->loginUserId();
                if (!$modelUser->checkSentFriendRequest($loginUserId, $userId)) {
                    # doesn't send
                    $modelFriendRequest = new TfUserFriendRequest();
                    $modelFriendRequest->insert($loginUserId, $userId);
                    $modelUserStatistic->plusFriendNotify($userId);
                }
            }
        }
    }

    # get list sent request
    public function listSentFriendRequest()
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUserLogin = $modelUser->loginUserInfo();
        if (count($dataUserLogin) > 0) {
            $dataUser = $dataUserLogin;
            $dataAccess = [
                'accessObject' => 'friend',
                'friendObject' => 'sentRequest'
            ];
            return view('user.friend.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    # get more friend request of user receive
    public function moreSentFriendRequest($skip = '', $take = '')
    {
        $modelUser = new TfUser();
        if ($modelUser->checkLogin()) {
            #logged
            $loginUserId = $modelUser->loginUserId();
            if (!empty($loginUserId)) {
                $dataFriendRequestSent = $modelUser->infoFriendRequestSent($loginUserId, $skip, $take);
                return view('user.friend.request.sent-request-object', compact('modelUser', 'dataFriendRequestSent', 'skip', 'take'));
            }
        }
    }

    #----------- ------------ Receive ----------- -----------
    # get friend request of user receive
    public function listReceivedFriendRequest()
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUserLogin = $modelUser->loginUserInfo();
        if (count($dataUserLogin) > 0) {
            $dataUser = $dataUserLogin;
            $dataAccess = [
                'accessObject' => 'friend',
                'friendObject' => 'receiveRequest'
            ];
            return view('user.friend.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    # get more friend request of user receive
    public function moreReceivedFriendRequest($skip = '', $take = '')
    {
        $modelUser = new TfUser();
        $dataUserLogin = $modelUser->loginUserInfo();
        if (count($dataUserLogin) > 0) {
            #logged
            $loginUserId = $dataUserLogin->userId();
            $dataFriendRequestReceived = $modelUser->infoFriendRequestReceived($loginUserId, $skip, $take);
            return view('user.friend.request.receive-request-object', compact('modelUser', 'dataFriendRequestReceived', 'skip', 'take'));
        }
    }

    #----------- ----------- Confirm request ----------- -----------
    # user agree friend request
    public function confirmFriendRequestYes($userId = '')
    {
        $modelUser = new TfUser();
        $modelFriendRequest = new TfUserFriendRequest();
        $loginUserId = $modelUser->loginUserId();
        return $modelFriendRequest->confirmYes($userId, $loginUserId);
    }

    # user don't agree friend request
    public function confirmFriendRequestNo($userId = '')
    {
        $modelUser = new TfUser();
        $modelFriendRequest = new TfUserFriendRequest();
        $loginUserId = $modelUser->loginUserId();
        return $modelFriendRequest->confirmNo($userId, $loginUserId);
    }

    public function getFriendLock($userId = '')
    {

    }

}
