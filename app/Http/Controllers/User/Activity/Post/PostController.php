<?php namespace App\Http\Controllers\User\Activity\Post;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\Relation\TfRelation;
use App\Models\Manage\Content\Users\Activity\TfUserActivity;
use App\Models\Manage\Content\Users\Post\TfUserPost;
use App\Models\Manage\Content\Users\PostLove\TfUserPostLove;
use App\Models\Manage\Content\Users\PostNewNotify\TfUserPostNewNotify;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
//use Illuminate\Http\Request;
use Request;
use File, Input;

class PostController extends Controller
{
    public function getPostForm($userWallId)
    {
        $modelUser = new TfUser();
        $modelRelation = new TfRelation();
        $dataUserWall = $modelUser->getInfo($userWallId);
        $dataUserLogin = $modelUser->loginUserInfo();
        if (count($dataUserLogin) > 0 && count($dataUserWall) > 0) {
            return view('user.activity.activity.post.add.form-content', compact('modelRelation', 'modelUser', 'dataUserWall'));
        } else {
            return view('components.login.login-notify');
        }

    }

    public function addPost($userWallId)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserStatistic = new TfUserStatistic();
        $modelUserActivity = new TfUserActivity();
        $modelUserPost = new TfUserPost();
        $content = Request::input('txtUserActivityPostsContent');
        $viewRelation = Request::input('cbRelationViewPosts');
        $image = Request::file('userActivityPostsImage');

        $dataUserLogin = $modelUser->loginUserInfo();
        $loginUserId = $dataUserLogin->userId();
        if (!empty($image)) {
            $file = Request::file('userActivityPostsImage');
            $imageName = $file->getClientOriginalName();
            $imageName = 'post-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
            $modelUserPost->uploadImage($file, $imageName);

        } else {
            $imageName = null;
        }

        if ($modelUserPost->insert($content, $imageName, $viewRelation, $userWallId, $loginUserId)) {
            $newPostsId = $modelUserPost->insertGetId();

            if ($modelUserActivity->insert(null, null, null, $userWallId, $newPostsId)) {
                $newActivityId = $modelUserActivity->insertGetId();
                $userActivity = $modelUserActivity->getInfo($newActivityId);
                return view('user.activity.activity.activity-object', compact('modelUser', 'userActivity'));

            }
            $listFriend = $dataUserLogin->listFriendId();
            if (count($listFriend) > 0) {
                foreach ($listFriend as $key => $value) {
                    $modelPostNewNotify = new TfUserPostNewNotify();
                    $modelPostNewNotify->insert($newPostsId, $value);
                    $modelUserStatistic->plusActionNotify($value);
                }
            }

        } else {
            return 'Your post is processing.';
        }

    }

    //full image
    public function viewImage($postId)
    {
        $modelUser = new TfUser();
        $modelUserPost = new TfUserPost();
        $dataUserPost = $modelUserPost->getInfo($postId);
        return view('user.activity.activity.post.post-image-view', compact('modelUser', 'dataUserPost'));
    }

    //detail info
    public function detailInfo($code)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelUserPost = new TfUserPost();
        $dataUserPost = $modelUserPost->infoOfPostCode($code);
        if(count($dataUserPost) > 0){
            $dataAccess = [
                'accessObject' => 'activity',
            ];
            $dataUser = $dataUserPost->userWall;
            return view('user.activity.activity.post.detail.detail', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess', 'dataUserPost'));
        }else{
            return redirect()->back();
        }
    }

    //love post
    public function lovePost($postId, $loveStatus)
    {
        $modelUser = new TfUser();
        $modelUserPostLove = new TfUserPostLove();
        $loginUserId = $modelUser->loginUserId();
        if (count($loginUserId) > 0) {
            if ($loveStatus == 1) {
                $modelUserPostLove->insert($postId, $loginUserId, 0);
            } else {
                $modelUserPostLove->actionDelete($postId, $loginUserId);
            }
        }
    }

    //edit info
    public function getEditPost($postId)
    {
        $modelRelation = new TfRelation();
        $modelUserPost = new TfUserPost();
        $dataUserPost = $modelUserPost->getInfo($postId);
        return view('user.activity.activity.post.edit.form-edit', compact('modelRelation', 'dataUserPost'));
    }

    public function postEditPost($postId)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserPost = new TfUserPost();
        $content = Request::input('txtUserActivityPostsContent');
        $viewRelationId = Request::input('cbRelationViewPost');
        $newImage = Request::file('userActivityPostEditImage');
        $checkOldImage = Request::input('userActivityPostEditOldImage');

        $dataUserPost_old = $modelUserPost->getInfo($postId);
        $oldImage = $dataUserPost_old->image();
        if (!empty($newImage)) {
            $imageName = $newImage->getClientOriginalName();
            $imageName = 'post-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
            $modelUserPost->uploadImage($newImage, $imageName);
            if (!empty($oldImage)) {
                $modelUserPost->dropImage($oldImage);
            }

        } else {
            if (empty($checkOldImage) && !empty($oldImage)) {
                $modelUserPost->dropImage($oldImage);
            }
            $imageName = $checkOldImage;
        }
        $modelUserPost->updateInfo($postId, $content, $imageName, $viewRelationId);
        //fresh info
        $dataUserPost = $modelUserPost->getInfo($postId);
        return view('user.activity.activity.post.posts-object-content', compact('modelUser', 'dataUserPost'));
    }

    //delete
    public function deletePost($postId)
    {
        $modelUserPost = new TfUserPost();
        $modelUserPost->actionDelete($postId);
    }
}
