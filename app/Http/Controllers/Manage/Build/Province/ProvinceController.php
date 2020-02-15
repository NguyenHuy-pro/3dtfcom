<?php namespace App\Http\Controllers\Manage\Build\Province;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\ProvinceArea\TfProvinceArea;
use App\Models\Manage\Content\Sample\PublicType\TfPublicType;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Country\TfCountry;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\System\Province\TfProvince;
use DB;
use File;
use Request;

class ProvinceController extends Controller
{

    public function getProvince($provinceId = '', $areaId = '')
    {
        $modelStaff = new TfStaff();
        $modelCountry = new TfCountry();
        $modelProvince = new TfProvince();
        $modelProvinceArea = new TfProvinceArea();
        $modelArea = new TfArea();
        $modelBusinessType = new TfBusinessType();
        $modelPublicType = new TfPublicType();

        if (!empty($areaId)) {
            $areaLoadId = $areaId;
        } else {
            # get history area (old position of province)
            $areaLoadId = $modelArea->getHistoryArea();
            if (empty($areaLoadId)) {
                # get default area of province
                $areaLoadId = $modelProvince->centerArea($provinceId);
            }
        }

        $dataMapAccess = [
            'provinceAccess' => $provinceId,
            'areaAccess' => $areaLoadId,
        ];
        # set load area filter
        $modelArea->setHistoryArea($areaLoadId);

        # cancel setup status when to new province
        $modelProvinceArea->closeSetup();
        return view('manage.build.map.map', compact('modelStaff', 'modelCountry', 'modelProvince', 'modelArea', 'modelProvinceArea', 'modelBusinessType', 'modelPublicType', 'dataMapAccess'));
    }

}
