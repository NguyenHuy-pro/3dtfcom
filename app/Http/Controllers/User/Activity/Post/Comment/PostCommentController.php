<?php namespace App\Http\Controllers\User\Activity\Post\Comment;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Models\Manage\Content\Users\Post\Comment\TfUserPostComment;
use App\Models\Manage\Content\Users\Post\TfUserPost;
use App\Models\Manage\Content\Users\TfUser;
use Request;
use File, Input;

class PostCommentController extends Controller {

    # ========== ========== Comment ========== ==========
    // add new
    public function postAddComment($postId)
    {
        $modelUser = new TfUser();
        $modelPostComment = new TfUserPostComment();

        $content = Request::input('txtCommentContent');

        $dataUserLogin = $modelUser->loginUserInfo();
        $loginUserId = $dataUserLogin->userId();
        if (!empty($loginUserId)) {
            $modelPostComment->insert($content, $postId, $loginUserId);
            $newCommentId = $modelPostComment->insertGetId();
            $dataUserPostComment = $modelPostComment->getInfo($newCommentId);
            return view('user.activity.activity.post.comments.comment-object', compact('modelUser', 'dataUserPostComment'));
        }
    }

    // edit
    public function getEditComment($commentId = null)
    {
        $modelPostComment = new TfUserPostComment();
        $dataUserPostComment = $modelPostComment->getInfo($commentId);
        return view('user.activity.activity.post.comments.comment-edit', compact('dataUserPostComment'));
    }

    // edit
    public function postEditComment($commentId = '')
    {
        $modelPostComment = new TfUserPostComment();
        $modelPostComment->updateContent($commentId, Request::input('txtCommentContent'));
        return $modelPostComment->content($commentId);
    }

    // get more old comment
    public function moreComment($postId, $take = null, $dateTake = null)
    {
        $modelUser = new TfUser();
        $modelUserPost = new TfUserPost();
        $result = $modelUserPost->commentInfoOfPost($postId, $take, $dateTake);
        if (count($result) > 0) {
            foreach ($result as $dataUserPostComment) {
                echo view('user.activity.activity.post.comments.comment-object', compact('modelUser', 'dataUserPostComment'));
            }
        }
    }

    //delete comment
    public function deleteComment($commentId = null)
    {
        $modelPostComment = new TfUserPostComment();
        if (!empty($commentId)) {
            $modelPostComment->actionDelete($commentId);
        };
    }

}
