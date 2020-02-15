<?php namespace App\Http\Controllers\Manage\Content\System\Bank;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\Bank\TfBank;
use Input;
use File;
use DB;
use Request;

class BankController extends Controller
{
    #========== ========== ========== GET INFO ========== ========== ==========
    # get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelBank = new TfBank();
        $accessObject = 'exchange';
        $dataBank = TfBank::orderBy('name', 'ASC')->select('*')->paginate(10);
        return view('manage.content.system.bank.list', compact('modelStaff', 'modelBank', 'dataBank', 'accessObject'));
    }

    #view
    public function viewBank($bankId)
    {
        $dataBank = TfBank::find($bankId);
        if (count($dataBank)) {
            return view('manage.content.system.bank.view', compact('dataBank'));
        }
    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    # get form add
    public function getAdd()
    {
        $accessObject = 'exchange';
        return view('manage.content.system.bank.add', compact('accessObject'));
    }

    # add new
    public function postAdd()
    {
        $modelBank = new TfBank();
        $hFunction = new \Hfunction();
        $name = Request::input('txtName');
        if ($modelBank->existName($name)) {
            Session::put('notifyAddBank', "Add fail, Name <b> '$name' </b> exists.");
        } else {
            if (Input::hasFile('txtImage')) {
                $file = Request::file('txtImage');
                $image_name = $file->getClientOriginalName();
                $image_name = $name . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($image_name);
                $file->move('public/images/system/bank/logo/', $image_name);
                if ($modelBank->insert($name, $image_name)) {
                    Session::put('notifyAddBank', 'Add success, Enter info to continue');
                } else {
                    Session::put('notifyAddBank', 'Add fail, Enter info to try again');
                }
            } else {
                Session::put('notifyAddBank', 'Add fail, Enter info to try again');
            }
        }
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # get form edit
    public function getEdit($bankId = null)
    {
        $dataBank = TfBank::find($bankId);
        if (count($dataBank)) {
            return view('manage.content.system.bank.edit', compact('dataBank'));
        }
    }

    # edit info
    public function postEdit($bankId)
    {
        $modelBank = new TfBank();
        $hFunction = new \Hfunction();
        $name = Request::input('txtName');

        $oldImage = $modelBank->image($bankId);
        // if exist name <> the country is editing
        if ($modelBank->existEditName($bankId, $name)) {
            return "Add fail, Name '$name' exists.";
        } else {
            if (Input::hasFile('txtImage')) {
                $file = Request::file('txtImage');
                if (!empty($file)) {
                    $image_name = $file->getClientOriginalName();
                    $image_name = $name . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($image_name);
                    if ($file->move('public/images/system/bank/logo/', $image_name)) {
                        $oldSrc = "public/images/system/bank/logo/$oldImage";
                        if (File::exists($oldSrc)) {
                            File::delete($oldSrc);
                        }
                    }
                } else {
                    $image_name = $oldImage;
                }

            } else {
                $image_name = $oldImage;
            }
            $modelBank->updateInfo($bankId, $name, $image_name);
        }

    }

    # update status
    public function statusUpdate($bankId)
    {
        $modelBank = new TfBank();
        if (!empty($bankId)) {
            $currentStatus = $modelBank->getInfo($bankId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelBank->updateStatus($bankId, $newStatus);
        }
    }

    # delete
    public function deleteBank($bankId = '')
    {
        if (!empty($bankId)) {
            $modelBank = new TfBank();
            $modelBank->actionDelete($bankId);
        }
    }

}
