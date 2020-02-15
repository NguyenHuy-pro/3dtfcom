<?php namespace App\Models\Manage\Content\Users\Socialite;

use Illuminate\Database\Eloquent\Model;

class TfUserSocialite extends Model
{

    protected $table = 'tf_user_socialites';
    protected $fillable = ['socialite_id', 'socialiteCode', 'userName', 'email', 'avatar', 'socialiteName', 'created_at', 'user_id'];
    protected $primaryKey = 'socialite_id';
    //public $incrementing = false;
    public $timestamps = false;
    public $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #----------- Insert -----------
    public function insert($socialiteCode, $userName, $email, $avatar, $socialiteName, $userId)
    {
        $hFunction = new \Hfunction();
        $modelSocialite = new TfUserSocialite();
        $modelSocialite->socialiteCode = $socialiteCode;
        $modelSocialite->userName = $userName;
        $modelSocialite->email = $email;
        $modelSocialite->avatar = $avatar;
        $modelSocialite->socialiteName = $socialiteName;
        $modelSocialite->user_id = $userId;
        $modelSocialite->created_at = $hFunction->createdAt();
        if ($modelSocialite->save()) {
            $this->lastId = $modelSocialite->socialite_id;
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

    #----------- Update -----------
    public function updateAvatar($socialiteId, $avatar)
    {
        return TfUserSocialite::where('socialite_id', $avatar)->update(['socialite_id' => $socialiteId]);
    }

    #delete
    public function drop($socialiteId = null)
    {
        return TfUserSocialite::where('socialite_id', $socialiteId)->delete();
    }

    public function dropOfUser($userId)
    {
        return TfUserSocialite::where('user_id', $userId)->delete(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-USER --------------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #========== ========== ========== Get info ========== ========== ==========
    public function getInfo($objectId = '', $field = '')
    {
        if (empty($objectId)) {
            return TfUserSocialite::get();
        } else {
            $result = TfUserSocialite::where('socialite_id', $objectId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #---------- User ---------
    #info of user
    public function infoOfUser($userId)
    {
        return TfUserSocialite::where('user_id', $userId)->where('action', 1)->first();
    }

    public function findInfo($socialiteId)
    {
        return TfUserSocialite::find($socialiteId);
    }

    public function infoOfSocialiteCode($socialiteCode)
    {
        return TfUserSocialite::where('socialiteCode', $socialiteCode)->first();
    }

    #--------- INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserSocialite::where('socialite_id', $objectId)->pluck($column);
        }
    }

    public function socialiteId()
    {
        return $this->socialite_id;
    }

    public function socialiteCode($objectId = null)
    {
        return $this->pluck('socialiteCode', $objectId);
    }

    public function userName($objectId = null)
    {
        return $this->pluck('userName', $objectId);
    }

    public function email($objectId = null)
    {
        return $this->pluck('email', $objectId);
    }

    public function socialiteName($objectId = null)
    {
        return $this->pluck('socialiteName', $objectId);
    }

    public function userId($objectId = null)
    {
        return $this->pluck('user_id', $objectId);
    }

    public function createdAt($objectId = null)
    {
        return $this->pluck('created_at', $objectId);
    }

    # total records
    public function totalRecords()
    {
        return TfUserSocialite::count();
    }

    #========== ========== ========== CHECK INFO ========== ========== ==========

    public function existSocialiteCode($socialiteCode)
    {
        $result = $this->infoOfSocialiteCode($socialiteCode);
        return ($result === null) ? false : true;
    }
}
