<?php namespace App\Http\Controllers\Ads;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Ads\Banner\Exchange\TfAdsBannerExchange;
use App\Models\Manage\Content\Ads\Banner\Image\TfAdsBannerImage;
use App\Models\Manage\Content\Ads\Banner\ImagePrevent\TfAdsBannerImagePrevent;
use App\Models\Manage\Content\Ads\Banner\ImageReport\TfAdsBannerImageReport;
use App\Models\Manage\Content\Ads\Banner\ImageVisit\TfAdsBannerImageVisit;
use App\Models\Manage\Content\Ads\Banner\License\TfAdsBannerLicense;
use App\Models\Manage\Content\Ads\Banner\TfAdsBanner;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\BadInfo\TfBadInfo;
use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Users\TfUser;
//use Illuminate\Http\Request;
use Request;
use File, Input;

class AdsController extends Controller
{

    public function getList()
    {
        $modelUser = new TfUser();
        $modelAbout = new TfAbout();
        $modelAdsBanner = new TfAdsBanner();
        $dataAdsAccess = [
            'object' => 'direct'
        ];
        return view('ads.banner.banner', compact('modelAbout', 'modelUser', 'modelAdsBanner', 'dataAdsAccess'));
    }

    public function viewBanner($bannerId = null)
    {
        $modelAdsBanner = new TfAdsBanner();
        $dataAdsBanner = $modelAdsBanner->getInfo($bannerId);
        return view('ads.banner.view-place', compact('modelAdsBanner', 'dataAdsBanner'));
    }

    public function detailOrder($bannerName = null)
    {
        $modelUser = new TfUser();
        $modelAbout = new TfAbout();
        $modelAdsBanner = new TfAdsBanner();
        $dataAdsBanner = $modelAdsBanner->getInfoByName($bannerName);
        $dataAdsAccess = [
            'object' => 'direct'
        ];
        if (count($dataAdsBanner) > 0) {
            return view('ads.banner.order.order', compact('modelAbout', 'modelAdsBanner', 'modelUser', 'dataAdsBanner', 'dataAdsAccess'));
        } else {
            return view('ads.banner.banner', compact('modelAbout', 'modelAdsBanner', 'modelUser', 'dataAdsAccess'));
        }

    }

    public function payOrder($name = null)
    {
        $modelUser = new TfUser();
        $modelUserCard = new TfUserCard();
        $modelAdsBanner = new TfAdsBanner();
        $modelAdsBannerLicense = new TfAdsBannerLicense();
        $modelAdsBannerExchange = new TfAdsBannerExchange();
        $show = Request::input('cbShow');
        $dataUserLogin = $modelUser->loginUserInfo();
        //check login
        if (count($dataUserLogin) > 0) {
            $dataAdsBanner = $modelAdsBanner->getInfoByName($name);
            //check exist
            if (count($dataAdsBanner) > 0) {
                $bannerId = $dataAdsBanner->bannerId();
                $priceShow = $dataAdsBanner->displayAvailable();
                $totalPay = $show / $priceShow;
                //user info
                $userId = $dataUserLogin->userId();
                //card info
                $dataUserCard = $dataUserLogin->userCard;
                $cardId = $dataUserCard->cardId();
                $userPoint = $dataUserCard->pointValue();

                //check point
                if ($userPoint < $totalPay) {
                    return view('ads.banner.order.notify-point');
                } else {
                    //card activity
                    if ($modelUserCard->decreasePoint($cardId, $totalPay, 'Set ads')) {
                        //insert license
                        if ($modelAdsBannerLicense->insert($show, $bannerId, $userId)) {
                            $newLicenseId = $modelAdsBannerLicense->insertGetId();
                            $modelAdsBannerExchange->insert($totalPay, $cardId, $newLicenseId);

                            $dataAdsBannerLicense = $modelAdsBannerLicense->getInfo($newLicenseId);
                            return view('ads.banner.order.notify-successful', compact('modelUser', 'dataAdsBannerLicense'));
                        } else {
                            $modelUserCard->increasePoint($cardId, $totalPay, 'Set ads failed.');
                            return view('ads.banner.order.notify-error');
                        }
                    } else {
                        return view('ads.banner.order.notify-error');
                    }

                }

            } else {
                return view('ads.banner.order.notify-error');
            }

        } else {
            return view('ads.banner.order.notify-login');
        }

    }

    //report
    public function getReport($imageName = null)
    {
        $modelAdsBannerImage = new TfAdsBannerImage();
        $modelBadInfo = new TfBadInfo();

        if (!empty($imageName)) {
            $dataAdsBannerImage = $modelAdsBannerImage->getInfoOfName($imageName);
            $dataBadInfo = $modelBadInfo->getInfo();
            if (count($dataAdsBannerImage) > 0) {
                return view('ads.report.image-report', compact('dataAdsBannerImage', 'dataBadInfo'));
            }
        }
    }

    public function sendReport()
    {
        $modelUser = new TfUser();
        $modelReport = new TfAdsBannerImageReport();
        $imageId = Request::input('image');
        $badInfoId = Request::input('badInfo');
        $userId = $modelUser->loginUserId();
        if (!$modelReport->existReportOfUserAndImage($userId, $imageId)) {
            $modelReport->insert($imageId, $userId, $badInfoId);
        }
        return view('ads.report.notify');
    }

    //visit image
    public function visitImage($imageId)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $accessIP = $hFunction->getClientIP();
        $userId = $modelUser->loginUserId();
        $modelAdsBannerImageVisit = new TfAdsBannerImageVisit();
        $modelAdsBannerImageVisit->insert($imageId, $accessIP, $userId);
    }

    //prevent image
    public function preventImage($imageId)
    {
        $modelUser = new TfUser();
        $modelAdsBannerImagePrevent = new TfAdsBannerImagePrevent();
        $userId = $modelUser->loginUserId();
        if (!$modelAdsBannerImagePrevent->existPreventOfUserAndImage($userId, $imageId)) {
            $modelAdsBannerImagePrevent->insert($userId, $imageId);
        }
    }

}
