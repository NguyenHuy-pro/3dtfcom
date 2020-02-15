<?php namespace App\Models\Manage\Content\Map\Project;

use App\Models\Manage\Content\Map\Banner\TfBanner;
use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\Map\Project\Build\TfProjectBuild;
use App\Models\Manage\Content\Map\Project\License\TfProjectLicense;
use App\Models\Manage\Content\Map\Project\Property\TfProjectProperty;
use App\Models\Manage\Content\Map\Publics\TfPublic;
use App\Models\Manage\Content\Map\Rank\TfRank;
use App\Models\Manage\Content\Map\Project\Rank\TfProjectRank;
use App\Models\Manage\Content\Map\Project\Icon\TfProjectIcon;
use App\Models\Manage\Content\Map\Project\Transaction\TfProjectTransaction;
use App\Models\Manage\Content\Sample\ProjectBackground\TfProjectBackground;
use App\Models\Manage\Content\Sample\ProjectIcon\TfProjectIconSample;
use Illuminate\Database\Eloquent\Model;
use DB;

class TfProject extends Model
{

    protected $table = 'tf_projects';
    protected $fillable = ['project_id', 'nameCode', 'name', 'shortDescription', 'description', 'pointValue', 'status', 'action', 'created_at', 'province_id', 'area_id', 'background_id'];
    protected $primaryKey = 'project_id';
    public $timestamps = false;

    private $lastId;

    #========== ============ =========== INSERT & UPDATE ========== ========== ==========
    #------------ Insert -----------
    public function insert($name, $shortDescription = null, $description = null, $pointValue, $provinceId, $areaId, $backgroundId = null)
    {
        $hFunction = new \Hfunction();
        $modelProject = new TfProject();
        $nameCode = "PROJECT" . ($this->lastId() + 1);# $hFunction->getTimeCode();
        $modelProject->nameCode = $nameCode;
        $modelProject->name = $name;
        $modelProject->shortDescription = $shortDescription;
        $modelProject->description = $description;
        $modelProject->pointValue = $pointValue;
        $modelProject->province_id = $provinceId;
        $modelProject->area_id = $areaId;
        $modelProject->background_id = $backgroundId;
        $modelProject->created_at = $hFunction->createdAt();
        if ($modelProject->save()) {
            $this->lastId = $modelProject->project_id;
            return true;
        } else {
            return false;
        }
    }

    # get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #------------ Update ------------
    public function editInfo($projectId, $name, $shortDescription, $description)
    {
        $modelProject = TfProject::find($projectId);
        $modelProject->name = $name;
        $modelProject->shortDescription = $shortDescription;
        $modelProject->description = $description;
        return $modelProject->save();
    }

    # point
    public function updatePoint($projectId, $pointValue)
    {
        return TfProject::where('project_id', $projectId)->update(['pointValue' => $pointValue]);
    }

    # background
    public function updateBackground($backgroundId, $projectId = null)
    {
        if (empty($projectId)) $projectId = $this->projectId();
        return TfProject::where('project_id', $projectId)->update(['background_id' => $backgroundId]);
    }

