<?php namespace App\Models\Manage\Content\Map\Land;

use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Map\Land\License\TfLandLicense;
use App\Models\Manage\Content\Map\Land\Reserve\TfLandReserve;
use App\Models\Manage\Content\Map\Land\Share\TfLandShare;
use App\Models\Manage\Content\Map\Land\Transaction\TfLandTransaction;
use App\Models\Manage\Content\Map\RuleLandRank\TfRuleLandRank;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use App\Models\Manage\Content\Sample\LandIcon\TfLandIconSample;
use App\Models\Manage\Content\System\Province\TfProvince;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Database\Eloquent\Model;
use DB;

class TfLand extends Model
{

    protected $table = 'tf_lands';
    protected $fillable = ['land_id', 'name', 'topPosition', 'leftPosition', 'zindex', 'publish', 'status', 'action', 'created_at', 'project_id', 'size_id'];
    protected $primaryKey = 'land_id';
    #public $incrementing = false;
    public $timestamps = false;
    private $lastId;
    #========== =========== ========== INSERT && UPDATE ========= ========= =========
    #---------- Insert -----------
    public function insert($topPosition, $leftPosition, $zIndex, $publish, $projectId, $sizeId)
    {
        $hFunction = new \Hfunction();
        $modelLand = new TfLand();
        $name = 'LAND' . ($this->lastId() + 1);
        $modelLand->name = $name;
        $modelLand->topPosition = $topPosition;
        $modelLand->leftPosition = $leftPosition;
        $modelLand->zindex = $zIndex;
        $modelLand->publish = $publish;
        $modelLand->status = 1;
        $modelLand->action = 1;
        $modelLand->project_id = $projectId;
        $modelLand->size_id = $sizeId;
        $modelLand->created_at = $hFunction->createdAt();
        if ($modelLand->save()) {
            $this->lastId = $modelLand->land_id;
            return true;
        } else {
            return false;
        }

    }

    #get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- Update -----------
    # disable land  when publish invalid
    public function publishFailOfProject($projectId)
    {
        return TfLand::where('project_id', $projectId)->where('publish', 0)->update(['action' => 0, 'status' => 0]);
    }

    # enable land  when publish success
    public function publishSuccessOfProject($projectId)
    {
        return TfLand::where('project_id', $projectId)->where('status', 1)->where('action', 1)->where('publish', 0)->update(['publish' => 1]);
    }

    # position
    public function updatePosition($landId, $topPosition, $leftPosition, $zIndex = '')
    {
        return TfLand::where('land_id', $landId)->update(
            [
                'publish' => 0,
                'topPosition' => $topPosition,
                'leftPosition' => $leftPosition,
                'zindex' => $zIndex
            ]
        );
    }

    # status
    public function updateStatus($landId, $status)
    {
        return TfLand::where('land_id', $landId)->update(['action' => $status]);
    }

    # publish
    public function updatePublish($landId = null)
    {
        if (empty($landId)) $landId = $this->landId();
        return TfLand::where('land_id', $landId)->update(['publish' => 1]);
    }

    //delete
    public function actionDelete($landId = null)
    {
        $modelLandTransaction = new TfLandTransaction();
        $modelLandLicense = new TfLandLicense();
        $modelLandReserve = new TfLandReserve();
        $modelLandShare = new TfLandShare();

        if (empty($landId)) $landId = $this->landId();
        if (TfLand::where('land_id', $landId)->update(['action' => 0])) {
            #delete transaction
            $modelLandTransaction->actionDelete($landId);

            #delete share
            $modelLandShare->actionDeleteByLand($landId);

            #delete reserve
            $modelLandReserve->actionDeleteByLand($landId);

            #delete license
            $modelLandLicense->actionDeleteByLand($landId);

        }
    }

    # delete when setup (does not publish)
    public function setupDelete($landId = null)
    {
        if (empty($landId)) $landId = $this->landId();
        return TfLand::where('land_id', $landId)->delete();
    }

