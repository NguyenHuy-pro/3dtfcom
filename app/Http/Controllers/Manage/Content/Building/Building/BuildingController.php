<?php namespace App\Http\Controllers\Manage\Content\Building\Building;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class BuildingController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBuilding = new TfBuilding();
        $dataBuilding = TfBuilding::where('action', 1)->orderBy('building_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'building';
        return view('manage.content.building.building.list', compact('modelStaff', 'modelBuilding', 'dataBuilding', 'accessObject'));
    }

    #update status
    public function updateStatus($buildingId)
    {
        $modelBuilding = new TfBuilding();
        $currentStatus = $modelBuilding->getInfo($buildingId, 'status');
        $newStatus = ($currentStatus == 0) ? 1 : 0;
        return $modelBuilding->updateStatus($buildingId, $newStatus);
    }

    #View
    public function viewBuilding($buildingId)
    {
        $modelUser = new TfUser();
        $modelBuilding = new TfBuilding();
        $dataBuilding = TfBuilding::find($buildingId);
        if (count($dataBuilding) > 0) {
            return view('manage.content.building.building.view', compact('modelUser', 'modelBuilding', 'dataBuilding'));
        }

    }

    #delete building
    public function deleteBuilding($buildingId)
    {
        $modelBuilding = new TfBuilding();
        return $modelBuilding->actionDelete($buildingId);
    }
}
