<?php namespace App\Http\Controllers\Manage\Content\System\Warning;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\Warning\TfWarning;
//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class WarningController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelWarning = new TfWarning();
        $dataWarning = TfWarning::where('action', 1)->orderBy('name', 'ASC')->select('*')->paginate(30);
        $accessObject = 'content';
        return view('manage.content.system.warning.list', compact('modelStaff', 'modelWarning', 'dataWarning', 'accessObject'));
    }

    #view
    public function viewWarning($warningId)
    {
        if (!empty($warningId)) {
            $dataWarning = TfWarning::find($warningId);
            return view('manage.content.system.warning.view', compact('dataWarning'));
        }
    }

    #========== ========== ========== ADD NEW ========== ========== ==========
    # Get form add
    public function getAdd()
    {
        $accessObject = 'content';
        return view('manage.content.system.warning.add', compact('accessObject'));
    }

    # Add new
    public function postAdd()
    {
        $modelWarning = new TfWarning();
        $name = Request::input('txtName');

        // check exist of name
        if ($modelWarning->existName($name)) {
            Session::put('notifyAddWarning', "Add fail, Name <b> '$name' </b> exists.");
        } else {
            if ($modelWarning->insert($name)) {
                Session::put('notifyAddWarning', 'Add success, Enter info to continue');
            } else {
                Session::put('notifyAddWarning', 'Add fail, Enter info to try again');
            }
        }

    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # Get form edit
    public function getEdit($warningId)
    {
        $dataWarning = TfWarning::find($warningId);
        if (count($dataWarning)) {
            return view('manage.content.system.warning.edit', compact('dataWarning'));
        }
    }

    #edit warning
    public function postEdit($warningId)
    {
        $modelWarning = new TfWarning();
        $name = Request::input('txtName');

        // if exist name <> the type is editing
        if (($modelWarning->existEditName($name))) {
            return "Add fail, Name '$name' exists.";
        } else {
            $modelWarning->updateInfo($warningId, $name);
        }
    }

    # Delete an warning
    public function deleteWarning($warningId = '')
    {
        if (!empty($warningId)) {
            $modelWarning = new TfWarning();
            $modelWarning->actionDelete($warningId);
        }
    }

}
