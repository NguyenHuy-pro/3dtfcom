<?php namespace App\Models\Manage\Content\Users\Visit;

use Illuminate\Database\Eloquent\Model;

class TfUserVisit extends Model
{

    protected $table = 'tf_user_visits';
    protected $fillable = ['visit_id', 'accessIP', 'created_at', 'user_id', 'visitUser_id'];
    protected $primaryKey = 'visit_id';
    //public $incrementing = false;
    public $timestamps = false;
    public $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #insert
    public function insert($accessIp, $userId, $userVisitId = null)
    {
        $hFunction = new \Hfunction();
        $modelUserVisit = new TfUserVisit();
        $modelUserVisit->accessIP = $accessIp;
        $modelUserVisit->user_id = $userId;
        $modelUserVisit->visitUser_id = $userVisitId;
        $modelUserVisit->created_at = $hFunction->createdAt();
        if ($modelUserVisit->save()) {
            $this->lastId = $modelUserVisit->visit_id;
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

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-USER --------
    public function user()
    {
        return $this->belongsTo('App/Models/Manage/Content/Users/TfUser');
    }

    #========== ========== ========== Get info ========== ========== ==========
    public function getInfo($visitId = '', $field = '')
    {
        if (empty($visitId)) {
            return null;
        } else {
            $result = TfUserVisit::where('visit_id', $visitId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }


    public function accessIP($visitId)
    {
        return $this->getInfo($visitId, 'accessIP');
    }

    # total records
    public function totalRecords()
    {
        return TfUserVisit::count();
    }

}
