<?php namespace App\Http\Controllers\Manage\Content\User\Access;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Users\Access\TfUserAccess;
use Illuminate\Http\Request;

class UserAccessController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelUserAccess = new TfUserAccess();
        $dataUserAccess = TfUserAccess::orderBy('access_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'user';
        return view('manage.content.user.access.list', compact('modelStaff', 'modelUserAccess', 'dataUserAccess', 'accessObject'));
    }

    #View
    public function viewAccess($accessId)
    {
        $modelUserAccess = new TfUserAccess();
        $dataUserAccess = $modelUserAccess->getInfo($accessId);
        if (count($dataUserAccess)) {
            return view('manage.content.user.access.view', compact('dataUserAccess'));
        }
    }

}
