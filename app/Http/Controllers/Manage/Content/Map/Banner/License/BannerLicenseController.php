<?php namespace App\Http\Controllers\Manage\Content\Map\Banner\License;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Banner\License\TfBannerLicense;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class BannerLicenseController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBannerLicense = new TfBannerLicense();
        $dataBannerLicense = TfBannerLicense::where('action', 1)->orderBy('license_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'banner';
        return view('manage.content.map.banner.license.list', compact('modelStaff', 'modelBannerLicense', 'dataBannerLicense', 'accessObject'));
    }

    #View
    public function viewBannerLicense($licenseId)
    {
        $dataBannerLicense = TfBannerLicense::find($licenseId);
        if (count($dataBannerLicense) > 0) {
            return view('manage.content.map.banner.license.view', compact('dataBannerLicense'));
        }

    }

}
