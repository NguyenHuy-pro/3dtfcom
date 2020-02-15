<?php namespace App\Http\Controllers\User\Seller;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Share\TfBuildingShare;
use App\Models\Manage\Content\Map\Banner\Share\TfBannerShare;
use App\Models\Manage\Content\Map\Land\Share\TfLandShare;
use App\Models\Manage\Content\Seller\Payment\TfSellerPayment;
use App\Models\Manage\Content\Seller\Price\TfSellerPaymentPrice;
use App\Models\Manage\Content\Seller\TfSeller;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class SellerController extends Controller
{

    #============ ============= Statistic =============== =================
    public function getStatistic()
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelSeller = new TfSeller();
        $modelSellerPaymentPrice = new TfSellerPaymentPrice();
        //$userId -> develop public show
        $dataUser = $modelUser->loginUserInfo();
        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'seller',
                'sellerObject' => 'statistic',
                'dataSellerPaymentPrice' => $modelSellerPaymentPrice->infoIsActive()
            ];
            return view('user.seller.index', compact('modelAbout', 'modelUser', 'modelSeller', 'dataUser', 'dataAccess'));

        } else {
            return redirect()->route('tf.home');
        }
    }

    //detail
    public function getDetailStatistic($object, $fromDate, $toDate)
    {
        $modelUser = new TfUser();
        $modelLandShare = new TfLandShare();
        $modelBannerShare = new TfBannerShare();
        $modelBuildingShare = new TfBuildingShare();
        $userLoginId = $modelUser->loginUserId();
        if ($object == 'land') {
            $dataLandShare = $modelLandShare->infoOfUserByDate($userLoginId, $fromDate, $toDate);
            return view('user.seller.statistic.view-on-land', compact('modelUser', 'dataLandShare'), ['fromDate' => $fromDate, 'toDate' => $toDate]);
        } elseif ($object == 'banner') {
            $dataBannerShare = $modelBannerShare->infoOfUserByDate($userLoginId, $fromDate, $toDate);
            return view('user.seller.statistic.view-on-banner', compact('modelUser', 'dataBannerShare'), ['fromDate' => $fromDate, 'toDate' => $toDate]);
        } elseif ($object == 'building') {
            $dataBuildingShare = $modelBuildingShare->infoOfUserByDate($userLoginId, $fromDate, $toDate);
            return view('user.seller.statistic.view-on-building', compact('modelUser', 'dataBuildingShare'), ['fromDate' => $fromDate, 'toDate' => $toDate]);
        }

    }

    #============ ============= Payment =============== =================
    //payment info
    public function getPayment()
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelSeller = new TfSeller();
        //$userId -> develop public show
        $dataUser = $modelUser->loginUserInfo();
        if (count($dataUser) > 0) {
            if ($dataUser->checkIsSeller()) {
                $dataAccess = [
                    'accessObject' => 'seller',
                    'sellerObject' => 'payment',
                ];
                return view('user.seller.index', compact('modelAbout', 'modelUser', 'modelSeller', 'dataUser', 'dataAccess'));
            } else {
                return redirect()->route('tf.home');
            }

        } else {
            return redirect()->route('tf.home');
        }
    }

    public function getMorePayment($take, $dateTake)
    {

    }

    //payment detail
    public function getDetailPayment($paymentCode)
    {
        $modelUser = new TfUser();
        $modelSellerPayment = new TfSellerPayment();
        $dataSellerPayment = $modelSellerPayment->infoByCode($paymentCode);
        if (count($dataSellerPayment) > 0) {
            return view('user.seller.payment.view', compact('modelUser', 'dataSellerPayment'));
        }
    }

    public function  getDetailPaymentMore($object, $fromDate, $toDate)
    {
        $modelUser = new TfUser();
        $modelLandShare = new TfLandShare();
        $modelBannerShare = new TfBannerShare();
        $modelBuildingShare = new TfBuildingShare();
        $userLoginId = $modelUser->loginUserId();
        $dataLandShare = null;
        $dataBannerShare = null;
        $dataBuildingShare = null;
        if ($object == 'land') {
            $dataLandShare = $modelLandShare->infoOfUserByDate($userLoginId, $fromDate, $toDate);
        } elseif ($object == 'banner') {
            $dataBannerShare = $modelBannerShare->infoOfUserByDate($userLoginId, $fromDate, $toDate);
        } elseif ($object == 'building') {
            $dataBuildingShare = $modelBuildingShare->infoOfUserByDate($userLoginId, $fromDate, $toDate);
        }
        return view('user.seller.payment.view-more', compact('modelUser', 'dataLandShare', 'dataBannerShare', 'dataBuildingShare'), ['object' => $object]);
    }
}