    # status
    public function updateStatus($projectId, $status)
    {
        return TfProject::where('project_id', $projectId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($projectId = null)
    {
        $modelProjectBuild = new TfProjectBuild();
        $modelProjectIcon = new TfProjectIcon();
        $modelProjectLicense = new TfProjectLicense();
        $modelProjectProperty = new TfProjectProperty();
        $modelProjectRank = new TfProjectRank();
        $modelProjectTransaction = new TfProjectTransaction();
        $modelBanner = new TfBanner();
        $modelLand = new TfLand();
        $modelPublic = new TfPublic();
        if (empty($projectId)) $projectId = $this->projectId();
        if (TfProject::where('project_id', $projectId)->update(['action' => 0, 'status' => 0])) {
            #delete transaction
            $modelProjectTransaction->actionDeleteByProject($projectId);

            #delete rank
            $modelProjectRank->actionDeleteByProject($projectId);

            #delete icon
            $modelProjectIcon->actionDeleteByProject($projectId);

            #table_project_build
            $modelProjectBuild->actionDeleteByProject($projectId);

            #delete license
            $modelProjectLicense->actionDeleteByProject($projectId);

            #delete property
            $modelProjectProperty->actionDeleteByProject($projectId);

            #delete banner
            $modelBanner->actionDeleteByProject($projectId);

            #delete land
            $modelLand->actionDeleteByProject($projectId);

            #delete public
            $modelPublic->actionDeleteByProject($projectId);
        }
    }

    #delete by project
    public function actionDeleteByProvince($provinceId = null)
    {
        if (!empty($provinceId)) {
            $listId = TfProject::where(['province_id' => $provinceId, 'action' => 1])->lists('project_id');
            if (!empty($listId)) {
                foreach ($listId as $value) {
                    $this->actionDelete($value);
                }
            }
        }
    }

    #========== ============ =========== RELATION ========== ========== ==========
    # ---------- TF-AREA ----------
    public function area()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Area\TfArea', 'area_id', 'area_id');
    }

    # ---------- TF-PROJECT-RANK -----------
    public function projectRank()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Rank\TfProjectRank', 'project_id', 'project_id');
    }

