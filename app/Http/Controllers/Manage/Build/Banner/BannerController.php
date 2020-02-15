<?php namespace App\Http\Controllers\Manage\Build\Banner;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\Banner\TfBanner;
use App\Models\Manage\Content\Map\Banner\Transaction\TfBannerTransaction;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\Map\RuleBannerRank\TfRuleBannerRank;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use App\Models\Manage\Content\Sample\Banner\TfBannerSample;

use DB;
use File;
use Request;

class BannerController extends Controller
{

    # =========== ========== ========== Add =========== ========== ==========
    # get form add
    public function getAddBanner($projectId, $sampleId, $topPosition = '', $leftPosition = '')
    {
        $modelRuleBannerRank = new TfRuleBannerRank();
        $dataProject = TfProject::find($projectId);
        $dataBannerSample = TfBannerSample::find($sampleId);

        $sizeId = $dataBannerSample->sizeId();
        $projectRankId = $dataProject->getRankId();
        $dataBannerRule = $modelRuleBannerRank->infoOfSizeAndRank($sizeId, $projectRankId);
        $dataBannerAdd = [
            'topPosition' => $topPosition,
            'leftPosition' => $leftPosition,
            'dataTransactionStatus' => TfTransactionStatus::whereIn('status_id', [1, 2])->select('status_id as optionKey', 'name as optionValue')->get()->toArray()
        ];
        return view('manage.build.map.banner.banner-add', compact('dataBannerAdd', 'dataProject', 'dataBannerSample', 'dataBannerRule'));
    }

    # add new banner
    public function postAddBanner()
    {
        $modelBanner = new TfBanner();
        $modelBannerTransaction = new TfBannerTransaction();

        $projectId = Request::input('txtProject');
        $sampleId = Request::input('txtBannerSample');
        $topPosition = Request::input('txtTopPosition');
        $leftPosition = Request::input('txtLeftPosition');
        $transactionStatus = Request::input('cbTransactionStatus');

        $dataProject = TfProject::find($projectId);
        $dataBannerSample = TfBannerSample::find($sampleId);

        $dataSize = $dataBannerSample->size;
        $bannerHeight = $dataSize->height();
        $bannerWidth = $dataSize->width();

        # set position
        $topPosition = $topPosition - (int)($bannerHeight / 2);
        $leftPosition = $leftPosition - (int)($bannerWidth / 2);
        if (($topPosition + $bannerHeight) > 896) $topPosition = 896 - $bannerHeight;
        if ($topPosition < $bannerHeight) $topPosition = 0;
        if (($leftPosition + $bannerWidth) > 896) $left = 896 - $bannerWidth;
        if ($leftPosition < $bannerWidth) $leftPosition = 0;
        # set zindex
        $topZindex = (int)($topPosition + $bannerHeight);
        $leftZindex = (int)($leftPosition + $bannerWidth);
        # set  distance 16px
        $top = (int)($topPosition / 16) * 16;
        $left = (int)($leftPosition / 16) * 16;
        $beginZindex = 802817; //802816 + 1 zindex of public way // z index must be greater than the ways
        for ($y = 0; $y <= 896; $y++) {
            for ($x = 0; $x <= 896; $x++) {
                if ($y == $topZindex && $x == $leftZindex) $bannerZindex = $beginZindex; //moi block co zindex khac nhau
                $beginZindex = $beginZindex + 1;
            }
        }
        if ($modelBanner->insert($top, $left, $bannerZindex, 0, 0, $projectId, $sampleId)) {
            $newBannerId = $modelBanner->insertGetId();

            #add banner transaction
            $modelBannerTransaction->insert($newBannerId, $transactionStatus);

            #access info of banner
            $dataBanner = TfBanner::find($newBannerId);
            $projectRankId = $dataProject->getRankId();
            $dataProjectInfoAccess = [
                'projectOwnStatus' => 1,
                'settingStatus' => true,
                'projectRankID' => $projectRankId,
            ];
            return view('manage.build.map.banner.banner', compact('dataBanner', 'dataProjectInfoAccess'));
        }
    }

    # set new position of banner
    public function setPosition($bannerId, $topPosition, $leftPosition, $zIndex)
    {
        $modelBanner = new TfBanner();
        $modelBanner->updatePosition($bannerId, $topPosition, $leftPosition, $zIndex);

    }

# delete when setup (land does not publish)
    public function getSetupDelete($bannerId)
    {
        $modelBanner = new TfBanner();
        return $modelBanner->setupDelete($bannerId);
    }

}
