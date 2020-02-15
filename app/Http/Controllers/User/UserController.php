<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\Image\TfUserImage;
use App\Models\Manage\Content\Users\ImageDetail\TfUserImageDetail;
use App\Models\Manage\Content\Users\ImageType\TfUserImageType;
use App\Models\Manage\Content\Users\Love\TfUserLove;
use App\Models\Manage\Content\Users\TfUser;
#use Illuminate\Http\Request;

use Request;
use File, Input;

class UserController extends Controller
{
    public function index($alias = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUserLogin = $modelUser->loginUserInfo();
        $dataUser = '';
        if (!empty($alias)) {
            $dataUser = $modelUser->getInfoByAlias($alias);
        } else {
            if (count($dataUserLogin) > 0) {
                $dataUser = $dataUserLogin;
            }
        }
        if (!empty($dataUser)) {
            $dataAccess = [
                'accessObject' => 'info'
            ];
            //return view('user.information.information', compact('modelAbout','modelUser', 'dataUser', 'dataAccess'));
            return redirect()->route('tf.user.activity.get', $alias);
        } else {
            return redirect()->route('tf.home');
        }
    }

    # ---------- ---------- love user ---------- ----------
    public function plusLoveUser($loveUserId = '')
    {
        $modelUser = new TfUser();
        $modelUserLove = new TfUserLove();
        if (!empty($loveUserId)) {
            $loginUserId = $modelUser->loginUserId();
            if (!empty($loveUserId)) {
                $newInfo = ($loginUserId != $loveUserId) ? 1 : 0;
                $modelUserLove->insert($loginUserId, $loveUserId, $newInfo);
            }
        }
    }

    public function minusLoveUser($loveUserId = '')
    {
        $modelUser = new TfUser();
        $modelUserLove = new TfUserLove();
        if (!empty($loveUserId)) {
            $loginUserId = $modelUser->loginUserId();
            if (!empty($loveUserId)) {
                return $modelUserLove->actionDelete($loginUserId, $loveUserId);
            }
        }
    }

    # ---------- ---------- Title banner ---------- ----------
    //view
    public function viewDetailTitleBanner($image = null)
    {
        $modelUser = new TfUser();
        if (!empty($image)) {
            $dataUserImage = TfUserImage::find($image);
            if (!empty($dataUserImage)) return view('user.components.title.banner-view', compact('modelUser', 'dataUserImage'));
        }
    }

    public function getTitleBanner()
    {
        return view('user.components.title.title-banner-edit');
    }

    public function postTitleBanner()
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserImageType = new TfUserImageType();
        $modelUserImage = new TfUserImage();
        $dataUserLogin = $modelUser->loginUserInfo();

        if (count($dataUserLogin) > 0) {

            if (Input::hasFile('bannerImage')) {
                $file = Request::file('bannerImage');
                $imageName = $file->getClientOriginalName();
                $imageName = $dataUserLogin->alias . "-" . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
                $pathSmallImage = "public/images/user/small/";
                $pathFullImage = "public/images/user/full/";
                if ($hFunction->uploadSave($file, $pathSmallImage, $pathFullImage, $imageName)) {
                    # insert into image table of user
                    $typeId = $modelUserImageType->typeIdBanner();
                    $highlight = 1;
                    $modelUserImage->insert($imageName, $highlight, $typeId, $dataUserLogin->userId());
                }
            }
        }
    }

    public function deleteTitleBanner($imageId)
    {
        $modelUser = new TfUser();
        $modelUserImageType = new TfUserImageType();
        $modelUserImageDetail = new TfUserImageDetail();
        if ($modelUser->checkLogin()) {
            $typeId = $modelUserImageType->typeIdBanner();
            $modelUserImageDetail->actionDelete($imageId, $typeId);
        }
    }

    # ---------- ---------- Avatar  ---------- ----------
    public function viewDetailAvatar($imageId = null)
    {
        $modelUser = new TfUser();
        if (!empty($imageId)) {
            $dataUserImage = TfUserImage::find($imageId);
            if (!empty($dataUserImage)) return view('user.components.avatar.avatar-view', compact('modelUser', 'dataUserImage'));
        }
    }

    public function getTitleAvatar()
    {
        return view('user.components.avatar.avatar-edit');
    }

    public function postTitleAvatar()
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserImageType = new TfUserImageType();
        $modelUserImage = new TfUserImage();
        $dataUserLogin = $modelUser->loginUserInfo();
        if (count($dataUserLogin) > 0) {

            if (Input::hasFile('avatarImage')) {
                $file = Request::file('avatarImage');
                $imageName = $file->getClientOriginalName();
                $imageName = $dataUserLogin->alias . "-" . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
                $pathSmallImage = "public/images/user/small/";
                $pathFullImage = "public/images/user/full/";
                if ($hFunction->uploadSave($file, $pathSmallImage, $pathFullImage, $imageName)) {
                    # insert into image table of user
                    $typeId = $modelUserImageType->typeIdAvatar();
                    $highlight = 1;
                    $modelUserImage->insert($imageName, $highlight, $typeId, $dataUserLogin->userId());
                }
            }
        }
    }

    public function deleteTitleAvatar($imageId)
    {
        $modelUser = new TfUser();
        $modelUserImageType = new TfUserImageType();
        $modelUserImageDetail = new TfUserImageDetail();
        if ($modelUser->checkLogin()) {
            $typeId = $modelUserImageType->typeIdAvatar();
            $modelUserImageDetail->actionDelete($imageId, $typeId);
        }
    }

    #---------- ---------- land ---------- ----------
    public function getLand($userId = '')
    {
        return view('user.land.land');
    }

    public function getProject($userId = '')
    {
        return view('user.project.project');
    }

    #---------- ---------- follow ---------- ----------
    public function getFollow($userId = '')
    {
        return view('user.follow.follow');
    }

}