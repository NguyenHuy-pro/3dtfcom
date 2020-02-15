<?php namespace App\Models\Manage\Content\Users\Activity\Love;

use Illuminate\Database\Eloquent\Model;

class TfUserActivityLove extends Model {

    protected $table = 'tf_user_activity_loves';
    protected $fillable = ['activity_id', 'user_id','created_at'];
    #protected $primaryKey = ['userPost_id','user_id'];
    #public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #---------- Insert -----------
    public function insert($activityId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelUserActivityLove = new TfUserActivityLove();
        $modelUserActivityLove->activity_id = $activityId;
        $modelUserActivityLove->user_id = $userId;
        $modelUserActivityLove->created_at = $hFunction->createdAt();
        return $modelUserActivityLove->save();
    }
    
    // delete
    public function actionDelete($activityId, $userId)
    {
        return TfUserActivityLove::where('activity_id', $activityId)->where('user_id', $userId)->delete();
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #-----------  TF-USER ACTIVITY -----------
    public function userActivity()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Activity\TfUserActivity', 'activity_id', 'activity_id');
    }

    // total love of activity
    public function totalOfActivity($activityId)
    {
        return TfUserActivityLove::where('activity_id',$activityId)->count();
    }

    #========== ========== ========== CHECK INFO ========= ========== ==========
    public function existLoveActivityOfUser($activityId, $userId)
    {
        $result = TfUserActivityLove::where('activity_id', $activityId)->where('user_id', $userId)->count();
        return ($result > 0) ? true : false;
    }

    //total records
    public function totalRecords()
    {
        return TfUserActivityLove::count();
    }

}
