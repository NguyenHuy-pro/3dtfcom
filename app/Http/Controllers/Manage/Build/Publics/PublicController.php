<?php namespace App\Http\Controllers\Manage\Build\Publics;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\Map\Publics\TfPublic;

use App\Models\Manage\Content\Sample\Publics\TfPublicSample;
use Illuminate\Http\Request;

class PublicController extends Controller
{

    # add new public
    public function getAddPublic($projectId, $sampleId, $topPosition = '', $leftPosition = '')
    {
        $modelPublic = new TfPublic();

        $dataProject = TfProject::find($projectId);
        $dataPublicSample = TfPublicSample::find($sampleId);

        $publicType = $dataPublicSample->typeId();
        $dataSize = $dataPublicSample->size;
        $bannerHeight = $dataSize->height();
        $bannerWidth = $dataSize->width();

        #set position
        $topPosition = $topPosition - (int)($bannerHeight / 2);
        $leftPosition = $leftPosition - (int)($bannerWidth / 2);
        if (($topPosition + $bannerHeight) > 896) $topPosition = 896 - $bannerHeight;
        if ($topPosition < $bannerHeight) $topPosition = 0;
        if (($leftPosition + $bannerWidth) > 896) $left = 896 - $bannerWidth;
        if ($leftPosition < $bannerWidth) $leftPosition = 0;
        # set zIndex
        $topZindex = $topPosition + $bannerHeight;
        $leftZindex = $leftPosition + $bannerWidth;
        # set  distance 16px
        $top = (int)($topPosition / 16) * 16;
        $left = (int)($leftPosition / 16) * 16;

        #create zindex
        if ($publicType == 1) {
            //zIndex of ways
            $beginZindex = 1;
        } else { //do not ways
            $beginZindex = 802817;
        }
        for ($y = 0; $y <= 896; $y++) {
            for ($x = 0; $x <= 896; $x++) {
                if ($y == $topZindex && $x == $leftZindex) $publicZindex = $beginZindex; //moi public co zindex khac nhau
                $beginZindex = $beginZindex + 1;
            }
        }
        if ($modelPublic->insert($top, $left, $publicZindex, 1, $projectId, $sampleId)) {
            $newPublicId = $modelPublic->insertGetId();

            $dataPublic = TfPublic::find($newPublicId);
            $projectRankId = $dataProject->getRankId();
            $dataProjectInfoAccess = [
                'projectOwnStatus' => 1,
                'settingStatus' => true,
                'projectRankID' => $projectRankId,
            ];
            return view('manage.build.map.publics.public', compact('dataPublic', 'dataProjectInfoAccess'));
        }
    }

    # set new position for project
    public function setPosition($publicId, $topPosition = '', $leftPosition = '', $zIndex = '')
    {
        $modelPublic = new TfPublic();
        $modelPublic->updatePosition($publicId, $topPosition, $leftPosition, $zIndex);
    }

    # delete when setup (land does not publish)
    public function getSetupDelete($publicId)
    {
        $modelPublic = new TfPublic();
        return $modelPublic->setupDelete($publicId);
    }

}
