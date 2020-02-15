<?php namespace App\Models\Manage\Content\Users\Image;

use App\Models\Manage\Content\Users\ImageDetail\TfUserImageDetail;
use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class TfUserImage extends Model
{

    protected $table = 'tf_user_images';
    protected $fillable = ['image_id', 'name', 'image', 'action', 'created_at', 'user_id'];
    protected $primaryKey = 'image_id';
    public $timestamps = false;

    private $lastId;

    #========== ========= ========= INSERT && EDIT ========== ========= =========
    public function insert($image, $highlight = '', $imageTypeId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelUserImage = new TfUserImage();
        $modelUserImage->name = "IMG" . $hFunction->getTimeCode();
        $modelUserImage->image = $image;
        $modelUserImage->user_id = $userId;
        $modelUserImage->created_at = $hFunction->createdAt();
        if ($modelUserImage->save()) {
            $newImageId = $modelUserImage->image_id;
            $this->lastId = $newImageId;
            $modelUserImageDetail = new TfUserImageDetail();
            if ($imageTypeId == 3 && $highlight == 1) {
                // turn off old banner
                $modelUserImageDetail->disableHighlightBannerOfUser($userId);
            } elseif ($imageTypeId == 2 && $highlight == 1) {
                // turn off old avatar
                $modelUserImageDetail->disableHighlightAvatarOfUser($userId);
            }
            $modelUserImageDetail->insert($newImageId, $imageTypeId, $highlight);
            return true;
        } else {
            return false;
        }
    }

    //get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    public function uploadImage($file, $imageName, $resize)
    {
        $hFunction = new \Hfunction();
        $pathFullImage = "public/images/user/full";
        $pathSmallImage = "public/images/user/small";
        if (!is_dir($pathFullImage)) mkdir($pathFullImage);
        if (!is_dir($pathSmallImage)) mkdir($pathSmallImage);
        return $hFunction->uploadSave($file, $pathSmallImage . '/', $pathFullImage . '/', $imageName, $resize);
    }

    //drop image
    public function dropImage($imageName)
    {
        $oldSmallSrc = "public/images/user/small/$imageName";
        $oldFullSrc = "public/images/user/full/$imageName";
        if (File::exists($oldSmallSrc)) File::delete($oldSmallSrc);
        if (File::exists($oldFullSrc)) File::delete($oldFullSrc);

    }

    #-----------Update ----------
    // delete
    public function actionDelete($imageId)
    {
        return TfUserImage::where('image_id', $imageId)->update(['action' => 0]);
    }

    #========= ========= =========  RELATION ========== ========== =========
    ## ----------- TF-USER ----------
    // get info on condition
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //---------- TF-USER-IMAGE-DETAIL -----------
    public function userImageDetail()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\ImageDetail\TfUserImageDetail', 'image_id', 'image_id');
    }
    #========== ========= ========= GET INFO ========== ========= =========
    //extend
    public function getInfo($imageId = null, $field = null)
    {
        if (empty($imageId)) {
            return TfUserImage::where('action', 1)->get();
        } else {
            $result = TfUserImage::where(['image_id'=> $imageId, 'action'=>1])->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    // get all images are using of user
    public function infoOfUser($userId, $take = '', $dateTake = '', $imageTypeId = null)
    {
        if (!empty($imageTypeId)) {
            $modelDetailImage = new TfUserImageDetail();
            $listImageId = $modelDetailImage->listImageOfType($imageTypeId);
        }

        if (empty($take) && empty($dateTake)) {
            if (!empty($imageTypeId)) {
                return TfUserImage::whereIn('image_id', $listImageId)->where('user_id', $userId)->where('action', 1)->orderBy('created_at', 'DESC')->get();
            } else {
                return TfUserImage::where('user_id', $userId)->where('action', 1)->orderBy('created_at', 'DESC')->get();
            }
        } else {
            if (!empty($imageTypeId)) {
                return TfUserImage::whereIn('image_id', $listImageId)->where('user_id', $userId)->where('action', 1)->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
            } else {
                return TfUserImage::where('user_id', $userId)->where('action', 1)->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
            }
        }

    }

    // list images id of user
    public function listIdOfUser($userId)
    {
        return TfUserImage::where('user_id', $userId)->where('action', 1)->lists('image_id');
    }

    // get avatar of user is using
    public function avatarOfUser($userId)
    {
        $result = DB::table('tf_user_images')->leftJoin('tf_user_image_details', 'tf_user_images.image_id', '=', 'tf_user_image_details.image_id')
            ->where('tf_user_images.user_id', $userId)
            ->where('tf_user_image_details.type_id', 2)
            ->where('tf_user_image_details.highlight', 1)
            ->where('tf_user_image_details.action', 1)->pluck('image');
        return $result;
    }

    // avatar info of user is using
    public function avatarInfoUsingOfUser($userId)
    {
        $result = DB::table('tf_user_images')->leftJoin('tf_user_image_details', 'tf_user_images.image_id', '=', 'tf_user_image_details.image_id')
            ->where('tf_user_images.user_id', $userId)
            ->where('tf_user_image_details.highlight', 1)
            ->where('tf_user_image_details.type_id', 2)
            ->where('tf_user_image_details.action', 1)->first();
        if (count($result) > 0) {
            return TfUserImage::find($result->image_id);
        } else {
            return null;
        }
    }

    // banner info of user is using
    public function bannerInfoUsingOfUser($userId)
    {
        $result = DB::table('tf_user_images')->leftJoin('tf_user_image_details', 'tf_user_images.image_id', '=', 'tf_user_image_details.image_id')
            ->where('tf_user_images.user_id', $userId)
            ->where('tf_user_image_details.highlight', 1)
            ->where('tf_user_image_details.type_id', 3)
            ->where('tf_user_image_details.action', 1)->first();
        if (count($result) > 0) {
            return TfUserImage::find($result->image_id);
        } else {
            return null;
        }
    }

    // get path image
    public function pathSmallImage($image = null)
    {
        if (empty($image)) $image = $this->image;
        return asset('public/images/user/small/' . $image);
    }

    public function pathFullImage($image = null)
    {
        if (empty($image)) $image = $this->image;
        return asset('public/images/user/full/' . $image);
    }

    public function pathDefaultBannerImage()
    {
        return asset('public/imgsample/test_1.jpg');
    }

    public function pathDefaultAvatarImage()
    {
        return asset('public/main/icons/people.jpeg');
    }

    ## ----------- INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserImage::where('image_id', $objectId)->pluck($column);
        }
    }

    public function imageId()
    {
        return $this->image_id;
    }

    // image
    public function image($imageId = null)
    {
        return $this->pluck('image', $imageId);
    }

    public function userId($imageId = null)
    {
        return $this->pluck('user_id', $imageId);
    }

    public function createdAt($imageId = null)
    {
        return $this->pluck('created_at', $imageId);
    }


    // total records
    public function totalRecords()
    {
        return TfUserImage::where('action', 1)->count();
    }

    // last id
    public function lastId()
    {
        $result = TfUserImage::orderBy('image_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->user_id;
    }

}
