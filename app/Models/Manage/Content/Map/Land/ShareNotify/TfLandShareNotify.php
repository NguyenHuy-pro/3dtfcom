<?php namespace App\Models\Manage\Content\Map\Land\ShareNotify;

use Illuminate\Database\Eloquent\Model;

class TfLandShareNotify extends Model
{

    protected $table = 'tf_land_share_notifies';
    protected $fillable = ['share_id', 'user_id', 'newInfo', 'status', 'created_at'];
    //protected $primaryKey = 'share_id';
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #----------- Insert -----------
    public function insert($shareId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelShareNotify = new TfLandShareNotify();
        $modelShareNotify->share_id = $shareId;
        $modelShareNotify->user_id = $userId;
        $modelShareNotify->newInfo = 1;
        $modelShareNotify->status = 1;
        $modelShareNotify->created_at = $hFunction->createdAt();
        return $modelShareNotify->save();

    }

    #----------- Update -----------
    public function updateNewInfo($shareId, $userId)
    {
        return TfLandShareNotify::where('share_id', $shareId)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    public function updateNewInfoOfUser($userId)
    {
        return TfLandShareNotify::where('newInfo', 1)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    // status
    public function updateStatus($shareId, $userId)
    {
        return TfLandShareNotify::where('share_id', $shareId)->where('user_id', $userId)->where('status', 1)->update(['status' => 0]);
    }

    // new info status
    public function getDrop($shareId, $userId)
    {
        return TfLandShareNotify::where('share_id', $shareId)->where('user_id', $userId)->delete();
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-LAND-SHARE ----------
    public function landShare()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\Share\TfLandShare', 'share_id', 'share_id');
    }

    #---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #========== ========== ========== Get info ========== ========== ==========
    //share
    public function infoOfShare($shareId)
    {
        return TfLandShareNotify::where('share_id', $shareId)->get();
    }

}
