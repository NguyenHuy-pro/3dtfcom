<?php namespace App\Http\Controllers\User\Follow;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class FollowController extends Controller
{

    public function index($userId = '')
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        if (empty($userId)) {
            $dataUser = $modelUser->loginUserInfo();
        }else{
            $dataUser = TfUser::find($userId);
        }
        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'follow',
            ];
            return view('user.follow.index', compact('modelAbout', 'modelUser','dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    #get more
    public function getMoreFollow($userId, $take, $dateTake)
    {
        $modelUser = new TfUser();
        $resultImage = $modelUser->buildingFollowOfUser($userId, $take, $dateTake);
        if (count($resultImage) > 0) {
            $dataUser = TfUser::find($userId);
            foreach ($resultImage as $dataBuildingFollow) {
                echo view('user.follow.follow-object',compact('modelUser', 'dataUser','dataBuildingFollow'));
            }
        }

    }

}
