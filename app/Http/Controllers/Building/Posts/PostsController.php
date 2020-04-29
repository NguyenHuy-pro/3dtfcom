<?php namespace App\Http\Controllers\Building\Posts;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Activity\TfBuildingActivity;
use App\Models\Manage\Content\Building\Post\TfBuildingPost;
use App\Models\Manage\Content\Building\PostComment\TfBuildingPostComment;
use App\Models\Manage\Content\Building\PostImage\TfBuildingPostImage;
use App\Models\Manage\Content\Building\PostInfoReport\TfBuildingPostInfoReport;
use App\Models\Manage\Content\Building\PostLove\TfBuildingPostLove;
use App\Models\Manage\Content\Building\PostNewNotify\TfBuildingPostNewNotify;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Building\VisitHome\TfBuildingVisitHome;
use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\System\BadInfo\TfBadInfo;
use App\Models\Manage\Content\System\Relation\TfRelation;
//use Illuminate\Http\Request;

use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
use Request;
use File, Input;

class PostsController extends Controller
{

    /*public function index($alias = null)
    {
        $modelUser = new TfUser();
        $modelProject = new TfProject();
        $modelBuilding = new TfBuilding();
        $modelBuildingVisitHome = new TfBuildingVisitHome();

        $dataBuilding = $modelBuilding->getInfoOfAlias($alias);
        $modelBannerImage = new TfBannerImage();
        if (count($dataBuilding) > 0) {
            //insert visit home
            $modelBuildingVisitHome->insert($dataBuilding->buildingId(), $modelUser->loginUserId());

            $dataBuildingAccess = [
                'accessObject' => 'post',
                'recentBuilding' => $modelBuilding->recentBuilding(5),
                'recentBannerImage' => $modelBannerImage->recentImage(5), // only take 5 records
                'recentProject' => $modelProject->recentProjectPublished(5)
            ];
            return view('building.activity.activity', compact('modelUser', 'modelBuilding', 'dataBuilding', 'dataBuildingAccess'));
//            return view('building.posts.posts', compact('modelUser', 'modelBuilding', 'dataBuilding', 'dataBuildingAccess'));
        } else {
            return redirect()->route('tf.home');
        }

    }*/

    // grant to posts on building
    public function grantPost($buildingId = '', $relationId = '')
    {
        $modelRelation = new TfRelation();
        $modelBuilding = new TfBuilding();

        $dataBuilding = $modelBuilding->findInfo($buildingId);
        if(count($dataBuilding) > 0){
            $dataBuilding->updateRelation($buildingId, $relationId);
        }
        $dataRelation = $modelRelation->getInfo();
        return view('building.posts.form-posts.add.posts-grant', compact('dataBuilding', 'dataRelation'));
    }

    public function getPostFormContent($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $dataBuilding = $modelBuilding->getInfo($buildingId);
        return view('building.posts.form-posts.add.form-content', compact('modelUser', 'dataBuilding'));
    }

