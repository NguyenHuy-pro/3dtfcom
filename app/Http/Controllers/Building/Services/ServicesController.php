<?php namespace App\Http\Controllers\Building\Services;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Building\Service\Articles\TfBuildingArticles;
use App\Models\Manage\Content\Building\Service\ArticlesComment\TfBuildingArticlesComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Building\VisitHome\TfBuildingVisitHome;
use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\System\BuildingServiceType\TfBuildingServiceType;
use App\Models\Manage\Content\Users\TfUser;
//use Illuminate\Http\Request;

use Request;
use File;
use Input;

class ServicesController extends Controller
{

    public function index($alias = null, $typeId = 0, $keyword = null)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelProject = new TfProject();
        $modelBuilding = new TfBuilding();
        $modelBuildingArticles = new TfBuildingArticles();
        $modelBuildingService = new TfBuildingServiceType();
        $modelBuildingVisitHome = new TfBuildingVisitHome();
        $modelBannerImage = new TfBannerImage();
        $dataBuilding = $modelBuilding->getInfoOfAlias($alias);

        if (count($dataBuilding) > 0) {
            $buildingId = $dataBuilding->buildingId();
            //insert view home
            $modelBuildingVisitHome->insert($buildingId, $modelUser->loginUserId());
            $take = 10;
            $dateTake = $hFunction->createdAt();
            $dataBuildingArticles = $dataBuilding->articlesInfoOfBuilding($buildingId, $take, $dateTake, $typeId, $keyword);
            $dataBuildingAccess = [
                'accessObject' => 'services',
                'take' => $take,
                'keyword' => $keyword,
                'serviceTypeId' => $typeId,
                'dataBuildingServiceType' => $modelBuildingService->getInfo(),
                'dataBuildingArticles' => $dataBuildingArticles,
                'recentBuilding' => $modelBuilding->recentBuilding(5), //only take 5 records
                'recentBannerImage' => $modelBannerImage->recentImage(5), // only take 5 records
                'recentProject' => $modelProject->recentProjectPublished(5),
            ];
            return view('building.services.services', compact('modelUser', 'modelBuilding', 'dataBuilding', 'dataBuildingAccess'));
        } else {
            return redirect()->route('tf.home');
        }

    }

    public function  moreArticles($buildingId, $take = null, $dateTake = null, $typeId = 0, $keyword = null)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        // building info
        $dataBuilding = $modelBuilding->findInfo($buildingId);

        // info of building owner
        $dataUserBuilding = $dataBuilding->userInfo();

        // info posts of building
        $listBuildingArticles = $dataBuilding->articlesInfoOfBuilding($buildingId, $take, $dateTake, $typeId, $keyword);
        if (count($listBuildingArticles) > 0) {
            foreach ($listBuildingArticles as $buildingArticles) {
                echo view('building.services.services-articles', compact('modelUser', 'dataUserBuilding', 'buildingArticles'));
            }
        }
    }

    //edit
    public function getEditArticle($articleId = null)
    {
        $modelUser = new TfUser();
        $modelBuildingService = new TfBuildingServiceType();
        $modelBuildingArticles = new TfBuildingArticles();
        $userLoginId = $modelUser->loginUserId();
        if (count($userLoginId) > 0) {
            $dataBuildingArticles = $modelBuildingArticles->getInfo($articleId);
            $dataBuildingServiceType = $modelBuildingService->getInfo();
            //articles of user logged
            if ($dataBuildingArticles->checkArticlesOfUser($userLoginId)) {
                return view('building.services.edit.edit-articles', compact('dataBuildingServiceType', 'dataBuildingArticles'));
            }
        }
    }

    public function postEditArticle()
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelBuildingArticles = new TfBuildingArticles();
        $articleId = Request::input('txtArticles');
        $serviceType = Request::input('cbServiceType');
        $title = Request::input('txtTitle');
        $shortDescription = Request::input('txtShortDescription');
        $keyword = Request::input('txtKeyWord');
        $content = Request::input('txtContent');
        $link = Request::input('txtLink');
        $avatar = Request::file('txtAvatar');
        $dataBuildingArticles = $modelBuildingArticles->getInfo($articleId);
        if (count($dataBuildingArticles) > 0) {
            $changeAvatarStatus = false;
            $oldAvatar = $dataBuildingArticles->avatar();
            $alias = $hFunction->alias($title, '-') . $hFunction->getTimeCode();
            $keyword = (empty($keyword)) ? $title : $keyword;
            if (!empty($avatar)) {
                $imageName = $avatar->getClientOriginalName();
                $imageName = $alias . '.' . $hFunction->getTypeImg($imageName);
                $modelBuildingArticles->uploadImage($avatar, $imageName);
                $changeAvatarStatus = true;
            } else {
                $imageName = $oldAvatar;
            }
            if ($modelBuildingArticles->updateInfo($articleId, $title, $shortDescription, $keyword, $content, $imageName, $serviceType, $link)) {
                if ($changeAvatarStatus) $modelBuildingArticles->dropImage($oldAvatar);
                //refresh info
                $buildingArticles = $modelBuildingArticles->getInfo($articleId);
                $dataUserBuilding = $buildingArticles->building->userInfo();
                echo view('building.services.services-articles-content', compact('modelUser', 'buildingArticles', 'dataUserBuilding'));
            }
        }

    }

    public function deleteArticles($articlesId)
    {
        $modelBuildingArticles = new TfBuildingArticles();
        return $modelBuildingArticles->actionDelete($articlesId);
    }
    //========= comment =========
    //add
    public function addComment()
    {
        $modelUser = new TfUser();
        $modelBuildingArticlesComment = new TfBuildingArticlesComment();
        $articlesId = Request::input('txtArticles');
        $txtContent = Request::input('txtCommentContent');
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId) && !empty($txtContent)) {
            $modelBuildingArticlesComment->insert($txtContent, $articlesId, $loginUserId);
            $dataBuildingArticlesComment = $modelBuildingArticlesComment->getInfo($modelBuildingArticlesComment->insertGetId());
            return view('building.services.comment.comment-object', compact('modelUser', 'dataBuildingArticlesComment'));
        }
    }

    //edit
    public function getEditComment($commentId)
    {
        $modelUser = new TfUser();
        $modelBuildingArticlesComment = new TfBuildingArticlesComment();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId)) {
            $dataBuildingArticlesComment = $modelBuildingArticlesComment->getInfo($commentId);
            if ($dataBuildingArticlesComment->checkCommentOfUser($loginUserId)) {
                return view('building.services.comment.comment-edit', compact('dataBuildingArticlesComment'));
            }
        }
    }

    public function saveEditComment()
    {
        $modelUser = new TfUser();
        $modelBuildingArticlesComment = new TfBuildingArticlesComment();
        $commentId = Request::input('txtComment');
        $txtContent = Request::input('txtCommentContent');
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId) && !empty($txtContent)) {
            $modelBuildingArticlesComment->updateContent($commentId, $txtContent);
            $dataBuildingArticlesComment = $modelBuildingArticlesComment->getInfo($commentId);
            echo view('building.services.comment.comment-object-content', compact('modelUser', 'dataBuildingArticlesComment'));
        }
    }

    public function deleteComment($commentId)
    {
        $modelUser = new TfUser();
        $modelBuildingArticlesComment = new TfBuildingArticlesComment();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId)) {
            $dataBuildingArticlesComment = $modelBuildingArticlesComment->getInfo($commentId);
            if ($loginUserId == $dataBuildingArticlesComment->userId() || $dataBuildingArticlesComment->buildingArticles->checkArticlesOfUser($loginUserId)) {
                $dataBuildingArticlesComment->actionDelete();
            }
        }
    }

    public function  moreComment($articlesId, $take = null, $dateTake = null)
    {
        $modelUser = new TfUser();
        $modelBuildingArticlesComment = new TfBuildingArticlesComment();

        $listBuildingArticlesComment = $modelBuildingArticlesComment->activityInfoOfArticles($articlesId, $take, $dateTake);
        if (count($listBuildingArticlesComment) > 0) {
            foreach ($listBuildingArticlesComment as $dataBuildingArticlesComment) {
                echo view('building.services.comment.comment-object', compact('modelUser', 'dataBuildingArticlesComment'));
            }
        }
    }
}
