<?php namespace App\Models\Manage\Content\Map\Banner\BadInfoNotify;

use Illuminate\Database\Eloquent\Model;

class TfBannerBadInfoNotify extends Model
{

    protected $table = 'tf_banner_bad_info_notifies';
    protected $fillable = ['notify_id', 'content', 'newInfo', 'action', 'created_at', 'image_id', 'badInfo_id'];
    protected $primaryKey = 'notify_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    # ------------ Insert ------------
    public function insert($content = '', $imageId, $badInoId)
    {
        $hFunction = new \Hfunction();
        $modelNotify = new TfBannerBadInfoNotify();
        $modelNotify->content = $content;
        $modelNotify->newInfo = 1;
        $modelNotify->action = 1;
        $modelNotify->image_id = $imageId;
        $modelNotify->badInfo_id = $badInoId;
        $modelNotify->created_at = $hFunction->createdAt();
        if ($modelNotify->save()) {
            $this->lastId = $modelNotify->notify_id;
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

    # ------------ Update ------------
    public function updateNewINfo($notifyId)
    {
        return TfBannerBadInfoNotify::where('notify_id', $notifyId)->update(['newInfo' => 0]);
    }

    # delete
    public function actionDelete($notifyId)
    {
        return TfBannerBadInfoNotify::where('notify_id', $notifyId)->update(['action' => 0]);
    }

    #delete by image (when delete image)
    public function actionDeleteByImage($imageId = null)
    {
        if (!empty($imageId)) {
            TfBannerBadInfoNotify::where(['image_id' => $imageId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-BANNER-IMAGE -----------
    public function bannerImage()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\Image\TfBannerImage', 'image_id', 'image_id');
    }

    #----------- TF-BAD-INFO ----------- -
    public function badInfo()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\BadInfo\TfBadInfo', 'badInfo_id', 'badInfo_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($notifyId = null, $field = null)
    {
        if (empty($notifyId)) {
            return null;
        } else {
            $result = TfBannerBadInfoNotify::where('notify_id', $notifyId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function content($notifyId = null)
    {
        if (empty($notifyId)) {
            return $this->content;
        } else {
            return $this->getInfo($notifyId, 'content');
        }
    }

    # total records
    public function totalRecords()
    {
        return TfBannerBadInfoNotify::where('action', 1)->count();
    }

}
