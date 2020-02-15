<?php namespace App\Http\Controllers\Manage\Content\Map\Banner\Share;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Banner\Share\TfBannerShare;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class BannerShareController extends Controller {

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBannerShare = new TfBannerShare();
        $dataBannerShare = TfBannerShare::where('action', 1)->orderBy('share_id', 'DESC')->select('*')->paginate(30);
        return view('manage.content.map.banner.share.list', compact('modelStaff','modelBannerShare','dataBannerShare'),
            [
                'accessObject' => 'banner'
            ]);
    }

    #View
    public function viewBannerShare($shareId)
    {
        $dataBannerShare = TfBannerShare::find($shareId);
        if(count($dataBannerShare) > 0){
            return view('manage.content.map.banner.share.view', compact('dataBannerShare'));
        }

    }

}
