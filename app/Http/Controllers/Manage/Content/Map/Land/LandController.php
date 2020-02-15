<?php namespace App\Http\Controllers\Manage\Content\Map\Land;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class LandController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelLand = new TfLand();
        $modelTransactionStatus = new TfTransactionStatus();
        $dataLand = TfLand::where('action', 1)->orderBy('land_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'land';
        return view('manage.content.map.land.land.list', compact('modelStaff', 'modelLand', 'modelTransactionStatus', 'dataLand', 'accessObject'));
    }

    #View
    public function viewLand($landId)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $dataLand = TfLand::find($landId);
        if (count($dataLand) > 0) {
            return view('manage.content.map.land.land.view', compact('modelTransactionStatus','dataLand'));
        }
    }

    #Delete
    public function deleteLand($landId)
    {
        $modelLand = new TfLand();
        $modelLand->actionDelete($landId);
    }

}
