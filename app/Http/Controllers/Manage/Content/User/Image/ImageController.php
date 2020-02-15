<?php namespace App\Http\Controllers\Manage\Content\User\Image;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Users\Image\TfUserImage;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelUserImage = new TfUserImage();
        $dataUserImage = TfUserImage::where('action', 1)->orderBy('image_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'image';
        return view('manage.content.user.image.list', compact('modelStaff', 'modelUserImage', 'dataUserImage', 'accessObject'));
    }

    #View
    public function viewImage($imageId)
    {
        $dataUserImage = TfUserImage::find($imageId);
        if (count($dataUserImage)) {
            return view('manage.content.user.image.view', compact('dataUserImage'));
        }
    }

    #delete
    public function deleteImage($imageId)
    {
        $modelUserImage = new TfUserImage();
        return $modelUserImage->actionDelete($imageId);
    }

}
