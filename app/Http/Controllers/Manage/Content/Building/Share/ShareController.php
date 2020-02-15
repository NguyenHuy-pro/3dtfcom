<?php namespace App\Http\Controllers\Manage\Content\Building\Share;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\Share\TfBuildingShare;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class ShareController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBuildingShare = new TfBuildingShare();
        $dataBuildingShare = TfBuildingShare::where('action', 1)->orderBy('share_id', 'DESC')->select('*')->paginate(30);
        return view('manage.content.building.share.list', compact('modelStaff', 'modelBuildingShare', 'dataBuildingShare'),
            [
                'accessObject' => 'share'
            ]);
    }

    #View post
    public function viewShare($shareId)
    {
        $dataBuildingShare = TfBuildingShare::find($shareId);
        if (count($dataBuildingShare) > 0) {
            return view('manage.content.building.share.view', compact('dataBuildingShare'));
        }
    }

}
