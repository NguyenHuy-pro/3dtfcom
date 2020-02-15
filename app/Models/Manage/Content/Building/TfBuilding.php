<?php namespace App\Models\Manage\Content\Building;

use App\Models\Manage\Content\Ads\Banner\TfAdsBanner;
use App\Models\Manage\Content\Ads\Page\TfAdsPage;
use App\Models\Manage\Content\Ads\Position\TfAdsPosition;
use App\Models\Manage\Content\Building\Activity\TfBuildingActivity;
use App\Models\Manage\Content\Building\BadInfoNotify\TfBuildingBadInfoNotify;
use App\Models\Manage\Content\Building\BadInfoReport\TfBuildingBadInfoReport;
use App\Models\Manage\Content\Building\Banner\TfBuildingBanner;
use App\Models\Manage\Content\Building\Business\TfBuildingBusiness;
use App\Models\Manage\Content\Building\Comment\TfBuildingComment;
use App\Models\Manage\Content\Building\CommentNotify\TfBuildingCommentNotify;
use App\Models\Manage\Content\Building\Follow\TfBuildingFollow;
use App\Models\Manage\Content\Building\Post\TfBuildingPost;
use App\Models\Manage\Content\Building\Rank\TfBuildingRank;
use App\Models\Manage\Content\Building\Service\Articles\TfBuildingArticles;
use App\Models\Manage\Content\Building\Share\TfBuildingShare;
use App\Models\Manage\Content\Building\VisitHome\TfBuildingVisitHome;
use App\Models\Manage\Content\Building\VisitWebsite\TfBuildingVisitWebsite;
use App\Models\Manage\Content\Map\Land\License\TfLandLicense;
use App\Models\Manage\Content\Sample\Building\TfBuildingSample;
use App\Models\Manage\Content\System\Business\TfBusinessType;
use App\Models\Manage\Content\Users\Activity\TfUserActivity;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use Illuminate\Database\Eloquent\Model;
use DB;

class TfBuilding extends Model
{

    protected $table = 'tf_buildings';
    protected $fillable = ['building_id', 'nameCode', 'name', 'displayName', 'alias', 'shortDescription', 'description', 'metaKeyword', 'website', 'phone', 'address', 'email'
        , 'pointValue', 'status', 'action', 'created_at', 'sample_id', 'license_id', 'postRelation_id'];
    protected $primaryKey = 'building_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========= INSERT && UPDATE =========== =========== =========
    #---------- ---------- New insert ---------- ----------
    public function insert($name, $displayName, $shortDescription, $description, $website, $phone, $address, $email, $sampleId, $licenseId, $postRelationId, $metaKeyword)
    {
        $hFunction = new \Hfunction();
        $modelBuilding = new TfBuilding();
        # handle have same name
        $lastId = $this->lastId();
        $alias = $hFunction->alias($name, '-') . '-' . ($lastId + 1);
        if ($website != '') {
            # delete https or http
            $website = str_replace('http://', '', str_replace('https://', '', $website));
        }
        $name = $hFunction->convertValidHTML($name);
        $modelBuilding->nameCode = $hFunction->getTimeCode() . ($lastId + 1);
        $modelBuilding->name = $name;
        $modelBuilding->displayName = $displayName;
        $modelBuilding->alias = $alias;
        $modelBuilding->shortDescription = $shortDescription;
        $modelBuilding->description = $description;
        $modelBuilding->metaKeyword = $metaKeyword;
        $modelBuilding->website = $website;
        $modelBuilding->phone = $phone;
        $modelBuilding->address = $address;
        $modelBuilding->email = $email;
        $modelBuilding->sample_id = $sampleId;
        $modelBuilding->license_id = $licenseId;
        $modelBuilding->postRelation_id = $postRelationId;
        $modelBuilding->created_at = $hFunction->createdAt();
        if ($modelBuilding->save()) {
            $this->lastId = $modelBuilding->building_id;
            return true;
        } else {
            return false;
        }
    }

