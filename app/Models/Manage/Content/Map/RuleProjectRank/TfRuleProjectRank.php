<?php namespace App\Models\Manage\Content\Map\RuleProjectRank;

use Illuminate\Database\Eloquent\Model;

class TfRuleProjectRank extends Model
{

    protected $table = 'tf_rule_project_ranks';
    protected $fillable = ['rule_id', 'salePrice', 'saleMonth', 'action', 'created_at', 'rank_id'];
    protected $primaryKey = 'rule_id';
    public $timestamps = false;

    private $lastId;
    #=========== =========== =========== INSERT && UPDATE =========== =========== ===========
    #----------- Insert -----------
    public function insert($salePrice, $saleMonth, $rankId)
    {
        $hFunction = new \Hfunction();
        $modelRule = new TfRuleProjectRank();
        $modelRule->salePrice = $salePrice;
        $modelRule->saleMonth = $saleMonth;
        $modelRule->acction = 1;
        $modelRule->rank_id = $rankId;
        $modelRule->created_at = $hFunction->createdAt();
        if ($modelRule->save()) {
            $this->lastId = $modelRule->rule_id;
            return true;
        } else {
            return false;
        }
    }

    #get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- Update ------------
    public function disableOldRule()
    {
        return TfRuleProjectRank::where('action', 1)->update(['action' => 0]);
    }

    #=========== ========== ========== RELATION =========== ========== =========
    #-----------TF-RANK -----------
    public function rank()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Rank\TfRank', 'rank_id', 'rank_id');
    }

    #=========== ========== ========== GET INFO =========== ========== =========
    public function existsPriceAndMonth($salePrice, $saleMonth)
    {
        $rule = TfRuleProjectRank::where('salePrice', $salePrice)->where('saleMonth', $saleMonth)->count();
        return ($rule > 0) ? true : false;
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfRuleProjectRank::where('rule_id', $objectId)->pluck($column);
        }
    }

    public function ruleId()
    {
        return $this->rule_id;
    }

    public function rankValue($ruleId = null)
    {
        return $this->pluck('rank_id', $ruleId);
    }

    public function salePrice($ruleId = null)
    {
        return $this->pluck('salePrice', $ruleId);
    }

    public function saleMonth($ruleId = null)
    {
        return $this->pluck('saleMonth', $ruleId);
    }

    public function rankId($ruleId = null)
    {
        return $this->pluck('rank_id', $ruleId);
    }

    public function createdAt($ruleId = null)
    {
        return $this->pluck('created_at', $ruleId);
    }


    # total records -->return number
    public function totalRecords()
    {
        return TfRuleProjectRank::where('action', 1)->count();
    }

}
