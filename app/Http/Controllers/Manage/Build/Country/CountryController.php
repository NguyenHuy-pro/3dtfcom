<?php namespace App\Http\Controllers\Manage\Build\Country;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Country\TfCountry;
use Illuminate\Http\Request;

class CountryController extends Controller {

    public function index($countryId=null)
    {
        $modelCountry = new TfCountry();
        if(empty($countryId)) $countryId = $modelCountry->centerCountryId();


        # get province of country to access
        $provinceId = $modelCountry->centerProvince($countryId);
        return redirect()->route('tf.m.build.province.get',$provinceId);
    }

}
