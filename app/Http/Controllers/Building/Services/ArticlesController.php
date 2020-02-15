<?php namespace App\Http\Controllers\Building\Services;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Building\Activity\TfBuildingActivity;
use App\Models\Manage\Content\Building\Service\ArticlesComment\TfBuildingArticlesComment;
use App\Models\Manage\Content\Building\Service\ArticlesLove\TfBuildingArticlesLove;
use App\Models\Manage\Content\Building\Service\ArticlesVisit\TfBuildingArticlesVisit;
use App\Models\Manage\Content\Building\VisitHome\TfBuildingVisitHome;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Building\Service\Articles\TfBuildingArticles;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\System\BuildingServiceType\TfBuildingServiceType;
use App\Models\Manage\Content\Users\TfUser;
//use Illuminate\Http\Request;

use Request;
use File;
use Input;

class ArticlesController extends Controller
{

    public function articles($buildingId, $typeId = 0, $keyword = null)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelProject = new TfProject();
        $modelBuilding = new TfBuilding();
        //$modelBuildingArticles = new TfBuildingArticles();
        $modelBuildingService = new TfBuildingServiceType();
        $modelBuildingVisitHome = new TfBuildingVisitHome();
        $modelBannerImage = new TfBannerImage();
        $dataBuilding = $modelBuilding->getInfo($buildingId);

