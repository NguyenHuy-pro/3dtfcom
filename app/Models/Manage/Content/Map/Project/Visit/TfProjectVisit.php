<?php namespace App\Models\Manage\Content\Map\Project\Visit;

use Illuminate\Database\Eloquent\Model;

class TfProjectVisit extends Model
{

    protected $table = 'tf_project_visits';
    protected $fillable = ['visit_id', 'accessIP', 'created_at', 'project_id', 'user_id'];
    protected $primaryKey = 'visit_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    # ========== ========== ========== INSERT && EDIT ========= ========== ==========
    public function insert($accessIP, $projectId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelVisit = new TfProjectVisit();
        $modelVisit->accessIP = $accessIP;
        $modelVisit->project_id = $projectId;
        $modelVisit->user_id = $userId;
        $modelVisit->created_at = $hFunction->createdAt();
        if ($modelVisit->save()) {
            $this->lastId = $modelVisit->visit_id;
            return true;
        } else {
            return false;
        }
    }

    #get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'project_id', 'project_id');
    }

    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    # get info
    public function getInfo($visitId = '', $field = '')
    {
        if (empty($visitId)) {
            return null;
        } else {
            $result = TfProjectVisit::where('visit_id', $visitId)->first();
            if (empty($field)) {  # have not to select a field
                return $result; # return object or null
            } else { # have not to select a field
                return $result->$field;
            }
        }
    }

    public function accessIP($visitIP = null)
    {
        if (empty($visitIP)) {
            return $this->accessIP;
        } else {
            return $this->getInfo($visitIP, 'accessIP');
        }
    }

    # total records
    public function totalRecords()
    {
        return TfProjectVisit::count();
    }

}
