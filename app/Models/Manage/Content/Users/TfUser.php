<?php namespace App\Models\Manage\Content\Users;

use App\Models\Manage\Content\Ads\Banner\ImagePrevent\TfAdsBannerImagePrevent;
use App\Models\Manage\Content\Ads\Banner\ImageReport\TfAdsBannerImageReport;
use App\Models\Manage\Content\Ads\Banner\License\TfAdsBannerLicense;
use App\Models\Manage\Content\Building\CommentNotify\TfBuildingCommentNotify;
use App\Models\Manage\Content\Building\Follow\TfBuildingFollow;
use App\Models\Manage\Content\Building\Love\TfBuildingLove;
use App\Models\Manage\Content\Building\PostLove\TfBuildingPostLove;
use App\Models\Manage\Content\Building\PostNewNotify\TfBuildingPostNewNotify;
use App\Models\Manage\Content\Building\Service\ArticlesLove\TfBuildingArticlesLove;
use App\Models\Manage\Content\Building\Share\TfBuildingShare;
use App\Models\Manage\Content\Building\ShareNotify\TfBuildingShareNotify;
use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Map\Banner\License\TfBannerLicense;
use App\Models\Manage\Content\Map\Banner\LicenseInvite\TfBannerLicenseInvite;
use App\Models\Manage\Content\Map\Banner\Share\TfBannerShare;
use App\Models\Manage\Content\Map\Banner\ShareNotify\TfBannerShareNotify;
use App\Models\Manage\Content\Map\Banner\TfBanner;
use App\Models\Manage\Content\Map\Land\License\TfLandLicense;
use App\Models\Manage\Content\Map\Land\LicenseInvite\TfLandLicenseInvite;
use App\Models\Manage\Content\Map\Land\Share\TfLandShare;
use App\Models\Manage\Content\Map\Land\ShareNotify\TfLandShareNotify;
use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\Map\Project\License\TfProjectLicense;
use App\Models\Manage\Content\Seller\TfSeller;
use App\Models\Manage\Content\Users\Access\TfUserAccess;
use App\Models\Manage\Content\Users\Activity\Love\TfUserActivityLove;
use App\Models\Manage\Content\Users\Card\TfUserCard;
use App\Models\Manage\Content\Users\Contact\TfUserContact;
use App\Models\Manage\Content\Users\Friend\TfUserFriend;
use App\Models\Manage\Content\Users\FriendRequest\TfUserFriendRequest;
use App\Models\Manage\Content\Users\Image\TfUserImage;
use App\Models\Manage\Content\Users\Love\TfUserLove;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity;
use App\Models\Manage\Content\Users\Notify\TfUserNotifyFriend;
use App\Models\Manage\Content\Users\PostLove\TfUserPostLove;
use App\Models\Manage\Content\Users\Statistic\TfUserStatistic;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Database\Eloquent\Model;
use DB;

class TfUser extends Model
{

    protected $table = 'tf_users';
    protected $fillable = ['user_id', 'nameCode', 'firstName', 'lastName', 'alias', 'account', 'password', 'birthday', 'gender', 'remember_token', 'newInfo', 'confirm', 'status', 'action', 'created_at', 'userIntroduce_id'];
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    private $lastId;

    public function __construct()
    {
        $modelUserCheckInfo = new UserCheckInfo();
        $modelUserCheckInfo->bannerLicenseInviteExpiry();
    }
    #========== ========= ========= INSERT && UPDATE ========== ========= =========

    #---------- Insert ----------
    //create password for user
    public function createUserPass($password, $nameCode)
    {
        $newPass = md5($nameCode . '3D') . md5('3D' . $password . $nameCode);
        return md5(sha1($newPass));
    }

    //insert
    public function insert($firstName, $lastName, $account, $password, $birthday = '', $gender = '', $token = null)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        #create code
        $nameCode = "U3DTF" . $hFunction->getTimeCode();

