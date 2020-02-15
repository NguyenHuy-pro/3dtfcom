<?php namespace App\Models\Manage\Content\Users\Access;

use Illuminate\Database\Eloquent\Model;

class TfUserAccess extends Model
{

    protected $table = 'tf_user_accesses';
    protected $fillable = ['access_id', 'accessIP', 'accessStatus', 'socialiteName', 'created_at', 'action', 'user_id'];
    protected $primaryKey = 'access_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    public function insert($accessIP, $accessStatus = '', $userId, $socialiteName = null)
    {
        $hFunction = new \Hfunction();
        $modelUserAccess = new TfUserAccess();
        # disable old access status
        $modelUserAccess->updateAction($userId);
        # add new info
        $modelUserAccess->accessIP = $accessIP;
        $modelUserAccess->accessStatus = $accessStatus;
        $modelUserAccess->action = 1;
        $modelUserAccess->user_id = $userId;
        $modelUserAccess->socialiteName = $socialiteName;
        $modelUserAccess->created_at = $hFunction->createdAt();
        if ($modelUserAccess->save()) {
            $this->lastId = $modelUserAccess->access_id;
            return true;
        } else {
            return false;
        }
    }

    #get new ind after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- Update -----------
    # action
    public function updateAction($userId)
    {
        return TfUserAccess::where('user_id', $userId)->update(['action' => 0]);
    }

    #disable status is logged of an user
    public function disableLoginOfUser($userId)
    {
        return TfUserAccess::where('user_id', $userId)->where('accessStatus', 1)->where('action', 1)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($accessId = '', $field = '')
    {
        if (empty($accessId)) {
            return TfUserAccess::get();
        } else {
            $result = TfUserAccess::where('access_id', $accessId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # ---------- INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserAccess::where('access_id', $objectId)->pluck($column);
        }
    }

    public function accessId()
    {
        return $this->access_id;
    }

    public function accessIP($accessId = null)
    {
        return $this->pluck('accessIP', $accessId);
    }

    public function accessStatus($accessId = null)
    {
        return $this->pluck('accessStatus', $accessId);
    }

    public function createdAt($accessId = null)
    {
        return $this->pluck('created_at', $accessId);
    }

    public function userId($accessId = null)
    {
        return $this->pluck('user_id', $accessId);
    }

    # total records
    public function totalRecords()
    {
        return TfUserAccess::count();
    }


}
