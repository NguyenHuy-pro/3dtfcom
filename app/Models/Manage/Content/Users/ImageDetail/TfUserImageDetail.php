<?php namespace App\Models\Manage\Content\Users\ImageDetail;

use App\Models\Manage\Content\Users\Image\TfUserImage;
use Illuminate\Database\Eloquent\Model;

class TfUserImageDetail extends Model
{

    protected $table = 'tf_user_image_details';
    protected $fillable = ['image_id', 'type_id', 'highlight', 'action', 'created_at'];
    #protected $primaryKey = 'share_id';
    public $timestamps = false;

    #========= ========== ========= INSERT && UPDATE ========== ========== ==========
    #----------- Insert ----------
    public function insert($imageId, $typeId, $highlight = '')
    {
        $hFunction = new \Hfunction();
        $modelUserImageDetail = new TfUserImageDetail();
        $modelUserImageDetail->image_id = $imageId;
        $modelUserImageDetail->type_id = $typeId;    # avatar type
        $modelUserImageDetail->highlight = $highlight;    # avatar type
        $modelUserImageDetail->action = 1;
        $modelUserImageDetail->created_at = $hFunction->createdAt();
        return $modelUserImageDetail->save();
    }

    #----------- Update ----------
    # delete
    public function actionDelete($imageId, $typeId)
    {
        return TfUserImageDetail::where('image_id', $imageId)->where('type_id', $typeId)->update(['action' => 0]);
    }

    #========= ========== ========= GET INFO ========== ========== ==========
    # ---------- ---------- User ---------- ----------
    #disable highlight banner of user
    public function disableHighlightBannerOfUser($userId)
    {
        $modelImage = new TfUserImage();
        $listImage = $modelImage->listIdOfUser($userId);
        # default: 3 - banner
        return TfUserImageDetail::whereIn('image_id', $listImage)->where('type_id', 3)->where('highlight', 1)->update(['highlight' => 0]);
    }

    #disable highlight avatar of user
    public function disableHighlightAvatarOfUser($userId)
    {
        $modelImage = new TfUserImage();
        $listImage = $modelImage->listIdOfUser($userId);
        # default: 2 - avatar
        return TfUserImageDetail::whereIn('image_id', $listImage)->where('type_id', 2)->where('highlight', 1)->update(['highlight' => 0]);
    }

    # ---------- ---------- IMAGE ---------- ----------
    # get image info on condition
    public function userImage()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Image\TfUserImage', 'image_id', 'image_id');
    }

    # ---------- ---------- IMAGE TYPE ---------- ----------
    # get type info on condition
    public function userImageType()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Image\TfUserImageType', 'type_id', 'type_id');
    }

    # get list image id of image type is using (return list id)
    public function listImageOfType($typeId)
    {
        return TfUserImageDetail::where('type_id', $typeId)->where('action', 1)->lists('image_id');
    }

}
