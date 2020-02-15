<?php namespace App\Http\Controllers\User\Ads;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Ads\Banner\Image\TfAdsBannerImage;
use App\Models\Manage\Content\Ads\Banner\License\TfAdsBannerLicense;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\Users\TfUser;
//use Illuminate\Http\Request;

use File;
use Input;
use Request;

class AdsBannerController extends Controller
{

    public function index($userCode = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUser = $modelUser->loginUserInfo();

        /*
         develop public
        if (empty($userCode)) {
            $dataUser = $dataUserLogin;
        } else {
            $dataUser = $modelUser->getInfoByNameCode($userCode);
        }
        */

        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'ads'
            ];
            return view('user.ads.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    public function moreAdsBanner($accessUserId = null, $skip = null, $take = null)
    {
        $modelUser = new TfUser();
        if (!empty($accessUserId)) {
            $dataUser = $modelUser->getInfo($accessUserId);
            $dataAdsBannerLicense = $dataUser->adsBannerLicenseOfUser($accessUserId, $skip, $take);
            return view('user.ads.ads-banner-object', compact('modelUser', 'dataUser', 'dataAdsBannerLicense', 'skip', 'take'));
        }
    }

    public function getSetImage($licenseName)
    {
        $modelBusinessType = new TfBusinessType();
        $modelAdsBannerLicense = new TfAdsBannerLicense();
        $dataAdsBannerLicense = $modelAdsBannerLicense->getInfoOfName($licenseName);
        return View('user.ads.image.set-image', compact('modelBusinessType','dataAdsBannerLicense'));
    }

    public function postSetImage($licenseName)
    {
        $hFunction = new \Hfunction();
        $modelAdsBannerLicense = new TfAdsBannerLicense();
        $modelAdsBannerImage = new TfAdsBannerImage();
        $businessTypeId = Request::input('cbBusinessType');
        $website = Request::input('txtWebsite');
        $website = str_replace("http://", "", str_replace("https://", "", $website));

        if (Input::hasFile('imageFile')) {
            $file = Request::file('imageFile');
            $imageName = $file->getClientOriginalName();
            $imageName = "3d-ads-social-virtual-city-virtual-land-online-marketing-" . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
            if ($modelAdsBannerImage->uploadImage($file, $imageName)) {
                $dataAdsBannerLicense = $modelAdsBannerLicense->getInfoOfName($licenseName);
                $licenseId = $dataAdsBannerLicense->licenseId();
                if (!$modelAdsBannerImage->insert($imageName, $website, 1, 1, $hFunction->carbonNow(), $licenseId,$businessTypeId)) {
                    $modelAdsBannerImage->dropImage($imageName);
                    return trans('frontend_user.ads_set_image_add_fail_notify');
                }
            } else {
                return trans('frontend_user.ads_set_image_add_fail_notify');
            }
        } else {
            return trans('frontend_user.ads_set_image_add_fail_notify');
        }
    }

}
