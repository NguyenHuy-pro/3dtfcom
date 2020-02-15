<?php namespace App\Models\Manage\Content\Map\Banner\CopyrightNotify;

use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use Illuminate\Database\Eloquent\Model;

class TfBannerCopyrightNotify extends Model
{

    protected $table = 'tf_banner_copyright_notifies';
    protected $fillable = ['notify_ id', 'content', 'newInfo', 'action', 'created_at', 'image_id', 'report_id'];
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
            TfBannerCopyrightNotify::where(['image_id' => $imageId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========= ========== ==========
    public function bannerImage()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\Image\TfBannerImage');
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($notifyId = '', $field = '')
    {
        if (empty($notifyId)) {
            return TfBannerCopyrightNotify::where('action', 1)->get();
        } else {
            $result = TfBannerCopyrightNotify::where('notify_id', $notifyId)->first();
            if (empty($field)) {  # have not to select a field
                return $result; # return object or null
            } else { # have not to select a field
                return $result->$field;
            }
        }
    }

    # get name
    public function content($notifyId = null)
    {
        if (empty($notifyId)) {
            return $this->content;
        } else {
            return $this->getInfo($notifyId, 'content');
        }
    }


    # total records
    public function totalBannerCopyrightNotify()
    {
        return TfBannerCopyrightNotify::where('action', 1)->count();
    }
    # end total records

    # update action
    public function updateAction($notifyID = '')
    {
        return TfBannerCopyrightNotify::where('notify_id', $notifyID)->update(['action' => 0]);
    }

    # delete
    public function getDelete($imageID = '')
    {
        return $this->updateAction($imageID);
    }
    # end delete

}
