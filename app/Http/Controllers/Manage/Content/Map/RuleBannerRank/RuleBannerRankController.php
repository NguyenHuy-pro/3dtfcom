<?php namespace App\Http\Controllers\Manage\Content\Map\RuleBannerRank;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Map\Rank\TfRank;
use App\Models\Manage\Content\Map\RuleBannerRank\TfRuleBannerRank;

//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class RuleBannerRankController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    # get list
    public function getList()
    {
        $modelStaff = new TfStaff();
        $modelSize = new TfSize();
        $modelRuleBannerRank = new TfRuleBannerRank();
        $accessObject = 'tool';
        $dataRuleBannerRank = TfRuleBannerRank::where('action', 1)->orderBy('rule_id', 'ASC')->select('*')->paginate(20);
        return view('manage.content.map.rule-banner-rank.list', compact('modelStaff', 'modelSize', 'modelRuleBannerRank', 'dataRuleBannerRank', 'accessObject'));
    }

    # filter
    public function getFilter($filterSizeId = '')
    {
        $modelStaff = new TfStaff();
        $modelSize = new TfSize();
        $modelRuleBannerRank = new TfRuleBannerRank();
        $accessObject = 'tool';
        if (empty($filterSizeId)) { // all size
            return redirect()->route('tf.m.c.map.rule_banner_rank.list');
        } else {  // select an size
            $dataRuleBannerRank = TfRuleBannerRank::where('size_id', $filterSizeId)->where('action', 1)->orderBy('salePrice', 'ASC')->select('*')->paginate(20);
            return view('manage.content.map.rule-banner-rank.list', compact('modelStaff', 'modelSize', 'modelRuleBannerRank', 'dataRuleBannerRank', 'filterSizeId', 'accessObject'));
        }
    }

    public function viewDetail($ruleId)
    {
        $modelRuleBannerRank = new TfRuleBannerRank();
        $dataRuleBannerRank = $modelRuleBannerRank->findInfo($ruleId);
        if (count($dataRuleBannerRank) > 0) {
            return view('manage.content.map.rule-banner-rank.view', compact('dataRuleBannerRank'));

        }
    }

    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $modelSize = new TfSize();
        $modelRuleBannerRank = new TfRuleBannerRank();
        $accessObject = 'tool';
        return view('manage.content.map.rule-banner-rank.add', compact('modelSize', 'modelRuleBannerRank', 'accessObject'));
    }

    # add
    public function postAdd(Request $request)
    {
        $modelRuleBannerRank = new TfRuleBannerRank();
        $sizeID = Request::input('cbSize');
        $salePrice = Request::input('txtSalePrice');
        $saleMonth = Request::input('txtSaleMonth');
        $freeMonth = Request::input('txtFreeMonth');
        if ($modelRuleBannerRank->existsPriceAndMonth($sizeID, $salePrice, $saleMonth, $freeMonth)) {
            Session::put('notifyAddRuleBannerRank', "Add fail, exists this price and this month ");
        } else {
            $modelRuleBannerRank->disableOldRule($sizeID);
            $objecRank = TfRank::select('*')->get();
            foreach ($objecRank as $itemRank) {
                $modelRuleBannerRank = new TfRuleBannerRank();
                $newPrice = $salePrice * $itemRank->rankValue;
                $modelRuleBannerRank->salePrice = $newPrice;
                $modelRuleBannerRank->saleMonth = $saleMonth;
                $modelRuleBannerRank->freeMonth = $freeMonth;
                $modelRuleBannerRank->dateAdded = date('Y-m-d H:j:s');
                $modelRuleBannerRank->rank_id = $itemRank->rank_id;
                $modelRuleBannerRank->size_id = $sizeID;
                $modelRuleBannerRank->save();
            }
            Session::put('notifyAddRuleBannerRank', "Add success, Enter info to continue");
        }
        return view('manage.content.map.rule-banner-rank.add');
    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit($ruleId = '')
    {
        $modelSize = new TfSize();
        $dataRuleBannerRank = TfRuleBannerRank::where('rule_id', $ruleId)->first();
        return view('manage.content.map.rule-banner-rank.edit', compact('modelSize', 'dataRuleBannerRank'));
    }

    # add
    public function postEdit($rankId = '')
    {
        $modelRuleBannerRank = new TfRuleBannerRank();
        $sizeId = Request::input('cbSize');
        $salePrice = Request::input('txtSalePrice');
        $saleMonth = Request::input('txtSaleMonth');
        $freeMonth = Request::input('txtFreeMonth');
        if ($modelRuleBannerRank->existsPriceAndMonth($rankId, $sizeId, $salePrice, $saleMonth, $freeMonth)) {
            Session::put('notifyEditRuleBannerRank', "edit fail, exists this price and this month ");
            return redirect()->back();
        } else {
            $objecRank = TfRank::select('*')->get();
            foreach ($objecRank as $itemRank) {
                $newPrice = $salePrice * $itemRank->rankValue;
                $rankId = $itemRank->rank_id;
                TfRuleBannerRank::where('size_id', $sizeId)->where('rank_id', $rankId)->where('action', 1)->update(['salePrice' => $newPrice, 'saleMonth' => $saleMonth, 'freeMonth' => $freeMonth]);
            }
            return redirect()->route('tf.m.c.map.rule_banner_rank.list');
        }


    }

}