        # insert
        $modelUser->nameCode = $nameCode;
        $modelUser->firstName = $firstName;
        $modelUser->lastName = $lastName;
        $modelUser->alias = $hFunction->alias($firstName . ' ' . $lastName, '-') . '-' . $hFunction->getTimeCode();
        $modelUser->account = $account;
        $modelUser->password = $this->createUserPass($password, $nameCode);
        $modelUser->birthday = $birthday;
        $modelUser->gender = $gender;
        $modelUser->remember_token = $token;
        $modelUser->created_at = $hFunction->createdAt();
        if ($modelUser->save()) {
            $this->lastId = $modelUser->user_id;
            return true;
        } else {
            return false;
        }
    }

    // get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- Update ----------
    public function updateBasicInfo($userId, $firstName, $lastName, $birthday = null, $gender)
    {
        $hFunction = new \Hfunction();
        $modelUser = TfUser::find($userId);
        $modelUser->firstName = $firstName;
        $modelUser->lastName = $lastName;
        $modelUser->alias = $hFunction->alias($firstName . ' ' . $lastName, '-') . '-' . $userId;
        $modelUser->birthday = $birthday;
        $modelUser->gender = $gender;
        return $modelUser->save();

    }

    //update password
    public function updatePassword($userId, $password)
    {
        $password = $this->createUserPass($password, $this->nameCode($userId));
        return TfUser::where('user_id', $userId)->update(['password' => $password]);
    }

    //new info status
    public function updateNewInfo($userId = null)
    {
        return TfUser::where('user_id', (empty($userId)) ? $this->userId() : $userId)->update(['newInfo' => 0]);
    }

    //confirm status
    public function updateConfirm($userId = null)
    {
        if (empty($userId)) $userId = $this->userId();
        return TfUser::where('user_id', $userId)->update(['confirm' => 1]);
    }

    //confirm status
    public function updateUserIntroduce($userIntroduceId, $userId = null)
    {
        return TfUser::where('user_id', (empty($userId)) ? $this->userId() : $userId)->update(['userIntroduce_id' => $userIntroduceId]);
    }

    //status
    public function updateStatus($userId, $status)
    {
        return TfUser::where('user_id', $userId)->update(['status' => $status]);
    }

    //delete
    public function actionDelete($userId = null)
    {
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        $modelUserNotifyFriend = new TfUserNotifyFriend();
        $modelSeller = new TfSeller();
        if (empty($userId)) $userId = $this->userId();
        if (TfUser::where('user_id', $userId)->update(['action' => 0])) {
            //delete seller
            $modelSeller->deleteByUser($userId);
            //delete notify
            $modelUserNotifyActivity->deleteByUser($userId);

            $modelUserNotifyFriend->deleteByUser($userId);
        }
    }

    #========== ========== =========== USER =========== =========== ===========
    # --------- TF-USER-NOTIFY-FRIEND ----------
    public function userNotifyFriend()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Notify\TfUserNotifyFriend', 'user_id', 'user_id');
    }

    public function notifyFriendInfo($userId = null, $take = null, $takeDate = null)
    {
        $modelUserNotifyFriend = new TfUserNotifyFriend();
        return $modelUserNotifyFriend->infoOfUser((empty($userId)) ? $this->userId() : $userId, $take, $takeDate);
    }

    public function totalNewNotifyFriend($userId=null)
    {
        $modelUserNotifyFriend = new TfUserNotifyFriend();
        return $modelUserNotifyFriend->totalNewNotifyOfUser((empty($userId)) ? $this->userId() : $userId);
    }

    //----------- TF-USER-NOTIFY-ACTIVITY -----------
    public function userNotifyActivity()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Notify\TfUserNotifyActivity', 'user_id', 'user_id');
    }

    public function notifyActivityInfo($userId = null, $take = null, $takeDate = null)
    {
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        return $modelUserNotifyActivity->infoOfUser((empty($userId)) ? $this->userId() : $userId, $take, $takeDate);
    }

    public function totalNewNotifyActivity($userId=null)
    {
        $modelUserNotifyActivity = new TfUserNotifyActivity();
        return $modelUserNotifyActivity->totalNewNotifyOfUser((empty($userId)) ? $this->userId() : $userId);
    }

    # --------- TF-USER-ACCESS ----------
    public function userAccess()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Access\TfUserAccess', 'user_id', 'user_id');
    }

    # --------- TF-SEARCH ----------
    public function search()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Search\TfSearch', 'user_id', 'user_id');
    }

    #---------- TF-ADVISORY -----------
    public function advisory()
    {
        return $this->hasMany('App\Models\Manage\Content\System\Advisory\TfAdvisory', 'user_id', 'user_id');
    }

    #---------- TF-USER-STATISTIC -----------
    public function userStatistic()
    {
        return $this->hasOne('App\Models\Manage\Content\Users\Statistic\TfUserStatistic', 'user_id', 'user_id');
    }

    # ---------- TF-USER-ACTIVITY ----------
    public function userActivity()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Activity\TfUserActivity', 'user_id', 'user_id');
    }

    # ---------- TF-USER-ACTIVITY-LOVE ----------
    public function userActivityLove()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Activity\Love\TfUserActivityLove', 'userPost_id', 'post_id');
    }

    public function existLoveUserActivity($activityId, $userId = null)
    {
        $modelUserActivityLove = new TfUserActivityLove();
        return $modelUserActivityLove->existLoveActivityOfUser($activityId, (empty($userId) ? $this->userId() : $userId));
    }

    #----------- TF-USER-ACTIVITY-COMMENT -----------
    public function userActivityComment()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Activity\Comment\TfUserActivityComment', 'activity_id', 'activity_id');
    }

    # ---------- TF-USER-POST ----------
    public function userPost()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Post\TfUserPost', 'user_id', 'userPost_id');
    }

    public function userPostOnWall()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Post\TfUserPost', 'user_id', 'userWall_id');
    }

    //----------- TF-USER-POST-COMMENT -----------
    public function userPostComment()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Post\Comment\TfUserPostComment', 'user_id', 'user_id');
    }


    # --------- TF-USER-POST-LOVE --------
    //relation
    public function userPostLove()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\PostLove\TfUserPostLove', 'user_id', 'user_id');
    }

    //check user love posts of building
    public function existUserLoveUserPost($postsId = null, $userId = null)
    {
        $modelUserPostsLove = new TfUserPostLove();
        if (empty($userId)) $userId = $this->userId();
        return $modelUserPostsLove->existLovePostOfUser($postsId, $userId);
    }

    # --------- TF-RECHARGE ----------
    public function recharge()
    {
        return $this->hasManyThrough('App\Models\Manage\Content\Users\Recharge\TfRecharge', 'App\Models\Manage\Content\Users\Card\TfUserCard', 'user_id', 'card_id', 'user_id');
    }

    # --------- TF-USER-CARD ----------
    public function userCard()
    {
        return $this->hasOne('App\Models\Manage\Content\Users\Card\TfUserCard', 'user_id', 'user_id');
    }

    //get card info of user
    public function cardInfo($userId = null)
    {
        $modelUserCard = new TfUserCard();
        if (empty($userId)) $userId = $this->userId();
        return $modelUserCard->infoOfUser($userId);
    }

    //only get card id of user
    public function cardId($userId = null)
    {
        $modelUserCard = new TfUserCard();
        if (empty($userId)) $userId = $this->userId();
        return $modelUserCard->cardIdOfUser($userId);
    }

    //get point of user
    public function point($userId = null)
    {
        $modelUserCard = new TfUserCard();
        if (empty($userId)) $userId = $this->userId();
        return $modelUserCard->pointOfUser($userId);
    }

    # --------- TF-USER-CONTACT ----------
    //relation
    public function userContact()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Contact\TfUserContact', 'user_id', 'user_id');
    }

    //get contact info
    public function contactInfo($userId = null)
    {
        $modelContact = new TfUserContact();
        if (empty($userId)) $userId = $this->userId();
        return $modelContact->infoOfUser($userId);
    }

    #--------- TF-USER-SOCIALITE ----------
    //relation
    public function userSocialite()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Socialite\TfUserContact', 'user_id', 'user_id');
    }

    //statistic info
    public function statisticInfo($userId = null)
    {
        $modelUserStatistic = new TfUserStatistic();
        if (empty($userId)) $userId = $this->userId();
        return $modelUserStatistic->infoOfUser($userId);
    }

    #--------- TF-PROVINCE ----------
    public function province()
    {
        return $this->belongsToMany('App\Models\Manage\Content\System\Province\TfProvince', 'tf_user_contacts', 'user_id', 'province_id');
    }

    #--------- TF-USER-IMAGE ----------
    //relation
    public function userImage()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Image\TfUserImage', 'user_id', 'user_id');
    }

    //get all images image of user
    public function imageInfo($userId, $take = '', $dateTake = '', $typeId = null)
    {
        $modelUserImage = new TfUserImage();
        return $modelUserImage->infoOfUser($userId, $take, $dateTake, $typeId);
    }

    //get avatar of user
    public function avatar($userId = null)
    {
        $modelUserImage = new TfUserImage();
        if (empty($userId)) $userId = $this->userId();
        return $modelUserImage->avatarOfUser($userId);
    }

    //avatar is using of user
    public function imageAvatarInfoUsing($userId = null)
    {
        $modelUserImage = new TfUserImage();
        if (empty($userId)) $userId = $this->userId();
        return $modelUserImage->avatarInfoUsingOfUser($userId);
    }

    //get path avatar
    public function pathSmallAvatar($userId = null, $default = false)
    {
        $modelUserImage = new TfUserImage();
        if (empty($userId)) $userId = $this->userId();
        $image = $this->avatar($userId);
        if (empty($image)) {
            if ($default) {
                return asset('public/main/icons/people.jpeg');
            } else {
                return null;
            }
        } else {
            return $modelUserImage->pathSmallImage($image);
        }
    }

    public function pathFullAvatar($userId = null, $default = false)
    {
        $modelUserImage = new TfUserImage();
        if (empty($userId)) $userId = $this->userId();
        $image = $this->avatar($userId);
        if (empty($image)) {
            if ($default) {
                return asset('public/main/icons/people.jpeg');
            } else {
                return null;
            }
        } else {
            return $modelUserImage->pathFullImage($image);
        }
    }

    //title banner info of user
    public function imageBannerInfoUsing($userId = null)
    {
        $modelUserImage = new TfUserImage();
        if (empty($userId)) $userId = $this->userId();
        return $modelUserImage->bannerInfoUsingOfUser($userId);
    }

    public function pathDefaultBannerImage()
    {
        $modelUserImage = new TfUserImage();
        return $modelUserImage->pathDefaultBannerImage();
    }

    #---------- TF-USER-FRIEND-REQUEST ----------
    public function userFriendRequest()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\FriendRequest\TfUserFriendRequest', 'user_id', 'user_id');
    }

    //get received request info of user
    public function infoFriendRequestReceived($userId, $skip = null, $take = null)
    {
        $modelFriendRequest = new TfUserFriendRequest();
        return $modelFriendRequest->infoReceiveOfUser($userId, $skip, $take);
    }

    //get sent request info of user
    public function infoFriendRequestSent($userId, $skip = null, $take = null)
    {
        $modelFriendRequest = new TfUserFriendRequest();
        return $modelFriendRequest->infoSentOfUser($userId, $skip, $take);
    }

    //check sent request friend
    public function checkSentFriendRequest($userId = '', $checkUserId = '')
    {
        $modelFriendRequest = new TfUserFriendRequest();
        return $modelFriendRequest->checkSentRequestOfUser($userId, $checkUserId);
    }

    //check user receive request friend
    public function checkReceiveFriendRequest($userId = '', $checkUserId = '')
    {
        $modelFriendRequest = new TfUserFriendRequest();
        return $modelFriendRequest->checkReceiveFriendRequest($userId, $checkUserId);
    }

    //total new friend request
    public function totalNewFriendRequest($userId = null)
    {
        $modelFriendRequest = new TfUserFriendRequest();
        if (empty($userId)) $userId = $this->userId();
        return count($modelFriendRequest->infoNewReceiveOfUser($userId));
    }

    //total sent friend request of user
    public function totalSentFriendRequest($userId = null)
    {
        $modelFriendRequest = new TfUserFriendRequest();
        if (empty($userId)) $userId = $this->userId();
        return count($modelFriendRequest->infoSentOfUser($userId));
    }

    #----------- TF-USER-LOVE -----------
    //relation
    public function userLove()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Love\TfUserLove', 'user_id', 'user_id');
    }

    //total favourite of page
    public function totalLoved($userId = null)
    {
        $modelUserLove = new TfUserLove();
        if (empty($userId)) $userId = $this->userId();
        return $modelUserLove->totalLoveOfUser($userId);
    }

    public function checkLoveUser($userLoveId, $userId = null)
    {
        $modelUserLove = new TfUserLove();
        if (empty($userId)) $userId = $this->userId();
        return $modelUserLove->existLoveOfUser($userId, $userLoveId);
    }

    #----------- TF-USER-FRIEND -----------
    //get friend info of user
    public function infoFriend($userId, $skip = null, $take = null)
    {
        $listFriendId = $this->listFriendId($userId);
        if (empty($skip) && empty($take)) {
            return TfUser::whereIn('user_id', $listFriendId)->where('action', 1)->get();
        } else {
            return TfUser::whereIn('user_id', $listFriendId)->where('action', 1)->skip($skip)->take($take)->get();
        }
    }

    //get list friend id of user
    public function listFriendId($userId = null)
    {
        $modelUserFriend = new TfUserFriend();
        if (empty($userId)) $userId = $this->userId();
        return $modelUserFriend->listFriendOfUser($userId);
    }

    //total friend of user
    public function totalFriend($userId = null)
    {
        if (empty($userId)) $userId = $this->userId();
        return count($this->listFriendId($userId));
    }

    //check friend
    public function checkFriend($userId, $checkUserId)
    {
        $modelUserFriend = new TfUserFriend();
        return $modelUserFriend->checkFriendOfUser($userId, $checkUserId);
    }

    #****************************************************************************************************************
    #************ ************ ************ ************ ADS ************ ************ ************ ************
    #----------- TF-ADS-BANNER-LICENSE -----------
    //relation
    public function adsBannerLicense()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\License\TfAdsBannerLicense', 'user_id', 'user_id');
    }

    public function adsBannerLicenseOfUser($userId, $skip = null, $take = null)
    {
        $modelLicense = new TfAdsBannerLicense();
        return $modelLicense->infoOfUser($userId, $skip, $take);
    }

    #----------- TF-ADS-BANNER-IMAGE-VISIT -----------
    //relation
    public function adsBannerImageVisit()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\ImageVisit\TfAdsBannerImageVisit', 'user_id', 'user_id');
    }

    #----------- TF-ADS-BANNER-IMAGE-VISIT -----------
    //relation
    public function adsBannerImagePrevent()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\ImagePrevent\TfAdsBannerImagePrevent', 'user_id', 'user_id');
    }

    public function preventImageOfUser($userId = null)
    {
        $modelAdsBannerImagePrevent = new TfAdsBannerImagePrevent();
        if (empty($userId)) $userId = $this->userId();
        return $modelAdsBannerImagePrevent->preventImageOfUser($userId);
    }
    #****************************************************************************************************************
    #************ ************ ************ ************ BUILDING ************ ************ ************ ************

    #--------- TF-BUILDING ----------
    //list building Of user
    public function listBuildingIdOfUser($userId = null)
    {
        $modelBuilding = new TfBuilding();
        if (empty($userId)) $userId = $this->userId();
        return $modelBuilding->listIdOfUser($userId);
    }

    public function buildingInfo($userId, $skip = null, $take = null)
    {
        $modelBuilding = new TfBuilding();
        return $modelBuilding->infoOfUser($userId, $skip, $take);
    }

    # --------- TF-BUILDING-SAMPLE ----------
    public function buildingSample()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Sample\Building\TfBuildingSample', 'App\Models\Manage\Content\Sample\BuildingSampleLicense\TfBuildingSampleLicense', 'user_id', 'sample_id');
    }

    # ---------- TF-BUILDING-COMMENT ----------
    public function buildingComment()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Comment\TfBuildingComment', 'user_id', 'user_id');
    }

    #----------- TF-BUILDING-SAMPLE-LICENSE -----------
    public function buildingSampleLicense()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\BuildingSampleLicense\TfBuildingSampleLicense', 'user_id', 'user_id');
    }

    #----------- TF-BUILDING-FOLLOW -----------
    //relation
    public function buildingFollow()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Follow\TfBuildingFollow', 'user_id', 'user_id');
    }

    //check followed
    public function checkFollowBuilding($buildingId, $userId = null)
    {
        $modelBuildingFollow = new TfBuildingFollow();
        if (empty($userId)) $userId = $this->userId();
        return $modelBuildingFollow->existFollowBuildingOfUser($buildingId, $userId);
    }

    //get building id of user following
    public function buildingFollowId($userId = null)
    {
        $modelBuildingFollow = new TfBuildingFollow();
        if (empty($userId)) $userId = $this->userId();
        return $modelBuildingFollow->listBuildingIdOfUser($userId);
    }

    public function buildingFollowOfUser($userId, $take = '', $dateTake = '')
    {
        $modelBuildingFollow = new TfBuildingFollow();
        return $modelBuildingFollow->buildingFollowOfUser($userId, $take, $dateTake);
    }

    # --------- TF-BUILDING-LOVE --------
    //relation
    public function buildingLove()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Love\TfBuildingLove', 'user_id', 'user_id');
    }

    //check loved
    public function checkLoveBuilding($buildingId = '', $userId = null)
    {
        $modelBuildingLove = new TfBuildingLove();
        if (empty($userId)) $userId = $this->userId();
        return $modelBuildingLove->existLoveBuildingOfUser($buildingId, $userId);
    }

    #----------- TF-BUILDING-BAD-INFO-REPORT -----------
    public function buildingBadInfoReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\BadInfoReport\TfBuildingBadInfoReport', 'user_id', 'user_id');
    }

    # --------- TF-BUILDING-POST --------
    public function buildingPost()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Post\TfBuildingPost', 'user_id', 'user_id');
    }

    # --------- TF-BUILDING-POST-LOVE --------
    public function buildingPostLove()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\PostLove\TfBuildingPostLove', 'user_id', 'user_id');
    }

    //check user love posts of building
    public function existUserLovePosts($postsId = null, $userId = null)
    {
        $modelBuildingPostsLove = new TfBuildingPostLove();
        if (empty($userId)) $userId = $this->userId();
        return $modelBuildingPostsLove->existLovePostsOfUser($postsId, $userId);
    }

    # --------- TF-BUILDING-POST-COMMENT --------
    public function buildingPostComment()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\PostComment\TfBuildingPostComment', 'user_id', 'user_id');
    }

    #----------- TF-BUILDING-POST-INFO-REPORT -----------
    public function buildingPostInfoReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\PostInfoReport\TfBuildingPostInfoReport', 'user_id', 'user_id');
    }

    # --------- TF-BUILDING-ARTICLES-VISIT --------
    public function buildingArticlesVisit()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Service\ArticlesVisit\TfBuildingArticlesVisit', 'user_id', 'user_id');
    }

    # --------- TF-BUILDING-ARTICLES-LOVE --------
    public function buildingArticlesLove()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Service\ArticlesLove\TfBuildingArticlesLove', 'user_id', 'user_id');
    }

    //check user love of building
    public function existUserLoveBuildingArticles($articlesId = null, $userId = null)
    {
        $modelBuildingArticlesLove = new TfBuildingArticlesLove();
        if (empty($userId)) $userId = $this->userId();
        return $modelBuildingArticlesLove->existLoveArticlesOfUser($articlesId, $userId);
    }

    #---------- TF-BUILDING-SHARE ----------
    //relation
    public function buildingShare()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Share\TfBuildingShare', 'user_id', 'user_id');
    }

    //share info
    public function infoBuildingShare($userId, $take = null, $dataTake = null)
    {
        $modelBuildingShare = new TfBuildingShare();
        return $modelBuildingShare->infoByUser($userId, $take, $dataTake);
    }

    #----------- TF-BUILDING-SHARE-NOTIFY -----------
    public function buildingShareNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\ShareNotify\TfBuildingShareNotify', 'user_id', 'user_id');
    }

    # ---------- TF-BUILDING-VISIT-HOME ----------
    public function buildingVisitHome()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\VisitHome\TfBuildingVisitHome', 'user_id', 'user_id');
    }

    # ---------- TF-BUILDING-VISIT-WEBSITE ----------
    public function buildingVisitWebsite()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\VisitWebsite\TfBuildingVisitWebsite', 'user_id', 'user_id');
    }

    #----------- TF-BUILDING-POST-NEW-NOTIFY -----------
    public function buildingPostNewNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\PostNewNotify\TfBuildingPostNewNotify', 'user_id', 'user_id');
    }

    #----------- TF-BUILDING-NEW-NOTIFY -----------
    public function buildingNewNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Notify\TfBuildingPostLove', 'user_id', 'user_id');
    }


    #----------- TF-ADS-BANNER-IMAGE-REPORT -----------
    public function adsBannerImageReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\ImageReport\TfAdsBannerImageReport', 'user_id', 'user_id');
    }

    public function existReportAdsBannerImage($imageId, $userId = null)
    {
        $modelAdsBannerImageReport = new TfAdsBannerImageReport();
        if (empty($userId)) $userId = $this->userId();
        return $modelAdsBannerImageReport->existReportOfUserAndImage($userId, $imageId);

    }
    #**************************************************************************************************************
    #************ ************ ************ ************ BANNER ************ ************ ************ ************

    # --------- TF-BANNER ----------
    //relation
    public function banner()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Map\Banner\TfBanner', 'App\Models\Manage\Content\Map\Banner\License\TfBannerLicense', 'user_id', 'banner_id');
    }

    //get banner info of user
    public function bannerInfoOfUser($userId, $skip = null, $take = null)
    {
        $modelBanner = new TfBanner();
        return $modelBanner->infoOfUser($userId, $skip, $take);
    }

    //get list banner id of user
    public function listBannerId($userId = null)
    {
        $modelBannerLicense = new TfBannerLicense();
        if (empty($userId)) $userId = $this->userId();
        return $modelBannerLicense->listBannerIdOfUser($userId);
    }

    # --------- TF-BANNER-LICENSE ----------
    //relation
    public function bannerLicense()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\License\TfBannerLicense', 'user_id', 'user_id');
    }

    //list license of user
    public function bannerLicenseOfUser($userId, $skip = null, $take = null)
    {
        $modelBannerLicense = new TfBannerLicense();
        return $modelBannerLicense->infoOfUser($userId, $skip, $take);
    }

    #---------- TF-BANNER-LICENSE-INVITE ------------
    public function bannerLicenseInviteInfoByUser($userId = null)
    {
        $modelBannerLicenseInvite = new TfBannerLicenseInvite();
        if (empty($userId)) $userId = $this->userId();
        return $modelBannerLicenseInvite->infoSentByUser($userId);
    }

    #---------- TF-BANNER-IMAGE-VISIT -----------
    public function bannerImageVisit()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Image\TfBannerImageVisit', 'user_id', 'user_id');
    }

    #---------- TF-BANNER-BAD-INFO-REPORT -----------
    public function bannerBadInfoReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\BadInfoReport\TfBannerBadInfoReport', 'user_id', 'user_id');
    }

    #---------- TF-BANNER-COPYRIGHT-REPORT -----------
    public function bannerCopyrightReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\CopyrightReport\TfBannerCopyrightReport', 'user_id', 'user_id');
    }

    #---------- TF-BANNER-RESERVE ----------
    public function bannerReserve()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Reserve\TfBannerReserve', 'user_d', 'user_id');
    }

    #---------- TF-BANNER-SHARE ----------
    #relation
    public function bannerShare()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Share\TfBannerShare', 'user_id', 'user_id');
    }

    #share info
    public function infoBannerShare($userId, $take = null, $dataTake = null)
    {
        $modelBannerShare = new TfBannerShare();
        return $modelBannerShare->infoByUser($userId, $take, $dataTake);
    }

    #---------- TF-BANNER-SHARE-NOTIFY ----------
    public function bannerShareNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\ShareNotify\TfBannerShareNotify', 'user_id', 'user_id');
    }


    #************************************************************************************************************
    #************ ************ ************ ************ LAND ************ ************ ************ ************

    # --------- TF-LAND ----------
    public function land()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Map\Land\TfLand', 'App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'user_id', 'land_id');
    }

    # get land info of user
    public function landInfoOfUser($userId = '', $skip = '', $take = '')
    {
        $modelLand = new TfLand();
        return $modelLand->infoOfUser($userId, $skip, $take);
    }

    # get list land id of user
    public function listLandId($userId = null)
    {
        $modelLandLicense = new TfLandLicense();
        if (empty($userId)) $userId = $this->userId();
        return $modelLandLicense->listLandIdOfUser($userId);
    }


    # --------- TF-LAND-LICENSE  ----------
    public function landLicense()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'user_id', 'user_id');
    }

    //list license of user
    public function landLicenseOfUser($userId, $skip = null, $take = null)
    {
        $modelLandLicense = new TfLandLicense();
        return $modelLandLicense->infoOfUser($userId, $skip, $take);
    }

    //get license id of user
    public function landLicenseId($userId = null)
    {
        $modelLandLicense = new TfLandLicense();
        if (empty($userId)) $userId = $this->userId();
        return $modelLandLicense->listIdOfUser($userId);
    }

    #---------- TF-LAND-RESERVE ----------
    #relation
    public function landReserve()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\Reserve\TfLandReserve', 'user_id', 'user_id');
    }

    #---------- TF-LAND-SHARE ----------
    //relation
    public function landShare()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\Share\TfLandShare', 'user_id', 'user_id');
    }

    //share info
    public function infoLandShare($userId, $take = null, $dataTake = null)
    {
        $modelLandShare = new TfLandShare();
        return $modelLandShare->infoByUser($userId, $take, $dataTake);
    }

    #---------- TF-LAND-LICENSE-INVITE ------------
    public function landLicenseInviteInfoByUser($userId = null, $take = null, $dateTake = null)
    {
        $modelLandLicenseInvite = new TfLandLicenseInvite();
        if (empty($userId)) $userId = $this->userId();
        return $modelLandLicenseInvite->infoSentByUser($userId, $take, $dateTake);
    }

    #---------- TF-LAND-SHARE-NOTIFY ----------
    public function landShareNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\ShareNotify\TfLandShareNotify', 'user_id', 'user_id');
    }

    #***************************************************************************************************************
    #************ ************ ************ ************ PROJECT ************ ************ ************ ************
    # --------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Map\Project\TfProject', 'App\Models\Manage\Content\Map\Project\License\TfProjectLicense', 'user_id', 'project_id');
    }

    # ----------- TF-PROJECT-LICENSE -----------
    public function projectLicense()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\License\TfProjectLicense', 'user_id', 'user_id');
    }

    # ---------- TF-PROJECT-VISIT ----------
    public function projectVisit()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Visit\TfProjectVisit', 'user_id', 'user_id');
    }

    #***************************************************************************************************************
    #************ ************ ************ ************ SELLER ************ ************ ************ ************
    # --------- TF-SELLER ----------
    public function seller()
    {
        return $this->hasOne('App\Models\Manage\Content\Seller\TfSeller', 'user_id', 'user_id');
    }

    public function checkIsSeller($userId = null)
    {
        $modelSeller = new TfSeller();
        if (empty($userId)) $userId = $this->userId();
        return $modelSeller->checkExistUser($userId);
    }

    public function sellerInfoOfUser($userId = null)
    {
        $modelSeller = new TfSeller();
        if (empty($userId)) $userId = $this->userId();
        return $modelSeller->infoOfUser($userId);
    }
    #=========== ========== ========== CHECK INFO =========== =========== =========
    # exist account
    public function existAccount($account)
    {
        $result = TfUser::where('account', $account)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditAccount($account, $userId)
    {
        $result = TfUser::where('account', $account)->where('user_id', $userId)->count();
        return ($result > 0) ? true : false;
    }

    # exist name code
    public function existNameCode($nameCode)
    {
        $result = TfUser::where('nameCode', $nameCode)->count();
        return ($result > 0) ? true : false;
    }

    #check new user
    public function checkNewUser($userId = null)
    {
        return ($this->newInfo($userId) == 1) ? true : false;
    }


    #========== ========= ========= LOGIN ========== ========= =========
    public function loginBySocialite($userId, $socialiteName)
    {
        $dataUser = TfUser::find($userId);
        if (count($dataUser) > 0) {
            $hFunction = new \Hfunction();
            $modelUserAccess = new TfUserAccess();
            $accessIP = $hFunction->getClientIP();
            $accessStatus = 1; # default login = 1
            $modelUserAccess->insert($accessIP, $accessStatus, $dataUser->userId(), $socialiteName);
            Session::put('loginUser', $dataUser);
            return true;
        } else {
            return false;
        }
    }

    public function login($account, $pass)
    {
        //$passLog = Hash::make($pass);
        $nameCode = TfUser::where('account', $account)->pluck('nameCode');
        $passLog = $this->createUserPass($pass, $nameCode);
        $dataUser = TfUser::where('action', 1)->where('account', $account)->where('password', $passLog)->first();
        if (!empty($dataUser)) {
            # login success
            $hFunction = new \Hfunction();
            $modelUserAccess = new TfUserAccess();
            $accessIP = $hFunction->getClientIP();
            $accessStatus = 1; # default login = 1
            $modelUserAccess->insert($accessIP, $accessStatus, $dataUser->userId(), null);
            Session::put('loginUser', $dataUser);
            return true;
        } else {
            return false;
        }
    }

    # check login ->return true\false
    public function checkLogin()
    {
        if (Session::has('loginUser')) return true; else return false;
    }

    public function checkLoginPassword($password)
    {
        $dataUserLogin = $this->loginUserInfo();
        if (count($dataUserLogin) > 0) {
            if ($dataUserLogin->password() == $this->createUserPass($password, $dataUserLogin->nameCode())) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function loginUserInfo($field = null)
    {
        if (Session::has('loginUser')) {
            # logged
            $result = Session::get('loginUser');
            if (empty($field)) {
                # have not to select a field -> return all field
                return $result;
            } else {
                # have not to select a field -> return one field
                return $result->$field;
            }
        } else {
            # have not to login
            return null;
        }
    }

    public function loginUserId()
    {
        return $this->loginUserInfo('user_id');
    }

    #refresh user login info (use when user change info)
    public function refreshLoginInfo($userId)
    {
        $dataUserLogin = TfUser::find($userId);
        return Session::put('loginUser', $dataUserLogin);
    }

    #=========== ========== ========== LOGOUT ========= ========== =========
    # logout
    public function logout()
    {
        $hFunction = new \Hfunction();
        $modelUserAccess = new TfUserAccess();
        $loginUserId = $this->loginUserId();
        if (!empty($loginUserId)) {
            $accessIP = $hFunction->getClientIP();
            $accessStatus = 2; # default logout = 2
            $modelUserAccess->insert($accessIP, $accessStatus, $loginUserId);
        }
        return Session::flush();
    }

    #========== ========== ========= GET INFO =========== =========== =========
    #get user id list is using
    public function idListIsUsing()
    {
        return TfUser::where(['action' => 1, 'confirm' => 1])->lists('user_id');
    }

    public function getInfoByNameCode($nameCode)
    {
        return TfUser::where('nameCode', $nameCode)->where('action', 1)->first();
    }

    //extend
    public function getInfo($userId = '', $field = '')
    {
        if (empty($userId)) {
            return TfUser::where('action', 1)->get();
        } else {
            $result = TfUser::where('user_id', $userId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    //get info of account
    public function getInfoOfAccount($account)
    {
        return TfUser::where('account', $account)->first();
    }

    //create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = DB::select("select user_id as optionKey, CONCAT(firstName,lastName) as optionValue from tf_users where action = 1 ");
        return $hFunction->option($result, $selected);
    }

    #--------- TF-USER-EXCHANGE-LAND ----------
    //check exist free exchange
    public function existExchangeLandFree($userId = null)
    {
        $modelLandLicense = new TfLandLicense();
        if (empty($userId)) $userId = $this->userId();
        return $modelLandLicense->existFreeLicenseOfUser($userId);
    }

    public function existExchangeLandInvitation($userId = null)
    {
        $modelLandLicense = new TfLandLicense();
        if (empty($userId)) $userId = $this->userId();
        return $modelLandLicense->existInviteLicenseOfUser($userId);
    }

    #--------- TF-USER-EXCHANGE-BANNER ----------
    //check exist free exchange
    public function existExchangeBannerFree($userId = null)
    {
        $modelBannerLicense = new TfBannerLicense();
        if (empty($userId)) $userId = $this->userId();
        return $modelBannerLicense->existFreeLicenseOfUser($userId);
    }

    public function existExchangeBannerInvitation($userId = null)
    {
        $modelBannerLicense = new TfBannerLicense();
        if (empty($userId)) $userId = $this->userId();
        return $modelBannerLicense->existFreeLicenseOfUser($userId);
    }

    # ---------- USER INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUser::where('user_id', $objectId)->pluck($column);
        }
    }

    public function userId()
    {
        return $this->user_id;
    }

    public function fullName($userId = null)
    {
        if (empty($userId)) {
            return $this->firstName . ' ' . $this->lastName;
        } else {
            $result = TfUser::find($userId);
            return (!empty($result)) ? $result->firstName . ' ' . $result->lastName : null;
        }
    }

    public function firstName($userId = null)
    {
        return $this->pluck('firstName', $userId);
    }

    public function lastName($userId = null)
    {
        return $this->pluck('lastName', $userId);
    }

    public function alias($userId = null)
    {
        return $this->pluck('alias', $userId);
    }

    public function account($userId = null)
    {
        return $this->pluck('account', $userId);
    }

    public function password($userId = null)
    {
        return $this->pluck('password', $userId);
    }

    public function nameCode($userId = null)
    {
        return $this->pluck('nameCode', $userId);
    }

    public function birthday($userId = null)
    {
        return $this->pluck('birthday', $userId);
    }

    public function gender($userId = null)
    {
        return $this->pluck('gender', $userId);
    }

    public function newInfo($userId = null)
    {
        return $this->pluck('newInfo', $userId);
    }

    public function confirm($userId = null)
    {
        return $this->pluck('confirm', $userId);
    }

    public function status($userId = null)
    {
        return $this->pluck('status', $userId);
    }

    public function createdAt($userId = null)
    {
        return $this->pluck('created_at', $userId);
    }

    public function userIntroduceId($userId = null)
    {
        return $this->pluck('userIntroduce_id', $userId);
    }

    //total records
    public function totalRecords()
    {
        return TfStaff::where('action', 1)->count();
    }

    //last id
    public function lastId()
    {
        $result = TfUser::orderBy('user_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->user_id;
    }

    //get info by name code
    public function loginUserIdByNameCode($nameCode)
    {
        return TfUser::where('nameCode', $nameCode)->first();
    }

    //get info by alias
    public function getInfoByAlias($alias)
    {
        return TfUser::where('alias', $alias)->first();
    }

    #============= ============ ============= NOTIFY ============= ============= =============
    //get info notify about friend
    public function notifyAboutFriend($userId = null)
    {
        if (empty($userId)) $userId = $this->userId();
        $strQuery = "SELECT * FROM (
                                        SELECT request_id AS objectId, 'friendRequest'  AS object, created_at FROM tf_user_friend_requests WHERE requestUser_id = $userId AND action = 1
                                        UNION ALL
                                        SELECT friendUser_id AS objectId, 'friend'  AS object, created_at FROM tf_user_friends WHERE user_id = $userId AND status = 1
                                        ) as notify ORDER BY created_at DESC LIMIT 0, 100 ";
        return DB::select($strQuery);
    }

    public function searchINfo()
    {
        $strQuery = "SELECT * FROM (
                                        SELECT * FROM multichoice_questions WHERE challenge_category_id = 1 LIMIT 0, 2
                                        UNION ALL
                                        SELECT * FROM multichoice_questions WHERE challenge_category_id = 2 LIMIT 0, 3
                                        UNION ALL
                                        SELECT * FROM multichoice_questions WHERE challenge_category_id = 3 LIMIT 0, 2
                                        ) as tbl_result ORDER BY created_at DESC";
        return DB::select($strQuery);
    }
    //turn off new info status
    public function offNewNotifyOfActivity($userId = null)
    {
        $modelBuildingCommentNotify = new TfBuildingCommentNotify();
        $modelBuildingShareNotify = new TfBuildingShareNotify();
        $modelBuildingPostNewNotify = new TfBuildingPostNewNotify();
        $modelBuildingLove = new TfBuildingLove();
        $modelBannerShareNotify = new TfBannerShareNotify();
        $modelLandShareNotify = new TfLandShareNotify();

        //off new share of banner
        $modelLandShareNotify->updateNewInfoOfUser($userId);

        //off new share of banner
        $modelBannerShareNotify->updateNewInfoOfUser($userId);

        //off new comment of building
        $modelBuildingCommentNotify->updateNewInfoOfUser($userId);

        //off new love building
        $modelBuildingLove->updateNewInfoOfUser($userId);

        //off notify  user share building
        $modelBuildingShareNotify->updateNewInfoOfUser($userId);

        //off new notify
        $modelBuildingPostNewNotify->updateNewInfoOfUser($userId);
    }

    //get info notify about action
    public function notifyAboutAction($userId = null)
    {
        $modelBuilding = new TfBuilding();
        if (empty($userId)) $userId = $this->userId();
        //get building_id list  are operating of user
        $listBuilding = $this->listBuildingIdOfUser($userId);
        $listBuilding = implode(',', $listBuilding);
        $listBuilding = (empty($listBuilding)) ? 0 : $listBuilding;

        //get building_id list  are operating
        $listBuildingOperating = $modelBuilding->listBuildingIdByOperating();
        $listBuildingOperating = implode(',', $listBuildingOperating);
        $listBuildingOperating = (empty($listBuildingOperating)) ? 0 : $listBuildingOperating;
        $strQuery = "SELECT * FROM (
                                        SELECT building_id AS objectId, 'addBuilding'  AS object, created_at FROM tf_building_new_notifies  WHERE building_id IN($listBuildingOperating) AND user_id = $userId AND status = 1
                                        UNION ALL
                                        SELECT love_id AS objectId, 'loveBuilding'  AS object, created_at FROM tf_building_loves WHERE building_id IN ($listBuilding) AND newInfo = 1 AND status = 1
                                        UNION ALL
                                        SELECT comment_id AS objectId, 'commentBuilding'  AS object, created_at FROM tf_building_comment_notifies WHERE user_id = $userId AND action = 1 AND comment_id IN (SELECT comment_id FROM tf_building_comments WHERE building_id IN ($listBuildingOperating))
                                        UNION ALL
                                        SELECT share_id AS objectId, 'shareBuilding'  AS object, created_at FROM tf_building_share_notifies WHERE user_id = $userId AND status = 1 AND share_id IN (SELECT share_id FROM tf_building_shares WHERE building_id IN ($listBuildingOperating))

                                        UNION ALL
                                        SELECT share_id AS objectId, 'shareBanner'  AS object, created_at FROM tf_banner_share_notifies WHERE user_id = $userId AND status = 1 AND share_id IN (SELECT share_id FROM tf_banner_shares WHERE banner_id IN (SELECT banner_id FROM tf_banners WHERE action = 1 ))

                                        UNION ALL
                                        SELECT share_id AS objectId, 'shareLand'  AS object, created_at FROM tf_land_share_notifies WHERE user_id = $userId AND status = 1 AND share_id IN (SELECT share_id FROM tf_land_shares WHERE land_id IN (SELECT land_id FROM tf_lands WHERE action = 1))

                                        UNION ALL
                                        SELECT post_id AS objectId, 'buildingPost'  AS object, created_at FROM tf_building_post_new_notifies WHERE user_id = $userId AND displayNotify = 1 AND action = 1 AND post_id IN (SELECT post_id FROM tf_building_posts WHERE action = 1)
                                        ) as notify ORDER BY created_at DESC LIMIT 0, 100 ";

        return DB::select($strQuery);
    }

    #============= ============ ============= ACCESS INFO ON MAP ============= ============= =============
    public function projectLicenseAccess($userId = null)
    {
        $modelProjectLicense = new TfProjectLicense();
        if (empty($userId)) $userId = $this->userId();
        return $modelProjectLicense->accessLicenseOfUser($userId);
    }

    public function landLicenseAccess($userId = null)
    {
        $modelLandLicense = new TfLandLicense();
        if (empty($userId)) $userId = $this->userId();
        return $modelLandLicense->accessLicenseOfUser($userId);
    }

    public function bannerLicenseAccess($userId = null)
    {
        $modelBannerLicense = new TfBannerLicense();
        if (empty($userId)) $userId = $this->userId();
        return $modelBannerLicense->accessLicenseOfUser($userId);
    }
}
