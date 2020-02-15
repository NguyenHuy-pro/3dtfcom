<?php namespace App\Http\Controllers\Manage\Content\Map\Area;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\Area\TfArea;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class AreaController extends Controller {

	public function getList(){
        $modelStaff = new TfStaff();
        $modelArea = new TfArea();
        $accessObject = 'tool';
        $dataArea = TfArea::orderBy('area_id','ASC')->select('*')->paginate(50);
        return view('manage.content.map.area.list',compact('modelStaff', 'modelArea', 'dataArea', 'accessObject'));
    }

}
