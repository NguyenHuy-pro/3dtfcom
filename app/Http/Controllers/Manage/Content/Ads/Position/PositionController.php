<?php namespace App\Http\Controllers\Manage\Content\Ads\Position;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Ads\Page\TfAdsPage;
use App\Models\Manage\Content\Ads\Position\TfAdsPosition;
use App\Models\Manage\Content\System\Staff\TfStaff;
//use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Session;
use Request;

class PositionController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelAdsPosition = new TfAdsPosition();
        $dataAdsPosition = TfAdsPosition::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'tool';
        return view('manage.content.ads.position.list', compact('modelStaff', 'modelAdsPosition', 'dataAdsPosition', 'accessObject'));
    }

    public function viewPosition($positionId = null)
    {
        $modelAdsPosition = new TfAdsPosition();
        if (!empty($positionId)) {
            $dataAdsPosition = $modelAdsPosition->getInfo($positionId);
            return view('manage.content.ads.position.view', compact('dataAdsPosition'));
        }
    }

    public function getAdd()
    {
        $accessObject = 'tool';
        return view('manage.content.ads.position.add', compact('accessObject'));
    }

    public function postAdd()
    {
        $modelAdsPosition = new TfAdsPosition();
        $name = Request::input('txtName');
        $width = Request::input('cbWidth');

        // check exist of name
        if ($modelAdsPosition->existName($name)) {
            Session::put('notifyAdsPosition', "Add fail, Name <b>'$name'</b> exists.");
        } else {
            if ($modelAdsPosition->insert($name, $width)) {
                Session::put('notifyAdsPosition', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAdsPosition', 'Add fail, Enter info to try again');
            }
        }

    }

    public function getEdit($positionId = null)
    {
        $modelAdsPosition = new TfAdsPosition();
        $dataAdsPosition = $modelAdsPosition->getInfo($positionId);
        if (count($dataAdsPosition) > 0) {
            return view('manage.content.ads.position.edit', compact('dataAdsPosition'));
        }
    }

    public function postEdit($positionId = '')
    {
        $modelAdsPosition = new TfAdsPosition();
        $name = Request::input('txtName');
        $width = Request::input('cbWidth');

        //if exist name
        if ($modelAdsPosition->existEditName($name, $positionId)) {
            return "Add fail, Name <b>'$name'</b> exists.";
        } else {
            $modelAdsPosition->updateInfo($positionId, $name, $width);
        }
    }

    public function statusUpdate($positionId = null)
    {
        $modelAdsPosition = new TfAdsPosition();
        if (!empty($positionId)) {
            $currentStatus = $modelAdsPosition->status($positionId);
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelAdsPosition->updateStatus($positionId, $newStatus);
        }
    }

    public function deletePosition($positionId = null)
    {
        $modelAdsPosition = new TfAdsPosition();
        if (!empty($positionId)) {
            $modelAdsPosition->actionDelete($positionId);
        }
    }

}
