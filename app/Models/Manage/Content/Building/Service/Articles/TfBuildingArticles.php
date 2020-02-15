<?php namespace App\Models\Manage\Content\Building\Service\Articles;

use App\Models\Manage\Content\Building\Activity\TfBuildingActivity;
use App\Models\Manage\Content\Building\Service\ArticlesComment\TfBuildingArticlesComment;
use App\Models\Manage\Content\Building\Service\ArticlesImage\TfBuildingArticlesImage;
use App\Models\Manage\Content\Building\Service\ArticlesLove\TfBuildingArticlesLove;
use App\Models\Manage\Content\Building\Service\ArticlesVisit\TfBuildingArticlesVisit;
use App\Models\Manage\Content\Building\TfBuilding;
use Illuminate\Database\Eloquent\Model;
use File;

class TfBuildingArticles extends Model
{

    protected $table = 'tf_building_articles';
    protected $fillable = ['articles_id', 'name', 'alias', 'avatar', 'shortDescription', 'keyWord', 'content', 'link', 'action', 'created_at', 'building_id', 'type_id'];
    protected $primaryKey = 'articles_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #---------- ---------- Insert ---------- ----------
    public function insert($buildingId, $typeId, $name, $shortDescription, $keyWord = null, $content = null, $avatar = null, $link = null)
    {
        $hFunction = new \Hfunction();
        $modelBuildingArticles = new TfBuildingArticles();
        $lastId = $this->lastId();
        $alias = $hFunction->alias($name, '-') . '-' . ($lastId + 1);
        $modelBuildingArticles->name = $name;
        $modelBuildingArticles->alias = $alias;
        $modelBuildingArticles->keyWord = $keyWord;
        $modelBuildingArticles->shortDescription = $shortDescription;
        $modelBuildingArticles->content = $content;
        $modelBuildingArticles->avatar = $avatar;
        $modelBuildingArticles->link = $link;
        $modelBuildingArticles->building_id = $buildingId;
        $modelBuildingArticles->type_id = $typeId;
        $modelBuildingArticles->created_at = $hFunction->createdAt();
        if ($modelBuildingArticles->save()) {
            $this->lastId = $modelBuildingArticles->articles_id;
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

    //upload image
    public function uploadImage($file, $imageName)
    {
        $hFunction = new \Hfunction();
        $pathSmallImage = "public/images/building/articles/avatars/small";
        $pathFullImage = "public/images/building/articles/avatars/full";
        if (!is_dir($pathFullImage)) mkdir($pathFullImage);
        if (!is_dir($pathSmallImage)) mkdir($pathSmallImage);
        return $hFunction->uploadSave($file, $pathSmallImage . '/', $pathFullImage . '/', $imageName, 500);
    }

    //drop image
    public function dropImage($imageName)
    {
        $oldSmallSrc = "public/images/building/articles/avatars/small/$imageName";
        $oldFullSrc = "public/images/building/articles/avatars/full/$imageName";
        if (File::exists($oldSmallSrc)) File::delete($oldSmallSrc);
        if (File::exists($oldFullSrc)) File::delete($oldFullSrc);
    }

    #---------- ---------- Update info ---------- ----------
    public function updateInfo($articlesId, $name, $shortDescription, $keyWord, $content, $avatar, $typeId, $link)
    {
        return TfBuildingArticles::where(['articles_id' => $articlesId])->update(
            [
                'name' => $name,
                'shortDescription' => $shortDescription,
                'keyWord' => $keyWord,
                'content' => $content,
                'avatar' => $avatar,
                'link' => $link,
                'type_id' => $typeId
            ]);
    }

    //delete
    public function actionDelete($articlesId = null)
    {
        #$modelBuildingArticlesComment = new TfBuildingArticlesComment();
        $modelBuildingActivity = new TfBuildingActivity();
        if (empty($articlesId)) $articlesId = $this->acticlesId();
        if (TfBuildingArticles::where('articles_id', $articlesId)->update(['action' => 0])) {
            $modelBuildingActivity->deleteByBuildingArticles($articlesId);
        }
    }

    //when delete building
    public function actionDeleteByBuilding($buildingId = null)
    {
        if (!empty($buildingId)) {
            $listId = TfBuildingArticles::where(['building_id' => $buildingId, 'action' => 1])->lists('articles_id');
            if (!empty($listId)) {
                foreach ($listId as $value) {
                    $this->actionDelete($value);
                }
            }
        }
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-BUILDING-ARTICLES-TYPE -----------
    public function buildingArticlesType()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\BuildingServiceType\TfBuildingArticlesType', 'type_id', 'type_id');
    }

    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    public function activityInfoOfBuilding($buildingId, $take = null, $dateTake = null, $typeId = 0, $keyword = null)
    {
        if ($typeId == 0 && $take === null && $dateTake === null && $keyword === null) {
            $dataArticles = TfBuildingArticles::where(['building_id' => $buildingId, 'action' => 1])->get();
        } else {
            if ($take !== null && $dateTake !== null) {
                if ($typeId != 0 && $keyword !== null) {
                    $dataArticles = TfBuildingArticles::where([
                        'building_id' => $buildingId,
                        'action' => 1,
                        'type_id' => $typeId,
                    ])->where('name', 'like', "%$keyword%")->where('created_at', '<', $dateTake)->orderBy('articles_id', 'DESC')->skip(0)->take($take)->get();
                } elseif ($typeId != 0 && $keyword === null) {
                    $dataArticles = TfBuildingArticles::where([
                        'building_id' => $buildingId,
                        'action' => 1,
                        'type_id' => $typeId,
                    ])->where('created_at', '<', $dateTake)->orderBy('articles_id', 'DESC')->skip(0)->take($take)->get();
                } elseif ($typeId == 0 && $keyword !== null) {
                    $dataArticles = TfBuildingArticles::where([
                        'building_id' => $buildingId,
                        'action' => 1,
                    ])->where('name', 'like', "%$keyword%")->where('created_at', '<', $dateTake)->orderBy('articles_id', 'DESC')->skip(0)->take($take)->get();
                } else {
                    $dataArticles = TfBuildingArticles::where([
                        'building_id' => $buildingId,
                        'action' => 1,
                    ])->where('created_at', '<', $dateTake)->orderBy('articles_id', 'DESC')->skip(0)->take($take)->get();
                }
            }
        }

        return $dataArticles;
    }

    //----------- TF-BUILDING-ARTICLES-IMAGE -----------
    public function buildingArticlesImage()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Service\ArticlesImage\TfBuildingArticlesImage', 'articles_id', 'articles_id');
    }

    public function imageActivityInfo($articlesId = null)
    {
        $modelBuildingArticlesImage = new TfBuildingArticlesImage();
        $articlesId = (empty($articlesId)) ? $this->articlesId() : $articlesId;
        return $modelBuildingArticlesImage->infoOfBuildingArticles($articlesId);
    }

    #----------- TF-BUILDING-ARTICLES-COMMENT -----------
    public function buildingArticlesComment()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Service\ArticlesComment\TfBuildingArticlesComment', 'articles_id', 'articles_id');
    }

