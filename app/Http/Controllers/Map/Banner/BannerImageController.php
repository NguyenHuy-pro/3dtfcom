<?php namespace App\Http\Controllers\Map\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Models\Manage\Content\Map\Banner\BadInfoReport\TfBannerBadInfoReport;
use App\Models\Manage\Content\Map\Land\License\TfLandLicense;
use App\Models\Manage\Content\System\BadInfo\TfBadInfo;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\Users\Activity\TfUserActivity;
use App\Models\Manage\Content\Users\TfUser;
use App\Models\Manage\Content\Map\Banner\TfBanner;
use App\Models\Manage\Content\Map\Banner\License\TfBannerLicense;
use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use App\Models\Manage\Content\Map\Banner\ImageVisit\TfBannerImageVisit;

use DB;
use File;
use Input;
use Request;

class BannerImageController extends Controller
{

    #=========== ========= ========== ADD NEW INFO ============ ========== ==========
    //get form add
    public function getAddImage($bannerId = null)
    {
        $modelBannerLicense = new TfBannerLicense();
        $dataBannerLicense = $modelBannerLicense->infoOfBanner($bannerId);
        if (count($dataBannerLicense) > 0) {
            return view('map.banner.image.image-add', compact('dataBannerLicense'));
        }

    }

    //add new
    public function postAddImage()
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserActivity = new TfUserActivity();
        $modelBanner = new TfBanner();
        $modelBannerLicense = new TfBannerLicense();
        $modelBusinessType = new TfBusinessType();
        $modelBannerImage = new TfBannerImage();
        $bannerLicenseId = Request::input('txtBannerLicense');
        $website = Request::input('txtWebsite');
        $website = str_replace("http://", "", str_replace("https://", "", $website));

        $dataUserLogin = $modelUser->loginUserInfo();
        $dataBannerLicense = $modelBannerLicense->getInfo($bannerLicenseId);
        $bannerId = $dataBannerLicense->bannerId();
        $dataBannerSample = $dataBannerLicense->banner->bannerSample;
        $border = $dataBannerSample->border();
        $resizeWidth = $dataBannerSample->size->width() - ($border * 2);
        if (Input::hasFile('imageFile')) {
            if (count($dataUserLogin) > 0) {
                $file = Request::file('imageFile');
                $imageName = $file->getClientOriginalName();
                $imageName = "3d-ads-social-virtual-city-virtual-land-online-marketing-map-banner-" . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
                if ($modelBannerImage->uploadImage($file, $imageName, $resizeWidth)) {
                    if ($modelBannerImage->insert($imageName, $website, $bannerLicenseId)) {
                        $newImageId = $modelBannerImage->insertGetId();
                        $modelUserActivity->insert($newImageId, null, null, $dataUserLogin->userId(), null);
                    }
                }
            }
            //set access project info
            //refresh info
            $dataBanner = $modelBanner->getInfo($bannerId);
            $dataProject = $dataBanner->project;
            $dataMapAccess = [
                'provinceAccess' => $dataProject->provinceId(),
                'areaAccess' => $dataProject->areaId(),
                'landAccess' => 0,
                'bannerAccess' => $bannerId,
                'businessTypeAccess' => $modelBusinessType->getAccess(),
                'projectOwnStatus' => 0, // undeveloped project sale,
                'settingStatus' => 0, // undeveloped project sale (not setup)
                'projectRankId' => $dataProject->getRankId()
            ];
            #banner sample
            $dataBannerSample = $dataBanner->bannerSample;
            return view('map.banner.image.banner-image-wrap', compact('modelUser', 'dataBanner', 'dataMapAccess', 'dataBannerSample'));
        }
    }

#=========== ========= ========== REPORT ============ ========== ==========
    public function getReport($bannerImageId = null)
    {
        $modelUser = new TfUser();
        $modelBannerBadInfoReport = new TfBannerBadInfoReport();
        $modelBadInfo = new TfBadInfo();
        $modelBannerImage = new TfBannerImage();

        $userLoginId = $modelUser->loginUserId();
        if (!empty($userLoginId)) {
            if ($modelBannerBadInfoReport->checkUserReported($userLoginId, $bannerImageId)) {
                return view('map.banner.report.notify');
            } else {
                $dataBadInfo = $modelBadInfo->getInfo();
                $dataBannerImage = $modelBannerImage->getInfo($bannerImageId);
                if (count($dataBadInfo) > 0) {
                    return view('map.banner.report.bad-info', compact('dataBannerImage', 'dataBadInfo'));
                }
            }
        }
    }

    public function sendReport()
    {
        $modelUser = new TfUser();
        $modelBannerBadInfoReport = new TfBannerBadInfoReport();
        $imageId = Request::input('bannerImage');
        $badInfoId = Request::input('badInfo');
        $userId = $modelUser->loginUserId();
        if(!empty($userId)){
            $modelBannerBadInfoReport->insert($imageId, $userId, $badInfoId);
        }
    }

