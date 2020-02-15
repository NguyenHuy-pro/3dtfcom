<?php namespace App\Http\Controllers\Manage\Content\System\PaymentType;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\PaymentType\TfPaymentType;
use DB;
use File;
use Request;

class PaymentTypeController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelPaymentType = new TfPaymentType();
        $accessObject = 'exchange';
        $dataPaymentType = TfPaymentType::orderBy('name', 'ASC')->select('*')->paginate(30);
        return view('manage.content.system.payment-type.list', compact('modelStaff', 'modelPaymentType', 'dataPaymentType', 'accessObject'));
    }

    #view
    public function viewPaymentType($typeId)
    {
        if (!empty($typeId)) {
            $dataPaymentType = TfPaymentType::find($typeId);
            return view('manage.content.system.payment-type.view', compact('dataPaymentType'));
        }
    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        $accessObject = 'exchange';
        return view('manage.content.system.payment-type.add', compact('accessObject'));
    }

    # add
    public function postAdd()
    {
        $modelPaymentType = new TfPaymentType();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');

        // check exist of name
        if ($modelPaymentType->existName($name)) {
            Session::put('notifyAddPaymentType', "Add fail, Name '$name' exists.");
        } else {
            if ($modelPaymentType->insert($name, $description)) {
                Session::put('notifyAddPaymentType', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddPaymentType', 'Add fail, Enter info to try again');
            }
        }
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($paymentTypeId = null)
    {
        $dataPaymentType = TfPaymentType::find($paymentTypeId);
        if (count($dataPaymentType) > 0) {
            return view('manage.content.system.payment-type.edit', compact('dataPaymentType'));
        }
    }

    # edit
    public function postEdit($paymentTypeId)
    {
        $modelPaymentType = new TfPaymentType();
        $name = Request::input('txtName');
        $description = Request::input('txtDescription');

        // if exist name <> the type is editing
        if (($modelPaymentType->existEditName($paymentTypeId, $name))) {
            return "Add fail, Name '$name' exists.";
        } else {
            $modelPaymentType->updateInfo($paymentTypeId, $name, $description);
        }
    }

    # update status
    public function statusUpdate($typeId)
    {
        $modelType = new TfPaymentType();
        if (!empty($typeId)) {
            $currentStatus = $modelType->status($typeId);
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelType->updateStatus($typeId, $newStatus);
        }
    }

    # delete
    public function deletePaymentType($paymentTypeId = null)
    {
        if (!empty($paymentTypeId)) {
            $modelPaymentType = new TfPaymentType();
            $modelPaymentType->actionDelete($paymentTypeId);
        }
    }

}
