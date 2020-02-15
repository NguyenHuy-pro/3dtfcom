<?php namespace App\Http\Controllers\Seller;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Seller\Guide\TfSellerGuide;
use App\Models\Manage\Content\Seller\Payment\TfSellerPaymentInfo;
use App\Models\Manage\Content\Seller\TfSeller;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\Bank\TfBank;
use App\Models\Manage\Content\Users\TfUser;
#use Illuminate\Http\Request;
use Request;
use File, Input;

class SellerController extends Controller
{
    public function getGuide($object = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelSellerGuide = new TfSellerGuide();
        $object = (empty($object)) ? 'banner' : $object;
        $dataSellerAccess = [
            'object' => 'guide',
            'guideObject' => $object,
        ];
        return view('seller.guide.index', compact('modelAbout', 'modelUser', 'modelSellerGuide', 'dataSellerAccess'));
    }

    #========== ========== Sign up ========== ==========
    public function getSignUp()
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelBank = new TfBank();
        $dataSellerAccess = [
            'object' => 'signUp'
        ];
        return view('seller.sign-up.index', compact('modelAbout', 'modelUser', 'modelBank', 'dataSellerAccess'));

    }

    public function postSignUp()
    {
        $modelUser = new TfUser();
        $modelSeller = new TfSeller();
        $modelSellerPaymentInfo = new TfSellerPaymentInfo();
        $bankId = Request::input('cbBank');
        $txtName = Request::input('txtName');
        $txtPaymentCode = Request::input('txtPaymentCode');
        $txtPassword = Request::input('txtConfirm');
        $dataUserLogin = $modelUser->loginUserInfo();
        if (count($dataUserLogin) > 0) {
            if ($modelUser->checkLoginPassword($txtPassword)) {
                if (!$dataUserLogin->checkIsSeller()) {
                    if ($modelSeller->insert(0, 0, 0, 0, 0, 0, 0, 0, 0, $dataUserLogin->userId())) {
                        $newSellerId = $modelSeller->insertGetId();
                        $modelSellerPaymentInfo->insert($txtName, $txtPaymentCode, $newSellerId, $bankId);
                    }
                }
            } else {
                return trans('frontend_seller.sign_up_wrong_password_notice');
            }
        }

    }

    #========== ========== Payment ========== ==========
    public function getPayment()
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelSellerGuide = new TfSellerGuide();
        $dataSellerAccess = [
            'object' => 'payment'
        ];
        return view('seller.payment.index', compact('modelAbout', 'modelUser', 'modelSellerGuide', 'dataSellerAccess'));

    }

}
