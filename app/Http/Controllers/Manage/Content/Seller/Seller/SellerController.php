<?php namespace App\Http\Controllers\Manage\Content\Seller\Seller;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Seller\TfSeller;
use App\Models\Manage\Content\System\Staff\TfStaff;
use File;
use Input;
use Illuminate\Support\Facades\Session;
use Request;

class SellerController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelSeller = new TfSeller();
        $dataSeller = TfSeller::where('action', 1)->orderBy('created_at', 'DESC')->select('*')->paginate(30);
        $accessObject = 'report';
        return view('manage.content.seller.seller.list', compact('modelStaff', 'modelSeller', 'dataSeller', 'accessObject'));
    }

    public function viewDetail($sellerId = null)
    {
        $modelSeller = new TfSeller();
        if (!empty($sellerId)) {
            $dataSeller = $modelSeller->getInfo($sellerId);
            return view('manage.content.seller.seller.view', compact('dataSeller'));
        }
    }

    public function confirmPay($sellerId = null)
    {
        $modelSeller = new TfSeller();
        if (!empty($sellerId)) {
            $currentStatus = $modelSeller->status($sellerId);
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelSeller->updateStatus($sellerId, $newStatus);
        }
    }

    public function deleteSeller($sellerId = null)
    {
        $modelSeller = new TfSeller();
        if (!empty($sellerId)) {
            $modelSeller->actionDelete($sellerId);
        }
    }

}
