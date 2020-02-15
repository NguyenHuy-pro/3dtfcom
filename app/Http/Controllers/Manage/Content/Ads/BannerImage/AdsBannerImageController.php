<?php namespace App\Http\Controllers\Manage\Content\Ads\BannerImage;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Ads\Banner\Image\TfAdsBannerImage;
use App\Models\Manage\Content\System\Staff\TfStaff;
//use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Session;
use Request;

class AdsBannerImageController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelAdsBannerImage = new TfAdsBannerImage();
        $dataAdsBannerImage = TfAdsBannerImage::where('action', 1)->orderBy('image_id', 'ASC')->select('*')->paginate(30);
        $accessObject = 'tool';
        return view('manage.content.ads.banner-image.list', compact('modelStaff', 'modelAdsBannerImage', 'dataAdsBannerImage', 'accessObject'));
    }

    public function viewBannerImage($bannerId = null)
    {
        $modelAdsBannerImage = new TfAdsBannerImage();
        if (!empty($bannerId)) {
            $dataAdsBannerImage = $modelAdsBannerImage->getInfo($bannerId);
            return view('manage.content.ads.banner-image.view', compact('dataAdsBannerImage'));
        }
    }

    public function deleteBannerImage($image = null)
    {
        $modelAdsBannerImage = new TfAdsBannerImage();
        if (!empty($image)) {
            $modelAdsBannerImage->actionDelete($image);
        }
    }

}
