<?php namespace App\Http\Controllers\Manage\Content\Map\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Banner\TfBanner;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBanner = new TfBanner();
        $modelTransactionStatus = new TfTransactionStatus();
        $dataBanner = TfBanner::where('action', 1)->orderBy('created_at', 'DESC')->select('*')->paginate(30);
        $accessObject = 'banner';
        return view('manage.content.map.banner.banner.list', compact('modelStaff', 'modelTransactionStatus', 'modelBanner', 'dataBanner', 'accessObject'));
    }

    #View
    public function viewBanner($bannerId)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $dataBanner = TfBanner::find($bannerId);
        if (count($dataBanner) > 0) {
            return view('manage.content.map.banner.banner.view', compact('modelTransactionStatus','dataBanner'));
        }
    }

    #Delete
    public function deleteBanner($bannerId)
    {
        $modelBanner = new TfBanner();
        $modelBanner->actionDelete($bannerId);
    }

}
