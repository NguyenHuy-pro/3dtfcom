<?php namespace App\Http\Controllers\Manage\Content\Map\Land\Share;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Land\Share\TfLandShare;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class LandShareController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelLandShare = new TfLandShare();
        $dataLandShare = TfLandShare::where('action', 1)->orderBy('share_id', 'DESC')->select('*')->paginate(30);
        return view('manage.content.map.land.share.list', compact('modelStaff','modelLandShare', 'dataLandShare'),
            [
                'accessObject' => 'land'
            ]);
    }

    #View
    public function viewLandShare($shareId)
    {
        $dataLandShare = TfLandShare::find($shareId);
        if (count($dataLandShare) > 0) {
            return view('manage.content.map.land.share.view', compact('dataLandShare'));
        }
    }

}
