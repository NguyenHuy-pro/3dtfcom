<?php namespace App\Http\Controllers\Manage\Content\System\PointTransaction;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\PointType\TfPointType;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\PointTransaction\TfPointTransaction;
//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class PointTransactionController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    # get list
    public function index()
    {
        $accessObject = 'point';
        $dataPointTransaction = TfPointTransaction::where('action', 1)->orderBy('dateApply', 'DESC')->select('*')->paginate(30);
        return view('manage.content.system.point-transaction.list', compact('dataPointTransaction', 'accessObject'));
    }

    #view
    public function viewPointTransaction($transactionId)
    {
        $dataPointTransaction = TfPointTransaction::find($transactionId);
        if (count($dataPointTransaction)) {
            return view('manage.content.system.point-transaction.view', compact('dataPointTransaction'));
        }
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $modelPointType = new TfPointType();
        $accessObject = 'point';
        return view('manage.content.system.point-transaction.add', compact('modelPointType', 'accessObject'));
    }

    # add
    public function postAdd()
    {
        $modelPointTransaction = new TfPointTransaction();
        $pointValue = Request::input('txtPointValue');
        $usdValue = Request::input('txtUsdValue');
        $pointTypeId = Request::input('cbPointType');

        if ($modelPointTransaction->insert($pointValue, $usdValue, date('Y-m-d H:i:s'), $pointTypeId)) {
            $newId = $modelPointTransaction->insertGetId();
            # disable old transaction
            TfPointTransaction::where('transaction_id', '<>', $newId)->where('pointType_id', $pointTypeId)->update(['action' => 0]);
            Session::put('notifyAddPointTransaction', 'Add success, Enter info to continue');
        } else {
            Session::put('notifyAddPointTransaction', 'Add fail, Enter info to try again');
        }
    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($transactionId = '')
    {
        $dataPointTransaction = TfPointTransaction::find($transactionId);
        if (count($dataPointTransaction)) {
            return view('manage.content.system.point-transaction.edit', compact('dataPointTransaction'));
        }

    }

    # edit info
    public function postEdit($transactionId)
    {
        $modelPointTransaction = new TfPointTransaction();
        $pointValue = Request::input('txtPointValue');
        $usdValue = Request::input('txtUsdValue');

        $modelPointTransaction->updateInfo($transactionId, $pointValue, $usdValue);
    }

    # delete
    public function deletePointTransaction($transactionId = '')
    {
        if (!empty($transactionId)) {
            $modelPointTransaction = new TfPointTransaction();
            $modelPointTransaction->actionDelete($transactionId);
        }
    }

}