    # ---------- TF-PROJECT-ICON ----------
    public function projectIcon()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Icon\TfProjectIcon', 'project_id', 'project_id');
    }

    # --------- TF-PROJECT-ICON-SAMPLE ----------
    public function projectIconSample()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Sample\Project\TfProjectIconSample', 'App\Models\Manage\Content\Map\Project\Icon\TfProjectIcon', 'project_id', 'sample_id');
    }

    # ---------- TF-PROJECT-BUILD ----------
    public function projectBuild()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Build\TfProjectBuild', 'project_id', 'project_id');
    }

    # ---------- TF-BANNER -----------
    public function banner()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\TfBanner', 'project_id', 'project_id');
    }

    # --------- TF-BANNER-SAMPLE ----------
    public function bannerSample()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Sample\Banner\TfBannerSample', 'App\Models\Manage\Content\Map\Banner\TfBanner', 'project_id', 'sample_id');
    }

    # ---------- TF-LAND ----------
    public function land()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\TfLand', 'project_id', 'project_id');
    }

    # ---------- TF-PUBLIC ---------
    public function publics()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Publics\TfPublic', 'project_id', 'project_id');
    }

    # --------- TF-PUBLIC-SAMPLE ----------
    public function publicSample()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Sample\Publics\TfPublicSample', 'App\Models\Manage\Content\Map\Publics\TfPublic', 'project_id', 'sample_id');
    }

    # ----------- TF-PROJECT-TRANSACTION -----------
    public function transaction()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Transaction\TfProjectTransaction', 'project_id', 'project_id');
    }

    # ----------- TF-PROJECT-LICENSE -----------
    public function projectLicense()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\License\TfProjectLicense', 'project_id', 'project_id');
    }

    # ----------- TF-PROJECT-PROPERTY -----------
    public function projectProperty()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Property\TfProjectProperty', 'project_id', 'project_id');
    }

    # ------------ TF-PROJECT-EXCHANGE ------------
    public function projectExchange()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Transaction\TfProjectExchange', 'project_id', 'project_id');
    }

    # ---------- TF-PROJECT-VISIT ----------
    public function projectVisit()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Visit\TfProjectVisit', 'project_id', 'project_id');
    }

    # ------------ TF-PROVINCE -----------
    public function province()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Province\TfProvince', 'province_id', 'province_id');
    }

    # ---------- TF-PROJECT-BACKGROUND ----------
    public function projectBackground()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\ProjectBackground', 'background_id', 'background_id');
    }

    #========== ============ =========== GET INFO ========== ========== ==========
    public function getInfo($projectId = '', $field = '')
    {
        if (empty($projectId)) {
            return TfProject::where('action', 1)->get();
        } else {
            $result = TfProject::where('project_id', $projectId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfProject::where('action', 1)->select('project_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    # get all info is active
    public function getInfoIsAction()
    {
        return TfProject::where('action', 1)->get();
    }

    # ---------- TF-PROJECT-BACKGROUND ----------
    public function pathImageBackground($defaultStatus = true, $projectId = null)
    {
        $backgroundId = $this->backgroundId($projectId);
        if (!empty($backgroundId)) {
            $dataProjectBackground = TfProjectBackground::find($backgroundId);
            return $dataProjectBackground->pathFullImage();
        } else {
            if ($defaultStatus) {
                return $this->pathImageBackgroundDefault();
            } else {
                return null;
            }
        }
    }

    public function pathImageBackgroundDefault()
    {
        return asset('public/main/icons/background_3d.png');
    }
    # ------------ TF-PROJECT-PROPERTY ---------
    #property info of project
    public function propertyInfo($projectId = null)
    {
        $modelProjectProperty = new TfProjectProperty();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelProjectProperty->infoOfProject($projectId);
    }

    # ------------ TF-PROVINCE -----------
    #get project info of province
    public function infoOfProvince($provinceId)
    {
        return TfProject::where('province_id', $provinceId)->where('action', 1)->get();
    }

    #get list project id of province
    public function listIdOfProvince($provinceId)
    {
        return TfProject::where('province_id', $provinceId)->where('action', 1)->lists('project_id');
    }

    # ---------- ---------- TF-PROVINCE - AREA --------- ---------
    # get project info of province and area (only info is using)
    public function infoOfProvinceAndArea($provinceId, $areaId)
    {
        return TfProject::where('area_id', $areaId)->where('province_id', $provinceId)->where('action', 1)->first();
    }

    # check exist project
    public function existProjectOfProvinceAndArea($provinceId, $areaId)
    {
        $result = TfProject::where('area_id', $areaId)->where('province_id', $provinceId)->where('action', 1)->count();
        return ($result > 0) ? true : false;
    }

    # ---------- TF-PROJECT-ICON ----------
    # get icon info of project (get only one icon is using)
    public function iconInfo($projectId = null)
    {
        $modelProjectIcon = new TfProjectIcon();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelProjectIcon->iconInfoOfProject($projectId);
    }

    # path icon image
    public function pathIconImage($projectId = null)
    {
        $modelProjectIconSample = new TfProjectIconSample();
        if (empty($projectId)) $projectId = $this->projectId();
        $dataIcon = $this->iconInfo($projectId);
        return $modelProjectIconSample->pathImage($modelProjectIconSample->image($dataIcon->sample_id));
    }

    # ---------- TF-BANNER -----------
    # only banners are using (front end)
    public function bannerInfo($projectId = null)
    {
        $modelBanner = new TfBanner();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelBanner->bannerInfoOfProject($projectId);
    }

    # only banners are using (back end)
    public function bannerInfoOnBuild($projectId = null)
    {
        $modelBanner = new TfBanner();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelBanner->bannerInfoOfProjectOnBuild($projectId);
    }

    # ---------- TF-LAND ----------
    # only lands area using
    public function landInfo($projectId = null)
    {
        $modelLand = new TfLand();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelLand->landInfoOfProject($projectId);
    }

    # ---------- TF-PUBLIC ---------
    # only public are using
    public function publicInfo($projectId = null)
    {
        $modelPublic = new TfPublic();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelPublic->infoOfProject($projectId);

    }

    # ----------- TF-PROJECT BUILD -----------
    # publish project info (only get publish info enable)
    public function infoProjectBuild($projectId = null)
    {
        $modelProjectBuild = new TfProjectBuild();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelProjectBuild->infoOfProject($projectId);
    }

    # publish project
    public function opening($projectId = null)
    {
        $modelProjectBuild = new TfProjectBuild();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelProjectBuild->checkOpeningOfProject($projectId);
    }

    #opening icon of project
    public function pathImageOpening()
    {
        return asset('public/main/icons/projectPublish.png');
    }

    # ----------- TF-PROJECT-TRANSACTION -----------
    # only get transaction info is using of project
    public function transactionInfo($projectId = null)
    {
        $modelProjectTransaction = new TfProjectTransaction();
        if (empty($projectId)) $projectId = $this->project_id;
        return $modelProjectTransaction->transactionInfoOfProject($projectId);
    }

    # ----------- TF-PROJECT-LICENSE -----------
    # only get info is using of project
    public function licenseInfo($projectId = null)
    {
        $modelProjectLicense = new TfProjectLicense();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelProjectLicense->infoOfProject($projectId);
    }

    # exist license
    public function existLicense($projectId = null)
    {
        $modelProjectLicense = new TfProjectLicense();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelProjectLicense->checkExistProject($projectId);
    }

    # ---------- TF-PROJECT-RANK -----------
    public function getRankId($projectId = null)
    {
        if (empty($projectId)) $projectId = $this->projectId();
        return TfProjectRank::where('project_id', $projectId)->where('action', 1)->pluck('rank_id');
    }

    public function getRankValue($projectId = null)
    {
        $modelRank = new TfRank();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelRank->rankValue($this->getRankId($projectId));
    }

    # ---------- PROJECT INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProject::where('project_id', $objectId)->pluck($column);
        }
    }

    public function projectId()
    {
        return $this->project_id;
    }

    public function nameCode($projectId = null)
    {
        return $this->pluck('nameCode', $projectId);
    }

    public function name($projectId = null)
    {
        return $this->pluck('name', $projectId);
    }

    public function shortDescription($projectId = null)
    {
        return $this->pluck('shortDescription', $projectId);
    }

    public function description($projectId = null)
    {
        return $this->pluck('description', $projectId);
    }

    public function pointValue($projectId = null)
    {
        return $this->pluck('pointValue', $projectId);
    }

    # only get province id of project
    public function provinceId($projectId = null)
    {
        return $this->pluck('province_id', $projectId);
    }

    public function areaId($projectId = null)
    {
        return $this->pluck('area_id', $projectId);
    }

    public function backgroundId($projectId = null)
    {
        return $this->pluck('background_id', $projectId);
    }

    public function status($projectId = null)
    {
        return $this->pluck('status', $projectId);
    }

    public function createdAt($projectId = null)
    {
        return $this->pluck('created_at', $projectId);
    }

    # last id
    public function lastId()
    {
        $result = TfProject::orderBy('project_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->project_id;
    }

    #total project
    public function totalRecords()
    {
        return TfProject::where('action', 1)->count();
    }

    # ========== ========= ========= CHECK INFO =========== ========= =========
    # check project login
    public function checkProjectLogin($provinceLoginId, $areaLoginId, $projectId)
    {
        $result = TfProject::where('province_id', $provinceLoginId)->where('area_id', $areaLoginId)->where('project_id', $projectId)->count();
        return ($result > 0) ? true : false;
    }

    # check exist name ( add new)
    public function existName($name)
    {
        $result = TfProject::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    # check exist name ( edit info)
    public function existEditName($name, $projectId)
    {
        $result = TfProject::where('name', $name)->where('project_id', '<>', $projectId)->count();
        return ($result > 0) ? true : false;
    }

    public function checkManager($staffId, $projectId = null)
    {
        $modelProperty = new TfProjectProperty();
        if (empty($projectId)) $projectId = $this->projectId();
        return $modelProperty->checkStaffManageProject($staffId, $projectId);
    }

    #projects published recently
    public function recentProjectPublished($take = null)
    {
        $modelProjectBuild = new TfProjectBuild();
        $projectList = $modelProjectBuild->recentProjectList();
        if (empty($take)) {
            return TfProject::whereIn('project_id', $projectList)->where('action', 1)->get();
        } else {
            return TfProject::whereIn('project_id', $projectList)->where('action', 1)->skip(0)->take($take)->get();
        }
    }

}
