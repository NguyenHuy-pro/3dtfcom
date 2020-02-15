<?php namespace App\Models\Manage\Content\Users\Statistic;

use Illuminate\Database\Eloquent\Model;

class TfUserStatistic extends Model
{

    protected $table = 'tf_user_statistics';
    protected $fillable = ['statistic_id', 'user_id', 'friendNotifies', 'actionNotifies', 'friends', 'buildings', 'lands',
        'banners', 'projects', 'buildingFollows', 'buildingSamples', 'friendsRequests', 'images'];
    protected $primaryKey = 'statistic_id';
    public $timestamps = false;

    #========== ========= ========= INSERT && UPDATE  ========== ========= =========
    #---------- ---------- Insert ---------- ----------
    # insert
    public function insert($userId, $friendNotifies = 0, $actionNotifies = 0, $friends = 0, $buildings = 0, $lands = 0,
                           $banners = 0, $projects = 0, $buildingFollows =0, $buildingSamples = 0, $friendsRequests = 0, $images = 0)
    {
        $modelUserStatistic = new TfUserStatistic();
        $modelUserStatistic->user_id = $userId;
        $modelUserStatistic->friendNotifies = $friendNotifies;
        $modelUserStatistic->actionNotifies = $actionNotifies;
        $modelUserStatistic->friends = $friends;
        $modelUserStatistic->buildings = $buildings;
        $modelUserStatistic->lands = $lands;
        $modelUserStatistic->banners = $banners;
        $modelUserStatistic->projects = $projects;
        $modelUserStatistic->buildingFollows = $buildingFollows;
        $modelUserStatistic->buildingSamples = $buildingSamples;
        $modelUserStatistic->friendRequests = $friendsRequests;
        $modelUserStatistic->images = $images;
        return $modelUserStatistic->save();
    }

    #---------- ---------- Update Info ---------- ----------
    # friend notify
    public function plusFriendNotify($userId)
    {
        $result = $this->getInfoOfUser($userId, 'friendNotifies') + 1;
        return TfUserStatistic::where('user_id', $userId)->update(['friendNotifies' => $result]);
    }

    public function minusFriendNotify($userId)
    {
        $result = $this->getInfoOfUser($userId, 'friendNotifies') - 1;
        $result = ($result > 0) ? $result - 1 : $result;
        return TfUserStatistic::where('user_id', $userId)->update(['friendNotifies' => $result]);
    }

    public function formatFriendNotify($userId)
    {
        return TfUserStatistic::where('user_id', $userId)->update(['friendNotifies' => 0]);
    }

    # action notify
    public function plusActionNotify($userId)
    {
        $result = $this->getInfoOfUser($userId, 'actionNotifies') + 1;
        return TfUserStatistic::where('user_id', $userId)->update(['actionNotifies' => $result]);
    }

    public function minusActionNotify($userId)
    {
        $result = $this->getInfoOfUser($userId, 'actionNotifies') - 1;

        $result = ($result > 0) ? $result - 1 : 0;
        return TfUserStatistic::where('user_id', $userId)->update(['actionNotifies' => $result]);
    }

    public function formatActionNotify($userId)
    {
        return TfUserStatistic::where('user_id', $userId)->update(['actionNotifies' => 0]);
    }

    # buildings
    public function plusBuilding($userId)
    {
        $result = $this->getInfoOfUser($userId, 'buildings') + 1;
        return TfUserStatistic::where('user_id', $userId)->update(['buildings' => $result]);
    }

    public function minusBuilding($userId)
    {
        $result = $this->getInfoOfUser($userId, 'buildings') - 1;
        return TfUserStatistic::where('user_id', $userId)->update(['buildings' => $result]);
    }

    # friend
    public function plusFriend($userId)
    {
        if(empty($userId)) $userId = $this->userId();
        $result = $this->getInfoOfUser($userId, 'friends') + 1;
        return TfUserStatistic::where('user_id', $userId)->update(['friends' => $result]);
    }

    public function minusFriend($userId)
    {
        $result = $this->getInfoOfUser($userId, 'friends') - 1;
        return TfUserStatistic::where('user_id', $userId)->update(['friends' => $result]);
    }

    # land
    public function plusLand($userId)
    {
        $result = $this->getInfoOfUser($userId, 'lands') + 1;
        return TfUserStatistic::where('user_id', $userId)->update(['lands' => $result]);
    }

    public function minusLand($userId)
    {
        $result = $this->getInfoOfUser($userId, 'lands') - 1;
        return TfUserStatistic::where('user_id', $userId)->update(['lands' => $result]);
    }

    # banner
    public function plusBanner($userId)
    {
        $result = $this->getInfoOfUser($userId, 'banners') + 1;
        return TfUserStatistic::where('user_id', $userId)->update(['banners' => $result]);
    }

