<?php namespace App\Models\Manage\Content\Building\Service\ArticlesLove;

use Illuminate\Database\Eloquent\Model;

class TfBuildingArticlesLove extends Model {

    protected $table = 'tf_building_articles_loves';
    protected $fillable = ['articles_id', 'user_id', 'created_at'];
    #protected $primaryKey = ['buildingarticles_id','user_id'];
    #public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #---------- Insert -----------
    public function insert($articlesId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelLove = new TfBuildingArticlesLove();
        $modelLove->articles_id = $articlesId;
        $modelLove->user_id = $userId;
        $modelLove->created_at = $hFunction->createdAt();
        return $modelLove->save();
    }
    
    # delete
    public function actionDelete($articlesId, $userId)
    {
        return TfBuildingArticlesLove::where('articles_id', $articlesId)->where('user_id', $userId)->delete();
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #-----------  TF-BUILDING-ARTICLES -----------
    public function buildingArticles()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Service\Articles\TfBuildingArticles', 'articles_id', 'articles_id');
    }

    # total love of articles
    public function totalOfArticles($articlesId)
    {
        return TfBuildingArticlesLove::where('articles_id',$articlesId)->count();
    }

    #========== ========== ========== CHECK INFO ========= ========== ==========
    public function existLoveArticlesOfUser($articlesId, $userId)
    {
        $result = TfBuildingArticlesLove::where('articles_id', $articlesId)->where('user_id', $userId)->count();
        return ($result > 0) ? true : false;
    }

    # total records
    public function totalRecords()
    {
        return TfBuildingArticlesLove::count();
    }

}
