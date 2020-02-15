<?php namespace App\Models\Manage\Content\Building\ShareNotify;

use Illuminate\Database\Eloquent\Model;

class TfBuildingShareNotify extends Model
{

    protected $table = 'tf_building_share_notifies';
    protected $fillable = ['share_id', 'user_id', 'newInfo', 'status', 'created_at'];
    //protected $primaryKey = 'share_id';
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #----------- Insert -----------
    //add new
    public function insert($shareId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelShareNotify = new TfBuildingShareNotify();
        $modelShareNotify->share_id = $shareId;
        $modelShareNotify->user_id = $userId;
        $modelShareNotify->newInfo = 1;
        $modelShareNotify->status = 1;
        $modelShareNotify->created_at = $hFunction->createdAt();
        $modelShareNotify->save();

    }

    #----------- Update -----------
    // new info status
    public function updateNewInfo($shareId, $userId)
    {
        return TfBuildingShareNotify::where('share_id', $shareId)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    // new info status of user
    public function updateNewInfoOfUser($userId)
    {
        return TfBuildingShareNotify::where('newInfo', 1)->where('user_id', $userId)->update(['newInfo' => 0]);
    }


    // status
    public function updateStatus($shareId, $userId)
    {
        return TfBuildingShareNotify::where('share_id', $shareId)->where('user_id', $userId)->where('status', 1)->update(['status' => 0]);
    }

    // new info status
    public function actionDelete($shareId, $userId)
    {
        return TfBuildingShareNotify::where('share_id', $shareId)->where('user_id', $userId)->delete();
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #----------- TF-BUILDING-SHARE -----------
    public function buildingShare()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Share\TfBuildingShare', 'share_id', 'share_id');
    }


    #========== ========== ========== GET INFO ========== ========== ==========
    //share
    public function infoOfShare($shareId)
    {
        return TfBuildingShareNotify::where('share_id', $shareId)->get();
    }


}
