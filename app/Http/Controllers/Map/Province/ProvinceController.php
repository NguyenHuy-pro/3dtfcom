<?php namespace App\Http\Controllers\Map\Province;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Area\TfArea;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    # access province from a direct province
    public function accessProvince($provinceId = null, $areaId = null)
    {
        $modelUser = new TfUser();
        $modelAbout = new TfAbout();
        $modelBusinessType = new TfBusinessType();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();
        $modelProject = new TfProject();

        if (!empty($areaId) or $areaId > 0) {
            $areaLoadId = $areaId;
        } else {
            # get history area (old position of province)
            $areaLoadId = $modelArea->getMainHistoryArea();
            if (empty($areaLoadId)) {
                # get default area of province
                $areaLoadId = $modelProvince->centerArea($provinceId);
            } else {
                if (!$modelProject->existProjectOfProvinceAndArea($provinceId, $areaId)) {
                    $areaLoadId = $modelProvince->centerArea($provinceId);
                }
            }
        }
        $dataMapAccess = [
            'provinceAccess' => $provinceId,
            'areaAccess' => $areaLoadId,
            'landAccess' => null,
            'bannerAccess' => null,
            'businessTypeAccess' => $modelBusinessType->getAccess()
        ];

        # set load area into history
        $modelArea->setMainHistoryArea($areaLoadId);
        return view('map.map', compact('modelAbout','modelUser', 'modelProvince', 'modelArea', 'dataMapAccess'));
    }

}
