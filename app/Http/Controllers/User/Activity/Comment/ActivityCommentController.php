<?php namespace App\Http\Controllers\User\Activity\Comment;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Models\Manage\Content\Users\Activity\Comment\TfUserActivityComment;
use App\Models\Manage\Content\Users\Activity\TfUserActivity;
use App\Models\Manage\Content\Users\TfUser;
use Request;
use File, Input;

class ActivityCommentController extends Controller {

    # ========== ========== Comment ========== ==========
    // add new
    public function postAddComment($activityId)
    {
        $modelUser = new TfUser();
        $modelActivityComment = new TfUserActivityComment();

        $content = Request::input('txtCommentContent');

        $dataUserLogin = $modelUser->loginUserInfo();
        $loginUserId = $dataUserLogin->userId();
        if (!empty($loginUserId)) {
            $modelActivityComment->insert($content, $activityId, $loginUserId);
            $newCommentId = $modelActivityComment->insertGetId();
            $dataUserActivityComment = $modelActivityComment->getInfo($newCommentId);
            return view('user.activity.activity.comment.comment-object', compact('modelUser', 'dataUserActivityComment'));
        }
    }

    // edit
    public function getEditComment($commentId = null)
    {
        $modelActivityComment = new TfUserActivityComment();
        $dataUserActivityComment = $modelActivityComment->getInfo($commentId);
        return view('user.activity.activity.comment.comment-edit', compact('dataUserActivityComment'));
    }

    // edit
    public function postEditComment($commentId = '')
    {
        $modelActivityComment = new TfUserActivityComment();
        $modelActivityComment->updateContent($commentId, Request::input('txtCommentContent'));
        return $modelActivityComment->content($commentId);
    }

    // get more old comment
    public function moreComment($activityId, $take = null, $dateTake = null)
    {
        $modelUser = new TfUser();
        $modelUserActivity = new TfUserActivity();
        $result = $modelUserActivity->commentInfoOfActivity($activityId, $take, $dateTake);
        if (count($result) > 0) {
            foreach ($result as $dataUserActivityComment) {
                echo view('user.activity.activity.comment.comment-object', compact('modelUser', 'dataUserActivityComment'));
            }
        }
    }

    //delete comment
    public function deleteComment($commentId = null)
    {
        $modelActivityComment = new TfUserActivityComment();
        if (!empty($commentId)) {
            $modelActivityComment->actionDelete($commentId);
        };
    }

}
