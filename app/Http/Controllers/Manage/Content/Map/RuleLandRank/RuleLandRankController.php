<?php namespace App\Http\Controllers\Manage\Content\Map\RuleLandRank;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Map\RuleLandRank\TfRuleLandRank;

use App\Models\Manage\Content\Map\Rank\TfRank;

//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class RuleLandRankController extends Controller
{

    //=========== =========== =========== GET INFO =========== =========== ===========
    // get list
    public function getList()
    {
        $modelStaff = new TfStaff();
        $modelSize = new TfSize();
        $modelRuleLandRank = new TfRuleLandRank();
        $accessObject = 'tool';
        $dataRuleLandRank = TfRuleLandRank::where('action', 1)->orderBy('rule_id', 'ASC')->select('*')->paginate(20);
        return view('manage.content.map.rule-land-rank.list', compact('modelStaff', 'modelSize', 'modelRuleLandRank', 'dataRuleLandRank', 'accessObject'));
    }

    // filter
    public function getFilter($filterSizeId = '')
    {
        $modelStaff = new TfStaff();
        $modelSize = new TfSize();
        $modelRuleLandRank = new TfRuleLandRank();
        if (empty($filterSizeId)) { // all size
            return redirect()->route('tf.m.c.map.rule_land_rank.list');
        } else {  // select an size
            $dataRuleLandRank = TfRuleLandRank::where('size_id', $filterSizeId)->where('action', 1)->orderBy('salePrice', 'ASC')->select('*')->paginate(20);
            return view('manage.content.map.rule-land-rank.list', compact('modelStaff', 'modelSize', 'modelRuleLandRank', 'dataRuleLandRank', 'accessObject', 'filterSizeId'));
        }
    }

    public function viewDetail($ruleId)
    {
        $modelRuleLandRank = new TfRuleLandRank();
        $dataRuleLandRank = $modelRuleLandRank->findInfo($ruleId);
        if (count($dataRuleLandRank) > 0) {
            return view('manage.content.map.rule-land-rank.view', compact('dataRuleLandRank'));

        }
    }
    //=========== =========== =========== ADD NEW =========== =========== ===========
    // get form add
    public function getAdd()
    {
        $modelSize = new TfSize();
        $modelRuleLandRank = new TfRuleLandRank();
        $accessObject = 'tool';
        return view('manage.content.map.rule-land-rank.add', compact('modelSize', 'modelRuleLandRank', 'accessObject'));
    }

    // add
    public function postAdd(Request $request)
    {
        $modelRuleLandRank = new TfRuleLandRank();
        $sizeId = Request::input('cbSize');
        $salePrice = Request::input('txtSalePrice');
        $saleMonth = Request::input('txtSaleMonth');
        $freeMonth = Request::input('txtFreeMonth');
        if ($modelRuleLandRank->existsPriceAndMonth($sizeId, $salePrice, $saleMonth, $freeMonth)) {
            Session::put('notifyAddRuleLandRank', "Add fail, exists this price and this month ");

        } else {
            $modelRuleLandRank->disableOldRule($sizeId);
            $objecRank = TfRank::select('*')->get();
            foreach ($objecRank as $itemRank) {
                $modelRuleLandRank = new TfRuleLandRank();
                $newPrice = $salePrice * $itemRank->rankValue;
                $modelRuleLandRank->salePrice = $newPrice;
                $modelRuleLandRank->saleMonth = $saleMonth;
                $modelRuleLandRank->freeMonth = $freeMonth;
                $modelRuleLandRank->dateAdded = date('Y-m-d H:j:s');
                $modelRuleLandRank->rank_id = $itemRank->rank_id;
                $modelRuleLandRank->size_id = $sizeId;
                $modelRuleLandRank->save();
            }
            Session::put('notifyAddRuleLandRank', "Add success, Enter info to continue");
        }
        return view('manage.content.map.rule-land-rank.add');
    }

    //=========== =========== =========== EDIT INFO =========== =========== ===========
    // get form edit
    public function getEdit($ruleId = '')
    {
        $dataRuleLandRank = TfRuleLandRank::where('rule_id', $ruleId)->first();
        return view('manage.content.map.rule-land-rank.edit', compact('dataRuleLandRank'));
    }

    // edit
    public function postEdit(Request $request, $rankId = '')
    {
        $modelRuleLandRank = new TfRuleLandRank();
        $sizeId = Request::input('cbSize');
        $salePrice = Request::input('txtSalePrice');
        $saleMonth = Request::input('txtSaleMonth');
        $freeMonth = Request::input('txtFreeMonth');
        if ($modelRuleLandRank->existsPriceAndMonth($rankId, $sizeId, $salePrice, $saleMonth, $freeMonth)) {
            Session::put('notifyEditRuleLandRank', "edit fail, exists this price and this month ");
            return redirect()->back();
        } else {
            $objecRank = TfRank::select('*')->get();
            foreach ($objecRank as $itemRank) {
                $newPrice = $salePrice * $itemRank->rankValue;
                $rankId = $itemRank->rank_id;
                TfRuleLandRank::where('size_id', $sizeId)->where('rank_id', $rankId)->where('action', 1)->update(['salePrice' => $newPrice, 'saleMonth' => $saleMonth, 'freeMonth' => $freeMonth]);
            }
            return redirect()->route('tf.m.c.map.rule_land_rank.list');
        }


    }
}
