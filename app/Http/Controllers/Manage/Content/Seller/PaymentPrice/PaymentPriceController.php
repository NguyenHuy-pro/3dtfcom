<?php namespace App\Http\Controllers\Manage\Content\Seller\PaymentPrice;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Seller\Price\TfSellerPaymentPrice;
use App\Models\Manage\Content\System\Staff\TfStaff;
//use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Session;
use Request;

class PaymentPriceController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelSellerPaymentPrice = new TfSellerPaymentPrice();
        $dataSellerPaymentPrice = TfSellerPaymentPrice::where('action', 1)->orderBy('price_id', 'ASC')->select('*')->paginate(30);
        $accessObject = 'tool';
        return view('manage.content.seller.payment-price.list', compact('modelStaff', 'modelSellerPaymentPrice', 'dataSellerPaymentPrice', 'accessObject'));
    }

    public function viewDetail($priceId = null)
    {
        $modelSellerPaymentPrice = new TfSellerPaymentPrice();
        if (!empty($priceId)) {
            $dataSellerPaymentPrice = $modelSellerPaymentPrice->getInfo($priceId);
            return view('manage.content.seller.payment-price.view', compact('dataSellerPaymentPrice'));
        }
    }

    public function getAdd()
    {
        $accessObject = 'tool';
        return view('manage.content.seller.payment-price.add', compact('accessObject'));
    }

    public function postAdd()
    {
        $modelSellerPaymentPrice = new TfSellerPaymentPrice();
        $price = Request::input('txtPrice');
        $shareNumber = Request::input('txtShare');
        $accessNumber = Request::input('txtAccess');
        $registerNumber = Request::input('txtRegister');
        $paymentLimit = Request::input('cbPaymentLimit');

        // check exist of name
        if ($modelSellerPaymentPrice->existPriceInfo($price, $accessNumber, $registerNumber)) {
            Session::put('notifyPaymentPrice', "Add fail, This price info existed.");
        } else {
            if ($modelSellerPaymentPrice->insert($price, $shareNumber, $accessNumber, $registerNumber, $paymentLimit)) {
                Session::put('notifyPaymentPrice', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyPaymentPrice', 'Add fail, Enter info to try again');
            }
        }

    }

}
