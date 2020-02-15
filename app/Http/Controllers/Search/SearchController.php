<?php namespace App\Http\Controllers\Search;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Building\TfBuilding;
use App\Models\Manage\Content\Map\Search\TfSearch;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class SearchController extends Controller
{


    public function involvedKeyword($keyword = null)
    {
        if (!empty($keyword)) {
            $modelSearch = new TfSearch();
            $dataSearch = $modelSearch->involvedKeyword($keyword);
            if (count($dataSearch) > 0) {
                return view('components.search.keyword-involved', compact('dataSearch'));
            }
        }
    }

    public function getSearchInfo($keyword = null, $businessTypeId = null)
    {
        if (!empty($keyword)) {
            $hFunction = new \Hfunction();
            $modelUser = new TfUser();
            $modelSearch = new TfSearch();
            $modelBuilding = new TfBuilding();

            $accessIP = $hFunction->getClientIP();
            if ($modelUser->checkLogin()) {
                $loginUserId = $modelUser->loginUserId();
            } else {
                $loginUserId = null;
            }
            $modelSearch->insert($keyword, $accessIP, $loginUserId);
            $dataSearchResult = $modelSearch->searchResult($keyword, $businessTypeId);
            return view('components.search.search-content-wrap', compact('modelBuilding', 'dataSearchResult'), ['keyword' => $keyword]);
        }
    }

    public function moreSearchInfo($keyword = null, $skip = null, $take = null, $businessTypeId = null)
    {
        if (!empty($keyword)) {
            $modelSearch = new TfSearch();
            $modelBuilding = new TfBuilding();


            $dataSearchResult = $modelSearch->searchResult($keyword, $businessTypeId, $skip, $take);
            if (count($dataSearchResult) > 0) {
                foreach ($dataSearchResult as $searchObject) {
                    echo view('components.search.search-object', compact('modelBuilding', 'searchObject'), ['keyword' => $keyword]);
                }
            }
        }
    }

    #---------- -------------  Small ----------- --------------
    # get involved keyword
    public function smallInvolvedKeyword($keyword = '')
    {
        $modelSearch = new TfSearch();
        $dataSearch = $modelSearch->involvedKeyword($keyword);
        if (count($dataSearch) > 0) {
            return view('components.search.small.small-keyword-involved', compact('dataSearch'));
        }
    }

    public function getSmallSearch()
    {
        return view('components.search.small.small-search-content-wrap');
    }

    # search result
    public function getSmallSearchInfo($keyword = null, $businessTypeId = null)
    {
        if (!empty($keyword)) {
            $hFunction = new \Hfunction();
            $modelUser = new TfUser();
            $modelSearch = new TfSearch();
            $modelBuilding = new TfBuilding();

            $accessIP = $hFunction->getClientIP();
            if ($modelUser->checkLogin()) {
                $loginUserId = $modelUser->loginUserId();
            } else {
                $loginUserId = null;
            }
            $modelSearch->insert($keyword, $accessIP, $loginUserId);
            $dataSearchResult = $modelSearch->searchResult($keyword, $businessTypeId);
            return view('components.search.small.small-search-content', compact('modelBuilding', 'dataSearchResult'), ['keyword' => $keyword]);
        } else {
            return redirect()->back();
        }
    }

    public function moreSmallSearchInfo($keyword = null, $skip = null, $take = null, $businessTypeId = null)
    {
        if (!empty($keyword)) {
            $modelSearch = new TfSearch();
            $modelBuilding = new TfBuilding();
            $dataSearchResult = $modelSearch->searchResult($keyword, $businessTypeId, $skip, $take);
            if (count($dataSearchResult) > 0) {
                foreach ($dataSearchResult as $searchObject) {
                    echo view('components.search.small.small-search-object', compact('modelBuilding', 'searchObject'), ['keyword' => $keyword]);
                }
            }
        }
    }

}
