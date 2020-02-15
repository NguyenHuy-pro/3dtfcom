<?php namespace App\Http\Controllers\Point;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\About\TfAbout;
use App\Models\Manage\Content\System\PointTransaction\TfPointTransaction;
use App\Models\Manage\Content\System\PointType\TfPointType;
use App\Models\Manage\Content\Users\TfUser;
#use Illuminate\Http\Request;
use Request;
use File, Input;

class PointController extends Controller
{
    public function getDirect()
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        if ($modelUser->checkLogin()) {
            $dataPointAccess = [
                'object' => 'direct'
            ];
            return view('point.direct.index', compact('modelAbout', 'modelUser', 'dataPointAccess'));
        } else {
            return redirect()->route('tf.home');
        }
    }

    #========== ========== Buy ========== ==========
    public function getPackage($point = null)
    {
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        $modelPointType = new TfPointType();
        $modelPointTransaction = new TfPointTransaction();
        if ($modelUser->checkLogin()) {
            $typeId = $modelPointType->normalTypeInfo()->typeId();
            $dataPointTransaction = $modelPointTransaction->infoOfPointType($typeId);
            $dataPointAccess = [
                'object' => 'online',
                'package' => $point
            ];
            return view('point.online.select-package', compact('modelAbout', 'modelUser', 'dataPointAccess', 'dataPointTransaction'));
        } else {
            return redirect()->route('tf.home');
        }

    }

    public function getWallet($point = null, $wallet = null)
    {
        $hFunction = new \Hfunction();
        $modelAbout = new TfAbout();
        $modelUser = new TfUser();
        if ($modelUser->checkLogin()) {
            if (empty($point) && empty($wallet)) {
                $point = Request::input('txtPoint');
            }


            $orderCode = 'NL' . $hFunction->getTimeCode();
            $dataPointAccess = [
                'object' => 'online',
                'package' => $point,
                'orderCode' => $orderCode,
                'wallet' => $wallet
            ];
            return view('point.online.wallet.select-wallet', compact('modelAbout', 'modelUser', 'dataPointAccess'));
        } else {
            return redirect()->route('tf.home');
        }

    }


}
