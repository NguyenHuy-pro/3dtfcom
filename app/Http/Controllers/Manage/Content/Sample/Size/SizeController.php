<?php namespace App\Http\Controllers\Manage\Content\Sample\Size;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Sample\Standard\TfStandard;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Sample\Size\TfSize;
use Input;
use File;
use DB;
use Request;

class SizeController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelSize = new TfSize();
        $modelStandard = new TfStandard();
        $dataSize = TfSize::orderBy('width', 'ASC')->select('*')->paginate(28);
        $accessObject = 'tool';
        return view('manage.content.sample.size.list', compact('modelStaff', 'modelStandard', 'modelSize', 'dataSize', 'accessObject'));
    }

    #view
    public function viewSize($sizeId)
    {
        if (!empty($sizeId)) {
            $dataSize = TfSize::find($sizeId);
            return view('manage.content.sample.size.view', compact('dataSize'));
        }
    }

    # filter
    public function getFilter($filterStandardId = '')
    {
        if (empty($filterStandardId)) { // all size
            return redirect()->route('tf.m.c.sample.size.list');
        } else {  // select an size
            $dataSize = TfSize::where('standard_id', $filterStandardId)->orderBy('width', 'ASC')->select('*')->paginate(20);
            return view('manage.content.sample.size.list', compact('dataSize', 'filterStandardId'));
        }
    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        $modelStandard = new TfStandard();
        $accessObject = 'tool';
        return view('manage.content.sample.size.add', compact('modelStandard', 'accessObject'));
    }

    # add new
    public function postAdd(Request $request)
    {
        $modelSize = new TfSize();
        $hFunction = new \Hfunction();
        $standardId = Request::input('cbStandard');
        $height = Request::input('cbHeight');
        $width = $standardId * 32;
        if ($modelSize->existSize($width, $height)) {
            Session::put('notifyAddSize', "Add fail, Size <b> '($width x $height)' </b> exists.");
        } else {
            if (Input::hasFile('txtImage')) {
                $file = Request::file('txtImage');
                $image_name = $file->getClientOriginalName();
                $imageName = $width . ' x ' . $height . '-' . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($image_name);
                $file->move('public/images/sample/size/icons/', $imageName);
                if ($modelSize->insert($width, $height, $imageName, $standardId)) {
                    Session::put('notifyAddSize', 'Add success, Enter info to continue');
                } else {
                    Session::put('notifyAddSize', 'Add fail, Enter info to try again');
                }
            } else {
                Session::put('notifyAddSize', 'Add fail, Enter info to try again');
            }

        }

    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($sizeId)
    {
        $dataSize = TfSize::find($sizeId);
        if (count($dataSize) > 0) {
            return view('manage.content.sample.size.edit', compact('dataSize'));
        }
    }

    # adit info
    public function postEdit($sizeId)
    {
        $modelSize = new TfSize();
        $hFunction = new \Hfunction();
        $width = Request::input('cbWidth');
        $height = Request::input('cbHeight');

        $oldImage = $modelSize->image($sizeId);

        if ($modelSize->existEditSize($width, $height, $sizeId)) {
            return "Add fail, Size <b>'($width x $height) '</b> exists.";
        }
        if (Input::hasFile('txtImage')) {
            $file = Request::file('txtImage');
            if (!empty($file)) {

                $image_name = $file->getClientOriginalName();
                $image_name = $width . ' x ' . $height . '-' . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($image_name);
                if ($file->move('public/images/sample/size/icons/', $image_name)) {
                    $oldSrc = "public/images/sample/size/icons/$oldImage";
                    if (File::exists($oldSrc)) {
                        File::delete($oldSrc);
                    }
                }
            }

        } else {
            $image_name = $oldImage;
        }
        $modelSize->updateInfo($sizeId, $width, $height, $image_name);
    }

    # update status
    public function statusUpdate($sizeId)
    {
        $modelSize = new TfSize();
        if (!empty($sizeId)) {
            $currentStatus = $modelSize->getInfo($sizeId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelSize->updateStatus($sizeId, $newStatus);
        }
    }

    # delete
    public function actionDelete($sizeId = null)
    {
        if (!empty($sizeId)) {
            $modelSize = new TfSize();
            $modelSize->actionDelete($sizeId);
        }
    }

}