    # get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- check Info ----------
    //existing building
    public function existBuilding($buildingId)
    {
        $dataBuilding = TfBuilding::where(['building_id' => $buildingId, 'action' => 1])->count();
        return ($dataBuilding > 0) ? true : false;
    }

    #---------- Update Info ----------
    //update
    public function updateInfo($buildingId, $name, $displayName, $shortDescription, $description, $website, $phone, $address, $email)
    {
        $hFunction = new \Hfunction();
        $modelBuilding = TfBuilding::find($buildingId);
        if ($website != '') {
            $website = str_replace('http://', '', str_replace('https://', '', $website));
        }
        $alias = $hFunction->alias($name, '-') . '-' . $buildingId;
        $modelBuilding->name = $name;
        $modelBuilding->displayName = $displayName;
        $modelBuilding->alias = $alias;
        $modelBuilding->shortDescription = $shortDescription;
        $modelBuilding->description = $description;
        $modelBuilding->website = $hFunction->htmlEntities($website);
        $modelBuilding->phone = $phone;
        $modelBuilding->address = $address;
        $modelBuilding->email = $email;
        return $modelBuilding->save();
    }

    //update name
    public function updateName($buildingId, $name)
    {
        $hFunction = new \Hfunction();
        $modelBuilding = TfBuilding::find($buildingId);
        $modelBuilding->name = $name;
        $modelBuilding->alias = $hFunction->alias($name, '-') . '-' . $buildingId;
        return $modelBuilding->save();
    }

    //update phone
    public function updatePhone($buildingId, $phone)
    {
        return TfBuilding::where('building_id', $buildingId)->update(['phone' => $phone]);
    }

    //update phone
    public function updateEmail($buildingId, $email)
    {
        return TfBuilding::where('building_id', $buildingId)->update(['email' => $email]);
    }

    //update phone
    public function updateWebsite($buildingId, $website)
    {
        if (!empty($website)) {
            # delete https or http
            $website = str_replace('http://', '', str_replace('https://', '', $website));
        }
        return TfBuilding::where('building_id', $buildingId)->update(['website' => $website]);
    }

    //update phone
    public function updateAddress($buildingId, $address)
    {
        return TfBuilding::where('building_id', $buildingId)->update(['address' => $address]);
    }

    //update phone
    public function updateShortDescription($buildingId, $content)
    {
        return TfBuilding::where('building_id', $buildingId)->update(['shortDescription' => $content]);
    }

    //update name
    public function updateContact($buildingId, $website, $phone, $address, $email)
    {
        $hFunction = new \Hfunction();
        $modelBuilding = TfBuilding::find($buildingId);
        $modelBuilding->website = $hFunction->htmlEntities($website);
        $modelBuilding->phone = $phone;
        $modelBuilding->address = $address;
        $modelBuilding->email = $email;
        return $modelBuilding->save();
    }

    //update description
    public function updateDescription($buildingId, $description)
    {
        return TfBuilding::where('building_id', $buildingId)->update(['description' => $description]);
    }

    // total visit
    public function plusVisit($buildingId = null)
    {
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $result = $this->totalVisit($buildingId) + 1;
        return TfBuilding::where('building_id', $buildingId)->update(['totalVisit' => $result]);
    }

    //total follow
    public function plusFollow($buildingId = null)
    {
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $result = $this->totalFollow($buildingId) + 1;
        return TfBuilding::where('building_id', $buildingId)->update(['totalFollow' => $result]);
    }

    public function minusFollow($buildingId = null)
    {
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $result = $this->totalFollow($buildingId) - 1;
        $result = ($result < 0) ? 0 : $result;
        return TfBuilding::where('building_id', $buildingId)->update(['totalFollow' => $result]);
    }

    //total comment
    public function plusComment($buildingId = null)
    {
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $result = $this->totalComment($buildingId) + 1;
        return TfBuilding::where('building_id', $buildingId)->update(['totalComment' => $result]);
    }

