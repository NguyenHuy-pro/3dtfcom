<?php namespace App\Http\Controllers\Manage\Content\System\Payment;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Bank\TfBank;
use App\Models\Manage\Content\System\PaymentType\TfPaymentType;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\Payment\TfPayment;
//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class PaymentController extends Controller
{

    #========== ========== ========== ADD NEW ========== ========== ==========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelPayment = new TfPayment();
        $accessObject = 'exchange';
        $dataPayment = TfPayment::where('action', 1)->orderBy('payment_id', 'ASC')->select('*')->paginate(30);
        return view('manage.content.system.payment.list', compact('modelStaff', 'modelPayment', 'dataPayment', 'accessObject'));
    }

    #view
    public function viewPayment($paymentId)
    {
        $dataPayment = TfPayment::find($paymentId);
        if (count($dataPayment)) {
            return view('manage.content.system.payment.view', compact('dataPayment'));
        }
    }
    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        $modelPaymentType = new TfPaymentType();
        $modelBank = new TfBank();
        $accessObject = 'exchange';
        return view('manage.content.system.payment.add', compact('modelPaymentType', 'modelBank', 'accessObject'));
    }

    # add
    public function postAdd()
    {
        $modelPayment = new TfPayment();
        $contactName = Request::input('txtContactName');
        $paymentName = Request::input('txtPaymentName');
        $paymentCode = Request::input('txtPaymentCode');
        $paymentTypeId = Request::input('cbPaymentType');
        $bankId = Request::input('cbBank');

        $contactName = (!empty($contactName)) ? $contactName : null;
        if ($paymentTypeId != 2) { # not bank transfer
            $bankId = null;
        }
        if ($modelPayment->insert($contactName, $paymentName, $paymentCode, $paymentTypeId, $bankId)) {
            Session::put('notifyAddPayment', 'Add success, Enter info to continue');
        } else {
            Session::put('notifyAddPayment', 'Add fail, Enter info to try again');
        }
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($paymentId = null)
    {
        $modelPaymentType = new TfPaymentType();
        $modelBank = new TfBank();
        $dataPayment = TfPayment::find($paymentId);
        if (count($dataPayment) > 0) {
            return view('manage.content.system.payment.edit', compact('modelPaymentType', 'modelBank', 'dataPayment'));
        }
    }

    # edit info
    public function postEdit($paymentId)
    {
        $modelPayment = new TfPayment();
        $contactName = Request::input('txtContactName');
        $paymentName = Request::input('txtPaymentName');
        $paymentCode = Request::input('txtPaymentCode');
        $paymentTypeId = Request::input('cbPaymentType');
        $bankId = Request::input('cbBank');
        $contactName = (!empty($contactName)) ? $contactName : null;
        if ($paymentTypeId != 2) { # not bank transfer
            $bankId = null;
        }
        $modelPayment->updateInfo($paymentId, $contactName, $paymentName, $paymentCode, $paymentTypeId, $bankId);
    }

    # update status
    public function statusUpdate($paymentId)
    {
        $modelPayment = new TfPayment();
        if (!empty($paymentId)) {
            $currentStatus = $modelPayment->getInfo($paymentId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelPayment->updateStatus($paymentId, $newStatus);
        }
    }

    # delete
    public function deletePayment($paymentId = null)
    {
        if (!empty($paymentId)) {
            $modelPayment = new TfPayment();
            $modelPayment->actionDelete($paymentId);
        }
    }

}
