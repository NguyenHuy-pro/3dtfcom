<?php namespace App\Models\Manage\Content\Map\RuleLandRank;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfRuleLandRank extends Model
{

    protected $table = 'tf_rule_land_ranks';
    protected $fillable = ['rule_id', 'salePrice', 'saleMonth', 'freeMonth', 'action', 'created_at', 'rank_id', 'size_id'];
    protected $primaryKey = 'rule_id';
    public $timestamps = false;

    private $lastId;
    //=========== =========== =========== INSERT && UPDATE =========== =========== ===========
    //----------- Insert -----------
    public function insert($salePrice, $saleMonth, $freeMonth, $rankId, $sizeId)
    {
        $hFunction = new \Hfunction();
        $modelRule = new TfRuleLandRank();
        $modelRule->salePrice = $salePrice;
        $modelRule->saleMonth = $saleMonth;
        $modelRule->freeMonth = $freeMonth;
        $modelRule->acction = 1;
        $modelRule->rank_id = $rankId;
        $modelRule->size_id = $sizeId;
        $modelRule->created_at = $hFunction->carbonNow();
        if ($modelRule->save()) {
            $this->lastId = $modelRule->rule_id;
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

    //---------- Update ------------
    public function disableOldRule($sizeId)
    {
        return TfRuleLandRank::where('size_id', $sizeId)->where('action', 1)->update(['action' => 0]);
    }

    //=========== ========== ========== RELATION =========== ========== =========
    //-----------TF-RANK -----------
    public function rank()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Rank\TfRank', 'rank_id', 'rank_id');
    }

    //-----------TF-SIZE -----------
    public function size()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Size\TfSize', 'size_id', 'size_id');
    }


    //=========== ========== ========== GET INFO INFO =========== ========== =========
    public function findInfo($ruleId)
    {
        return TfRuleLandRank::where('rule_id', $ruleId)->first();
    }

    public function getInfo($ruleId = null, $field = null)
    {
        if (empty($ruleId)) {
            return $ruleId::where('action', 1)->get();
        } else {
            $result = TfRuleLandRank::where(['building_id' => $ruleId, 'action' => 1])->first();
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
            return TfRuleLandRank::where('rule_id', $objectId)->pluck($column);
        }
    }

    public function ruleId()
    {
        return $this->rule_id;
    }

    public function rankId($ruleId = null)
    {
        return $this->pluck('rank_id', $ruleId);
    }

    public function sizeId($ruleId = null)
    {
        return $this->pluck('size_id', $ruleId);
    }

    public function createdAt($ruleId = null)
    {
        return $this->pluck('created_at', $ruleId);
    }

    // get rule info of size and project rank
    public function infoOfSizeAndRank($sizeId, $projectRankId)
    {
        return TfRuleLandRank::where('size_id', $sizeId)->where('rank_id', $projectRankId)->where('action', 1)->first();
    }

    // price
    public function salePrice($sizeId = null, $projectRankId = null)
    {
        if (empty($sizeId) && empty($projectRankId)) {
            return $this->salePrice;
        } else {
            return TfRuleLandRank::where('size_id', $sizeId)->where('rank_id', $projectRankId)->where('action', 1)->pluck('salePrice');
        }

    }

    // sale month
    public function saleMonth($sizeId = null, $projectRankId = null)
    {
        if (empty($sizeId) && empty($projectRankId)) {
            return $this->saleMonth;
        } else {
            return TfRuleLandRank::where('size_id', $sizeId)->where('rank_id', $projectRankId)->where('action', 1)->pluck('saleMonth');
        }

    }

    // free month
    public function freeMonth($sizeId = null, $projectRankId = null)
    {
        if (empty($sizeId) && empty($projectRankId)) {
            return $this->freeMonth;
        } else {
            return TfRuleLandRank::where('size_id', $sizeId)->where('rank_id', $projectRankId)->where('action', 1)->pluck('freeMonth');
        }

    }

    // total records -->return number
    public function totalRecords()
    {
        return TfRuleLandRank::where('action', 1)->count();
    }

    //=========== ========== ========== CHECK INFO =========== ========== =========
    // exist info
    public function existsPriceAndMonth($rankId, $sizeId, $salePrice, $saleMonth, $freeMonth)
    {
        $rule = TfRuleLandRank::where('rank_id', $rankId)->where('size_id', $sizeId)->where('salePrice', $salePrice)->where('saleMonth', $saleMonth)->where('freeMonth', $freeMonth)->count();
        return ($rule > 0) ? true : false;
    }

    //exist size
    public function existSize($sizeId)
    {
        $rule = TfRuleLandRank::where('size_id', $sizeId)->where('action', 1)->count();
        return ($rule > 0) ? true : false;
    }

}
