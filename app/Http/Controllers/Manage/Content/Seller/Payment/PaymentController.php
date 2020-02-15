<?php namespace App\Http\Controllers\Manage\Content\Seller\Payment;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Seller\Payment\TfSellerPayment;
use App\Models\Manage\Content\Seller\Payment\TfSellerPaymentDetail;
use App\Models\Manage\Content\Seller\Payment\TfSellerPaymentInfo;
use App\Models\Manage\Content\Seller\TfSeller;
use App\Models\Manage\Content\System\Staff\TfStaff;
use File;
use Input;
use Illuminate\Support\Facades\Session;
use Request;

class PaymentController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelSellerPayment = new TfSellerPayment();
        $dataSellerPayment = TfSellerPayment::where('action', 1)->orderBy('created_at', 'DESC')->select('*')->paginate(30);
        $accessObject = 'report';
        return view('manage.content.seller.payment.list', compact('modelStaff', 'modelSellerPayment', 'dataSellerPayment', 'accessObject'));
    }

    //filter
    public function getFilter($payStatus = null, $code = null)
    {
        $modelStaff = new TfStaff();
        $modelSellerPayment = new TfSellerPayment();
        $modelSeller = new TfSeller();
        $dataSellerPayment = null;
        if ($payStatus == 999 && empty($code)) { # all country
            return redirect()->route('tf.m.c.seller.payment.list');

        } elseif ($payStatus < 999 && !empty($code)) {
            //user input seller code
            $dataSeller = $modelSeller->getInfoByCode($code);
            if (count($dataSeller) > 0) {
                $dataSellerPayment = TfSellerPayment::where(['seller_id' => $dataSeller->sellerId(), 'payStatus' => $payStatus, 'action' => 1])->orderBy('created_at', 'DESC')->select('*')->paginate(30);
            } else {
                //user input payment code
                $dataSellerPayment = TfSellerPayment::where(['paymentCode' => $code, 'payStatus' => $payStatus, 'action' => 1])->orderBy('created_at', 'DESC')->select('*')->paginate(30);
            }
            return view('manage.content.seller.payment.list', compact('modelStaff', 'modelSellerPayment', 'dataSellerPayment', 'accessObject'),
                [
                    'filterPayStatus' => $payStatus,
                    'filterCode' => $code
                ]);

        } else {
            if ($payStatus < 999 && empty($code)) {
                $dataSellerPayment = TfSellerPayment::where(['payStatus' => $payStatus, 'action' => 1])->orderBy('created_at', 'DESC')->select('*')->paginate(30);

            } elseif ($payStatus == 999 && !empty($code)) {
                //user input seller code
                $dataSeller = $modelSeller->getInfoByCode($code);
                if (count($dataSeller) > 0) {
                    $dataSellerPayment = TfSellerPayment::where(['seller_id' => $dataSeller->sellerId(), 'action' => 1])->orderBy('created_at', 'DESC')->select('*')->paginate(30);

                } else {
                    //user input payment code
                    $dataSellerPayment = TfSellerPayment::where(['paymentCode' => $code, 'action' => 1])->orderBy('created_at', 'DESC')->select('*')->paginate(30);
                }
            }
            return view('manage.content.seller.payment.list', compact('modelStaff', 'modelSellerPayment', 'dataSellerPayment', 'accessObject'),
                [
                    'filterPayStatus' => $payStatus,
                    'filterCode' => $code
                ]);
        }
    }

    public function viewDetail($paymentId)
    {
        $modelSellerPayment = new TfSellerPayment();
        if (!empty($paymentId)) {
            $dataSellerPayment = $modelSellerPayment->getInfo($paymentId);
            return view('manage.content.seller.payment.view', compact('dataSellerPayment'));
        }
    }

    public function confirmPay($paymentId = null)
    {
        $modelStaff = new TfStaff();
        $modelSellerPayment = new TfSellerPayment();
        $modelSellerPaymentInfo = new TfSellerPaymentInfo();
        $modelSellerPaymentDetail = new TfSellerPaymentDetail();
        $dataSellerPayment = $modelSellerPayment->getInfo($paymentId);
        $dataSeller = $dataSellerPayment->seller;
        if ($modelSellerPaymentDetail->insert($paymentId, $modelSellerPaymentInfo->infoIdOfSeller($dataSeller->sellerId()), $modelStaff->loginStaffID())) {
            $modelSellerPayment->confirmPayStatus($paymentId);
        }

    }


}