#=========== ========= ========== EDIT INFO ============ ========== ==========
# get form edit
    public function getEditImage($imageId = null)
    {
        $modelBannerImage = new TfBannerImage();
        #image info of banner
        $dataBannerImage = $modelBannerImage->getInfo($imageId);
        return view('map.banner.image.image-edit', compact('dataBannerImage'));
    }

# edit info
    public function postEditImage()
    {
        $hFunction = new \Hfunction();
        $modelBanner = new TfBanner();
        $modelBannerImage = new TfBannerImage();
        $modelBannerImageVisit = new TfBannerImageVisit();
        $bannerImageId = Request::input('txtBannerImage');
        $website = Request::input('txtWebsite');
        $file = Request::file('imageFile');

        $website = str_replace("http://", "", str_replace("https://", "", $website));

        $dataBannerImage = $modelBannerImage->getInfo($bannerImageId);
        $oldWebsite = $dataBannerImage->website();

        #update website
        if ($oldWebsite != $website) {
            $dataBannerImage->website = $website;
            $modelBannerImageVisit->deleteVisitWebsiteByImage($bannerImageId);
        }

        #get size
        $bannerId = $dataBannerImage->bannerId();
        $dataBanner = $modelBanner->getInfo($bannerId);
        $dataBannerSample = $dataBanner->bannerSample;
        $border = $dataBannerSample->border();
        $resizeWidth = $dataBannerSample->size->width() - ($border * 2);
        if (!empty($file)) {
            $imageName = $file->getClientOriginalName();
            $imageName = "3d-ads-social-virtual-city-virtual-land-online-marketing-map-banner-" . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
            $oldImage = $dataBannerImage->image;
            if ($modelBannerImage->uploadImage($file, $imageName, $resizeWidth)) {
                $modelBannerImage->dropImage($oldImage);
                $dataBannerImage->image = $imageName;
                $modelBannerImageVisit->deleteVisitImageByImage($bannerImageId);
            }

        }
        $dataBannerImage->save();
        return view('map.banner.image.banner-image', compact('dataBannerImage'));
    }

#=========== ========= ========== GENERAL ============ ========== ==========
#detail image
    public function detailImage($imageId = null)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelBannerImage = new TfBannerImage();
        $modelBannerImageVisit = new TfBannerImageVisit();

        $accessIP = $hFunction->getClientIP();
        $visitUserId = $modelUser->loginUserId();
        if (!$modelBannerImageVisit->checkUserViewImage($imageId, $accessIP, $visitUserId)) {
            $modelBannerImageVisit->insert($accessIP, $imageId, $visitUserId, null);
        }
        $dataBannerImage = $modelBannerImage->getInfo($imageId);
        return view('map.banner.image.image-view', compact('modelUser', 'dataBannerImage'));
    }

# visit image of banner (when user click on image)
    public function visitWebsite($imageId = null)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelBannerImage = new TfBannerImage();
        $modelBannerLicense = new TfBannerLicense();
        $modelBannerImageVisit = new TfBannerImageVisit();
        $dataBannerImage = $modelBannerImage->getInfo($imageId);
        $accessIP = $hFunction->getClientIP();
        //when user was logged
        $visitStatus = true;
        # enable visit

        if ($modelUser->checkLogin()) {
            $visitUserId = $modelUser->loginUserId();
            $bannerId = $dataBannerImage->bannerId();
            //banner of user login
            if ($modelBannerLicense->existBannerOfUser($visitUserId, $bannerId)) {
                $visitStatus = false;   # disable visit
            }
        } else {
            $visitUserId = null;
        }

        if ($visitStatus) {
            if (!$modelBannerImageVisit->checkUserViewWebsite($imageId, $accessIP, $visitUserId)) {
                $modelBannerImageVisit->insert($accessIP, $imageId, $visitUserId, 1);
            }
        }
    }

#delete
    public function deleteImage($imageId)
    {
        $modelUser = new TfUser();
        $modelBanner = new TfBanner();
        $modelBannerImage = new TfBannerImage();
        $modelBusinessType = new TfBusinessType();

        $dataBannerImage = $modelBannerImage->getInfo($imageId);

        $bannerId = $dataBannerImage->bannerLicense->bannerId();

        //delete
        $dataBannerImage->actionDelete();

        //set access project info
        //refresh info
        $dataBanner = $modelBanner->getInfo($bannerId);
        $dataProject = $dataBanner->project;
        $dataMapAccess = [
            'provinceAccess' => $dataProject->provinceId(),
            'areaAccess' => $dataProject->areaId(),
            'landAccess' => 0,
            'bannerAccess' => $bannerId,
            'businessTypeAccess' => $modelBusinessType->getAccess(),
            'projectOwnStatus' => 0, // undeveloped project sale,
            'settingStatus' => 0, // undeveloped project sale (not setup)
            'projectRankId' => $dataProject->getRankId()
        ];
        //banner sample
        $dataBannerSample = $dataBanner->bannerSample;

        return view('map.banner.image.banner-image-wrap', compact('modelUser', 'dataBanner', 'dataMapAccess', 'dataBannerSample'));
    }
}
