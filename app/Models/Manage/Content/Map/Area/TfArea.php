<?php namespace App\Models\Manage\Content\Map\Area;

use App\Models\Manage\Content\Map\Project\TfProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class TfArea extends Model
{

    protected $table = 'tf_areas';
    protected $fillable = ['area_id', 'width', 'height', 'leftPosition', 'topPosition', 'x', 'y'];
    protected $primaryKey = 'area_id';
    public $timestamps = false;

    #============ ========== ========== RELATION ============ =========== ===========
    # ---------- TF-PROJECT ----------
    public function area()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Area\TfArea', 'area_id', 'area_id');
    }

    #---------- TF-PROVINCE-AREA -----------
    public function provinceArea()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\ProvinceArea\TfProvinceArea', 'area_id', 'area_id');
    }

    #============ ========== ========== LAND GRID ============ =========== ===========
    # load area
    public function createPlan($y, $x)
    {   // tao ma tran land , moi phan tu se chua 1 project
        $var = 1;        //$var area_id
        for ($i = 0; $i <= $y; $i++) {
            for ($j = 0; $j <= $x; $j++) {
                $area_element[$i][$j] = $var;
                $var++;
            }
        }
        return $area_element;
    }

    # get lands around of a land
    public function getAround($id = '', $x = '', $y = '')
    {
        $listAround = "";
        $around = $this->createPlan($y, $x);
        for ($i = 0; $i <= $y; $i++) {
            for ($j = 0; $j <= $x; $j++) {
                if ($around[$i][$j] == $id) {
                    if ($i != 0 and $j != 0) $listAround .= $around[$i - 1][$j - 1] . ",";
                    if ($i != 0) $listAround .= $around[$i - 1][$j] . ",";
                    if ($i != 0 and $j != $x) $listAround .= $around[$i - 1][$j + 1] . ",";
                    if ($j != 0) $listAround .= $around[$i][$j - 1] . ",";
                    $listAround .= $around[$i][$j] . ",";
                    if ($j != $x) $listAround .= $around[$i][$j + 1] . ",";
                    if ($i != $y and $j != 0) $listAround .= $around[$i + 1][$j - 1] . ",";
                    if ($i != $y) {
                        $listAround .= $around[$i + 1][$j] . ",";
                    }
                    if ($i != $y and $j != $x) $listAround .= $around[$i + 1][$j + 1] . ",";
                }
            }
        }
        return substr($listAround, 0, strlen($listAround) - 1);
    }

    public function selectiveArea($areaId = '')
    {     # lay land_id xung quanh
        return $this->getAround($areaId, 100, 100);
    }

    #========== ========== ============ GET INFO ========== ========== ===========
    public function getInfo($areaId = '', $field = '')
    {
        if (empty($areaId)) {
            return null;
        } else {
            $result = TfArea::where('area_id', $areaId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function getInfoFromListAreaId($listAreaId)
    {
        return TfArea::whereIn('area_id', $listAreaId)->get();
    }

    public function areaId()
    {
        return $this->area_id;
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfArea::where('area_id', $objectId)->pluck($column);
        }
    }

    public function topPosition($areaId = null)
    {
        return $this->pluck('topPosition', $areaId);
    }

    public function leftPosition($areaId = null)
    {
        return $this->pluck('leftPosition', $areaId);
    }

    public function width($areaId = null)
    {
        return $this->pluck('width', $areaId);
    }

    public function height($areaId = null)
    {
        return $this->pluck('height', $areaId);
    }

    public function x($areaId = null)
    {
        return $this->pluck('x', $areaId);
    }

    public function y($areaId = null)
    {
        return $this->pluck('y', $areaId);
    }

    # take according to conditions x and y #return area id
    public function getAreaXY($x = '', $y = '')
    {
        return TfArea::where('x', $x)->where('y', $y)->pluck('area_id');
    }

    #return info area
    public function getInfoAreaXY($x = '', $y = '')
    {
        return TfArea::where('x', $x)->where('y', $y)->first();
    }

    # take according to conditions position
    public function getAreaPosition($topPosition = '', $leftPosition = '')
    {
        return TfArea::where('topPosition', $topPosition)->where('leftPosition', $leftPosition)->pluck('area_id');
    }

    # total records -->return number
    public function totalRecords()
    {
        return TfArea::count();
    }

    #------------- TF-PROJECT ----------
    public function projectInfoOfProvince($provinceId, $areaId = null)
    {
        $modelProject = new TfProject();
        if (empty($areaId)) $areaId = $this->areaId();
        return $modelProject->infoOfProvinceAndArea($provinceId, $areaId);
    }
    #========= ========== ============ load area HISTORY (front end)  =========== ========== ===========
    # check exist
    public function existMainHistoryArea()
    {
        return (Session::has('dataMapHistoryAccess')) ? true : false;
    }

    # set history
    public function setMainHistoryArea($areaId = '')
    {
        return Session::put('dataMapHistoryAccess', $areaId);
    }

    # get history
    public function getMainHistoryArea()
    {
        return Session::get('dataMapHistoryAccess');
    }

    # destroy history
    public function forgetMainHistoryArea()
    {
        return Session::forget('dataMapHistoryAccess');
    }

    #note the areas load
    public function setAreaLoaded($areaId = null)
    {
        #save string id
        if (!empty($areaId)) {
            if (Session::has('tf_map_area_history')) // load lai vi tri cu
            {
                # load when move on map (by: mouse over, trend, min imap)
                Session::put('tf_map_area_history', Session::get('tf_map_area_history') . ',' . $areaId);
            } else {
                # first load or return load
                Session::put('tf_map_area_history', $areaId);
            }
        }
    }

    #get areas loaded -> return list
    public function getAreaLoaded()
    {
        return (Session::has('tf_map_area_history')) ? Session::get('tf_map_area_history') : null;
    }

    public function forgetAreaLoad()
    {
        if (Session::has('tf_map_area_history')) {
            Session::forget('tf_map_area_history');
        }
    }


    #========== =============== ========== load area HISTORY (back end)  =========== ========== =============
    # check exist
    public function existHistoryArea()
    {
        return (Session::has('dataHistoryAccess')) ? true : false;
    }

    # set history
    public function setHistoryArea($areaId = '')
    {
        return Session::put('dataHistoryAccess', $areaId);
    }

    # get history
    public function getHistoryArea()
    {
        return Session::get('dataHistoryAccess');
    }

    # destroy history
    public function forgetHistoryArea()
    {
        return Session::forget('dataHistoryAccess');
    }
}