    #delete by project
    public function actionDeleteByProject($projectId = null)
    {
        if (!empty($projectId)) {
            $listId = TfLand::where(['project_id' => $projectId, 'action' => 1])->lists('land_id');
            if (!empty($listId)) {
                foreach ($listId as $value) {
                    $this->actionDelete($value);
                }
            }
        }
    }

    #========== =========== ========== RELATION ========= ========= =========
    # ---------- TF-USER ----------
    public function user()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Users\TfUser', 'App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'land_id', 'user_id');
    }

    # ---------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'project_id', 'project_id');
    }

    # ---------- TF-SIZE ----------
    public function size()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Size\TfSize', 'size_id', 'size_id');
    }

    # ---------- TF-BUILDING ----------
    public function building()
    {
        return $this->hasManyThrough('App\Models\Manage\Content\Building\TfBuilding', 'App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'land_id', 'license_id', 'land_id');
    }

    # ---------- TF-LAND-LICENSE ----------
    public function license()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'land_id', 'land_id');
    }

    # ---------- TF-LAND-TRANSACTION ----------
    public function landTransaction()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\Transaction\TfLandTransaction', 'land_id', 'land_id');
    }

    #---------- TF-LAND-RESERVE ----------
    public function landReserve()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\Reserve\TfLandReserve', 'land_id', 'land_id');
    }

    #---------- TF-LAND-SHARE ----------
    public function landShare()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\Share\TfLandShare', 'land_id', 'land_id');
    }

    #---------- TF-LAND-SHARE-VIEW ----------
    public function landShareView()
    {
        return $this->hasManyThrough('App\Models\Manage\Content\Map\Land\ShareView\TfLandShareView', 'App\Models\Manage\Content\Map\Land\Share\TfLandShare', 'land_id', 'share_id', 'land_id');
    }

    #---------- TF-TRANSACTION-STATUS ----------
    public function transactionStatus()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Map\Transaction\TfTransactionStatus', 'App\Models\Manage\Content\Map\Land\Transaction\TfLandTransaction', 'land_id', 'status_id');
    }

    #========== =========== ========== GET INFO ========= ========= =========
    public function getInfo($landId = null, $field = null)
    {
        if (empty($landId)) {
            return TfLand::where('action', 1)->get();
        } else {
            $result = TfLand::where(['land_id' => $landId, 'action' => 1])->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # ---------- TF-PROJECT ----------

    # get lands area using exist License
    public function landInfoOfProject($projectId)
    {
        return TfLand::where('action', 1)->where('project_id', $projectId)->get();
    }

    # ---------- TF-RULE ----------
    //rule info of a land
    public function ruleInfo($landId = null)
    {
        if (empty($landId)) $landId = $this->landId();
        $dataLand = TfLand::find($landId);
        $projectId = $dataLand->projectId();
        $sizeId = $dataLand->sizeId();
        $projectRankId = $dataLand->project->getRankId($projectId);
        return $this->ruleOfSizeAndRank($sizeId, $projectRankId);
    }

    //get rule info on size and rank of project
    public function ruleOfSizeAndRank($sizeId, $projectRankId)
    {
        $modelRuleLandRank = new TfRuleLandRank();
        return $modelRuleLandRank->infoOfSizeAndRank($sizeId, $projectRankId);
    }

    //price of land
    public function price($sizeId, $projectRankId)
    {
        $modelRuleLandRank = new TfRuleLandRank();
        return $modelRuleLandRank->salePrice($sizeId, $projectRankId);
    }

    //sale month
    public function saleMonth($sizeId, $projectRankId)
    {
        $modelRuleLandRank = new TfRuleLandRank();
        return $modelRuleLandRank->saleMonth($sizeId, $projectRankId);
    }

    //free month
    public function freeMonth($sizeId, $projectRankId)
    {
        $modelRuleLandRank = new TfRuleLandRank();
        return $modelRuleLandRank->freeMonth($sizeId, $projectRankId);
    }

    # ---------- TF-BUILDING ----------
    //only building is using of a land
    public function  buildingInfo($landId = null)
    {
        $modelBuilding = new TfBuilding();
        if (empty($landId)) $landId = $this->landId();
        return $modelBuilding->infoOfLand($landId);
    }

    # ---------- TF-LICENSE ----------
    //only get license is using of a land
    public function licenseInfo($landId = null)
    {
        $modelLandLicense = new TfLandLicense();
        if (empty($landId)) $landId = $this->landId();
        return $modelLandLicense->infoOfLand($landId);
    }

    //exist license
    public function existLicense($landId = null)
    {
        $modelLandLicense = new TfLandLicense();
        if (empty($landId)) $landId = $this->landId();
        return $modelLandLicense->checkExistLand($landId);
    }

    # ---------- TF-USER ----------
    //check land of user
    public function existLandOfUser($userId = null, $landId = null)
    {
        $modelLandLicense = new TfLandLicense();
        return $modelLandLicense->existLandOfUser($userId, $landId);
    }

    //get user if of land
    public function userId($landId = null)
    {
        $modelLandLicense = new TfLandLicense();
        if (empty($landId)) $landId = $this->landId();
        return $modelLandLicense->userIdOfLand($landId);
    }

    public function userInfo($landId = null)
    {
        return TfUser::find($this->userId($landId));
    }


    //get land info of user (get all)
    public function infoOfUser($userId = '', $skip = '', $take = '')
    {
        $modelLandLicense = new TfLandLicense();
        $listLandId = $modelLandLicense->listLandIdOfUser($userId);
        if (empty($skip) && empty($take)) {
            return TfLand::whereIn('land_id', $listLandId)->get();
        } else {
            return TfLand::whereIn('land_id', $listLandId)->skip($skip)->take($take)->get();
        }

    }
    # ---------- --------- TRANSACTION ---------- ----------

    //only get transaction is using of a land
    public function transactionInfo($landId = null)
    {
        $modelLandTransaction = new TfLandTransaction();
        if (empty($landId)) $landId = $this->landId();
        return $modelLandTransaction->infoOfLand($landId);
    }

    //only get transaction id is using of a land
    public function transactionStatusId($landId = null)
    {
        $modelLandTransaction = new TfLandTransaction();
        if (empty($landId)) $landId = $this->landId();
        return $modelLandTransaction->transactionStatusIdOfLand($landId);
    }

    //disable transaction of land
    public function transactionDisable($landId = null)
    {
        $modelLandTransaction = new TfLandTransaction();
        if (empty($landId)) $landId = $this->landId();
        return $modelLandTransaction->disableOfLand($landId);
    }

    # ---------- --------- LAND INFO ---------- ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfLand::where('land_id', $objectId)->pluck($column);
        }
    }

    public function landId()
    {
        return $this->land_id;
    }

    public function projectId($landId = null)
    {
        return $this->pluck('project_id', $landId);
    }

    public function name($landId = null)
    {
        return $this->pluck('name', $landId);
    }

    # top position
    public function topPosition($landId = null)
    {
        return $this->pluck('topPosition', $landId);
    }

    # left position
    public function leftPosition($landId = null)
    {
        return $this->pluck('leftPosition', $landId);
    }

    //z-index
    public function zIndex($landId = null)
    {
        return $this->pluck('zindex', $landId);
    }

    public function sizeId($landId = null)
    {
        return $this->pluck('size_id', $landId);
    }

    public function publish($landId = null)
    {
        return $this->pluck('publish', $landId);
    }

    public function status($landId = null)
    {
        return $this->pluck('status', $landId);
    }

    public function createdAt($landId = null)
    {
        return $this->pluck('created_at', $landId);
    }

    //last id
    public function lastId()
    {
        $result = TfLand::orderBy('land_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->land_id;
    }

    //total records
    public function totalRecords()
    {
        return TfLand::where('action', 1)->count();
    }

    //icon image
    public function icon($sizeId = '', $transactionStatusId = '', $ownStatus = '')
    {
        $modelLandIconSample = new TfLandIconSample();
        return $modelLandIconSample->imageOnSizeAndTransaction($sizeId, $transactionStatusId, $ownStatus);
    }

    public function pathIcon($icon)
    {
        $modelLandIconSample = new TfLandIconSample();
        return $modelLandIconSample->pathImage($icon);
    }

    public function pathIconDefault()
    {
        return asset('public/main/icons/icon_block.gif');
    }

    #============ ============ ========= CHECK INFO =========== ========= =========
    public function  checkPublished($landId=null)
    {
        return ($this->publish($landId) == 1) ? true : false;
    }

    public function existLand($landId)
    {
        $dataLand = TfLand::where(['land_id' => $landId, 'action' => 1])->count();
        return ($dataLand > 0) ? true : false;
    }

    //check sold
    public function checkSold($landId)
    {
        $modelLandLicense = new TfLandLicense();
        return $modelLandLicense->checkExistLand($landId);
    }

    //land of user
    public function checkLandOfUser($userId, $landId)
    {
        $modelLandLicense = new TfLandLicense();
        return $modelLandLicense->existLandOfUser($userId, $landId);
    }

    //check build status of land
    public function existBuilding($landId = null)
    {
        if (empty($landId)) $landId = $this->landId();
        $dataBuilding = $this->buildingInfo($landId);
        return (count($dataBuilding) > 0) ? true : false;
    }

    #========== ========== ========== GET INFO FOR MARKET ========== ========= =========
    //get land info follow transaction and province
    public function infoOfTransactionAndProvince($transactionStatusId = null, $provinceId = null)
    {
        if (!empty($transactionStatusId) && !empty($provinceId)) {
            $modelProvince = new TfProvince();
            $modelLandTransaction = new TfLandTransaction();
            $result = null;
            $listProjectId = $modelProvince->listProjectId($provinceId);
            $listLandOfTransaction = $modelLandTransaction->landIdOfTransactionStatus($transactionStatusId);
            /*
            $result = DB::table('tf_lands')->leftJoin('tf_land_transactions', 'tf_lands.land_id', '=', 'tf_land_transactions.land_id')
                ->whereIn('tf_lands.project_id', $listProjectId)
                ->where('tf_lands.publish', '=', 1)
                ->where('tf_lands.action', '=', 1)
                ->where('tf_land_transactions.transactionStatus_id', '=', $transactionStatusId)
                ->where('tf_land_transactions.action', '=', 1)
                ->select('*')->get();
            */
            $result = TfLand::whereIn('project_id', $listProjectId)->whereIn('land_id', $listLandOfTransaction)->where(['action' => 1, 'publish' => 1])->get();
            return $result;
        }
    }

    //get sale land info on a province
    public function infoSaleOfProvince($provinceId)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $transactionStatusId = $modelTransactionStatus->saleStatusId(); #sale
        return $this->infoOfTransactionAndProvince($transactionStatusId, $provinceId);
    }

    //get free land info on a province
    public function infoFreeOfProvince($provinceId)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $transactionStatusId = $modelTransactionStatus->freeStatusId(); #free
        return $this->infoOfTransactionAndProvince($transactionStatusId, $provinceId);
    }

    #========= ========== ============ load land HISTORY (front end)  =========== ========== ===========
    # check exist
    public function existMainLandAccess()
    {
        return (Session::has('dataMapHistoryLandAccess')) ? true : false;
    }

    # set history
    public function setMainLandAccess($landId)
    {
        return Session::put('dataMapHistoryLandAccess', $landId);
    }

    # get history
    public function getMainLandAccess()
    {
        return Session::get('dataMapHistoryLandAccess');
    }

    # destroy history
    public function forgetMainLandAccess()
    {
        return Session::forget('dataMapHistoryLandAccess');
    }


}
