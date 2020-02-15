<?php namespace App\Models\Manage\Content\Map\Banner;

use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use App\Models\Manage\Content\Map\Banner\License\TfBannerLicense;
use App\Models\Manage\Content\Map\Banner\Reserve\TfBannerReserve;
use App\Models\Manage\Content\Map\Banner\Share\TfBannerShare;
use App\Models\Manage\Content\Map\Banner\Transaction\TfBannerTransaction;
use App\Models\Manage\Content\Map\Project\TfProject;

use App\Models\Manage\Content\Map\RuleBannerRank\TfRuleBannerRank;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use App\Models\Manage\Content\Sample\Banner\TfBannerSample;
use App\Models\Manage\Content\System\Province\TfProvince;
use Illuminate\Database\Eloquent\Model;
use DB;

class TfBanner extends Model
{

    protected $table = 'tf_banners';
    protected $fillable = ['banner_id', 'name', 'topPosition', 'leftPosition', 'zindex', 'pointValue', 'publish', 'status', 'action', 'created_at', 'project_id', 'sample_id'];
    protected $primaryKey = 'banner_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========= ========= INSERT && UPDATE ========= ========= =========
    #------------ Insert ------------
    public function insert($topPosition, $leftPosition, $zIndex, $pointValue = null, $publish = null, $projectId, $sampleId)
    {
        $hFunction = new \Hfunction();
        $modelBanner = new TfBanner();
        $modelBanner->name = 'BANNER-' . ($this->lastId() + 1);
        $modelBanner->topPosition = $topPosition;
        $modelBanner->leftPosition = $leftPosition;
        $modelBanner->zindex = $zIndex;
        $modelBanner->pointValue = $pointValue;
        $modelBanner->publish = $publish;
        $modelBanner->project_id = $projectId;
        $modelBanner->sample_id = $sampleId;
        $modelBanner->created_at = $hFunction->carbonNow();
        if ($modelBanner->save()) {
            $this->lastId = $modelBanner->banner_id;
            return true;
        } else {
            return false;
        }
    }

    //get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #------------ Update ------------
    // disable banner  when publish invalid
    public function publishFailOfProject($projectId)
    {
        return TfBanner::where('project_id', $projectId)->where('publish', 0)->update(['action' => 0, 'status' => 0]);
    }

    // enable banner  when publish success
    public function publishSuccessOfProject($projectId)
    {
        return TfBanner::where('project_id', $projectId)->where('status', 1)->where('action', 1)->where('publish', 0)->update(['publish' => 1]);
    }

    // position
    public function updatePosition($bannerId = '', $topPosition = '', $leftPosition = '', $zIndex = '')
    {
        return TfBanner::where('banner_id', $bannerId)->update(
            [
                'publish' => 0,
                'topPosition' => $topPosition,
                'leftPosition' => $leftPosition,
                'zindex' => $zIndex
            ]
        );
    }

    // status
    public function updateStatus($bannerId = '', $status = '')
    {
        return TfBanner::where('banner_id', $bannerId)->update(['status' => $status]);
    }

    // publish
    public function updatePublish($bannerId = null)
    {
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return TfBanner::where('banner_id', $bannerId)->update(['publish' => 1]);
    }

    // delete
    public function actionDelete($bannerId = null)
    {
        $modelBannerTransaction = new TfBannerTransaction();
        $modelBannerLicense = new TfBannerLicense();
        $modelBannerImage = new TfBannerImage();
        $modelBannerReserve = new TfBannerReserve();
        $modelBannerShare = new TfBannerShare();

        if (empty($bannerId)) $bannerId = $this->bannerId();
        if (TfBanner::where('banner_id', $bannerId)->update(['action' => 0])) {
            //delete transaction
            $modelBannerTransaction->actionDeleteByBanner($bannerId);

            //delete license
            $modelBannerLicense->actionDeleteByBanner($bannerId);

            //delete image
            $modelBannerImage->actionDeleteByBanner($bannerId);

            //delete reserve
            $modelBannerReserve->actionDeleteByBanner($bannerId);

            //delete share
            $modelBannerShare->actionDeleteByBanner($bannerId);
        }
    }

