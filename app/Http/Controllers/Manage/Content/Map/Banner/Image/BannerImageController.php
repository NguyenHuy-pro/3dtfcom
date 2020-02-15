<?php namespace App\Http\Controllers\Manage\Content\Map\Banner\Image;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class BannerImageController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBannerImage = new TfBannerImage();
        $dataBannerImage = TfBannerImage::where('action', 1)->orderBy('image_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'banner';
        return view('manage.content.map.banner.image.list', compact('modelStaff', 'modelBannerImage', 'dataBannerImage', 'accessObject'));
    }

    #View
    public function viewBannerImage($imageId)
    {
        $dataBannerImage = TfBannerImage::find($imageId);
        if (count($dataBannerImage) > 0) {
            return view('manage.content.map.banner.image.view', compact('dataBannerImage'));
        }
    }

    #Delete
    public function deleteBannerImage($imageId)
    {
        $modelBannerImage = new TfBannerImage();
        $modelBannerImage->actionDelete($imageId);
    }

}
