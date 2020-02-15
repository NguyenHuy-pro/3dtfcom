<?php namespace App\Http\Controllers\Map\Building\Comment;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Comment\TfBuildingComment;
use App\Models\Manage\Content\Building\CommentNotify\TfBuildingCommentNotify;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
use Request;
use Input;

class CommentController extends Controller
{

    public function index($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $modelCommentNotify = new TfBuildingCommentNotify();

        $dataUserLogin = $modelUser->loginUserInfo();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        if (count($dataUserLogin) > 0) {
            // confirm users viewed
            $modelCommentNotify->disableNewOfUserOnBuilding($buildingId, $dataUserLogin->userId());
        }

        return view('map.building.comment.comment', compact('modelUser', 'dataBuilding'));
    }

    // view more comment
    public function moreComment($buildingId, $take, $takeDate)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $resultComment = $modelBuilding->commentInfoOfBuilding($buildingId, $take, $takeDate);
        if (count($resultComment) > 0) {
            foreach ($resultComment as $dataBuildingComment) {
                echo view('map.building.comment.comment-object', compact('modelUser', 'dataBuildingComment'));
            }
        }
    }

    //get content
    public function getContent($commentId = null)
    {
        $modelBuildingComment = new TfBuildingComment();
        if (!empty($commentId)) {
            $dataBuildingComment = $modelBuildingComment->getInfo($commentId);
            return $dataBuildingComment->content();
        }
    }

    //========== ========== Add comment =========== ==========
    public function postAddComment($buildingId)
    {
        $modelUser = new TfUser();
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        $modeUserStatistic = new TfUserStatistic();
        $modelBuilding = new TfBuilding();
        $modelBuildingComment = new TfBuildingComment();
        $modelCommentNotify = new TfBuildingCommentNotify();

        $dataUserLogin = $modelUser->loginUserInfo();

        $content = Request::input('txtComment');
        if (count($dataUserLogin) > 0) {
            $loginUserId = $dataUserLogin->userId();
            $userBuildingId = $modelBuilding->userId($buildingId);
            $newInfo = ($loginUserId !== $userBuildingId) ? 1 : 0;

            if ($modelBuildingComment->insert($content, $newInfo, $buildingId, $loginUserId)) {
                $newCommentId = $modelBuildingComment->insertGetId();

                //update statistic of building
                $modelBuilding->plusComment($buildingId);

                //notify to building owner
                if (($loginUserId !== $userBuildingId)) {
                    $modelCommentNotify->insert($newCommentId, $userBuildingId);
                    $modeUserStatistic->plusActionNotify($userBuildingId);

                    //insert notify
                    $modelUserNotifyActivity->insert($userBuildingId, null, null, null, $newCommentId, null, null, null);
                }

                //notify to friend
                $listFriend = $modelUser->listFriendId($loginUserId);

                if (!empty($listFriend)) {
                    foreach ($listFriend as $key => $value) {
                        if ($userBuildingId != $value) {
                            $modelCommentNotify->insert($newCommentId, $value);
                            $modeUserStatistic->plusActionNotify($value);

                            //insert notify
                            $modelUserNotifyActivity->insert($value, null, null, null, $newCommentId, null, null, null);
                        }
                    }
                }

                $dataBuildingComment = $modelBuildingComment->getInfo($newCommentId);
                return view('map.building.comment.comment-object', compact('modelUser', 'dataBuildingComment'));
            }
        }

    }

    //========== ========== Update ========== ==========
    public function getEditComment($commentId)
    {
        $modelBuildingComment = new TfBuildingComment();
        $dataBuildingComment = $modelBuildingComment->getInfo($commentId);
        return view('map.building.comment.comment-edit', compact('dataBuildingComment'));
    }

    public function postEditComment($commentId)
    {
        $modelBuildingComment = new TfBuildingComment();
        $content = Request::input('txtComment');
        $modelBuildingComment->updateContent($commentId, $content);
        $dataBuildingComment = $modelBuildingComment->getInfo($commentId);
        return view('map.building.comment.comment-object-content', compact('dataBuildingComment'));
    }

    //========== ========== Delete =========== ==========
    public function deleteComment($commentId)
    {
        $modelBuilding = new TfBuilding();
        $modelBuildingComment = new TfBuildingComment();
        $buildingId = $modelBuildingComment->buildingId($commentId);
        if ($modelBuildingComment->actionDelete($commentId)) {
            $modelBuilding->minusComment($buildingId);
        }
    }

}
