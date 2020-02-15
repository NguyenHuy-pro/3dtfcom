<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 4/26/2017
 * Time: 1:09 PM
 */
namespace App\Http\Controllers\Point\Wallet\NganLuong;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\PointTransaction\TfPointTransaction;
use App\Models\Manage\Content\System\PointType\TfPointType;
use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Users\CardActive\TfUserCardActive;
use App\Models\Manage\Content\Users\NganLuongOrder\TfNganLuongOrder;
use App\Models\Manage\Content\Users\TfUser;
#use Illuminate\Http\Request;
use Request;
use File, Input;

class NganLuongController extends Controller
{
    public function getPaymentDetail()
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelPointType = new TfPointType();
        $modelPointTransaction = new TfPointTransaction();

        if ($modelUser->checkLogin()) {
            $typeId = $modelPointType->normalTypeInfo()->typeId();
            $dataPointTransaction = $modelPointTransaction->infoOfPointType($typeId);

            $point = Input::get('txtPoint');
            $orderCode = Input::get('txtOrderCode');
            $walletId = Input::get('txtWallet');

            $dataPointAccess = [
                'object' => 'online',
                'package' => $point,
                'wallet' => $walletId,
                'orderCode' => $orderCode
            ];
            return view('point.online.wallet.nganluong.payment-detail', compact('modelAbout', 'modelUser', 'dataPointAccess', 'dataPointTransaction'));
        } else {
            return redirect()->route('tf.home');
        }

    }

    public function getPayment($point = null, $walletId = null, $transactionId = null, $cardId = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelNganLuong = new \NL_Checkout();
        $modelNganLuongOrder = new TfNganLuongOrder();
        $modelUserCard = new TfUserCard();
        if (!empty($point) && !empty($walletId) && !empty($transactionId) && !empty($cardId)) {
            if (Input::has('payment_id')) {
                $paymentId = Input::get('payment_id');
                $transactionInfo = Input::get('transaction_info');
                $orderCode = Input::get('order_code');
                $price = Input::get('price');
                $paymentType = Input::get('payment_type');
                $errorText = Input::get('error_text');
                $secureCode = Input::get('secure_code');
                $check = $modelNganLuong->verifyPaymentUrl($transactionInfo, $orderCode, $price, $paymentId, $paymentType, $errorText, $secureCode);
                if ($check) {
                    if (!$modelNganLuongOrder->checkExistOrderCode($orderCode)) {
                        if ($modelNganLuongOrder->insert($orderCode, $point, 'VND', $transactionInfo, $price, $paymentId, $paymentType, $errorText, $secureCode, 1, 1, $cardId, $walletId, $transactionId)) {
                            $modelUserCard->increasePoint($cardId, $point, 'Buy points through the nganluoong.vn');
                            $dataPointAccess = [
                                'object' => 'online',
                                'notify' => 'Your transaction has been completed.'
                            ];
                        } else {
                            $dataPointAccess = [
                                'object' => 'online',
                                'notify' => 'Your transaction fail'
                            ];
                        }

                    } else {
                        $dataPointAccess = [
                            'object' => 'online',
                            'notify' => 'Your transaction has been completed.'
                        ];
                    }
                } else {
                    $dataPointAccess = [
                        'object' => 'online',
                        'notify' => 'Your transaction fail'
                    ];
                }

            } else {
                $dataPointAccess = [
                    'object' => 'online',
                    'notify' => 'Your transaction fail'
                ];

            }
        } else {
            $dataPointAccess = [
                'object' => 'online',
                'notify' => 'Your transaction fail'
            ];
        }
        return view('point.online.wallet.nganluong.notify', compact('modelAbout', 'modelUser', 'dataPointAccess'));
    }

    public function getPaymentCancel()
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataPointAccess = [
            'object' => 'online',
            'notify' => 'Your cancel transaction on nganluong.vn'
        ];
        return view('point.online.wallet.nganluong.notify', compact('modelAbout', 'modelUser', 'dataPointAccess'));
    }
}