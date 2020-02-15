<?php namespace App\Http\Controllers\Manage\Content\User\NganLuong;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Users\NganLuongOrder\TfNganLuongOrder;
use Illuminate\Http\Request;

class NganLuongController extends Controller {

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelNganLuongOrder = new TfNganLuongOrder();
        $dataNganLuongOrder = TfNganLuongOrder::orderBy('created_at', 'DESC')->select('*')->paginate(30);
        $accessObject = 'card';
        return view('manage.content.user.nganluong.list', compact('modelStaff', 'modelNganLuongOrder', 'dataNganLuongOrder', 'accessObject'));
    }

    #View
    public function viewOrder($rechargeId)
    {
        $modelNganLuongOrder = new TfNganLuongOrder();
        $dataNganLuongOrder = $modelNganLuongOrder->findInfo($rechargeId);
        if (count($dataNganLuongOrder)) {
            return view('manage.content.user.nganluong.view', compact('dataNganLuongOrder'));
        }
    }

}
