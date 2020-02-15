<?php namespace App\Models\Manage\Content\Building\Service\ArticlesImage;

use Illuminate\Database\Eloquent\Model;

class TfBuildingArticlesImage extends Model {

    protected $table = 'tf_building_articles_images';
    protected $fillable = ['image_id', 'image','action', 'created_at', 'articles_id'];
    protected $primaryKey = 'image_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    # ========== ========== ========== INSERT && UPDATE ========= ========== ==========
    public function insert($image, $articlesId)
    {
        $hFunction = new \Hfunction();
        $modelBuildingArticlesImage = new TfBuildingArticlesImage();
        $modelBuildingArticlesImage->image = $image;
        $modelBuildingArticlesImage->articles_id = $articlesId;
        $modelBuildingArticlesImage->created_at = $hFunction->carbonNow();
        if ($modelBuildingArticlesImage->save()) {
            $this->lastId = $modelBuildingArticlesImage->image_id;
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
        return TfBuildingArticlesImage::where('image_id', $imageId)->update(['action' => 0]);
    }

    //when delete banner
    public function actionDeleteByBuildingArticles($articlesId = null)
    {
        /*if (!empty($articlesId)) {
            $objectId = TfBuildingArticlesImage::where(['articles_id' => $articlesId, 'action' => 1])->pluck('image_id');
            if (!empty($objectId)) {
                $this->actionDelete($objectId);
            }
        }*/
        return TfBuildingArticlesImage::where('articles_id', $articlesId)->update(['action' => 0]);
    }

    public function uploadImage($source_img, $imageName, $resize)
    {
        $hFunction = new \Hfunction();
        $pathFullImage = "public/images/building/articles/images/full";
        $pathSmallImage = "public/images/building/articles/images/small";
        if (!is_dir($pathFullImage)) mkdir($pathFullImage);
        if (!is_dir($pathSmallImage)) mkdir($pathSmallImage);
        return $hFunction->uploadSaveByFileName($source_img, $imageName, $pathSmallImage . '/', $pathFullImage . '/', $resize);
    }

    //drop image
    public function dropImage($imageName)
    {
        $oldSmallSrc = "public/images/building/articles/images/small/$imageName";
        $oldFullSrc = "public/images/building/articles/images/full/$imageName";
        if (File::exists($oldSmallSrc)) File::delete($oldSmallSrc);
        if (File::exists($oldFullSrc)) File::delete($oldFullSrc);

    }

    # ========== ========== ========== RELATION ========= ========== ==========
    # ---------- TF- BUILDING ARTICLES ----------
    public function buildingArticles()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Service\Articles\TfBuildingArticles', 'articles_id', 'articles_id');
    }

    //only get info is using of articles
    public function infoOfBuildingArticles($articlesId, $limit = null)
    {
        if (empty($limit)) {
            return TfBuildingArticlesImage::where('articles_id', $articlesId)->where('action', 1)->get();
        } else {
            return TfBuildingArticlesImage::where('articles_id', $articlesId)->where('action', 1)->limit($limit)->get();
        }

    }

    # ========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($imageId = null, $field = null)
    {
        if (empty($imageId)) {
            return TfBuildingArticlesImage::where('action', 1)->get();
        } else {
            $result = TfBuildingArticlesImage::where('image_id', $imageId)->first();
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
            return TfBuildingArticlesImage::where('image_id', $objectId)->pluck($column);
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

    public function articlesId($imageId = null)
    {
        return $this->pluck('articles_id', $imageId);
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
        return TfBuildingArticlesImage::where('action', 1)->count();
    }

    // last id
    public function lastId()
    {
        $result = TfBuildingArticlesImage::orderBy('image_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->image_id;
    }

    public function pathSmallImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset("public/images/building/articles/images/small/$image");
    }

    public function pathFullImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset("public/images/building/articles/images/full/$image");
    }
}
