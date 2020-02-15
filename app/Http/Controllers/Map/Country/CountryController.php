<?php namespace App\Http\Controllers\Map\Country;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Country\TfCountry;
use Illuminate\Http\Request;

class CountryController extends Controller {

    # access province from a country
    public function accessCountry($countryId=null)
    {
        $modelCountry = new TfCountry();
        if(empty($countryId)) $countryId = $modelCountry->centerCountryId();


        # get province of country to access
        $provinceId = $modelCountry->centerProvince($countryId);
        return redirect()->route('tf.map.province.access',$provinceId);
        /*
        # get area of province to access
        $areaId = $modelProvince->centerArea($provinceId);

        # set load area into history
        $modelArea->setMainHistoryArea($areaId);
        $dataMapAccess = [
            'provinceAccess' => $provinceId,
            'areaAccess' => $areaId,
            'landAccess' => 0,
            'bannerAccess' => 0
        ];
        return view('map.map', compact(['dataMapAccess' => $dataMapAccess]));
        */
    }

}
