<?php namespace App\Http\Controllers\Map\Market;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Banner\TfBanner;
use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\Sample\Banner\TfBannerSample;
use App\Models\Manage\Content\System\Country\TfCountry;
use App\Models\Manage\Content\System\Province\TfProvince;
use Illuminate\Http\Request;

class MarketController extends Controller
{

    # get sale land info
    public function getSaleLand($countryId = null, $provinceId = null)
    {
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $modelLand = new TfLand();
        if (!empty($countryId)) {
            if (empty($provinceId)) {
                $provinceId = $modelCountry->centerProvince($countryId);
            }
            $dataProvince = $modelProvince->findInfo($provinceId);
            $marketObject = 'saleLand';
            $dataLand = $modelLand->infoSaleOfProvince($provinceId);
            return view('map.components.market.market-land', compact('modelCountry', 'modelProvince','dataProvince', 'marketObject', 'dataLand'));
        }
    }

    # get free land info
    public function getFreeLand($countryId = null, $provinceId = null)
    {
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $modelLand = new TfLand();
        if (!empty($countryId)) {
            if (empty($provinceId)) {
                $provinceId = $modelCountry->centerProvince($countryId);
            }
            $dataProvince = $modelProvince->findInfo($provinceId);
            $marketObject = 'freeLand';
            $dataLand = $modelLand->infoFreeOfProvince($provinceId);
            return view('map.components.market.market-land', compact('modelCountry', 'modelProvince','dataProvince', 'marketObject', 'dataLand'));
        }
    }

    # get sale banner info
    public function getSaleBanner($countryId = null, $provinceId = null)
    {
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $modelBanner = new TfBanner();
        if (!empty($countryId)) {
            if (empty($provinceId)) {
                $provinceId = $modelCountry->centerProvince($countryId);
            }
            $dataProvince = $modelProvince->findInfo($provinceId);
            $marketObject = 'saleBanner';
            $dataBanner = $modelBanner->infoSaleOfProvince($provinceId);
            return view('map.components.market.market-banner', compact('modelCountry', 'modelProvince','dataProvince', 'marketObject', 'dataBanner'));
        }
    }

    # get free banner info
    public function getFreeBanner($countryId = null, $provinceId = null)
    {
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $modelBanner = new TfBanner();
        if (!empty($countryId)) {
            if (empty($provinceId)) {
                $provinceId = $modelCountry->centerProvince($countryId);
            }
            $dataProvince = $modelProvince->findInfo($provinceId);
            $marketObject = 'freeBanner';
            $dataBanner = $modelBanner->infoFreeOfProvince($provinceId);
            return view('map.components.market.market-banner', compact('modelCountry', 'modelProvince','dataProvince', 'marketObject', 'dataBanner'));
        }
    }
}
