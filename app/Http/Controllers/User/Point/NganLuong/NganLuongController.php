<?php namespace App\Http\Controllers\User\Point\NganLuong;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\Users\NganLuongOrder\TfNganLuongOrder;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class NganLuongController extends Controller
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
                'pointObject' => 'nganluong',
            ];
            return view('user.point.index', compact('modelAbout', 'modelUser', 'dataUser', 'dataAccess'));

        } else {
            return redirect()->route('tf.home');
        }
    }

    # get more info
    public function getMoreNganLuong($userId, $take, $dateTake)
    {
        $modelUser = new TfUser();
        $dataUser = $modelUser->getInfo($userId);
        $dataUserCard = $dataUser->userCard;
        $orderList = $dataUserCard->infoNganLuongOrder($dataUserCard->cardId(), $take, $dateTake);
        if (!empty($orderList)) {
            foreach ($orderList as $dataNganLuongOrder) {
                echo view('user.point.nganluong.nganluong-object', compact('modelUser', 'dataUser', 'dataNganLuongOrder'));
            }
        }
    }

    public function getDetail($orderId = null)
    {
        $modelNganLuong = new TfNganLuongOrder();
        if (!empty($orderId)) {
            $dataNganLuongOrder = $modelNganLuong->findInfo($orderId);
            if (!empty($dataNganLuongOrder)) {
                return view('user.point.nganluong.nganluong-view', compact('dataNganLuongOrder'));
            }
        }
    }

}
