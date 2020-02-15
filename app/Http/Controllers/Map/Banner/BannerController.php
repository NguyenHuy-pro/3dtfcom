<?php namespace App\Http\Controllers\Map\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\Map\Banner\LicenseInvite\TfBannerLicenseInvite;
use App\Models\Manage\Content\Map\Banner\Share\TfBannerShare;
use App\Models\Manage\Content\Map\Banner\ShareNotify\TfBannerShareNotify;
use App\Models\Manage\Content\Map\Banner\ShareView\TfBannerShareView;
use App\Models\Manage\Content\Map\Banner\Visit\TfBannerVisit;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\Users\ExchangeBanner\TfUserExchangeBanner;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use App\Models\Manage\Content\Users\TfUser;
use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Map\Banner\TfBanner;
use App\Models\Manage\Content\Map\Banner\License\TfBannerLicense;

#use Illuminate\Http\Request;
use Request;
use Input;


class BannerController extends Controller
{
    public function accessBanner($bannerId = null, $shareCode = null)
    {
        $hFunction = new \Hfunction();
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelBusinessType = new TfBusinessType();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();
        $modelBanner = new TfBanner();
        $modelBannerVisit = new TfBannerVisit();
        $modelBannerShare = new TfBannerShare();
        $modelBannerShareView = new TfBannerShareView();

        $existStatus = false;
        # check existing banner
        if (!empty($bannerId)) $existStatus = $modelBanner->existBanner($bannerId);

        #existing banner
        if ($existStatus) {
            # insert visit
            $accessIP = $hFunction->getClientIP();
            $userId = $modelUser->loginUserId();
            if (!$modelBannerVisit->checkUserVisited($bannerId, $accessIP, $userId)) {
                $modelBannerVisit->insert($accessIP, $bannerId, $userId);
            }

            #visitor access banner from share link
            if (!empty($shareCode)) {
                $dataBannerShare = $modelBannerShare->getInfoByShareCode($shareCode);
                if (!empty($dataBannerShare)) {
                    $shareId = $dataBannerShare->shareId();
                    if (!$modelBannerShareView->existViewOfShareId($shareId)) {
                        $modelBannerShareView->insert($accessIP, $shareId);
                    }
                }
            }
            # set access project info
            #refresh info
            $dataBanner = $modelBanner->getInfo($bannerId);
            $dataProject = $dataBanner->project;
            $dataMapAccess = [
                'provinceAccess' => $dataProject->provinceId(),
                'areaAccess' => $dataProject->areaId(),
                'landAccess' => null,
                'bannerAccess' => $dataBanner,
                'businessTypeAccess' => $modelBusinessType->getAccess(),
                'projectOwnStatus' => 0, // undeveloped project sale,
                'settingStatus' => 0, // undeveloped project sale (not setup)
                'projectRankId' => $dataProject->getRankId()
            ];

            # set load area into history
            $modelArea->setMainHistoryArea($dataProject->areaId());
            return view('map.map', compact('modelAbout', 'modelUser', 'modelProvince', 'modelArea', 'dataMapAccess'));

        } else {
            return redirect()->back();
        }

    }