    //delete by project
    public function actionDeleteByProject($projectId = null)
    {
        if (!empty($projectId)) {
            $listBannerId = TfBanner::where(['project_id' => $projectId, 'action' => 1])->lists('banner_id');
            if (!empty($listBannerId)) {
                foreach ($listBannerId as $value) {
                    $this->actionDelete($value);
                }
            }
        }
    }

    // delete when setup (does not publish)
    public function setupDelete($bannerId = null)
    {
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return TfBanner::where('banner_id', $bannerId)->delete();
    }

    #========== ========= ========= RELATION ========= ========= =========
    #---------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'project_id', 'project_id');
    }
    // get banners are using (front end)
    public function bannerInfoOfProject($projectId)
    {
        return TfBanner::where('action', 1)->where('project_id', $projectId)->get();
    }

    // get banners are using (back end)
    public function bannerInfoOfProjectOnBuild($projectId)
    {
        return TfBanner::where('action', 1)->where('project_id', $projectId)->get();
    }


    #---------- TF-USER ----------
    public function user()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Users\TfUser', 'App\Models\Manage\Content\Map\Banner\License\TfBannerLicense', 'banner_id', 'user_id');
    }
    // check banner of user
    public function existBannerOfUser($userId, $bannerId)
    {
        $modelBannerLicense = new TfBannerLicense();
        return $modelBannerLicense->existBannerOfUser($userId, $bannerId);
    }

    // get banner info of user (get all)
    public function infoOfUser($userId, $skip = null, $take = null)
    {
        $modelBannerLicense = new TfBannerLicense();
        $listBannerId = $modelBannerLicense->listBannerIdOfUser($userId);
        if (empty($skip) && empty($take)) {
            return TfBanner::whereIn('banner_id', $listBannerId)->get();
        } else {
            return TfBanner::whereIn('banner_id', $listBannerId)->skip($skip)->take($take)->get();
        }
    }

    #----------- TF-BANNER-SAMPLE ----------
    public function bannerSample()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Banner\TfBannerSample', 'sample_id', 'sample_id');
    }
    // get path banner sample
    public function pathImageSample($sampleId)
    {
        $modelBannerSample = new TfBannerSample();
        return $modelBannerSample->pathImage($modelBannerSample->image($sampleId));
    }

    public function pathIconDefault()
    {
        return asset('public/main/icons/banner-icon.png');
    }

    #---------- TF-BANNER-LICENSE ----------
    public function bannerLicense()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\License\TfBannerLicense', 'banner_id', 'banner_id');
    }
    // only get license is using of a banner
    public function licenseInfo($bannerId = null)
    {
        $modelBannerLicense = new TfBannerLicense();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelBannerLicense->infoOfBanner($bannerId);
    }

    // exist license
    public function existLicense($bannerId = null)
    {
        $modelBannerLicense = new TfBannerLicense();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelBannerLicense->checkExistBanner($bannerId);
    }

    #---------- TF-BANNER-IMAGE ----------
    public function bannerImage()
    {
        return $this->hasManyThrough('App\Models\Manage\Content\Map\Banner\Image\TfBannerImage', 'App\Models\Manage\Content\Map\Banner\License\TfBannerLicense', 'banner_id', 'license_id', 'banner_id');
    }
    // only get image is using of a banner
    public function imageInfo($bannerId = null)
    {
        $modelBannerImage = new TfBannerImage();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelBannerImage->infoOfBanner($bannerId);
    }

    #---------- TF-BANNER-TRANSACTION ----------
    public function bannerTransaction()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Transaction\TfBannerTransaction', 'banner_id', 'banner_id');
    }

    #---------- TF-BANNER-RESERVE ----------
    public function bannerReserve()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Reserve\TfBannerReserve', 'banner_id', 'banner_id');
    }

    #---------- TF-BANNER-VISIT ----------
    public function bannerVisit()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Visit\TfBannerVisit', 'banner_id', 'banner_id');
    }

    #---------- TF-BANNER-SHARE ----------
    public function bannerShare()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Share\TfBannerShare', 'banner_id', 'banner_id');
    }

    #---------- TF-BANNER-SHARE-VIEW ----------
    public function bannerShareView()
    {
        return $this->hasManyThrough('App\Models\Manage\Content\Map\Banner\Share\TfBannerShareView', 'App\Models\Manage\Content\Map\Banner\Share\TfBannerShare', 'banner_id', 'share_id', 'banner_id');
    }

    #---------- TF-TRANSACTION-STATUS ----------
    public function transactionStatus()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Map\Transaction\TfTransactionStatus', 'App\Models\Manage\Content\Map\Banner\Transaction\TfBannerTransaction', 'banner_id', 'status_id');
    }
    // only get transaction is using of a banner
    public function transactionInfo($bannerId = null)
    {
        $modelBannerTransaction = new TfBannerTransaction();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelBannerTransaction->infoOfBanner($bannerId);
    }

    // only get transaction id is using of a banner
    public function transactionStatusId($bannerId = null)
    {
        $modelBannerTransaction = new TfBannerTransaction();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelBannerTransaction->transactionStatusOfBanner($bannerId);
    }

    // disable transaction of banner
    public function transactionDisable($bannerId = null)
    {
        $modelBannerTransaction = new TfBannerTransaction();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelBannerTransaction->disableOfBanner($bannerId);
    }

    #========== ========= ========= GET INFO ========= ========= =========
    public function getInfo($bannerId = null, $field = null)
    {
        if (empty($bannerId)) {
            return TfBanner::where('action', 1)->get();
        } else {
            $result = TfBanner::where(['banner_id' => $bannerId, 'action' => 1])->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #---------- RULE ----------
    // rule info of a banner
    public function ruleInfo($bannerId = null)
    {
        if (empty($bannerId)) $bannerId = $this->bannerId();
        $dataBanner = TfBanner::find($bannerId);
        $projectId = $dataBanner->projectId();
        $sizeId = $dataBanner->bannerSample->sizeId();
        $projectRankId = $dataBanner->project->getRankId($projectId);
        return $this->ruleOfSizeAndRank($sizeId, $projectRankId);
    }

    // get rule info on sample size and rank of project
    public function ruleOfSizeAndRank($sizeId, $projectRankId)
    {
        $modelRuleBannerRank = new TfRuleBannerRank();
        return $modelRuleBannerRank->infoOfSizeAndRank($sizeId, $projectRankId);
    }

    // price of banner
    public function price($sizeId, $projectRankId)
    {
        $modelRuleBannerRank = new TfRuleBannerRank();
        return $modelRuleBannerRank->salePrice($sizeId, $projectRankId);
    }

    // sale month
    public function saleMonth($sizeId, $projectRankId)
    {
        $modelRuleBannerRank = new TfRuleBannerRank();
        return $modelRuleBannerRank->saleMonth($sizeId, $projectRankId);
    }

    // free month
    public function freeMonth($sizeId, $projectRankId)
    {
        $modelRuleBannerRank = new TfRuleBannerRank();
        return $modelRuleBannerRank->freeMonth($sizeId, $projectRankId);
    }

    // ---------- BANNER INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBanner::where('banner_id', $objectId)->pluck($column);
        }
    }

    public function bannerId()
    {
        return $this->banner_id;
    }

    public function name($bannerId = null)
    {
        return $this->pluck('name', $bannerId);
    }

    public function sampleId($bannerId = null)
    {
        return $this->pluck('sample_id', $bannerId);
    }

    public function topPosition($bannerId = null)
    {
        return $this->pluck('topPosition', $bannerId);
    }

    public function leftPosition($bannerId = null)
    {
        return $this->pluck('leftPosition', $bannerId);
    }

    public function zIndex($bannerId = null)
    {
        return $this->pluck('zindex', $bannerId);
    }

    public function pointValue($bannerId = null)
    {
        return $this->pluck('pointValue', $bannerId);
    }

    public function projectId($bannerId = null)
    {
        return $this->pluck('project_id', $bannerId);
    }

    public function publish($bannerId = null)
    {
        return $this->pluck('publish', $bannerId);
    }

    public function status($bannerId = null)
    {
        return $this->pluck('status', $bannerId);
    }

    public function createdAt($bannerId = null)
    {
        return $this->pluck('created_at', $bannerId);
    }

    // last id
    public function lastId()
    {
        $result = TfBanner::orderBy('banner_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->banner_id;
    }

    // total records
    public function totalRecords()
    {
        return TfBanner::where('action', 1)->count();
    }

    public function totalVisit($bannerId = null)
    {
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return TfBanner::find($bannerId)->bannerVisit->count();
    }

    #========== ========= ========= CHECK INFO ========== ========= =========
    public function  checkPublished($bannerId=null)
    {
        return ($this->publish($bannerId) == 1) ? true : false;
    }

    public function existBanner($bannerId)
    {
        $dataBanner = TfBanner::where('banner_id', $bannerId)->count();
        return ($dataBanner > 0) ? true : false;
    }

    // check sold
    public function checkSold($bannerId = null)
    {
        $modelBannerLicense = new TfBannerLicense();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelBannerLicense->checkExistBanner($bannerId);
    }

    // banner of user
    public function checkBannerOfUser($userId = '', $bannerId = '')
    {
        $modelBannerLicense = new TfBannerLicense();
        return $modelBannerLicense->existBannerOfUser($userId, $bannerId);
    }

    //exist image
    public function existImage($bannerId = null)
    {
        if (empty($bannerId)) $bannerId = $this->bannerId();
        $dataBannerImage = $this->imageInfo($bannerId);
        return (count($dataBannerImage) > 0) ? true : false;
    }

    #========== ========== ========== GET INFO FOR MARKET ========== ========= =========
    //get banner info follow transaction and province
    public function infoOfTransactionAndProvince($transactionStatusId = null, $provinceId = null)
    {
        if (!empty($transactionStatusId) && !empty($provinceId)) {
            $modelProvince = new TfProvince();
            $modelBannerTransaction = new TfBannerTransaction();
            $result = null;
            $listProjectId = $modelProvince->listProjectId($provinceId);
            $listBannerOfTransaction = $modelBannerTransaction->bannerIdOfTransactionStatus($transactionStatusId);
            /*
            $result = DB::table('tf_banners')->leftJoin('tf_banner_transactions', 'tf_banners.banner_id', '=', 'tf_banner_transactions.banner_id')
                ->whereIn('tf_banners.project_id', $listProjectId)
                ->where('tf_banners.publish', '=', 1)
                ->where('tf_banners.action', '=', 1)
                ->where('tf_banner_transactions.transactionStatus_id', '=', $transactionStatusId)
                ->where('tf_banner_transactions.action', '=', 1)
                ->select('*')->get();
            */
            $result = TfBanner::whereIn('project_id', $listProjectId)->whereIn('banner_id', $listBannerOfTransaction)->where(['action' => 1, 'publish' => 1])->get();
            return $result;
        }
    }

    //get sale banner info on a province
    public function infoSaleOfProvince($provinceId)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $transactionStatusId = $modelTransactionStatus->saleStatusId(); //sale
        return $this->infoOfTransactionAndProvince($transactionStatusId, $provinceId);
    }

    //get free banner info on a province
    public function infoFreeOfProvince($provinceId)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $transactionStatusId = $modelTransactionStatus->freeStatusId(); //free
        return $this->infoOfTransactionAndProvince($transactionStatusId, $provinceId);
    }


}
