<?php namespace App\Http\Controllers\Manage\Content\User\Recharge;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\System\Payment\TfPayment;
use App\Models\Manage\Content\System\PaymentType\TfPaymentType;
use App\Models\Manage\Content\System\PointTransaction\TfPointTransaction;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Users\Recharge\TfRecharge;
#use Illuminate\Http\Request;

use Request;
use Input;

class RechargeController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelRecharge = new TfRecharge();
        $dataRecharge = TfRecharge::orderBy('created_at', 'DESC')->select('*')->paginate(30);
        $accessObject = 'card';
        return view('manage.content.user.recharge.list', compact('modelStaff', 'modelRecharge', 'dataRecharge', 'accessObject'));
    }

    #View
    public function viewRecharge($rechargeId)
    {
        $dataRecharge = TfRecharge::find($rechargeId);
        if (count($dataRecharge)) {
            return view('manage.content.user.recharge.view', compact('dataRecharge'));
        }
    }

    #---------- Add -----------
    public function getAddRecharge()
    {
        $modelPointTransaction = new TfPointTransaction();
        $modelPaymentType = new TfPaymentType();
        $modelPayment = new TfPayment();
        $directTypeId = $modelPaymentType->directTypeId();
        $dataPayment = $modelPayment->infoOfPaymentType($directTypeId);
        $dataPointTransaction = $modelPointTransaction->infoOfPointType(1);
        $accessObject = 'card';
        return view('manage.content.user.recharge.add', compact('accessObject', 'dataPointTransaction', 'dataPayment'));
    }

    public function postAddRecharge()
    {
        $modelStaff = new TfStaff();
        $modelUser = new TfUser();
        $modelUserCard = new TfUserCard();
        $modelRecharge = new TfRecharge();
        $modelPaymentType = new TfPaymentType();
        $modelPayment = new TfPayment();
        $modelPointTransaction = new TfPointTransaction();
        $code = Request::input('txtRechargeCode');
        $accountConfirm = Request::input('txtAccount');
        $money = Request::input('txtPayment');
        $transactionId = Request::input('txtPointTransaction');
        $paymentId = Request::input('txtPlace');
        $dataUser = $modelUser->getInfoOfAccount($accountConfirm);
        $dataCard = null;
        if (count($dataUser) > 0) {
            $dataCard = $modelUser->cardInfo($dataUser->userId());
        } else {
            $dataCard = $modelUserCard->getInfoOfName($accountConfirm);
        }
        if (count($dataCard) > 0) {
            if (!$modelRecharge->existRechargeCode($code)) {
                $cardId = $dataCard->card_id;
                $dataPointTransaction = $modelPointTransaction->find($transactionId);
                $point = $money * ($dataPointTransaction->pointValue() / $dataPointTransaction->usdValue());
                if ($modelRecharge->insert($code, $point, $money, 1, 0, $cardId, $paymentId, $transactionId, $modelStaff->loginStaffID())) {
                    $modelUserCard->increasePoint($cardId, $point, 'direct recharge');
                    Session::put('notifyAddRecharge', 'Recharge successful, Enter info to again');
                } else {
                    Session::put('notifyAddRecharge', 'Fail recharge, Enter info to again');
                }
            }


        } else {
            Session::put('notifyAddRecharge', 'Wrong account or Name card');
        }
        $accessObject = 'card';
        $directTypeId = $modelPaymentType->directTypeId();
        $dataPayment = $modelPayment->infoOfPaymentType($directTypeId);
        $dataPointTransaction = $modelPointTransaction->infoOfPointType(1);
        return view('manage.content.user.recharge.add', compact('accessObject', 'dataPointTransaction', 'dataPayment'));
    }
}