    public function minusComment($buildingId = null)
    {
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $result = $this->totalComment($buildingId) - 1;
        $result = ($result < 0) ? 0 : $result;
        return TfBuilding::where('building_id', $buildingId)->update(['totalComment' => $result]);
    }

    //total love
    public function plusLove($buildingId = null)
    {
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $result = $this->totalLove($buildingId) + 1;
        return TfBuilding::where('building_id', $buildingId)->update(['totalLove' => $result]);
    }

    public function minusLove($buildingId = null)
    {
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $result = $this->totalLove($buildingId) - 1;
        $result = ($result < 0) ? 0 : $result;
        return TfBuilding::where('building_id', $buildingId)->update(['totalLove' => $result]);
    }

    # total share
    public function plusShare($buildingId = null)
    {
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $result = $this->totalShare($buildingId) + 1;
        return TfBuilding::where('building_id', $buildingId)->update(['totalShare' => $result]);
    }

    #update sample
    public function updateSample($buildingId, $sampleId)
    {
        return TfBuilding::where('building_id', $buildingId)->update(['sample_id' => $sampleId]);
    }

    #update relation
    public function updateRelation($buildingId, $postRelationId)
    {
        return TfBuilding::where('building_id', $buildingId)->update(['postRelation_id' => $postRelationId]);
    }

    # status
    public function updateStatus($buildingId, $status)
    {
        return TfBuilding::where('building_id', $buildingId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($buildingId = null)
    {
        $modelUserActivity = new TfUserActivity();
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        $modelBuildingRank = new TfBuildingRank();
        $modelBuildingShare = new TfBuildingShare();
        $modelBuildingBadInfoNotify = new TfBuildingBadInfoNotify();
        $modelBuildingBadInfoReport = new TfBuildingBadInfoReport();
        $modelBuildingBanner = new TfBuildingBanner();
        $modelBuildingComment = new TfBuildingComment();
        $modelBuildingPost = new TfBuildingPost();

        if (empty($buildingId)) $buildingId = $this->buildingId();
        if (TfBuilding::where('building_id', $buildingId)->update(['action' => 0, 'status' => 0])) {
            //delete post
            $modelBuildingPost->actionDeleteByBuilding($buildingId);

            //delete banner
            $modelBuildingBanner->actionDeleteByBuilding($buildingId);

            //delete rank
            $modelBuildingRank->actionDeleteByBuilding($buildingId);

            //delete share
            $modelBuildingShare->actionDeleteByBuilding($buildingId);

            //delete bad info
            $modelBuildingBadInfoNotify->actionDeleteByBuilding($buildingId);
            $modelBuildingBadInfoReport->actionDeleteByBuilding($buildingId);

            //delete comment
            $modelBuildingComment->actionDeleteByBuilding($modelBuildingComment);

            //update user activity
            $modelUserActivity->deleteByBuilding($buildingId);
            //delete notify for user
            $modelUserNotifyActivity->deleteByBuilding($buildingId);

            return true;
        } else {
            return false;
        }
    }

    //when delete license
    public function actionDeleteByLicense($licenseId = null)
    {
        if (!empty($licenseId)) {
            $buildingId = TfBuilding::where(['license_id' => $licenseId, 'action' => 1])->pluck('building_id');
            if (!empty($buildingId)) {
                $this->actionDelete($buildingId);
            }
        }
    }

    #========= ========= ========= RELATION ======= ========= =========
    //----------- TF-BUILDING - ACTIVITY -----------
    public function buildingActivity()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Activity\TfBuildingActivity', 'building_id', 'building_id');
    }

    // highlight post info of building
    public function activityHighlightOfBuilding($buildingId = null)
    {
        $modelBuildingActivity = new TfBuildingActivity();
        if (empty($buildingId)) $buildingId = $this->buildingId();
        return $modelBuildingActivity->infoHighLightOfBuilding($buildingId);
    }

    //activity info of building
    public function activityOfBuilding($buildingId, $take = null, $dateTake = null)
    {
        $modelBuildingPost = new TfBuildingActivity();
        return $modelBuildingPost->infoOfBuilding($buildingId, $take, $dateTake);
    }


    //----------- TF-BUILDING - ARTICLES -----------
    public function buildingArticles()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Service\Articles\TfBuildingArticles', 'building_id', 'building_id');
    }

