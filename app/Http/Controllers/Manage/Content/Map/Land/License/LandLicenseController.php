<?php namespace App\Http\Controllers\Manage\Content\Map\Land\License;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Land\License\TfLandLicense;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class LandLicenseController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelLandLicense = new TfLandLicense();
        $dataLandLicense = TfLandLicense::where('action', 1)->orderBy('license_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'land';
        return view('manage.content.map.land.license.list', compact('modelStaff', 'modelLandLicense', 'dataLandLicense', 'accessObject'));
    }

    #View
    public function viewLandLicense($licenseId)
    {
        $dataLandLicense = TfLandLicense::find($licenseId);
        if (count($dataLandLicense) > 0) {
            return view('manage.content.map.land.license.view', compact('dataLandLicense'));
        }
    }

}
