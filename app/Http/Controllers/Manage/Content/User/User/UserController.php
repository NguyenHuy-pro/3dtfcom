<?php namespace App\Http\Controllers\Manage\Content\User\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelUser = new TfUser();
        $dataUser = TfUser::where('action', 1)->orderBy('user_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'user';
        return view('manage.content.user.user.list', compact('modelStaff', 'modelUser', 'dataUser', 'accessObject'));
    }

    #update status
    public function updateStatus($userId)
    {
        $modelUser = new TfUser();
        $currentStatus = $modelUser->getInfo($userId, 'status');
        $newStatus = ($currentStatus == 0) ? 1 : 0;
        return $modelUser->updateStatus($userId, $newStatus);
    }

    #View
    public function viewUser($userId)
    {
        $modelProvince = new TfProvince();
        $modelUser = new TfUser();
        $dataUser = $modelUser->find($userId);
        if (count($dataUser)) {
            return view('manage.content.user.user.view', compact('modelProvince', 'dataUser'));
        }
    }

    #delete
    public function deleteUser($userId)
    {
        $modelUser = new TfUser();
        return $modelUser->getDelete($userId);
    }

}
