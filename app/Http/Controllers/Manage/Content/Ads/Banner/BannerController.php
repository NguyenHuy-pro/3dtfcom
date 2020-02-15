<?php namespace App\Http\Controllers\Manage\Content\Ads\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Ads\Banner\Price\TfAdsBannerPrice;
use App\Models\Manage\Content\Ads\Banner\TfAdsBanner;
use App\Models\Manage\Content\Ads\Page\TfAdsPage;
use App\Models\Manage\Content\Ads\Position\TfAdsPosition;
use App\Models\Manage\Content\System\Staff\TfStaff;
//use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Session;
use Request;
use Input;

class BannerController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelAdsBanner = new TfAdsBanner();
        $modelAdsPage = new TfAdsPage();
        $modelAdsPosition = new TfAdsPosition();
        $dataAdsBanner = TfAdsBanner::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'tool';
        return view('manage.content.ads.banner.list', compact('modelStaff', 'modelAdsPage', 'modelAdsPosition', 'modelAdsBanner', 'dataAdsBanner', 'accessObject'));
    }

    public function viewBanner($bannerId = null)
    {
        $modelAdsBanner = new TfAdsBanner();
        if (!empty($bannerId)) {
            $dataAdsBanner = $modelAdsBanner->getInfo($bannerId);
            return view('manage.content.ads.banner.view', compact('dataAdsBanner'));
        }
    }

    #-------------- ------------ ADD ------------ --------------
    public function getAdd()
    {
        $modelAdsPage = new TfAdsPage();
        $modelAdsPosition = new TfAdsPosition();
        $accessObject = 'tool';
        return view('manage.content.ads.banner.add', compact('modelAdsPage', 'modelAdsPosition', 'accessObject'));
    }

    //select icon
    public function selectIcon($width, $height)
    {
        return view('manage.content.ads.banner.select-icon', compact('width', 'height'));
    }

    public function getPositionWidth($positionId = null)
    {
        $modelAdsPosition = new TfAdsPosition();
        if (empty($positionId) || $positionId == 0) {
            return 'Null';
        } else {
            return $modelAdsPosition->width($positionId);
        }
    }

    public function postAdd()
    {
        $hFunction = new \Hfunction();
        $modelAdsPosition = new TfAdsPosition();
        $modelAdsBanner = new TfAdsBanner();
        $modelAdsBannerPrice = new TfAdsBannerPrice();
        $pageId = Request::input('cbPage');
        $positionId = Request::input('cbPosition');
        $height = Request::input('cbHeight');
        $show = Request::input('cbShow');

        $width = $modelAdsPosition->width($positionId);
        $imageName = null;
        if (Input::hasFile('imageFile')) {
            $file = Request::file('imageFile');
            if (!empty($file)) {
                $imageName = $file->getClientOriginalName();
                $imageName = '3d-ads-social-virtual-city-virtual-land-online-marketing-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
                $modelAdsBanner->uploadImage($file, $imageName);
            }

        }

        if ($modelAdsBanner->insert($width, $height, $imageName, $pageId, $positionId)) {
            $newAdsBannerId = $modelAdsBanner->insertGetId();
            $modelAdsBannerPrice->insert(1, $show, $newAdsBannerId);
            Session::put('notifyAdsBanner', 'Add success, Enter info to continue');
        } else {
            $modelAdsBanner->dropImage($imageName);
            Session::put('notifyAdsBanner', 'Add fail, Enter info to try again');
        }

    }

    #-------------- ------------ EDIT ------------ --------------
    public function getEdit($bannerId = null)
    {
        $modelAdsBanner = new TfAdsBanner();
        $dataAdsBanner = $modelAdsBanner->getInfo($bannerId);
        if (count($dataAdsBanner) > 0) {
            return view('manage.content.ads.banner.edit', compact('dataAdsBanner'));
        }
    }

    public function postEdit($bannerId = null)
    {
        $hFunction = new \Hfunction();
        $modelAdsBanner = new TfAdsBanner();
        $modelAdsBannerPrice = new TfAdsBannerPrice();
        $show = Request::input('cbShow');

        //if exist name
        if (!$modelAdsBanner->existPriceByBanner($bannerId, $show)) {
            $priceIdAvailable = $modelAdsBanner->priceIdAvailable($bannerId);
            if (!$modelAdsBannerPrice->insert(1, $show, $bannerId)) {
                return "Add fail, Enter info to again.";
            } else {
                $modelAdsBannerPrice->actionDelete($priceIdAvailable);
            }

        }
        if (Input::hasFile('imageFile')) {
            $file = Request::file('imageFile');
            if (!empty($file)) {
                $dataAdsBanner = $modelAdsBanner->getInfo($bannerId);
                $oldImage = $dataAdsBanner->icon();
                $imageName = $file->getClientOriginalName();
                $imageName = '3d-ads-social-virtual-city-virtual-land-online-marketing-' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
                if ($modelAdsBanner->uploadImage($file, $imageName)) {
                    if ($modelAdsBanner->updateIcon($bannerId, $imageName)) {
                        $modelAdsBanner->dropImage($oldImage);
                    }
                }
            }

        }
    }

    public function statusUpdate($bannerId = null)
    {
        $modelAdsBanner = new TfAdsBanner();
        if (!empty($bannerId)) {
            $currentStatus = $modelAdsBanner->status($bannerId);
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelAdsBanner->updateStatus($bannerId, $newStatus);
        }
    }

    public function deleteBanner($bannerId = null)
    {
        $modelAdsBanner = new TfAdsBanner();
        if (!empty($bannerId)) {
            $modelAdsBanner->actionDelete($bannerId);
        }
    }

}
