<?php namespace App\Http\Controllers\Manage\Content\Building\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Banner\TfBuildingBanner;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBuildingBanner = new TfBuildingBanner();
        $dataBuildingBanner = TfBuildingBanner::where('action', 1)->orderBy('created_at', 'DESC')->select('*')->paginate(30);
        $accessObject = 'building';
        return view('manage.content.building.banner.list', compact('modelStaff', 'modelBuildingBanner', 'dataBuildingBanner', 'accessObject'));
    }

    #view
    public function getView($bannerId)
    {
        $modelBuildingBanner = new TfBuildingBanner();
        $dataBuildingBanner = $modelBuildingBanner->getInfo($bannerId);
        return view('manage.content.building.banner.view', compact('dataBuildingBanner'));
    }

    #delete
    public function deleteBanner($bannerId)
    {
        $modelBuildingBanner = new TfBuildingBanner();
        return $modelBuildingBanner->getDelete($bannerId);
    }
}
