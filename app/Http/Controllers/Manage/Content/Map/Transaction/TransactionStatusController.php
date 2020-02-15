<?php namespace App\Http\Controllers\Manage\Content\Map\Transaction;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;

use DB;
use File;
use Request;

class TransactionStatusController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    # get list
    public function getList()
    {
        $modelStaff = new TfStaff();
        $modelTransactionStatus = new TfTransactionStatus();
        $accessObject = 'tool';
        $dataTransactionStatus = TfTransactionStatus::orderBy('name', 'ASC')->select('*')->paginate(30);
        return view('manage.content.map.transaction-status.list', compact('modelStaff', 'modelTransactionStatus','dataTransactionStatus', 'accessObject'));
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $accessObject = 'tool';
        return view('manage.content.map.transaction-status.add', compact('accessObject'));
    }

    # add new
    public function postAdd(Request $request)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $name = Request::input('txtName');
        // check exist of name
        if ($modelTransactionStatus->existName($name)) {
            Session::put('notifyAddTransactionStatus', "Add fail, Name <b>'$name'</b> exists.");
        } else {
            #insert
            if ($modelTransactionStatus->insert($name)) {
                Session::put('notifyAddTransactionStatus', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddTransactionStatus', 'Add fail, Enter info to try again');
            }
        }
    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($statusId)
    {
        $modelTransaction = new TfTransactionStatus();
        $dataTransactionStatus = $modelTransaction->getInfo($statusId);
        return view('manage.content.map.transaction-status.edit', compact('dataTransactionStatus'));
    }

    # edit
    public function postEdit($statusId)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $name = Request::input('txtName');
        # if exist name <> the type is editing
        if ($modelTransactionStatus->existEditName($name, $statusId)) {
            return "Add fail, Name <b>'$name'</b> exists.";
        }else{
            $modelTransactionStatus->updateInfo($statusId, $name);
        }
    }

    # update status
    public function statusUpdate($statusId)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $currentStatus = $modelTransactionStatus->getInfo($statusId, 'status');
        $newStatus = ($currentStatus == 0) ? 1 : 0;
        return $modelTransactionStatus->updateStatus($statusId, $newStatus);
    }

}