        if ($modelUser->checkLogin() && count($dataBuilding) > 0) {
            $buildingId = $dataBuilding->buildingId();
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
            return view('building.services.tool.article', compact('modelUser', 'modelBuilding', 'dataBuilding', 'dataBuildingAccess'));
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
                echo view('building.services.tool.articles-object', compact('modelUser', 'dataUserBuilding', 'buildingArticles'));
            }
        }
    }

    public function detailArticle($articleAlias = null)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $modelBannerImage = new TfBannerImage();
        $modelBuildingArticles = new TfBuildingArticles();
        $modelBuildingArticlesVisit = new TfBuildingArticlesVisit();
        $modelProject = new TfProject();
        $dataBuildingArticles = $modelBuildingArticles->infoByAlias($articleAlias);
        $dataBuildingAccess = [
            'accessObject' => 'services',
            'recentBuilding' => $modelBuilding->recentBuilding(5), //only take 5 records
            'recentBannerImage' => $modelBannerImage->recentImage(5), // only take 5 records
            'recentProject' => $modelProject->recentProjectPublished(5),
        ];
        if (count($dataBuildingArticles) > 0) {
            $modelBuildingArticlesVisit->insert($dataBuildingArticles->articlesId(), $modelUser->loginUserId());
            //$relation = $dataBuildingArticles->infoRelationOfArticles($dataBuildingArticles->articlesId(),2);
            return view('building.services.detail.detail', compact('modelUser', 'modelBuilding', 'dataBuildingArticles', 'dataBuildingAccess'));
        }
    }

    //add service
    public function getAddArticle($buildingId = null)
    {
        $modelUser = new TfUser();
        $modelBuildingService = new TfBuildingServiceType();
        $modelBuilding = new TfBuilding();
        $modelBannerImage = new TfBannerImage();
        $modelProject = new TfProject();
        $userLoginId = $modelUser->loginUserId();
        $actionStatus = false;
        if (count($userLoginId) > 0) {
            $dataBuilding = $modelBuilding->getInfo($buildingId);
            if (count($dataBuilding) > 0 && $modelBuilding->checkBuildingOfUser($buildingId, $userLoginId)) {
                $dataBuildingServiceType = $modelBuildingService->getInfo();
                $dataBuildingAccess = [
                    'accessObject' => 'services',
                    'recentBuilding' => $modelBuilding->recentBuilding(5), //only take 5 records
                    'recentBannerImage' => $modelBannerImage->recentImage(5), // only take 5 records
                    'recentProject' => $modelProject->recentProjectPublished(5),
                ];
                $actionStatus = true;
            }
        }
        if ($actionStatus) {
            return view('building.services.tool.add.add', compact('modelUser', 'modelBuilding', 'dataBuilding', 'dataBuildingAccess', 'dataBuildingServiceType'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    public function postAddArticle($buildingId)
    {
        $hFunction = new \Hfunction();
        $modelBuilding = new TfBuilding();
        $modelBuildingArticles = new TfBuildingArticles();
        $modelBuildingActivity = new TfBuildingActivity();
        $serviceType = Request::input('cbServiceType');
        $title = Request::input('txtTitle');
        $shortDescription = Request::input('txtShortDescription');
        $keyword = Request::input('txtKeyWord');
        $content = Request::input('txtContent');
        $link = Request::input('txtLink');
        $avatar = Request::file('txtAvatar');
        $dataBuilding = $modelBuilding->getInfo($buildingId); // get building info
        if (count($dataBuilding) > 0) { # exist building
            $alias = $hFunction->alias($title, '-') . $hFunction->getTimeCode();
            $keyword = (empty($keyword)) ? $title : $keyword;
            if (!empty($avatar)) {
                $imageName = $avatar->getClientOriginalName();
                $imageName = $alias . '.' . $hFunction->getTypeImg($imageName);
                $modelBuildingArticles->uploadImage($avatar, $imageName);

            } else {
                $imageName = null;
            }
            if ($modelBuildingArticles->insert($buildingId, $serviceType, $title, $shortDescription, $keyword, $content, $imageName, $link)) {
                $articlesNewId = $modelBuildingArticles->insertGetId();
                $modelBuildingActivity->insert($buildingId, $articlesNewId, null);
                Session::flash('addArticlesNotify', 'true');
            } else {
                Session::flash('addArticlesNotify', 'false');
            }
            return redirect()->route('tf.building.services.article.tool.get', $buildingId);
        }

    }

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
                return view('building.services.tool.edit.edit', compact('dataBuildingServiceType', 'dataBuildingArticles'));
            }
        }
    }

    public function postEditArticle($articleId = null)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelBuildingArticles = new TfBuildingArticles();
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
                echo view('building.services.tool.articles-object-content', compact('modelUser', 'buildingArticles'));
            }
        }

    }

    public function deleteArticles($articlesId)
    {
        $modelUser = new TfUser();
        $modelBuildingArticles = new TfBuildingArticles();
        $userLoginId = $modelUser->loginUserId();
        if (count($userLoginId) > 0) {
            if ($modelBuildingArticles->checkArticlesOfUser($userLoginId, $articlesId)) {
                return $modelBuildingArticles->actionDelete($articlesId);
            }
        }
    }

    //love
    public function loveArticles($articlesId)
    {
        $modelUser = new TfUser();
        $modelBuildingArticlesLove = new TfBuildingArticlesLove();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId)) {
            $modelBuildingArticlesLove->insert($articlesId, $loginUserId);
        }
    }

    public function unLoveArticles($articlesId)
    {
        $modelUser = new TfUser();
        $modelBuildingArticlesLove = new TfBuildingArticlesLove();
        $loginUserId = $modelUser->loginUserId();
        if (!empty($loginUserId)) {
            $modelBuildingArticlesLove->actionDelete($articlesId, $loginUserId);
        }
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
            return view('building.services.detail.comment.comment-object', compact('modelUser', 'dataBuildingArticlesComment'));
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
                return view('building.services.detail.comment.comment-edit', compact('dataBuildingArticlesComment'));
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
            echo view('building.services.detail.comment.comment-object-content', compact('modelUser', 'dataBuildingArticlesComment'));
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
                echo view('building.services.detail.comment.comment-object', compact('modelUser', 'dataBuildingArticlesComment'));
            }
        }
    }

    //embed
    public function embedShareArticles($articlesId)
    {
        $modelBuildingArticles = new TfBuildingArticles();
        $dataBuildingArticles = $modelBuildingArticles->getInfo($articlesId);
        if (count($dataBuildingArticles) > 0) {
            return view('building.services.detail.share.share-embed', compact('dataBuildingArticles'));
        }
    }

    public function embedArticles($articlesAlias)
    {
        $modelBuildingArticles = new TfBuildingArticles();
        $dataBuildingArticles = $modelBuildingArticles->infoByAlias($articlesAlias);
        if (count($dataBuildingArticles) > 0) {
            return view('building.services.detail.share.articles-embed', compact('dataBuildingArticles'));
        }
    }

}
