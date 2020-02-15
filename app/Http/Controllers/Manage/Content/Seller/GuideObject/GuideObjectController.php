<?php namespace App\Http\Controllers\Manage\Content\Seller\GuideObject;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Seller\Guide\TfSellerGuideObject;
use App\Models\Manage\Content\System\Staff\TfStaff;
//use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Session;
use Request;

class GuideObjectController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelSellerGuideObject= new TfSellerGuideObject();
        $dataSellerGuideObject = TfSellerGuideObject::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'tool';
        return view('manage.content.seller.guide-object.list', compact('modelStaff', 'modelSellerGuideObject', 'dataSellerGuideObject', 'accessObject'));
    }

    public function viewDetail($objectId = null)
    {
        $modelSellerGuideObject = new TfSellerGuideObject();
        if (!empty($objectId)) {
            $dataSellerGuideObject = $modelSellerGuideObject->getInfo($objectId);
            return view('manage.content.seller.guide-object.view', compact('dataSellerGuideObject'));
        }
    }

    public function getAdd()
    {
        $accessObject = 'tool';
        return view('manage.content.seller.guide-object.add', compact('accessObject'));
    }

    public function postAdd()
    {
        $modelSellerGuideObject = new TfSellerGuideObject();
        $name = Request::input('txtName');

        // check exist of name
        if ($modelSellerGuideObject->existName($name)) {
            Session::put('notifyGuideObject', "Add fail, Name <b>'$name'</b> exists.");
        } else {
            if ($modelSellerGuideObject->insert($name)) {
                Session::put('notifyGuideObject', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyGuideObject', 'Add fail, Enter info to try again');
            }
        }

    }

    public function getEdit($objectId = null)
    {
        $modelSellerGuideObject = new TfSellerGuideObject();
        $dataSellerGuideObject = $modelSellerGuideObject->getInfo($objectId);
        if (count($dataSellerGuideObject) > 0) {
            return view('manage.content.seller.guide-object.edit', compact('dataSellerGuideObject'));
        }
    }

    public function postEdit($objectId = null)
    {
        $modelSellerGuideObject = new TfSellerGuideObject();
        $name = Request::input('txtName');

        if(!empty($objectId)){
            //if exist name
            if ($modelSellerGuideObject->existEditName($name, $objectId)) {
                return "Add fail, Name <b>'$name'</b> exists.";
            } else {
                $modelSellerGuideObject->updateInfo($objectId, $name);
            }
        }

    }

    public function statusUpdate($objectId = null)
    {
        $modelSellerGuideObject = new TfSellerGuideObject();
        if (!empty($objectId)) {
            $currentStatus = $modelSellerGuideObject->status($objectId);
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelSellerGuideObject->updateStatus($objectId, $newStatus);
        }
    }

    public function deleteObject($objectId = null)
    {
        $modelSellerGuideObject = new TfSellerGuideObject();
        if (!empty($objectId)) {
            $modelSellerGuideObject->actionDelete($objectId);
        }
    }

}