    public function minusBanner($userId)
    {
        $result = $this->getInfoOfUser($userId, 'banners') - 1;
        return TfUserStatistic::where('user_id', $userId)->update(['banners' => $result]);
    }

    # project
    public function plusProject($userId)
    {
        $result = $this->getInfoOfUser($userId, 'projects') + 1;
        return TfUserStatistic::where('user_id', $userId)->update(['projects' => $result]);
    }

    public function minusProject($userId)
    {
        $result = $this->getInfoOfUser($userId, 'projects') - 1;
        return TfUserStatistic::where('user_id', $userId)->update(['projects' => $result]);
    }

    # image
    public function plusImage($userId)
    {
        $result = $this->getInfoOfUser($userId, 'images') + 1;
        return TfUserStatistic::where('user_id', $userId)->update(['images' => $result]);
    }

    public function minusImage($userId)
    {
        $result = $this->getInfoOfUser($userId, 'images') - 1;
        return TfUserStatistic::where('user_id', $userId)->update(['images' => $result]);
    }

    # building sample
    public function plusBuildingSample($userId)
    {
        $result = $this->getInfoOfUser($userId, 'buildingSamples') + 1;
        return TfUserStatistic::where('user_id', $userId)->update(['buildingSamples' => $result]);
    }

    public function minusBuildingSample($userId)
    {
        $result = $this->getInfoOfUser($userId, 'buildingSamples') - 1;
        return TfUserStatistic::where('user_id', $userId)->update(['buildingSamples' => $result]);
    }

    # friend request
    public function plusFriendRequest($userId)
    {
        $result = $this->getInfoOfUser($userId, 'friendsRequests') + 1;
        return TfUserStatistic::where('user_id', $userId)->update(['friendsRequests' => $result]);
    }

    public function minusFriendRequest($userId)
    {
        $result = $this->getInfoOfUser($userId, 'friendsRequests') - 1;
        return TfUserStatistic::where('user_id', $userId)->update(['friendsRequests' => $result]);
    }

    # friend request
    public function plusBuildingFollow($userId)
    {
        $result = $this->getInfoOfUser($userId, 'buildingFollows') + 1;
        return TfUserStatistic::where('user_id', $userId)->update(['buildingFollows' => $result]);
    }

    public function minusBuildingFollow($userId)
    {
        $result = $this->getInfoOfUser($userId, 'buildingFollows') - 1;
        return TfUserStatistic::where('user_id', $userId)->update(['buildingFollows' => $result]);
    }

    #========== ========== =========== RELATION =========== =========== ===========
    # --------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #========== ========== ========= GET INFO =========== =========== =========
    public function getInfoOfUser($userId = '', $field = '')
    {
        if (empty($userId)) {
            return TfUserStatistic::select('*')->get();
        } else {
            $result = TfUserStatistic::where('user_id', $userId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #---------- TF-USER ----------
    public function infoOfUser($userId)
    {
        return TfUserStatistic::where('user_id', $userId)->first();
    }

    #---------- Statistic info ----------

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserStatistic::where('statistic_id', $objectId)->pluck($column);
        }
    }

    public function statisticId()
    {
        return $this->statistic_id;
    }

    public function userId($statisticId = null)
    {
        return $this->pluck('user_id', $statisticId);
    }

    public function friendNotifies($statisticId = null)
    {
        return $this->pluck('friendNotifies', $statisticId);
    }

    public function actionNotifies($statisticId = null)
    {
        return $this->pluck('actionNotifies', $statisticId);
    }

    public function friends($statisticId = null)
    {
        return $this->pluck('friends', $statisticId);
    }

    public function buildings($statisticId = null)
    {
        return $this->pluck('buildings', $statisticId);
    }

    public function lands($statisticId = null)
    {
        return $this->pluck('lands', $statisticId);
    }

    public function banners($statisticId = null)
    {
        return $this->pluck('banners', $statisticId);
    }

    public function projects($statisticId = null)
    {
        return $this->pluck('projects', $statisticId);
    }

    public function buildingFollows($statisticId = null)
    {
        return $this->pluck('buildingFollows', $statisticId);
    }

    public function buildingSamples($statisticId = null)
    {
        return $this->pluck('buildingSamples', $statisticId);
    }

    public function friendRequests($statisticId = null)
    {
        return $this->pluck('friendRequests', $statisticId);
    }

    public function images($statisticId = null)
    {
        return $this->pluck('images', $statisticId);
    }

    #========== ========== ========= CHECK INFO =========== =========== =========
    public function existUser($userId)
    {
        $result = TfUserStatistic::where('user_id', $userId)->count();
        return ($result > 0) ? true : false;
    }
}
