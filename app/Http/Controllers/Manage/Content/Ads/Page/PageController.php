<?php namespace App\Http\Controllers\Manage\Content\Ads\Page;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Ads\Page\TfAdsPage;
use App\Models\Manage\Content\System\Staff\TfStaff;
//use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Session;
use Request;

class PageController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelAdsPage = new TfAdsPage();
        $dataAdsPage = TfAdsPage::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'tool';
        return view('manage.content.ads.page.list', compact('modelStaff', 'modelAdsPage', 'dataAdsPage', 'accessObject'));
    }

    public function viewPage($pageId = null)
    {
        $modelAdsPage = new TfAdsPage();
        if (!empty($pageId)) {
            $dataAdsPage = $modelAdsPage->getInfo($pageId);
            return view('manage.content.ads.page.view', compact('dataAdsPage'));
        }
    }

    public function getAdd()
    {
        $accessObject = 'tool';
        return view('manage.content.ads.page.add', compact('accessObject'));
    }

    public function postAdd()
    {
        $modelAdsPage = new TfAdsPage();
        $name = Request::input('txtName');

        // check exist of name
        if ($modelAdsPage->existName($name)) {
            Session::put('notifyAdsPage', "Add fail, Name <b>'$name'</b> exists.");
        } else {
            if ($modelAdsPage->insert($name)) {
                Session::put('notifyAdsPage', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAdsPage', 'Add fail, Enter info to try again');
            }
        }

    }

    public function getEdit($pageId = null)
    {
        $modelAdsPage = new TfAdsPage();
        $dataAdsPage = $modelAdsPage->getInfo($pageId);
        if (count($dataAdsPage) > 0) {
            return view('manage.content.ads.page.edit', compact('dataAdsPage'));
        }
    }

    public function postEdit($pageId = '')
    {
        $modelAdsPage = new TfAdsPage();
        $name = Request::input('txtName');

        //if exist name
        if ($modelAdsPage->existEditName($name, $pageId)) {
            return "Add fail, Name <b>'$name'</b> exists.";
        } else {
            $modelAdsPage->updateInfo($pageId, $name);
        }
    }

    public function statusUpdate($pageId = null)
    {
        $modelAdsPage = new TfAdsPage();
        if (!empty($pageId)) {
            $currentStatus = $modelAdsPage->status($pageId);
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelAdsPage->updateStatus($pageId, $newStatus);
        }
    }

    public function deletePage($pageId = null)
    {
        $modelAdsPage = new TfAdsPage();
        if (!empty($pageId)) {
            $modelAdsPage->actionDelete($pageId);
        }
    }

}
