<?php namespace App\Models\Manage\Content\Ads\Banner\ImagePrevent;

use Illuminate\Database\Eloquent\Model;

class TfAdsBannerImagePrevent extends Model
{

    protected $table = 'tf_ads_banner_image_prevents';
    protected $fillable = ['image_id', 'user_id', 'created_at'];
//    protected $primaryKey = 'share_id';
    public $timestamps = false;


    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    public function insert($userId, $imageId)
    {
        $hFunction = new \Hfunction();
        $modelPrevent = new TfAdsBannerImagePrevent();
        $modelPrevent->image_id = $imageId;
        $modelPrevent->user_id = $userId;
        $modelPrevent->created_at = $hFunction->carbonNow();
        if ($modelPrevent->save()) {
            return true;
        } else {
            return false;
        }

    }

    //drop
    public function drop($userId = null, $imageId = null)
    {
        return TfAdsBannerImagePrevent::where('user_id', $userId)->where('image_id', $imageId)->delete();
    }
    #=========== ============ ============ RELATION ============ ============ ============
    #----------- ADS-BANNER-IMAGE  ---------------
    public function adsBannerImage()
    {
        return $this->belongsTo('App\Models\Manage\Content\Ads\Banner\Image\TfAdsBannerImage', 'image_id', 'image_id');
    }

    #----------- USER ---------------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    public function existPreventOfUserAndImage($userId, $imageId)
    {
        $result = TfAdsBannerImagePrevent::where(['user_id' => $userId, 'image_id' => $imageId])->count();
        return ($result > 0) ? true : false;
    }

    public function preventImageOfUser($userId)
    {
        return TfAdsBannerImagePrevent::where('user_id', $userId)->lists('image_id');
    }


}
