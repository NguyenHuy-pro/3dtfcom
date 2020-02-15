<?php namespace App\Http\Controllers\Manage\Build\Land;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\Map\Land\Transaction\TfLandTransaction;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\Map\RuleLandRank\TfRuleLandRank;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use App\Models\Manage\Content\Sample\Size\TfSize;
use DB;
use File;
use Request;

class LandController extends Controller
{
    # get form add
    public function getAddLand($projectId, $sizeId, $topPosition = '', $leftPosition = '')
    {
        $modelRuleLandRank = new TfRuleLandRank();
        $dataProject = TfProject::find($projectId);
        $dataSize = TfSize::find($sizeId);

        $projectRankId = $dataProject->getRankId();
        $dataLandRule = $modelRuleLandRank->infoOfSizeAndRank($dataSize->sizeId(), $projectRankId);
        $dataLandAdd = [
            'topPosition' => $topPosition,
            'leftPosition' => $leftPosition,
            'dataTransactionStatus' => TfTransactionStatus::whereIn('status_id', [1, 2])->select('status_id as optionKey', 'name as optionValue')->get()->toArray()
        ];
        return view('manage.build.map.land.land-add', compact('dataLandAdd', 'dataProject', 'dataSize', 'dataLandRule'));
    }

    # add new land
    public function postAddLand()
    {
        $modelLand = new TfLand();
        $modelLandTransaction = new TfLandTransaction();

        $projectId = Request::input('txtProject');
        $sizeId = Request::input('txtSize');
        $topPosition = Request::input('txtTopPosition');
        $leftPosition = Request::input('txtLeftPosition');
        $transactionStatus = Request::input('cbTransactionStatus');

        $dataProject = TfProject::find($projectId);
        $dataSize = TfSize::find($sizeId);
        $landHeight = $dataSize->height();
        $landWidth = $dataSize->width();

        # set position
        $topPosition = $topPosition - (int)($landHeight / 2);
        $leftPosition = $leftPosition - (int)($landWidth / 2);
        if (($topPosition + $landHeight) > 896) $topPosition = 896 - $landHeight;
        if ($topPosition < $landHeight) $topPosition = 0;
        if (($leftPosition + $landWidth) > 896) $left = 896 - $landWidth;
        if ($leftPosition < $landWidth) $leftPosition = 0;
        # set zindex
        $topZindex = (int)($topPosition + $landHeight);
        $leftZindex = (int)($leftPosition + $landWidth);

        # set  distance 16px
        $top = (int)($topPosition / 16) * 16;
        $left = (int)($leftPosition / 16) * 16;
        $beginZindex = 802817; //802816 + 1 zindex of public way // z index must be greater than the ways
        for ($y = 0; $y <= 896; $y++) {
            for ($x = 0; $x <= 896; $x++) {
                if ($y == $topZindex && $x == $leftZindex) $landZindex = $beginZindex; //moi block co zindex khac nhau
                $beginZindex = $beginZindex + 1;
            }
        }
        if ($modelLand->insert($top, $left, $landZindex, 0, $projectId, $sizeId)) {
            $newLandId = $modelLand->insertGetId();
            # add transaction for land

            $modelLandTransaction->insert( $newLandId, $transactionStatus);

            #access info of land
            $dataLand = TfLand::find($newLandId);
            $projectRankId = $dataProject->getRankId();
            $dataProjectInfoAccess = [
                'projectOwnStatus' => 1,
                'settingStatus' => true,
                'projectRankID' => $projectRankId,
            ];
            return view('manage.build.map.land.land', compact('dataLand', 'dataProjectInfoAccess'));
        }
    }

    # set new position for project
    public function setPosition($landId, $topPosition = '', $leftPosition = '', $zIndex = '')
    {
        $modelLand = new TfLand();
        #update position
        $modelLand->updatePosition($landId, $topPosition, $leftPosition, $zIndex);
    }

    # delete when setup (land does not publish)
    public function getSetupDelete($landId)
    {
        $modelLand = new TfLand();
        return $modelLand->setupDelete($landId);
    }
}
