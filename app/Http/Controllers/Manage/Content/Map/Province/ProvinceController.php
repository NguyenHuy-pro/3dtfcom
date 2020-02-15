<?php namespace App\Http\Controllers\Manage\Content\Map\Province;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Country\TfCountry;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $dataProvince = TfProvince::where('build3d', 1)->where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'province';
        return view('manage.content.map.province.list', compact('modelStaff', 'modelCountry', 'modelProvince', 'dataProvince', 'accessObject'));
    }

    #View
    public function viewProvince($provinceId)
    {
        $dataProvince = TfProvince::find($provinceId);
        if (count($dataProvince) > 0) {
            return view('manage.content.map.province.view', compact('dataProvince'));
        }

    }

}
