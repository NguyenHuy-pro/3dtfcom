<?php namespace App\Models\Manage\Content\Building\PostImage;

use Illuminate\Database\Eloquent\Model;
use League\Flysystem\File;

class TfBuildingPostImage extends Model
{

    protected $table = 'tf_building_posts_images';
    protected $fillable = ['image_id', 'image', 'created_at', 'post_id'];
    protected $primaryKey = 'image_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    # ========== ========== ========== INSERT && UPDATE ========= ========== ==========
    public function insert($image, $postId)
    {
        $hFunction = new \Hfunction();
        $modelBuildingPostImage = new TfBuildingPostImage();
        $modelBuildingPostImage->image = $image;
        $modelBuildingPostImage->post_id = $postId;
        $modelBuildingPostImage->created_at = $hFunction->carbonNow();
        if ($modelBuildingPostImage->save()) {
            $this->lastId = $modelBuildingPostImage->image_id;
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

    //delete
    public function actionDelete($imageId = null)
    {
        return TfBuildingPostImage::where('image_id', $imageId)->update(['action' => 0]);
    }

    //when delete banner
    public function actionDeleteByBuildingPost($postId = null)
    {
        /*if (!empty($postId)) {
            $objectId = TfBuildingPostImage::where(['post_id' => $postId, 'action' => 1])->pluck('image_id');
            if (!empty($objectId)) {
                $this->actionDelete($objectId);
            }
        }*/
        return TfBuildingPostImage::where('post_id', $postId)->update(['action' => 0]);
    }

    public function uploadImage($source_img, $imageName, $resize)
    {
        $hFunction = new \Hfunction();
        $pathFullImage = "public/images/building/posts/images/full";
        $pathSmallImage = "public/images/building/posts/images/small";
        if (!is_dir($pathFullImage)) mkdir($pathFullImage);
        if (!is_dir($pathSmallImage)) mkdir($pathSmallImage);
        return $hFunction->uploadSaveByFileName($source_img, $imageName, $pathSmallImage . '/', $pathFullImage . '/', $resize);
    }

    //drop image
    public function dropImage($imageName)
    {
        $oldSmallSrc = "public/images/building/posts/images/small/$imageName";
        $oldFullSrc = "public/images/building/posts/images/full/$imageName";
        if (File::exists($oldSmallSrc)) File::delete($oldSmallSrc);
        if (File::exists($oldFullSrc)) File::delete($oldFullSrc);

    }

    # ========== ========== ========== RELATION ========= ========== ==========
    # ---------- TF- BUILDING POST ----------
    public function buildingPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Post\TfBuildingPost', 'post_id', 'post_id');
    }

    //only get info is using of banner
    public function infoOfBuildingPost($postId, $limit = null)
    {
        if (empty($limit)) {
            return TfBuildingPostImage::where('post_id', $postId)->where('action', 1)->get();
        } else {
            return TfBuildingPostImage::where('post_id', $postId)->where('action', 1)->limit($limit)->get();
        }

    }

    # ========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($imageId = null, $field = null)
    {
        if (empty($imageId)) {
            return TfBuildingPostImage::where('action', 1)->get();
        } else {
            $result = TfBuildingPostImage::where('image_id', $imageId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #---------- IMAGE INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuildingPostImage::where('image_id', $objectId)->pluck($column);
        }
    }

    public function imageId()
    {
        return $this->image_id;
    }


    public function image($imageId = null)
    {
        return $this->pluck('image', $imageId);
    }

    public function postId($imageId = null)
    {
        return $this->pluck('post_id', $imageId);
    }

    public function action($imageId = null)
    {
        return $this->pluck('action', $imageId);
    }

    public function createdAt($imageId = null)
    {
        return $this->pluck('created_at', $imageId);
    }

    // total records
    public function totalRecords()
    {
        return TfBuildingPostImage::where('action', 1)->count();
    }

    // last id
    public function lastId()
    {
        $result = TfBuildingPostImage::orderBy('image_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->image_id;
    }

    public function pathSmallImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset("public/images/building/posts/images/small/$image");
    }

    public function pathFullImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset("public/images/building/posts/images/full/$image");
    }

}