    //total love of articles
    public function totalComment($articlesId = null)
    {
        $modelArticlesComment = new TfBuildingArticlesComment();
        if (empty($articlesId)) $articlesId = $this->articlesId();
        return $modelArticlesComment->totalOfArticles($articlesId);
    }

    // get comment of articles
    public function commentInfoOfArticles($articlesId, $take = null, $dateTake = null)
    {
        $modelArticlesComment = new TfBuildingArticlesComment();
        return $modelArticlesComment->activityInfoOfArticles($articlesId, $take, $dateTake);
    }

    #----------- TF-BUILDING-ARTICLES-LOVE -----------
    public function buildingArticlesLove()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Service\ArticlesLove\TfBuildingArticlesLove', 'articles_id', 'articles_id');
    }

    //total love of articles
    public function totalLove($articlesId = null)
    {
        $modelLove = new TfBuildingArticlesLove();
        if (empty($articlesId)) $articlesId = $this->articlesId();
        return $modelLove->totalOfArticles($articlesId);
    }

    #----------- TF-BUILDING-ARTICLES-VISIT -----------
    public function buildingArticlesVisit()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Service\ArticlesVisit\TfBuildingArticlesVisit', 'articles_id', 'articles_id');
    }

    public function totalVisit($articlesId = null)
    {
        $modelVisit = new TfBuildingArticlesVisit();
        if (empty($articlesId)) $articlesId = $this->articlesId();
        return $modelVisit->totalVisitOfArticles($articlesId);
    }

    #----------- TF-BUILDING-ACTIVITY -----------
    public function buildingActivity()
    {
        return $this->hasOne('App\Models\Manage\Content\Building\Activity\TfBuildingActivity', 'articles_id', 'articles_id');
    }

    //========== ========== ========== CHECK INFO ========= ========== ==========
    // check articles of user
    public function checkArticlesOfUser($userId, $articlesId = null)
    {
        $modelBuilding = new TfBuilding();
        return $modelBuilding->checkBuildingOfUser($this->buildingId($articlesId), $userId);
    }

    //========== ========== ========== GET INFO ========= ========== ==========
    public function infoRelationOfArticles($articlesId, $limit = 5, $getOtherType = true)
    {
        $result = TfBuildingArticles::whereNotIn('articles_id', [$articlesId])->where(['action' => 1, 'type_id' => $this->typeId($articlesId)])->limit($limit)->get();
        if (count($result) == 0 && $getOtherType) $result = TfBuildingArticles::whereNotIn('articles_id', [$articlesId])->where(['action' => 1])->limit($limit)->get();
        return $result;
    }

    public function getInfo($articlesId = null, $field = null)
    {
        if (empty($articlesId)) {
            return TfBuildingArticles::where('action', 1)->get();
        } else {
            $result = TfBuildingArticles::where(['articles_id' => $articlesId, 'action' => 1])->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    // get info by alias
    public function infoByAlias($alias)
    {
        return TfBuildingArticles::where('alias', $alias)->first();
    }

    //----------- ARTICLES INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuildingArticles::where('articles_id', $objectId)->pluck($column);
        }
    }

    public function articlesId()
    {
        return $this->articles_id;
    }

    public function name($articlesId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('name', $articlesId));
    }

    public function alias($articlesId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('alias', $articlesId));
    }

    // get building intro
    public function buildingId($articlesId = null)
    {
        return $this->pluck('building_id', $articlesId);
    }

    public function typeId($articlesId = null)
    {
        return $this->pluck('type_id', $articlesId);
    }

    public function avatar($articlesId = null)
    {
        return $this->pluck('avatar', $articlesId);
    }

    public function shortDescription($articlesId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('shortDescription', $articlesId));
    }

    public function keyWord($articlesId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('keyWord', $articlesId));
    }

    public function link($articlesId = null)
    {
        return $this->pluck('link', $articlesId);
    }

    public function content($articlesId = null)
    {
        //$hFunction = new \Hfunction();
        //return $hFunction->htmlEntities($this->pluck('content', $articlesId));
        return $this->pluck('content', $articlesId);
    }

    public function createdAt($articlesId = null)
    {
        return $this->pluck('created_at', $articlesId);
    }

    // total
    public function totalRecords()
    {
        return TfBuildingArticles::count();
    }

    // get last Id
    public function lastId()
    {
        return TfBuildingArticles::orderBy('articles_id', 'DESC')->pluck('articles_id');
    }

    //get path image
    public function pathSmallImage($image = null)
    {
        if (empty($image)) $image = $this->avatar();
        return asset("public/images/building/articles/avatars/small/$image");
    }

    public function pathFullImage($image = null)
    {
        if (empty($image)) $image = $this->avatar();
        return asset("public/images/building/articles/avatars/full/$image");
    }

}
