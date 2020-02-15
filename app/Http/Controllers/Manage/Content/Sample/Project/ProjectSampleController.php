<?php namespace App\Http\Controllers\Manage\Content\Sample\Project;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use App\Models\Manage\Content\Sample\Banner\TfBannerSample;
use App\Models\Manage\Content\Sample\LandIcon\TfLandIconSample;
use App\Models\Manage\Content\Sample\ProjectBackground\TfProjectBackground;
use App\Models\Manage\Content\Sample\ProjectSampleBanner\TfProjectSampleBanner;
use App\Models\Manage\Content\Sample\ProjectSampleLand\TfProjectSampleLand;
use App\Models\Manage\Content\Sample\ProjectSamplePublic\TfProjectSamplePublic;
use App\Models\Manage\Content\Sample\Publics\TfPublicSample;
use App\Models\Manage\Content\Sample\PublicType\TfPublicType;
use App\Models\Manage\Content\Sample\Size\TfSize;
use Illuminate\Support\Facades\Session;

use App\Models\Manage\Content\Sample\ProjectSample\TfProjectSample;
use App\Models\Manage\Content\System\Staff\TfStaff;
#use Illuminate\Http\Request;

use Request;
use Input, File;

class ProjectSampleController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    # get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelProjectSample = new TfProjectSample();
        $dataProjectSample = TfProjectSample::where('action', 1)->orderBy('project_id', 'ASC')->select('*')->paginate(30);
        $accessObject = 'project';
        return view('manage.content.sample.project.list', compact('modelStaff', 'modelProjectSample', 'dataProjectSample', 'accessObject'));
    }

    #view
    public function viewProject($projectId)
    {
        $modelStaff = new TfStaff();
        $modelLandIconSample = new TfLandIconSample();
        if (!empty($projectId)) {
            $dataProjectSample = TfProjectSample::find($projectId);
            if (count($dataProjectSample) > 0) {
                return view('manage.content.sample.project.view', compact('modelStaff', 'modelLandIconSample', 'dataProjectSample'));
            }

        }
    }

    #=========== ADD NEW ===========
    # get form add
    public function getAdd()
    {
        $modelStaff = new TfStaff();
        $dataStaffLogin = $modelStaff->loginStaffInfo();
        $listStaff = $dataStaffLogin->listStaffManage();
        $dataStaff = TfStaff::whereIn('staff_id', $listStaff)->select('staff_id as optionKey', 'account as optionValue')->get()->toArray();
        $accessObject = 'project';
        return view('manage.content.sample.project.add', compact('accessObject', 'dataStaff'));
    }

    # add new
    public function postAdd()
    {
        $modelProjectSample = new TfProjectSample();
        $hFunction = new \Hfunction();
        $staffId = Request::input('cbStaff');
        $description = Request::input('txtDescription');

        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            $imageName = $file->getClientOriginalName();
            $imageName = 'sample' . '-' . $hFunction->getTimeCode() . "." . $hFunction->getTypeImg($imageName);
            $pathFullImage = "public/images/sample/project-sample/full/";
            $pathSmallImage = "public/images/sample/project-sample/small/";
            if ($hFunction->uploadSave($file, $pathSmallImage, $pathFullImage, $imageName, 200)) {
                if ($modelProjectSample->insert($imageName, $staffId, $description)) {
                    Session::put('notifyAddProjectSample', 'Add success, Enter info to continue');
                } else {
                    Session::put('notifyAddProjectSample', 'Add fail, Enter info to try again');
                }
            } else {
                Session::put('notifyAddProjectSample', 'Add fail, Enter info to try again');
            }

        } else {
            Session::put('notifyAddProjectSample', 'Add fail, Enter info to try again');
        }

    }

    #===========  EDIT INFO ===========
    # get form edit
    public function getEdit($projectId)
    {
        $modelStaff = new TfStaff();
        $dataStaffLogin = $modelStaff->loginStaffInfo();
        $listStaff = $dataStaffLogin->listStaffManage();
        $dataStaff = TfStaff::whereIn('staff_id', $listStaff)->select('staff_id as optionKey', 'account as optionValue')->get()->toArray();
        $dataProjectSample = TfProjectSample::find($projectId);
        if (count($dataProjectSample) > 0) {
            return view('manage.content.sample.project.edit', compact('dataProjectSample', 'dataStaff'));
        }
    }

    # edit info
    public function postEdit($projectId)
    {
        $modelProjectSample = new TfProjectSample();
        $hFunction = new \Hfunction();
        $staffId = Request::input('cbStaff');
        $description = Request::input('txtDescription');

        $dataProjectSample = $modelProjectSample->findInfo($projectId);
        $oldImage = $dataProjectSample->image(); # old image
        if (Input::hasFile('fileImage')) {
            $file = Request::file('fileImage');
            if (!empty($file)) {
                $imageName = $file->getClientOriginalName();
                $imageName = 'sample' . $hFunction->getTimeCode() . '.' . $hFunction->getTypeImg($imageName);
                $pathFullImage = "public/images/sample/project-sample/full/";
                $pathSmallImage = "public/images/sample/project-sample/small/";
                if ($hFunction->uploadSave($file, $pathSmallImage, $pathFullImage, $imageName, 200)) {
                    $oldSmallSrc = "public/images/sample/project-sample/small/$oldImage";
                    $oldFullSrc = "public/images/sample/project-sample/full/$oldImage";
                    if (File::exists($oldFullSrc)) File::delete($oldFullSrc);
                    if (File::exists($oldSmallSrc)) File::delete($oldSmallSrc);
                }
            }

        } else {
            $imageName = $oldImage;
        }
        $dataProjectSample->updateInfo($imageName, $staffId, $description);
    }

    # update status
    public function statusUpdate($projectId)
    {
        if (!empty($projectId)) {
            $dataProjectSample = TfProjectSample::find($projectId);
            $currentStatus = $dataProjectSample->status();
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $dataProjectSample->updateStatus($newStatus);
        }
    }

    # delete
    public function deleteProject($projectId = null)
    {
        $modelProjectSample = new TfProjectSample();
        if (!empty($projectId)) {
            $dataProjectSample = $modelProjectSample->findInfo($projectId);
            $dataProjectSample->actionDelete();
        }
    }

    #===========  BUILD ===========
    #finish build
    public function  finishBuild($projectId)
    {
        $modelProjectSample = new TfProjectSample();
        $dataProjectSample = $modelProjectSample->findInfo($projectId);
        $dataProjectSample->finishBuild();
    }

    #===========  PUBLISH ===========
    public function publishYes($projectId)
    {
        $modelProjectSample = new TfProjectSample();
        $dataProjectSample = $modelProjectSample->findInfo($projectId);
        $dataProjectSample->publishAgree();
    }

    public function publishNo($projectId)
    {
        $modelProjectSample = new TfProjectSample();
        $dataProjectSample = $modelProjectSample->findInfo($projectId);
        $dataProjectSample->publishDisagree();
    }

    #------------- PUBLIC ------------
    public function buildProjectPublic($projectId, $typeId = null)
    {
        $modelProjectSample = new TfProjectSample();
        $modelStaff = new TfStaff();
        $modelPublicType = new TfPublicType();
        $modelPublicSample = new TfPublicSample();
        $accessObject = 'project';
        if (!empty($projectId)) {
            $dataProjectSample = $modelProjectSample->findInfo($projectId);
            $dataStaffLogin = $modelStaff->loginStaffInfo();

            if (empty($typeId)) $typeId = $modelPublicType->typeIdOfDefault();
            if (count($dataProjectSample) > 0) {
                $dataTool = [
                    'buildObject' => 'public',
                    'publicTypeId' => $typeId,
                    'dataPubicSample' => $modelPublicSample->publicTool($typeId)
                ];
                return view('manage.content.sample.project.build.build', compact('accessObject', 'dataProjectSample', 'dataStaffLogin', 'modelPublicType', 'dataTool'));
            }

        }
    }

    public function addPublic($projectId, $sampleId, $topPosition = '', $leftPosition = '')
    {
        $modelProjectSamplePublic = new TfProjectSamplePublic();
        $dataPublicSample = TfPublicSample::find($sampleId);

        $dataSize = $dataPublicSample->size;
        $publicHeight = $dataSize->height();
        $publicWidth = $dataSize->width();

        #set position
        $topPosition = $topPosition - (int)($publicHeight / 2);
        $leftPosition = $leftPosition - (int)($publicWidth / 2);
        if (($topPosition + $publicHeight) > 896) $topPosition = 896 - $publicHeight;
        if ($topPosition < $publicHeight) $topPosition = 0;
        if (($leftPosition + $publicWidth) > 896) $leftPosition = 896 - $publicWidth;
        if ($leftPosition < $publicWidth) $leftPosition = 0;
        # set zIndex
        $topZindex = (int)($topPosition + $publicHeight);
        $leftZindex = (int)($leftPosition + $publicWidth);
        # set  distance 16px
        $top = (int)($topPosition / 16) * 16;
        $left = (int)($leftPosition / 16) * 16;

        #create zindex
        if ($dataPublicSample->checkWay()) {
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
        if ($modelProjectSamplePublic->insert($top, $left, $publicZindex, $projectId, $sampleId)) {
            $newPublicId = $modelProjectSamplePublic->insertGetId();
            $dataProjectSamplePublic = TfProjectSamplePublic::find($newPublicId);
            if (!$dataProjectSamplePublic->projectSample->checkBuild($projectId)) {
                $dataProjectSamplePublic->projectSample->openBuild($projectId);
            }
            return view('manage.content.sample.project.public.public', compact('dataProjectSamplePublic'));
        }
    }

    public function setPositionPublic($publicId, $topPosition = '', $leftPosition = '', $zIndex = '')
    {
        $dataProjectSamplePublic = TfProjectSamplePublic::find($publicId);
        if (!$dataProjectSamplePublic->projectSample->checkBuild()) {
            $dataProjectSamplePublic->projectSample->openBuild();
        }
        $dataProjectSamplePublic->updatePosition($publicId, $topPosition, $leftPosition, $zIndex);
    }

    public function deletePublic($publicId)
    {
        $dataProjectSamplePublic = TfProjectSamplePublic::find($publicId);
        if (!$dataProjectSamplePublic->projectSample->checkBuild()) {
            $dataProjectSamplePublic->projectSample->openBuild();
        }
        $dataProjectSamplePublic->actionDrop();
    }

    #------------- BANNER -------------
    public function buildProjectBanner($projectId)
    {

        $modelStaff = new TfStaff();
        $modelPublicType = new TfPublicType();
        $modelBannerSample = new TfBannerSample();
        $accessObject = 'project';
        if (!empty($projectId)) {
            $dataProjectSample = TfProjectSample::find($projectId);
            $dataStaffLogin = $modelStaff->loginStaffInfo();

            if (count($dataProjectSample) > 0) {
                $dataTool = [
                    'buildObject' => 'banner',
                    'dataBannerSample' => $modelBannerSample->bannerTool()
                ];
                return view('manage.content.sample.project.build.build', compact('accessObject', 'dataProjectSample', 'dataStaffLogin', 'modelPublicType', 'dataTool'));
            }

        }
    }

    #get add
    public function getAddBanner($projectId, $sampleId, $topPosition = '', $leftPosition = '')
    {
        $dataProjectSample = TfProjectSample::find($projectId);
        $dataBannerSample = TfBannerSample::find($sampleId);
        $dataBannerAdd = [
            'topPosition' => $topPosition,
            'leftPosition' => $leftPosition,
            'dataTransactionStatus' => TfTransactionStatus::whereIn('status_id', [1, 2])->select('status_id as optionKey', 'name as optionValue')->get()->toArray()
        ];
        return view('manage.content.sample.project.banner.banner-add', compact('dataBannerAdd', 'dataProjectSample', 'dataBannerSample'));
    }

    # add new banner
    public function postAddBanner()
    {
        $modelProjectSampleBanner = new TfProjectSampleBanner();

        $projectId = Request::input('txtProject');
        $sampleId = Request::input('txtBannerSample');
        $topPosition = Request::input('txtTopPosition');
        $leftPosition = Request::input('txtLeftPosition');
        $transactionStatusId = Request::input('cbTransactionStatus');

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
        if ($modelProjectSampleBanner->insert($top, $left, $bannerZindex, $transactionStatusId, $projectId, $sampleId)) {
            $newBannerId = $modelProjectSampleBanner->insertGetId();

            #access info of banner
            $dataProjectSampleBanner = TfProjectSampleBanner::find($newBannerId);
            if (!$dataProjectSampleBanner->projectSample->checkBuild()) {
                $dataProjectSampleBanner->projectSample->openBuild();
            }
            return view('manage.content.sample.project.banner.banner', compact('dataProjectSampleBanner'));
        }
    }

    #move
    public function setPositionBanner($bannerId, $topPosition = '', $leftPosition = '', $zIndex = '')
    {
        $dataProjectSampleBanner = TfProjectSampleBanner::find($bannerId);
        if (!$dataProjectSampleBanner->projectSample->checkBuild()) {
            $dataProjectSampleBanner->projectSample->openBuild();
        }
        $dataProjectSampleBanner->updatePosition($bannerId, $topPosition, $leftPosition, $zIndex);
    }

    #delete
    public function deleteBanner($bannerId)
    {
        $dataProjectSampleBanner = TfProjectSampleBanner::find($bannerId);
        if (!$dataProjectSampleBanner->projectSample->checkBuild()) {
            $dataProjectSampleBanner->projectSample->openBuild();
        }
        $dataProjectSampleBanner->actionDrop();
    }

    #------------- LAND -------------
    public function buildProjectLand($projectId)
    {
        $modelStaff = new TfStaff();
        $modelPublicType = new TfPublicType();
        $modelSize = new TfSize();
        $accessObject = 'project';
        if (!empty($projectId)) {
            $dataProjectSample = TfProjectSample::find($projectId);
            $dataStaffLogin = $modelStaff->loginStaffInfo();

            if (count($dataProjectSample) > 0) {
                $dataTool = [
                    'buildObject' => 'land',
                    'dataSize' => $modelSize->sizeTool()
                ];
                return view('manage.content.sample.project.build.build', compact('accessObject', 'dataProjectSample', 'dataStaffLogin', 'modelPublicType', 'dataTool'));
            }

        }
    }

    public function getAddLand($projectId, $sizeId, $topPosition = '', $leftPosition = '')
    {
        $dataProjectSample = TfProjectSample::find($projectId);
        $dataSize = TfSize::find($sizeId);
        $dataLandAdd = [
            'topPosition' => $topPosition,
            'leftPosition' => $leftPosition,
            'dataTransactionStatus' => TfTransactionStatus::whereIn('status_id', [1, 2])->select('status_id as optionKey', 'name as optionValue')->get()->toArray()
        ];
        return view('manage.content.sample.project.land.land-add', compact('dataLandAdd', 'dataProjectSample', 'dataSize'));
    }

    public function postAddLand()
    {
        $modelLand = new TfProjectSampleLand();

        $projectId = Request::input('txtProject');
        $sizeId = Request::input('txtSize');
        $topPosition = Request::input('txtTopPosition');
        $leftPosition = Request::input('txtLeftPosition');
        $transactionStatusId = Request::input('cbTransactionStatus');

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
        if ($modelLand->insert($top, $left, $landZindex, $transactionStatusId, $projectId, $sizeId)) {
            $newLandId = $modelLand->insertGetId();
            # add transaction for land

            #access info of land
            $dataProjectSampleLand = TfProjectSampleLand::find($newLandId);
            if (!$dataProjectSampleLand->projectSample->checkBuild()) {
                $dataProjectSampleLand->projectSample->openBuild();
            }
            return view('manage.content.sample.project.land.land', compact('dataProjectSampleLand'));
        }
    }

    public function setPositionLand($landId, $topPosition = '', $leftPosition = '', $zIndex = '')
    {
        $dataProjectSampleLand = TfProjectSampleLand::find($landId);
        if (!$dataProjectSampleLand->projectSample->checkBuild()) {
            $dataProjectSampleLand->projectSample->openBuild();
        }
        $dataProjectSampleLand->updatePosition($landId, $topPosition, $leftPosition, $zIndex);
    }

    public function deleteLand($landId)
    {
        $dataProjectSampleLand = TfProjectSampleLand::find($landId);
        if (!$dataProjectSampleLand->projectSample->checkBuild()) {
            $dataProjectSampleLand->projectSample->openBuild();
        }
        $dataProjectSampleLand->actionDrop();
    }

    #----------- --------- BACKGROUND -------------
    public function buildProjectBackground($projectId = null)
    {
        $modelStaff = new TfStaff();
        $modelPublicType = new TfPublicType();
        $modelProjectBackground = new TfProjectBackground();
        $accessObject = 'project';
        if (!empty($projectId)) {
            $dataProjectSample = TfProjectSample::find($projectId);
            $dataStaffLogin = $modelStaff->loginStaffInfo();
            if (count($dataProjectSample) > 0) {
                $dataTool = [
                    'buildObject' => 'background',
                    'dataProjectBackground' => $modelProjectBackground->backgroundTool()
                ];
                return view('manage.content.sample.project.build.build', compact('accessObject', 'dataProjectSample', 'dataStaffLogin', 'modelPublicType', 'dataTool'));
            }

        }
    }

    #view
    public function viewBackground($backgroundId = null)
    {
        if (!empty($backgroundId)) {
            $dataProjectBackground = TfProjectBackground::find($backgroundId);
            if (count($dataProjectBackground) > 0) {
                return view('manage.content.sample.project.build.tool-background-view', compact('dataProjectBackground'));
            }
        }
    }

    public function addBackground($projectId = null, $backgroundId = null)
    {
        $dataProjectSample = TfProjectSample::find($projectId);
        if (!empty($projectId) && !empty($backgroundId)) {
            $dataProjectSample->updateBackground($backgroundId);
        }
    }

    public function dropBackground($projectId = null)
    {
        if (!empty($projectId)) {
            $dataProjectSample = TfProjectSample::find($projectId);
            $dataProjectSample->updateBackground(null);
        }
    }
}
