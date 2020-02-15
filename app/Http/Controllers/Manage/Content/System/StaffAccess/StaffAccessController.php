<?php namespace App\Http\Controllers\Manage\Content\System\StaffAccess;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\System\StaffAccess\TfStaffAccess;

use Illuminate\Http\Request;

class StaffAccessController extends Controller
{

    public function getList()
    {
        $modelStaff = new TfStaff();
        $modelStaffAccess = new TfStaffAccess();
        $dataStaffAccess = TfStaffAccess::orderBy('created_at', 'DESC')->select('*')->paginate(30);
        return view('manage.content.system.staff-access.list', compact('modelStaff', 'modelStaffAccess','dataStaffAccess'));
    }

}
