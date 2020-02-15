<?php namespace App\Http\Controllers\Manage\Content\Map\Publics;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Publics\TfPublic;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class PublicController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelPublic = new TfPublic();
        $dataPublic = TfPublic::where('action', 1)->orderBy('created_at', 'DESC')->select('*')->paginate(30);
        $accessObject = 'public';
        return view('manage.content.map.public.list', compact('modelStaff', 'modelPublic', 'dataPublic', 'accessObject'));
    }

    #View
    public function viewPublic($publicId)
    {
        $dataPublic = TfPublic::find($publicId);
        if (count($dataPublic) > 0) {
            return view('manage.content.map.public.view', compact('dataPublic'));
        }
    }

    #Delete
    public function deletePublic($publicId)
    {
        $modelPublic = new TfPublic();
        $modelPublic->actionDelete($publicId);
    }

}
