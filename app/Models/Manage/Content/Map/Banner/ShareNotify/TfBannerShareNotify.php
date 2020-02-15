<?php namespace App\Models\Manage\Content\Map\Banner\ShareNotify;

use Illuminate\Database\Eloquent\Model;

class TfBannerShareNotify extends Model
{

    protected $table = 'tf_banner_share_notifies';
    protected $fillable = ['share_id', 'user_id', 'newInfo', 'status', 'created_at'];
    //protected $primaryKey = 'share_id';
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #----------- Insert -----------
    public function insert($shareId, $userId = '')
    {
        $hFunction = new \Hfunction();
        $modelShareNotify = new TfBannerShareNotify();
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
        return TfBannerShareNotify::where('share_id', $shareId)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    public function updateNewInfoOfUser($userId)
    {
        return TfBannerShareNotify::where('newInfo', 1)->where('user_id', $userId)->update(['newInfo' => 0]);
    }

    public function updateStatus($shareId, $userId)
    {
        return TfBannerShareNotify::where('share_id', $shareId)->where('user_id', $userId)->where('status', 1)->update(['status' => 0]);
    }

    // new info status
    public function getDrop($shareId, $userId)
    {
        return TfBannerShareNotify::where('share_id', $shareId)->where('user_id', $userId)->delete();
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-BANNER-SHARE ----------
    public function bannerShare()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\Share\TfBannerShare', 'share_id', 'share_id');
    }

    #---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    //share
    public function infoOfShare($shareId=null)
    {
        if(empty($shareId)) $shareId = $this->share_id;
        return TfBannerShareNotify::where('share_id', $shareId)->get();
    }

}
