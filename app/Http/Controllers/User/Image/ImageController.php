<?php namespace App\Http\Controllers\User\Image;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\Image\TfUserImage;
use App\Models\Manage\Content\Users\ImageDetail\TfUserImageDetail;
use App\Models\Manage\Content\Users\ImageType\TfUserImageType;
use App\Models\Manage\Content\Users\TfUser;
#use Illuminate\Http\Request;

use Request;
use File;
use Input;

class ImageController extends Controller
{

    //=========== =========== Manage image ============ ============
    public function index($userId = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUserLogin = $modelUser->loginUserInfo();
        if (empty($userId)) {
            if (count($dataUserLogin) > 0) {
                $userId = $dataUserLogin->userId();
            }
        }
        if (!empty($userId)) {
            $dataUser = TfUser::find($userId);
            if (count($dataUser) > 0) {
                $dataAccess = [
                    'accessObject' => 'image',
                    'imageObject' => 'all'
                ];
                return view('user.image.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
            } else {
                return redirect()->route('tf.home');
            }

        } else {
            return redirect()->route('tf.home');
        }
    }

    public function moreAllImage($userId, $take, $dateTake)
    {
        $modelUser = new TfUser();
        $modelUserImage = new TfUserImage();
        $resultImage = $modelUserImage->infoOfUser($userId, $take, $dateTake);
        if (count($resultImage) > 0) {
            foreach ($resultImage as $dataUserImage) {
                echo view('user.image.image.image-object', compact('modelUser','dataUserImage'));
            }
        }
    }

    #view full image
    public function getViewImage($imageId)
    {
        $dataUserImage = TfUserImage::find($imageId);
        return view('user.image.image-view', compact('dataUserImage'));
    }

    #delete
    public function deleteAllImage($imageId)
    {
        $modelUserImage = new TfUserImage();
        return $modelUserImage->actionDelete($imageId);
    }

    #----------- Manage avatar -----------
    public function getAvatarImage($userId)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUser = TfUser::find($userId);
        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'image',
                'imageObject' => 'avatar'
            ];
            return view('user.image.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        }
    }

    public function moreAvatarImage($userId, $take, $dateTake)
    {
        $modelUser = new TfUser();
        $modelUserImageType = new TfUserImageType();
        $modelUserImage = new TfUserImage();
        $typeId = $modelUserImageType->typeIdAvatar();
        $resultImage = $modelUserImage->infoOfUser($userId, $take, $dateTake, $typeId);
        if (count($resultImage) > 0) {
            foreach ($resultImage as $dataUserImage) {
                echo view('user.image.avatar.avatar-object', compact('modelUser', 'dataUserImage'));
            }
        }
    }

    #delete avatar'
    public function deleteAvatarImage($imageId)
    {
        $modelUserImageType = new TfUserImageType();
        $modelImageDetail = new TfUserImageDetail();
        $typeId = $modelUserImageType->typeIdAvatar();
        return $modelImageDetail->actionDelete($imageId, $typeId);
    }

    #----------- Manage banner -----------
    public function getBannerImage($userId)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUser = TfUser::find($userId);
        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'image',
                'imageObject' => 'banner'
            ];
            return view('user.image.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        }
    }

    public function moreBannerImage($userId, $take, $dateTake)
    {
        $modeUser = new TfUser();
        $modelUserImageType = new TfUserImageType();
        $modelUserImage = new TfUserImage();
        $typeId = $modelUserImageType->typeIdBanner();
        $resultImage = $modelUserImage->infoOfUser($userId, $take, $dateTake, $typeId);
        if (count($resultImage) > 0) {
            foreach ($resultImage as $dataUserImage) {
                echo view('user.image.banner.banner-object', compact('modelUser','dataUserImage'));
            }
        }
    }

    #delete
    public function deleteBannerImage($imageId)
    {
        $modelUserImageType = new TfUserImageType();
        $modelImageDetail = new TfUserImageDetail();
        $typeId = $modelUserImageType->typeIdBanner();
        return $modelImageDetail->actionDelete($imageId, $typeId);
    }


}