    // get list introduction building
    public function getBuildingIntro()
    {
        $modelUser = new TfUser();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId)) {
            $dataBuilding = $modelUser->buildingInfo($loginUserId);
            return view('building.posts.form-posts.add.select-intro-building', compact('dataBuilding'));
        }
    }

    //turn on\off highlight status
    public function updateHighlight($postId = null, $highlight = 0)
    {
        $modelBuildingPost = new TfBuildingPost();
        if (!empty($postId)) {
            return $modelBuildingPost->updateHighlight($highlight, $postId);
        }
    }

    //add posts
    public function addPost($buildingId)
    {
        $hFunction = new \Hfunction();
        $hImageResize = new \imageResize();
        $modelUser = new TfUser();
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        $modelUserStatistic = new TfUserStatistic();
        $modelBuilding = new TfBuilding();
        $modelBuildingActivity = new TfBuildingActivity();
        $modelBuildingPosts = new TfBuildingPost();
        $modelBuildingPostNewNotify = new TfBuildingPostNewNotify();
        $modelBuildingPostImage = new TfBuildingPostImage();
        $content = Request::input('txtBuildingPostsContent');
        $viewRelation = Request::input('cbRelationViewPosts');
        $buildingIntroId = Request::input('buildingPostsInfo');
        $image = Request::file('buildingPostsImage');
        $multipleImage = Request::file('tf_building_post_mul_image_file');
        $buildingIntroId = ($buildingIntroId == 0) ? null : $buildingIntroId;

        $dataUserLogin = $modelUser->loginUserInfo();
        $dataBuilding = $modelBuilding->findInfo($buildingId);

        $loginUserId = $dataUserLogin->userId();

        /*if (!empty($image)) {
            $file = Request::file('buildingPostsImage');
            $imageName = $file->getClientOriginalName();
            $imageName = $dataBuilding->alias . '-post-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
            $modelBuildingPosts->uploadImage($file, $imageName);

        } else {
            $imageName = null;
        }*/
        if ($modelBuildingPosts->insert($content, null, $buildingId, $viewRelation, $buildingIntroId, $loginUserId)) {
            $newPostsId = $modelBuildingPosts->insertGetId();

            //insert activity
            $modelBuildingActivity->insert($buildingId, null, $newPostsId);
            $newBuildingActivityId = $modelBuildingActivity->insertGetId();

            //add image
            if (!empty($multipleImage)) {
                $n_o = 0;
                foreach ($_FILES['tf_building_post_mul_image_file']['name'] as $name => $value) {
                    $name_img = stripslashes($_FILES['tf_building_post_mul_image_file']['name'][$name]);
                    if (!empty($name_img)) {
                        $n_o = $n_o + 1;
                        $name_img = $hFunction->getTimeCode() . "_$n_o." . $hFunction->getTypeImg($name_img);
                        $source_img = $_FILES['tf_building_post_mul_image_file']['tmp_name'][$name];
                        if ($modelBuildingPostImage->uploadImage($source_img, $name_img, 500)) {
                            $modelBuildingPostImage->insert($name_img, $newPostsId);
                        }
                    }
                }
            }

            //notify new post
            $listUserFollowBuilding = $modelBuilding->listUserFollowBuilding($buildingId);
            if (!empty($listUserFollowBuilding)) {
                foreach ($listUserFollowBuilding as $key => $notifyUserId) {
                    if ($loginUserId != $notifyUserId) {
                        $modelBuildingPostNewNotify->insert($newPostsId, $notifyUserId);
                        $modelUserStatistic->plusActionNotify($notifyUserId);

                        // insert notify
                        $modelUserNotifyActivity->insert($notifyUserId, $newPostsId, null, null, null, null, null, null);
                    }

                }
            }
            //notify to owner building
            $userBuildingId = $dataBuilding->userId();
            if ($loginUserId != $userBuildingId) {
                $modelBuildingPostNewNotify->insert($newPostsId, $userBuildingId);
                $modelUserStatistic->plusActionNotify($userBuildingId);
                // insert notify
                $modelUserNotifyActivity->insert($userBuildingId, $newPostsId, null, null, null, null, null, null);
            }

            //refresh info
            $dataBuildingActivity = $modelBuildingActivity->getInfo($newBuildingActivityId);
            $dataBuildingPost = $modelBuildingPosts->getInfo($newPostsId);
            $dataUserBuilding = $dataBuildingPost->building->userInfo();
            return view('building.posts.content-posts.posts-object', compact('modelUser', 'dataUserBuilding', 'dataBuildingActivity'));
        } else {
            return 'Your post is processing.';
        }

    }

    #=========== =========== =========== Edit =========== =========== ===========
    // get edit form
    public function getEditPost($postId)
    {
        $modelBuildingPost = new TfBuildingPost();
        $dataBuildingPost = $modelBuildingPost->getInfo($postId);
        return view('building.posts.form-posts.edit.form-edit', compact('dataBuildingPost'));
    }

    // get list introduction building
    public function getEditBuildingIntro()
    {
        $modelUser = new TfUser();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId)) {
            $dataBuilding = $modelUser->buildingInfo($loginUserId);
            return view('building.posts.form-posts.edit.select-intro-building', compact('dataBuilding'));
        }
    }

    // post edit
    public function postEditPost($postId)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelBuildingPost = new TfBuildingPost();
        $content = Request::input('txtBuildingPostsContent');
        $viewRelation = Request::input('cbRelationViewPostsEdit');
        $buildingIntroId = Request::input('buildingPostEditInfo');
        $image = Request::file('buildingPostEditImage');
        $newImage = Request::input('buildingPostEditOldImage');

        $dataBuildingPost_old = $modelBuildingPost->getInfo($postId);
        $oldImage = $dataBuildingPost_old->image();
        $buildingIntroId = ($buildingIntroId == 0) ? null : $buildingIntroId;
        if (!empty($image)) {// change image
            $imageName = $image->getClientOriginalName();
            $imageName = $dataBuildingPost_old->building->alias() . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
            $modelBuildingPost->uploadImage($image, $imageName);
            if (!empty($oldImage)) {
                $modelBuildingPost->dropImage($oldImage);
            }

        } else {
            if (empty($newImage) && !empty($oldImage)) {
                $modelBuildingPost->dropImage($oldImage);
            }
            $imageName = $newImage;
        }
        $modelBuildingPost->updateInfo($postId, $content, $imageName, $buildingIntroId, $viewRelation);

        //fresh info
        $dataBuildingPost = $modelBuildingPost->getInfo($postId);
        return view('building.posts.content-posts.posts-object-content', compact('modelUser', 'dataBuildingPost'));
    }

    // view full image of posts
    public function viewPostImage($accessImageId = null)
    {
        $modelUser = new TfUser();
        $modelBuildingPost = new TfBuildingPost();
        $modelBuildingPostImage = new TfBuildingPostImage();
        $dataBuildingPost = $modelBuildingPost->getInfo($modelBuildingPostImage->postId($accessImageId));
        return view('building.posts.content-posts.post-image-view', compact('modelUser', 'dataBuildingPost','accessImageId'));

    }

    //delete
    public function deletePost($postId=null)
    {
        $modelBuildingPost = new TfBuildingPost();
        if(!empty($postId)){
            $modelBuildingPost->actionDelete($postId);
        }

    }

    #========== ========== Detail ========= ===========
    public function detail($postCode = null)
    {
        $modelUser = new TfUser();
        $modelProject = new TfProject();
        $modelBuilding = new TfBuilding();
        $modelBuildingPost = new TfBuildingPost();
        $modelBannerImage = new TfBannerImage();
        $dataBuildingPost = $modelBuildingPost->infoOfPostCode($postCode);
        if (count($dataBuildingPost) > 0) {
            $dataBuildingAccess = [
                'accessObject' => 'detail',
                'recentBuilding' => $modelBuilding->recentBuilding(5), //only take 5 records
                'recentBannerImage' => $modelBannerImage->recentImage(5), // only take 5 records
                'recentProject' => $modelProject->recentProjectPublished(5)
            ];
            return view('building.posts.detail.detail', compact('modelUser', 'modelBuilding', 'dataBuildingPost', 'dataBuildingAccess'));
        } else {
            return view('errors.404');
        }

    }

    #========== ========== Report ========= ===========
    public function getReport($postId = null)
    {
        $modelUser = new TfUser();
        $modelBuildingPost = new TfBuildingPost();
        $modelBuildingPostReport = new TfBuildingPostInfoReport();
        $modelBadInfo = new TfBadInfo();

        $userLoginId = $modelUser->loginUserId();
        if (!empty($userLoginId)) {
            if ($modelBuildingPostReport->checkUserReported($userLoginId, $postId)) {
                return view('building.posts.report.notify');
            } else {
                $dataBadInfo = $modelBadInfo->getInfo();
                $dataBuildingPost = $modelBuildingPost->getInfo($postId);
                if (count($dataBadInfo) > 0) {
                    return view('building.posts.report.bad-info', compact('dataBuildingPost', 'dataBadInfo'));
                }
            }
        }

    }

    public function sendReport()
    {
        $modelUser = new TfUser();
        $modelBuildingPostReport = new TfBuildingPostInfoReport();
        $postId = Request::input('buildingPost');
        $badInfoId = Request::input('badInfo');
        $userId = $modelUser->loginUserId();
        $modelBuildingPostReport->insert($postId, $userId, $badInfoId);

    }

    #========== ========== Love ========== ==========
    public function lovePost($postId, $loveStatus = '')
    {
        $modelUser = new TfUser();
        $modelBuildingPostsLove = new TfBuildingPostLove();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId)) {
            if ($loveStatus == 1) {
                $modelBuildingPostsLove->insert($postId, $loginUserId, 0);
            } else {
                $modelBuildingPostsLove->actionDelete($postId, $loginUserId);
            }
        }
    }
    # ========== ========== Comment ========== ==========
    // add new
    public function postAddComment($postId)
    {
        $modelUser = new TfUser();
        $modelPostComment = new TfBuildingPostComment();
        $content = Request::input('txtCommentContent');
        $dataUserLogin = $modelUser->loginUserInfo();
        $loginUserId = $dataUserLogin->userId();
        if (!empty($loginUserId)) {
            $modelPostComment->insert($content, $postId, $loginUserId);
            $newCommentId = $modelPostComment->insertGetId();
            $dataBuildingPostsComment = $modelPostComment->getInfo($newCommentId);

            $dataBuilding = $dataBuildingPostsComment->buildingPost->building;
            $dataUserBuilding = $dataBuilding->userInfo();
            return view('building.posts.comments.comment-object', compact('modelUser', 'dataBuildingPostsComment', 'dataUserBuilding'));
        }
    }

    // edit
    public function getEditComment($commentId = null)
    {
        $modelPostComment = new TfBuildingPostComment();
        $dataBuildingPostComment = $modelPostComment->getInfo($commentId);
        return view('building.posts.comments.comment-edit', compact('dataBuildingPostComment'));
    }

    // edit
    public function postEditComment($commentId = null)
    {
        $modelPostComment = new TfBuildingPostComment();
        if(!empty($commentId)){
            $modelPostComment->updateContent($commentId, Request::input('txtCommentContent'));
            return $modelPostComment->content($commentId);
        }
    }

    // get more old comment
    public function moreComment($postId, $take = null, $dateTake = null)
    {
        $modelUser = new TfUser();
        $modelBuildingPost = new TfBuildingPost();
        $dataBuildingPost = $modelBuildingPost->getInfo($postId);

        $result = $modelBuildingPost->commentInfoOfPost($postId, $take, $dateTake);
        $dataBuilding = $dataBuildingPost->building;
        $dataUserBuilding = $dataBuilding->userInfo();
        if (count($result) > 0) {
            foreach ($result as $dataBuildingPostsComment) {
                echo view('building.posts.comments.comment-object', compact('modelUser', 'dataBuildingPostsComment', 'dataUserBuilding'));
            }
        }
    }

    //delete comment
    public function deleteComment($commentId = null)
    {
        $modelPostComment = new TfBuildingPostComment();
        if (!empty($commentId)) {
            $modelPostComment->actionDelete($commentId);
        };
    }

}
