<?php namespace App\Http\Controllers\User\Point\Recharge;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\Recharge\TfRecharge;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class RechargeController extends Controller
{

    public function index($userId = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        //$userId -> develop public show
        $dataUser = $modelUser->loginUserInfo();
        if (count($dataUser) > 0) {
            $dataAccess = [
                'accessObject' => 'point',
                'pointObject' => 'recharge',
            ];
            return view('user.point.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    # get more info
    public function getMoreRecharge($userId, $take, $dateTake)
    {
        $modelUser = new TfUser();
        $dataUser = $modelUser->getInfo($userId);
        $dataUserCard = $dataUser->userCard;
        $rechargeList = $dataUserCard->infoRecharge($dataUserCard->cardId(), $take, $dateTake);
        if (!empty($rechargeList)) {
            foreach ($rechargeList as $dataRecharge) {
                echo view('user.point.recharge.recharge-object', compact('dataRecharge', 'modelUser', 'dataUser'));
            }
        }
    }

    public function getDetail($rechargeId = null)
    {
        $modelRecharge = new TfRecharge();
        if (!empty($rechargeId)) {
            $dataRecharge = $modelRecharge->getInfo($rechargeId);
            if (!empty($dataRecharge)) {
                return view('user.point.recharge.recharge-view', compact('dataRecharge'));
            }
        }
    }
}
