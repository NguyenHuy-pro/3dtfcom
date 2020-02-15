<?php namespace App\Http\Controllers\Manage\Content\Seller\Guide;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Seller\Guide\TfSellerGuide;
use App\Models\Manage\Content\Seller\Guide\TfSellerGuideObject;
use App\Models\Manage\Content\System\Staff\TfStaff;
//use Illuminate\Http\Request;
use File;
use Input;
use Illuminate\Support\Facades\Session;
use Request;

class GuideController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelSellerGuide= new TfSellerGuide();
        $dataSellerGuide = TfSellerGuide::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'tool';
        return view('manage.content.seller.guide.list', compact('modelStaff', 'modelSellerGuide', 'dataSellerGuide', 'accessObject'));
    }

    public function viewDetail($guideId = null)
    {
        $modelSellerGuide = new TfSellerGuide();
        if (!empty($guideId)) {
            $dataSellerGuide = $modelSellerGuide->getInfo($guideId);
            return view('manage.content.seller.guide.view', compact('dataSellerGuide'));
        }
    }

    public function getAdd()
    {
        $accessObject = 'tool';
        $modelSellerGuideObject = new TfSellerGuideObject();
        return view('manage.content.seller.guide.add', compact('accessObject', 'modelSellerGuideObject'));
    }

    public function postAdd()
    {
        $modelSellerGuide = new TfSellerGuide();
        $objectId = Request::input('cbObject');
        $name = Request::input('txtName');
        $content = Request::input('txtContent');
        $video = Request::input('txtVideo');
        // check exist of name
        if ($modelSellerGuide->existName($name)) {
            Session::put('notifyGuide', "Add fail, Name <b>'$name'</b> exists.");
        } else {
            if ($modelSellerGuide->insert($name, $content, $video, $objectId)) {
                Session::put('notifyGuide', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyGuide', 'Add fail, Enter info to try again');
            }
        }

    }

    public function getEdit($guideId = null)
    {
        $modelSellerGuideObject = new TfSellerGuideObject();
        $modelSellerGuide = new TfSellerGuide();
        $dataSellerGuide = $modelSellerGuide->getInfo($guideId);
        if (count($dataSellerGuide) > 0) {
            return view('manage.content.seller.guide.edit', compact('modelSellerGuideObject', 'dataSellerGuide'));
        }
    }

    public function postEdit($guideId = null)
    {
        $modelSellerGuide = new TfSellerGuide();
        $objectId = Request::input('cbObject');
        $name = Request::input('txtName');
        $content = Request::input('txtContent');
        $video = Request::input('txtVideo');

        if(!empty($guideId)){
            //if exist name
            if ($modelSellerGuide->existEditName($name, $guideId)) {
                return "Add fail, Name <b>'$name'</b> exists.";
            } else {
                $modelSellerGuide->updateInfo($guideId, $name, $content, $video, $objectId);
            }
        }

    }

    public function statusUpdate($guideId = null)
    {
        $modelSellerGuide = new TfSellerGuide();
        if (!empty($guideId)) {
            $currentStatus = $modelSellerGuide->status($guideId);
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelSellerGuide->updateStatus($guideId, $newStatus);
        }
    }

    public function deleteGuide($guideId = null)
    {
        $modelSellerGuide = new TfSellerGuide();
        if (!empty($guideId)) {
            $modelSellerGuide->actionDelete($guideId);
        }
    }

}
