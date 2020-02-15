<?php namespace App\Http\Controllers\Manage\Build\Area;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\ProvinceArea\TfProvinceArea;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Map\Area\TfArea;
use DB;
use File;
use Request;

class AreaController extends Controller
{
    # get area (on mouse move)
    public function getArea($provinceAccess = '', $areaAccessId = '')
    {
        $hFunction = new \Hfunction();
        $modelStaff = new TfStaff();
        $modelProvinceArea = new TfProvinceArea();
        $modelArea = new TfArea();
        # get around area ->return string area ID
        $listArea = $modelArea->selectiveArea($areaAccessId);
        # get area loaded
        $oldList = Session::get('tf_m_build_area_history');
        # get new area list
        $newArea = $hFunction->getSubListNew($listArea, $oldList);
        # convert to array
        $loadArea = explode(',', $newArea);

        # get info of new areas
        $area = TfArea::whereIn('area_id', $loadArea)->get();
        $dataMapAccess = [
            'provinceAccess' => $provinceAccess,
            'areaAccess' => $areaAccessId,
            'setupStatus' => 0,
        ];
        if (count($area) > 0) {
            foreach ($area as $key => $dataArea) {
                echo view('manage.build.map.area.area', compact('modelStaff', 'modelProvinceArea', 'modelArea', 'dataArea', 'dataMapAccess'));
            }
        }
    }

    # go to area (select x -y)
    public function getLoadCoordinates($provinceAccess = '', $areaX = '', $areaY = '')
    {
        $hFunction = new \Hfunction();
        $modelStaff = new TfStaff();
        $modelProvinceArea = new TfProvinceArea();
        $modelArea = new TfArea();
        # get around area ->return string area ID
        $areaAccessId = $modelArea->getAreaXY($areaX, $areaY);
        $listArea = $modelArea->selectiveArea($areaAccessId);
        # get area loaded
        $oldList = Session::get('tf_m_build_area_history');
        # get new area list
        $newArea = $hFunction->getSubListNew($listArea, $oldList);
        # convert to array
        $loadArea = explode(',', $newArea);
        # get info of new areas
        $area = TfArea::whereIn('area_id', $loadArea)->get();
        $dataMapAccess = [
            'provinceAccess' => $provinceAccess,
            'areaAccess' => $areaAccessId,
            'setupStatus' => 0,
        ];
        if (count($area) > 0) {
            foreach ($area as $key => $dataArea) {
                echo view('manage.build.map.area.area', compact('modelStaff', 'modelProvinceArea', 'modelArea', 'dataArea', 'dataMapAccess'));
            }
        }
    }

    #set position
    public function setPosition($areaAccessId = '')
    {
        $modelArea = new TfArea();
        # set area login
        $modelArea->setHistoryArea($areaAccessId);
    }
}
