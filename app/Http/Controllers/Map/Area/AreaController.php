<?php namespace App\Http\Controllers\Map\Area;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\System\BusinessType\TfBusinessType;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Map\Area\TfArea;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    # get get
    public function  getArea($provinceAccess = null, $areaAccess = null)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelBusinessType = new TfBusinessType();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();
        # get around area ->return string area Id
        $listArea = $modelArea->selectiveArea($areaAccess);
        # get area loaded
        $oldList = $modelArea->getAreaLoaded();

        # get new area list
        $newArea = $hFunction->getSubListNew($listArea, $oldList);
        # convert to array
        $loadArea = explode(',', $newArea);

        # get info of new areas
        $area = TfArea::whereIn('area_id', $loadArea)->get();
        $dataMapAccess = [
            'provinceAccess' => $provinceAccess,
            'areaAccess' => $areaAccess,
            'projectAccess' => null,
            'landAccess' => null,
            'bannerAccess' =>null,
            'businessTypeAccess' => $modelBusinessType->getAccess()
        ];

        if (count($area) > 0) {
            foreach ($area as $key => $dataArea) {
                echo view('map.area.area', compact('modelUser', 'modelProvince', 'modelArea', 'dataArea', 'dataMapAccess'));
            }
        }
    }

    #==========  ========== ==========  go to area (select x -y) ========== ========== ==========
    public function getLoadCoordinates($provinceAccessId = '', $areaX = '', $areaY = '')
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelProvince = new TfProvince();
        $modelArea = new TfArea();

        # get around area ->return string area ID
        $areaAccessId = $modelArea->getAreaXY($areaX, $areaY);
        $listArea = $modelArea->selectiveArea($areaAccessId);
        # get area loaded
        $oldList = $modelArea->getAreaLoaded();// Session::get('tf_map_area_history');

        # get new area list
        $newArea = $hFunction->getSubListNew($listArea, $oldList);
        # convert to array
        $loadArea = explode(',', $newArea);

        # get info of new areas
        $area = TfArea::whereIn('area_id', $loadArea)->get();
        $dataMapAccess = [
            'provinceAccess' => $provinceAccessId,
            'areaAccess' => $areaAccessId,
            'projectAccess' => null,
            'landAccess' => null,
            'bannerAccess' => null
        ];

        if (count($area) > 0) {
            foreach ($area as $key => $dataArea) {
                return view('map.area.area', compact('modelUser', 'modelProvince', 'modelArea', 'dataArea', 'dataMapAccess'));
            }
        }

    }

    #========== ========== =========== set position ========= ========== ==========
    public function setPosition($areaAccessId = '')
    {
        $modelArea = new TfArea();
        # set area login
        $modelArea->setMainHistoryArea($areaAccessId);
    }

    #========== ========== =========== Zoom =========== =========== ========
    public function getZoom($provinceId = null, $areaId=null, $provinceTop = null, $provinceLeft = null)
    {
        $modelArea = new TfArea();
        if (!empty($provinceId) && !empty($areaId)) {
            $dataProvince = TfProvince::find($provinceId);
            $dataAreaAccess = TfArea::find($areaId);
            if (count($dataAreaAccess) > 0) {
                $areaId = $dataAreaAccess->areaId();
                # get around area ->return string area Id
                $listArea = $modelArea->selectiveArea($areaId);
                # convert to array
                $loadArea = explode(',', $listArea);

                # get info of new areas
                $dataArea = TfArea::whereIn('area_id', $loadArea)->get();
                return view('map.area.zoom.content', compact('modelArea', 'dataArea', 'dataProvince','dataAreaAccess', 'provinceTop', 'provinceLeft'));

            }
        }
    }

}
