<?php namespace App\Http\Controllers\Manage\Content\Map\Banner\ImageVisit;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Banner\ImageVisit\TfBannerImageVisit;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class BannerImageVisitController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBannerImageVisit = new TfBannerImageVisit();
        $dataBannerImageVisit = TfBannerImageVisit::orderBy('visit_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'banner';
        return view('manage.content.map.banner.image-visit.list', compact('modelStaff', 'modelBannerImageVisit', 'dataBannerImageVisit', 'accessObject'));
    }

    #View
    public function viewVisitImage($visitId)
    {
        $dataBannerImageVisit = TfBannerImageVisit::find($visitId);
        if (count($dataBannerImageVisit) > 0) {
            return view('manage.content.map.banner.image-visit.view', compact('dataBannerImageVisit'));
        }

    }

}