    public function articlesInfoOfBuilding($buildingId, $take = null, $dateTake = null, $typeId = 0, $keyword = null)
    {
        $modelBuildingArticles = new TfBuildingArticles();
        return $modelBuildingArticles->activityInfoOfBuilding($buildingId, $take, $dateTake, $typeId, $keyword);
    }

    //----------- TF-USER-NOTIFY-ACTIVITY -----------
    public function userNotifyActivity()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity', 'building_id', 'buildingNew_id');
    }

    # ---------- TF-RELATION ----------
    public function relation()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Relation\TfRelation', 'postRelation_id', 'relation_id');
    }

    # ---------- TF-BUILDING-SAMPLE ----------
    //relation
    public function buildingSample()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Building\TfBuildingSample', 'sample_id', 'sample_id');
    }

    //get path building sample
    public function pathImageSample($sampleId)
    {
        $modelBuildingSample = new TfBuildingSample();
        return $modelBuildingSample->pathImage($modelBuildingSample->image($sampleId));
    }

    # ---------- TF-BUSINESS ----------
    public function business()
    {
        return $this->belongsToMany('App\Models\Manage\Content\System\Business\TfBusiness', 'App\Models\Manage\Content\Building\Business\TfBuildingBusiness', 'building_id', 'business_id');
    }

    # ---------- TF-BUILDING - BUSINESS ----------
    //relation
    public function buildingBusiness()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Business\TfBuildingBusiness', 'building_id', 'building_id');
    }

    //list business of building
    public function listBusinessId($buildingId = null)
    {
        $modelBuildingBusiness = new TfBuildingBusiness();
        if (empty($buildingId)) $buildingId = $this->buildingId();
        return $modelBuildingBusiness->listBusinessOfBuilding($buildingId);
    }

    # ---------- TF-BUILDING-BANNER ----------
    //relation
    public function buildingBanner()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Banner\TfBuildingBanner', 'building_id', 'building_id');
    }

    //default banner image
    public function pathBannerImageDefault()
    {
        return asset('public/main/icons/bannerDefault.jpg');
    }

    //get banner info is enable of building
    public function bannerInfoUsing($buildingId = null)
    {
        $modelBuildingBanner = new TfBuildingBanner();
        if (empty($buildingId)) $buildingId = $this->buildingId();
        return $modelBuildingBanner->infoUsingOfBuilding($buildingId);
    }

    //get banner image is enable of building
    public function bannerImageUsing($buildingId = null)
    {
        $modelBuildingBanner = new TfBuildingBanner();
        if (empty($buildingId)) $buildingId = $this->buildingId();
        return $modelBuildingBanner->imageUsingOfBuilding($buildingId);
    }

    //get path image of banner
    public function pathImageBanner($buildingId = null)
    {
        $modelBuildingBanner = new TfBuildingBanner();
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $image = $this->bannerImageUsing($buildingId);
        if (empty($image)) {
            return null;
        } else {
            return $modelBuildingBanner->pathImage($image);
        }
    }

    # ---------- TF-LAND ----------
    //only get info is using of land
    public function infoOfLand($landId)
    {
        $modelLandLicense = new TfLandLicense();
        $dataLandLicense = $modelLandLicense->infoOfLand($landId);
        if (count($dataLandLicense) > 0) {
            $licenseId = $dataLandLicense->licenseId();
            return TfBuilding::where('license_id', $licenseId)->where('action', 1)->first();
        } else {
            return null;
        }
    }

    //building id of land
    public function buildingIdOfLand($landId)
    {
        $dataBuildingInfo = $this->infoOfLand($landId);
        if (count($dataBuildingInfo) > 0) {
            return $dataBuildingInfo->buildingId();
        } else {
            return null;
        }
    }

    public function landId($buildingId = null)
    {
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $dataBuildingInfo = $this->getInfo($buildingId);
        if (count($dataBuildingInfo) > 0) {
            return $dataBuildingInfo->landLicense->landId();
        } else {
            return null;
        }
    }

    # ---------- TF-LAND-LICENSE ----------
    public function landLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'license_id', 'license_id');
    }

    //building id of license
    public function infoOfLandLicense($licenseId)
    {
        return TfBuilding::where('license_id', $licenseId)->where('action', 1)->first();
    }

    //building id of license
    public function buildingIdOfLandLicense($licenseId)
    {
        return TfBuilding::where('license_id', $licenseId)->where('action', 1)->pluck('building_id');
    }

    # ---------- TF-BUILDING-COMMENT ----------
    //relation
    public function buildingComment()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Comment\TfBuildingComment', 'building_id', 'building_id');
    }

    //comment info of building
    public function commentInfoOfBuilding($buildingId, $take = null, $dateTake = null)
    {
        $modelBuildingComment = new TfBuildingComment();
        return $modelBuildingComment->infoOfBuilding($buildingId, $take, $dateTake);
    }

    # ---------- TF-BUILDING-NEW-NOTIFY ----------
    public function buildingNewNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Notify\TfBuildingNewNotify', 'building_id', 'building_id');
    }

    # ---------- TF-BUILDING-LOVE ----------
    public function buildingLove()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Love\TfBuildingLove', 'building_id', 'building_id');
    }

    # ---------- TF-BUILDING-FOLLOW ----------
    #relation
    public function buildingFollow()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Follow', 'building_id', 'building_id');
    }

    #list user_id follow building
    public function listUserFollowBuilding($buildingId = null)
    {
        $modelBuildingFollow = new TfBuildingFollow();
        if (empty($buildingId)) $buildingId = $this->buildingId();
        return $modelBuildingFollow->listUserOfBuilding($buildingId);
    }

    #----------- TF-BUILDING-BAD-INFO-NOTIFY -----------
    public function buildingBadInfoNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\BadInfoNotify\TfBuildingBadInfoNotify', 'building_id', 'building_id');
    }

    #----------- TF-BUILDING-BAD-INFO-REPORT -----------
    public function buildingBadInfoReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\BadInfoReport\TfBuildingBadInfoReport', 'building_id', 'building_id');
    }

    # ---------- TF-BUILDING-POST ----------
    //relation
    public function buildingPost()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Post\TfBuildingPost', 'building_id', 'building_id');
    }

    // highlight post info of building
    public function postsHighlightOfBuilding($buildingId = null)
    {
        $modelBuildingPost = new TfBuildingPost();
        if (empty($buildingId)) $buildingId = $this->buildingId();
        return $modelBuildingPost->infoHighLightOfBuilding($buildingId);
    }

    //post info of building
    public function postsInfoOfBuilding($buildingId, $take = null, $dateTake = null)
    {
        $modelBuildingPost = new TfBuildingPost();
        return $modelBuildingPost->infoOfBuilding($buildingId, $take, $dateTake);
    }

    # ---------- TF-BUILDING-SHARE ----------
    public function buildingShare()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Share\TfBuildingShare', 'building_id', 'building_id');
    }

    # ---------- TF-BUILDING-VISIT-HOME ----------
    //relation
    public function buildingVisitHome()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\VisitHome\TfBuildingVisitHome', 'building_id', 'building_id');
    }

    //total visit home page
    public function totalVisitHome($buildingId = null)
    {
        $modelVisit = new TfBuildingVisitHome();
        if (empty($buildingId)) $buildingId = $this->buildingId();
        return $modelVisit->totalVisitOfBuilding($buildingId);
    }

    # ---------- TF-BUILDING-VISIT-WEBSITE ----------
    //relation
    public function buildingVisitWebsite()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\VisitWebsite\TfBuildingVisitWebsite', 'building_id', 'building_id');
    }

    //total visit website
    public function totalVisitWebsite($buildingId = null)
    {
        $modelVisit = new TfBuildingVisitWebsite();
        if (empty($buildingId)) $buildingId = $this->buildingId();
        return $modelVisit->totalVisitOfBuilding($buildingId);
    }

    #----------- TF-BUILDING-RANK -----------
    public function buildingRank()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Rank\TfBuildingRank', 'building_id', 'building_id');
    }

    #----------- TF-RANK -----------
    public function rank()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Map\Rank\TfRank', 'App\Models\Manage\Content\Building\Rank\TfBuildingRank', 'building_id', 'rank_id');
    }

    #----------- TF-BAD-INFO -----------
    public function badInfo()
    {
        return $this->belongsToMany('App\Models\Manage\Content\System\BadInfo\TfBadInfo', 'App\Models\Manage\Content\Building\BadInfoNotify\TfBuildingBadInfoNotify', 'building_id', 'badInfo_id');
    }

    #---------- TF-USER-ACTIVITY ----------
    public function userActivity()
    {
        return $this->hasOne('App\Models\Manage\Content\Users\Activity\TfUserActivity', 'building_id', 'building_id');
    }

    # ---------- TF-USER ----------
    //get building of user
    public function infoOfUser($userId, $skip = null, $take = null)
    {
        $modelLandLicense = new TfLandLicense();
        # get land of user
        $listLicenseId = $modelLandLicense->listIdOfUser($userId);
        if (empty($skip) && empty($take)) {
            return TfBuilding::whereIn('license_id', $listLicenseId)->where('action', 1)->get();
        } else {
            # have limit
            return TfBuilding::whereIn('license_id', $listLicenseId)->where('action', 1)->skip($skip)->take($take)->get();
        }
    }

    //check building of user
    public function checkBuildingOfUser($buildingId, $userId)
    {
        $modelLandLicense = new TfLandLicense();
        # get land of user
        $listLicenseId = $modelLandLicense->listIdOfUser($userId);
        $result = TfBuilding::whereIn('license_id', $listLicenseId)->where('building_id', $buildingId)->where('action', 1)->count();
        return ($result > 0) ? true : false;
    }

    public function checkNewNotifyOfUser($userId, $buildingId = null)
    {
        $modelCommentNotify = new TfBuildingCommentNotify();
        if (empty($buildingId)) $buildingId = $this->buildingId();
        return $modelCommentNotify->checkNewNotifyOfUserOnBuilding($buildingId, $userId);
    }

    //get user id of building
    public function userId($buildingId = null)
    {
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $dataBuilding = $this->getInfo($buildingId);
        return $dataBuilding->landLicense->userId();
    }

    //get user info of building
    public function userInfo($buildingId = null)
    {
        if (empty($buildingId)) $buildingId = $this->buildingId();
        $dataBuilding = $this->getInfo($buildingId);
        return $dataBuilding->landLicense->user;
    }

    //list building Of user
    public function listIdOfUser($userId)
    {
        $modelLandLicense = new TfLandLicense();
        $listLicenseId = $modelLandLicense->listIdOfUser($userId);
        return TfBuilding::whereIn('license_id', $listLicenseId)->where('action', 1)->lists('building_id');
    }

    #========= ========= ========= GET INFO ========= ========= =========

    # ---------- BUILDING INFO ----------
    //get building_id list  are operating
    public function listBuildingIdByOperating()
    {
        return TfBuilding::where('action', 1)->lists('building_id');
    }

    public function findInfo($buildingId)
    {
        return TfBuilding::find($buildingId);
    }

    public function getInfo($buildingId = null, $field = null)
    {
        if (empty($buildingId)) {
            return TfBuilding::where('action', 1)->get();
        } else {
            $result = TfBuilding::where(['building_id' => $buildingId, 'action' => 1])->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    // get info follow alias
    public function getInfoOfAlias($alias)
    {
        return TfBuilding::where(['alias' => $alias, 'action' => 1])->first();
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuilding::where('building_id', $objectId)->pluck($column);
        }
    }

    public function buildingId()
    {
        return $this->building_id;
    }

    public function sampleId($buildingId = null)
    {
        return $this->pluck('sample_id', $buildingId);
    }

    public function nameCode($buildingId = null)
    {
        return $this->pluck('nameCode', $buildingId);
    }

    public function name($buildingId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('name', $buildingId));
    }

    public function displayName($buildingId = null)
    {
        return $this->pluck('displayName', $buildingId);
    }

    public function alias($buildingId = null)
    {
        return $this->pluck('alias', $buildingId);
    }

    public function shortDescription($buildingId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('shortDescription', $buildingId));
    }

    public function description($buildingId = null)
    {
        return $this->pluck('description', $buildingId);
    }

    public function metaKeyword($buildingId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('metaKeyword', $buildingId));
    }

    public function website($buildingId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('website', $buildingId));
    }

    public function phone($buildingId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('phone', $buildingId));
    }

    public function address($buildingId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('address', $buildingId));
    }

    public function email($buildingId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('email', $buildingId));
    }

    public function pointValue($buildingId = null)
    {
        return $this->pluck('pointValue', $buildingId);
    }

    public function status($buildingId = null)
    {
        return $this->pluck('status', $buildingId);
    }

    public function createdAt($buildingId = null)
    {
        return $this->pluck('created_at', $buildingId);
    }

    public function totalVisit($buildingId = null)
    {
        return $this->pluck('totalVisit', $buildingId);
    }

    public function totalFollow($buildingId = null)
    {
        return $this->pluck('totalFollow', $buildingId);
    }

    public function totalComment($buildingId = null)
    {
        return $this->pluck('totalComment', $buildingId);
    }

    public function totalLove($buildingId = null)
    {
        return $this->pluck('totalLove', $buildingId);
    }

    public function totalShare($buildingId = null)
    {
        return $this->pluck('totalShare', $buildingId);
    }

    public function landLicenseId($buildingId = null)
    {
        return $this->pluck('license_id', $buildingId);
    }

    public function postRelationId($buildingId = null)
    {
        return $this->pluck('postRelation_id', $buildingId);
    }

    //total records
    public function totalRecords()
    {
        return TfBuilding::Where('action', 1)->count();
    }

    //last id
    public function lastId()
    {
        $result = TfBuilding::orderBy('building_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->building_id;
    }

    //recent building
    public function recentBuilding($take = null)
    {
        if (empty($take)) {
            return TfBuilding::where(['action' => 1, 'status' => 1])->get();
        } else {
            return TfBuilding::where(['action' => 1, 'status' => 1])->skip(0)->take($take)->get();
        }
    }

    #========== ========== ========= ON PRIVATE PAGE =========== =========== =========
    public function adsBannerRight()
    {
        $modelAdsPage = new TfAdsPage();
        $modelAdsPosition = new TfAdsPosition();
        $modelAdsBanner = new TfAdsBanner();
        return $modelAdsBanner->bannerOfPageAndPosition($modelAdsPage->buildingPageId(), $modelAdsPosition->rightPositionId());

    }

    public function adsBannerBottom()
    {
        $modelAdsPage = new TfAdsPage();
        $modelAdsPosition = new TfAdsPosition();
        $modelAdsBanner = new TfAdsBanner();
        return $modelAdsBanner->bannerOfPageAndPosition($modelAdsPage->buildingPageId(), $modelAdsPosition->bottomPositionId());
    }
}
