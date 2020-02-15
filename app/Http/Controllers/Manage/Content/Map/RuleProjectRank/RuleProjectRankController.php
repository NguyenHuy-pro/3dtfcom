<?php namespace App\Http\Controllers\Manage\Content\Map\RuleProjectRank;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Map\Rank\TfRank;
use App\Models\Manage\Content\Map\RuleProjectRank\TfRuleProjectRank;

//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class RuleProjectRankController extends Controller
{

    #=========== =========== =========== GET INFO =========== =========== ===========
    # get list
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelRuleProjectRank = new TfRuleProjectRank();
        $accessObject = 'tool';
        $dataRuleProjectRank = TfRuleProjectRank::where('action', 1)->orderBy('rule_id', 'ASC')->select('*')->paginate(30);
        return view('manage.content.map.rule-project-rank.list', compact('modelStaff','modelRuleProjectRank', 'dataRuleProjectRank', 'accessObject'));
    }

    public function viewDetail($rankId)
    {
        $dataRuleProjectRank = TfRuleProjectRank::find($rankId);
        if(count($dataRuleProjectRank) > 0){
            return view('manage.content.map.rule-project-rank.view', compact('dataRuleProjectRank'));
        }

    }
    #=========== =========== =========== ADD NEW =========== =========== ===========
    # get form add
    public function getAdd()
    {
        $accessObject = 'tool';
        return view('manage.content.map.rule-project-rank.add', compact('accessObject'));
    }

    # add
    public function postAdd(Request $request)
    {
        $modelRuleProjectRank = new TfRuleProjectRank();
        $salePrice = Request::input('txtSalePrice');
        $saleMonth = Request::input('txtSaleMonth');

        if ($modelRuleProjectRank->existsPriceAndMonth($salePrice, $saleMonth)) {
            Session::put('notifyAddRuleProjectRank', "Add fail, exists this price and this month ");
        } else {
            $modelRuleProjectRank->disableOldRule();
            $dataRank = TfRank::select('*')->get();
            foreach ($dataRank as $itemRank) {
                $newPrice = $salePrice * $itemRank->rankValue;
                $modelRuleProjectRank->insert($newPrice, $saleMonth, $itemRank->rank_id);
            }
        }


    }

    #=========== =========== =========== EDIT INFO =========== =========== ===========
    # get form edit
    public function getEdit()
    {
        $dataRuleProjectRank = TfRuleProjectRank::where('action', 1)->orderBy('salePrice', 'ASC')->first();
        if(count($dataRuleProjectRank) > 0){
            return view('manage.content.map.rule-project-rank.edit', compact('dataRuleProjectRank'));
        }

    }

    # edit
    public function postEdit()
    {
        $modelRuleProjectRank = new TfRuleProjectRank();
        $salePrice = Request::input('txtSalePrice');
        $saleMonth = Request::input('txtSaleMonth');
        if ($modelRuleProjectRank->existsPriceAndMonth($salePrice, $saleMonth)) {
            return "edit fail, Exists this price and this month ";
        } else {
            $dataRank = TfRank::select('*')->get();
            foreach ($dataRank as $itemRank) {
                $newPrice = $salePrice * $itemRank->rankValue;
                $rankId = $itemRank->rank_id;
                TfRuleProjectRank::where('rank_id', $rankId)->where('action', 1)->update(['salePrice' => $newPrice, 'saleMonth' => $saleMonth]);
            }

        }


    }
}
