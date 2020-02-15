<?php namespace App\Models\Manage\Content\Map\Search;

use App\Models\Manage\Content\Building\TfBuilding;
use Illuminate\Database\Eloquent\Model;

use DB;

class TfSearch extends Model
{

    protected $table = 'tf_searches';
    protected $fillable = ['search_id', 'keyword', 'accessIP', 'created_at', 'user_id'];
    protected $primaryKey = 'search_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    public function insert($keyword, $accessIP, $userId = null)
    {
        $hFunction = new \Hfunction();
        $modelSearch = new TfSearch();
        $modelSearch->keyword = $keyword;
        $modelSearch->accessIP = $accessIP;
        $modelSearch->user_id = $userId;
        $modelSearch->created_at = $hFunction->carbonNow();
        if ($modelSearch->save()) {
            $this->lastId = $modelSearch->search_id;
            return true;
        } else {
            return false;
        }
    }

    //get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($searchId = null, $field = null)
    {
        if (empty($searchId)) {
            return TfSearch::get();
        } else {
            $result = TfSearch::where('search_id', $searchId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #---------- SEARCH INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfSearch::where('search_id', $objectId)->pluck($column);
        }
    }

    public function searchId()
    {
        return $this->search_id;
    }

    public function accessIP($searchId = null)
    {
        return $this->pluck('search_id', $searchId);
    }

    public function keyword($searchId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('keyword', $searchId));
    }

    public function userId($searchId = null)
    {
        return $this->pluck('user_id', $searchId);
    }

    public function createdAt($searchId = null)
    {
        return $this->pluck('created_at', $searchId);
    }

    # total records
    public function totalRecords()
    {
        return TfSearch::count();
    }

    #========== ========== ========== search ========== ========== ==========
    //get info involved of keyword ->return list object or null
    public function involvedKeyword($keyword = '')
    {
        #heads priority keywords
        $result_1 = DB::table('tf_searches')->where('keyword', 'like', "%$keyword")->groupBy('keyword');
        $dataSearch = DB::table('tf_searches')->where('keyword', 'like', "$keyword%")->union($result_1)->groupBy('keyword')->get();
        return $dataSearch;
    }

    //get search result
    public function getSearchResult($keyword = null, $businessTypeId = null, $skip = 0, $take = null)
    {
        #$businessTypeId ==> develop later
        $searchOnDescription = DB::table('tf_buildings')->where('action', 1)->where('description', 'like', "%$keyword%")->groupBy('description');
        $searchOnEmail = DB::table('tf_buildings')->where('action', 1)->where('email', 'like', "%$keyword%")->groupBy('email');
        $searchOnAddress = DB::table('tf_buildings')->where('action', 1)->where('address', 'like', "%$keyword%")->groupBy('address');
        $searchOnWebsite = DB::table('tf_buildings')->where('action', 1)->where('website', 'like', "%$keyword%")->groupBy('website');
        $searchOnShortDescription = DB::table('tf_buildings')->where('action', 1)->where('shortDescription', 'like', "%$keyword%")->groupBy('shortDescription');
        $searchOnName = DB::table('tf_buildings')->where('action', 1)->where('name', 'like', "%$keyword%")->groupBy('name');
        if (!empty($take)) {
            $dataSearchResult = DB::table('tf_buildings')->where('action', 1)->where('name', 'like', "$keyword%")
                ->union($searchOnName)
                ->union($searchOnShortDescription)
                ->union($searchOnWebsite)
                ->union($searchOnAddress)
                ->union($searchOnEmail)
                ->union($searchOnDescription)
                ->skip($skip)->take($take)
                ->groupBy('name')->get();
        } else {
            $dataSearchResult = DB::table('tf_buildings')->where('action', 1)->where('name', 'like', "$keyword%")
                ->union($searchOnName)
                ->union($searchOnShortDescription)
                ->union($searchOnWebsite)
                ->union($searchOnAddress)
                ->union($searchOnEmail)
                ->union($searchOnDescription)
                ->groupBy('name')->get();
        }
        return $dataSearchResult;
    }

    public function searchResult($keyword = null, $businessTypeId = null, $skip = 0, $take = null)
    {

        $dataSearchResult = null;
        if (!empty($keyword)) {
            // search full string
            $dataSearchResult = $this->getSearchResult($keyword, $businessTypeId, $skip, $take);
            if (count($dataSearchResult) > 0) {
                return $dataSearchResult;
            } else {
                //Search follow each word (left->right)
                $arrayKeyword = explode(' ', $keyword);
                foreach ($arrayKeyword as $value) {
                    $dataSearchResult = $this->getSearchResult($value, $businessTypeId, $skip, $take);
                    if (count($dataSearchResult) > 0) return $dataSearchResult;
                }
            }

        }
        return $dataSearchResult;
    }
}