    //visit
    public function visitBanner($bannerId = null)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelBannerVisit = new TfBannerVisit();
        if (!empty($bannerId)) {
            $accessIP = $hFunction->getClientIP();
            $userId = $modelUser->loginUserId();
            if (!$modelBannerVisit->checkUserVisited($bannerId, $accessIP, $userId)) {
                $modelBannerVisit->insert($accessIP, $bannerId, $userId);
            }
        }
    }

    //get information
    public function m_getInformation($bannerId = null)
    {
        $modelUser = new TfUser();
        $modelBanner = new TfBanner();
        if (!empty($bannerId)) {
            $dataBanner = $modelBanner->getInfo($bannerId);
            return view('map.banner.information.m-information', compact('modelUser', 'dataBanner'));
        }
    }

    #=========== ========= ========== TRANSACTION ============ ========= =========
    #--------- ----------- SALE ---------- ----------
    //select buy banner
    public function getBuy($bannerId)
    {
        $modelUser = new TfUser();
        $modelBanner = new TfBanner();
        $dataBanner = $modelBanner->getInfo($bannerId);
        return view('map.banner.transaction.buy-select', compact('modelUser', 'dataBanner'));
    }

    public function postBuy($bannerId)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelUserCard = new TfUserCard();
        $modelBusinessType = new TfBusinessType();
        $modelBanner = new TfBanner();

        $dataBanner = $modelBanner->getInfo($bannerId);
        #user info
        $dataUserLogin = $modelUser->loginUserInfo();
        $loginUserId = $dataUserLogin->userId();
        $userPoint = $modelUser->point($loginUserId);

        #exist license
        if (!$dataBanner->existLicense()) {
            $projectRankId = $dataBanner->project->getRankId();

            # transaction info
            $transactionStatusId = $dataBanner->transactionStatusId();
            $sizeId = $dataBanner->bannerSample->sizeId();

            $dataRuleBanner = $dataBanner->ruleOfSizeAndRank($sizeId, $projectRankId);
            $paymentPoint = $dataRuleBanner->salePrice();
            $saleMonth = $dataRuleBanner->saleMonth();

            //the user enough point to payment
            if ($userPoint >= $paymentPoint) {
                $cardId = $dataUserLogin->cardId();

                if ($modelUserCard->decreasePoint($cardId, $paymentPoint, 'buy banner')) {
                    //add license for banner
                    $modelBannerLicense = new TfBannerLicense();

                    //use datetime
                    $dateBegin = $hFunction->carbonNow();
                    $dateEnd = $hFunction->carbonNowAddMonths($saleMonth);

                    if ($modelBannerLicense->insert($dateBegin, $dateEnd, $bannerId, $loginUserId, $transactionStatusId)) {
                        $newLicenseId = $modelBannerLicense->insertGetId();
                        //insert table banner exchange
                        $modelUserExchangeBanner = new TfUserExchangeBanner();
                        $modelUserExchangeBanner->insert($paymentPoint, $cardId, $newLicenseId);

                        $modelUserStatistic = new TfUserStatistic();
                        if ($modelUserStatistic->existUser($loginUserId)) {
                            $modelUserStatistic->plusBanner($loginUserId);
                        } else {
                            $modelUserStatistic->insert($loginUserId, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0);
                        }
                    }
                }
            }

            # set access project info
            #refresh info
            $dataBanner = $modelBanner->getInfo($bannerId);
            $dataProject = $dataBanner->project;
            $dataMapAccess = [
                'provinceAccess' => $dataProject->provinceId(),
                'areaAccess' => $dataProject->areaId(),
                'landAccess' => null,
                'bannerAccess' => $dataBanner,
                'businessTypeAccess' => $modelBusinessType->getAccess(),
                'projectOwnStatus' => 0, // undeveloped project sale,
                'settingStatus' => 0, // undeveloped project sale (not setup)
                'projectRankId' => $dataProject->getRankId()
            ];

            $dataBannerSample = $dataBanner->bannerSample;
            return view('map.banner.image.banner-image-wrap', compact('modelUser', 'dataBanner', 'dataMapAccess', 'dataBannerSample'));
        }
    }

    #--------- ---------- FREE ---------- ----------
    # select free banner
    public function getFree($bannerId)
    {
        $modelUser = new TfUser();
        $modelBanner = new TfBanner();
        $dataBanner = $modelBanner->getInfo($bannerId);
        return view('map.banner.transaction.free-select', compact('modelUser', 'dataBanner'));
    }

    public function postFree($bannerId)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelBusinessType = new TfBusinessType();
        $modelBanner = new TfBanner();
        #user info
        $dataUserLogin = $modelUser->loginUserInfo();
        $loginUserId = $dataUserLogin->userId();
        $cardId = $dataUserLogin->cardId();

        $dataBanner = $modelBanner->getInfo($bannerId);

        #exist license
        if (!$dataBanner->existLicense()) {
            $projectRankId = $dataBanner->project->getRankId();

            # transaction info
            $transactionStatusId = $dataBanner->transactionStatusId();
            $sizeId = $dataBanner->bannerSample->sizeId();
            $dataRuleBanner = $dataBanner->ruleOfSizeAndRank($sizeId, $projectRankId);
            $freeMonth = $dataRuleBanner->freeMonth;

            # add license for banner
            $modelBannerLicense = new TfBannerLicense();
            $dateBegin = $hFunction->carbonNow();
            $dateEnd = $hFunction->carbonNowAddMonths($freeMonth);
            if ($modelBannerLicense->insert($dateBegin, $dateEnd, $bannerId, $loginUserId, $transactionStatusId)) {
                $newLicenseId = $modelBannerLicense->insertGetId();
                # insert table banner exchange
                $modelUserExchangeBanner = new TfUserExchangeBanner();
                $modelUserExchangeBanner->insert(0, $cardId, $newLicenseId);

                $modelUserStatistic = new TfUserStatistic();
                if ($modelUserStatistic->existUser($loginUserId)) {
                    $modelUserStatistic->plusBanner($loginUserId);
                } else {
                    $modelUserStatistic->insert($loginUserId, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0);
                }
            }

            # set access project info
            #refresh info
            $dataBanner = $modelBanner->getInfo($bannerId);
            $dataProject = $dataBanner->project;
            $dataMapAccess = [
                'provinceAccess' => $dataProject->provinceId(),
                'areaAccess' => $dataProject->areaId(),
                'landAccess' => null,
                'bannerAccess' => $dataBanner,
                'businessTypeAccess' => $modelBusinessType->getAccess(),
                'projectOwnStatus' => 0, // undeveloped project sale,
                'settingStatus' => 0, // undeveloped project sale (not setup)
                'projectRankId' => $dataProject->getRankId()
            ];
            $dataBannerSample = $dataBanner->bannerSample;
            return view('map.banner.image.banner-image-wrap', compact('modelUser', 'dataBanner', 'dataMapAccess', 'dataBannerSample'));
        }

    }
}