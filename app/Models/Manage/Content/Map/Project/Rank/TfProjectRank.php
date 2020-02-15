<?php namespace App\Models\Manage\Content\Map\Project\Rank;

use Illuminate\Database\Eloquent\Model;

class TfProjectRank extends Model
{

    protected $table = 'tf_project_ranks';
    protected $fillable = ['detail_id', 'action', 'created_at', 'project_id', 'rank_id'];
    protected $primaryKey = 'detail_id';
    public $timestamps = false;

    private $lastId;
    //========== ============ =========== INSERT & EDIT ========== ========== ==========
    #------------- Insert ------------
    # insert has option
    public function insert($projectId, $rankId)
    {
        $hFunction = new \Hfunction();
        $modelProjectRank = new TfProjectRank();
        $modelProjectRank->action = 1;
        $modelProjectRank->project_id = $projectId;
        $modelProjectRank->rank_id = $rankId;
        $modelProjectRank->created_at = $hFunction->createdAt();
        if ($modelProjectRank->save()) {
            $this->lastId = $modelProjectRank->detail_id;
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

    #------------- Update ------------
    public function actionDelete($projectId, $rankId)
    {
        return TfProjectRank::where('project_id', $projectId)->where('rank', $rankId)->update(['action' => 0]);
    }

    #delete by project (when delete project)
    public function actionDeleteByProject($projectId = null)
    {
        if (!empty($projectId)) {
            TfProjectRank::where(['project_id' => $projectId, 'action' => 1])->update(['action' => 0]);
        }
    }


    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-PROJECT -----------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'project_id', 'project_id');
    }

    #-----------TF-RANK -----------
    public function rank()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Rank\TfRank', 'rank_id', 'rank_id');
    }


    #========== ========== ========== GET INFO ========= ========== ==========
    # total records
    public function totalRecords()
    {
        return TfProjectRank::count();
    }

}
