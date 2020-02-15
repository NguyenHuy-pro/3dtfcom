<?php namespace App\Http\Controllers\User\Building;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class BuildingController extends Controller {

    #---------- ---------- Building ---------- ----------
    public function index($userId = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $dataUserLogin = $modelUser->loginUserInfo();
        if (empty($userId)) {
            $dataUser = $dataUserLogin;
        }else{
            $dataUser = TfUser::find($userId);
        }

        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'building'
            ];
            return view('user.building.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    # get more building
    public function moreBuilding($accessUserId = '', $skip = '', $take = '')
    {
        $modelUser = new TfUser();
        if (!empty($accessUserId)) {
            $dataUser = TfUser::find($accessUserId);
            $dataBuilding = $dataUser->buildingInfo($accessUserId, $skip, $take);
            return view('user.building.building-object',compact('modelUser', 'dataUser','dataBuilding','skip','take'));
        }
    }

}
