<?php namespace App\Models\Manage\Content\Building\Service\ArticlesVisit;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TfBuildingArticlesVisit extends Model {

    protected $table = 'tf_building_articles_visits';
    protected $fillable = ['visit_id', 'accessIP', 'created_id', 'articles_id', 'user_id'];
    protected $primaryKey = 'visit_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    //---------- Insert ----------
    public function insert($articlesId, $userId = null)
    {
        $hFunction = new \Hfunction();
        $modelBuildingArticlesVisit = new TfBuildingArticlesVisit();

        $accessIP = $hFunction->getClientIP();
        if (!$this->checkUserView($articlesId, $accessIP, $userId)) {
            $modelBuildingArticlesVisit->accessIP = $accessIP;
            $modelBuildingArticlesVisit->articles_id = $articlesId;
            $modelBuildingArticlesVisit->user_id = $userId;
            $modelBuildingArticlesVisit->created_at = $hFunction->createdAt();
            if ($modelBuildingArticlesVisit->save()) {
                $this->lastId = $modelBuildingArticlesVisit->visit_id;
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }

    }

    //get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-BUILDING-ARTICLES -----------
    //relation
    public function buildingArticles()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Service\Articles\TfBuildingArticles', 'articles_id', 'articles_id');
    }

    public function totalVisitOfArticles($articlesId)
    {
        return TfBuildingArticlesVisit::where('articles_id', $articlesId)->count();
    }

    #----------- TF-USER -----------
    //relation
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //visit articles of user on  a day
    public function checkUserView($articlesId, $accessIP, $userId = null)
    {
        //current date
        $checkDate = Carbon::now();
        $checkDate = Carbon::parse($checkDate->format('Y-m-d'));
        //logged
        if (!empty($userId)) {
            // last visit info
            $dataBuildingArticlesVisit = TfBuildingArticlesVisit::where([
                'articles_id' => $articlesId,
                'user_id' => $userId
            ])->orderBy('visit_id', 'DESC')->first();
            if (count($dataBuildingArticlesVisit) > 0) {
                //last date
                $viewDate = $dataBuildingArticlesVisit->createdAt();
                $viewDate = Carbon::parse($viewDate->format('Y-m-d'));
                if ($viewDate != $checkDate) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            $dataBuildingArticlesVisit = TfBuildingArticlesVisit::where([
                'articles_id' => $articlesId,
                'accessIP' => $accessIP
            ])->orderBy('visit_id', 'DESC')->first();
            if (count($dataBuildingArticlesVisit) > 0) {
                //last date
                $viewDate = $dataBuildingArticlesVisit->createdAt();
                $viewDate = Carbon::parse($viewDate->format('Y-m-d'));
                if ($viewDate != $checkDate) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($visitId = '', $field = '')
    {
        if (empty($visitId)) {
            return TfBuildingArticlesVisit::get();
        } else {
            $result = TfBuildingArticlesVisit::where('visit_id', $visitId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuildingArticlesVisit::where('visit_id', $objectId)->pluck($column);
        }
    }

    public function visitId()
    {
        return $this->visit_id;
    }

    public function accessIP($visitId = null)
    {
        if (empty($visitId)) $visitId = $this->visitId();
        return $this->pluck('accessIP', $visitId);
    }

    public function userId($visitId = null)
    {
        if (empty($visitId)) $visitId = $this->visitId();
        return $this->pluck('user_id', $visitId);
    }

    public function createdAt($visitId = null)
    {
        if (empty($visitId)) $visitId = $this->visitId();
        return $this->pluck('created_at', $visitId);
    }

    // total records
    public function totalRecords()
    {
        return TfBuildingArticlesVisit::count();
    }

}
