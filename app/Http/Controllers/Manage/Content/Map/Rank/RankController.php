<?php namespace App\Http\Controllers\Manage\Content\Map\Rank;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\Rank\TfRank;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class RankController extends Controller
{

    public function getList()
    {
        $modelStaff = new TfStaff();
        $modelRank = new TfRank();
        $accessObject = 'tool';
        $dataRank = TfRank::orderBy('rank_id', 'ASC')->select('*')->paginate(50);
        return view('manage.content.map.rank.list', compact('modelStaff', 'modelRank', 'dataRank', 'accessObject'));
    }

}
