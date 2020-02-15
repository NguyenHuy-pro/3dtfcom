<?php namespace App\Models\Manage\Content\Users\CardActive;

use Illuminate\Database\Eloquent\Model;

class TfUserCardActive extends Model
{

    protected $table = 'tf_user_card_actives';
    protected $fillable = ['active_id', 'current', 'increase', 'decrease', 'reason', 'action', 'created_at', 'card_id'];
    protected $primaryKey = 'active_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    public function insert($current, $increase, $decrease, $reason, $cardId)
    {
        $hFunction = new \Hfunction();
        $modelUserCardActive = new TfUserCardActive();
        $modelUserCardActive->current = $current;
        $modelUserCardActive->increase = $increase;
        $modelUserCardActive->decrease = $decrease;
        $modelUserCardActive->reason = $reason;
        $modelUserCardActive->action = 1;
        $modelUserCardActive->card_id = $cardId;
        $modelUserCardActive->created_at = $hFunction->createdAt();
        if ($modelUserCardActive->save()) {
            $this->lastId = $modelUserCardActive->active_id;
            return true;
        } else {
            return false;
        }
    }

    # get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #----------- Update ------------
    public function updateStatus($activeId)
    {
        return TfUserCardActive::where('active_id', $activeId)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #------------ CARD -------------
    public function userCard()
    {
        return $this->belongsTo('App/Models/Manage/Content/Users/TfUserCard', 'card_id', 'card_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($activeId = '', $field = '')
    {
        if (empty($cardId)) {
            return TfUserCardActive::get();
        } else {
            $result = TfUserCardActive::where('active_id', $activeId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }


    #----------- ACTIVE INFO -----------
    # current point
    public function current($activeId = null)
    {
        if(empty($activeId)){
            return $this->current;
        }else{
            return $this->getInfo($activeId, 'current');
        }

    }

    # increase point
    public function increase($activeId = null)
    {
        if(empty($activeId)){
            return $this->increase;
        }else{
            return $this->getInfo($activeId, 'increase');
        }

    }

    # decrease point
    public function decrease($activeId = null)
    {
        if(empty($activeId)){
            return $this->decrease;
        }else{
            return $this->getInfo($activeId, 'decrease');
        }

    }

    # reason
    public function reason($activeId = null)
    {
        if(empty($activeId)){
            return $this->reason;
        }else{
            return $this->getInfo($activeId, 'reason');
        }

    }

    # total records
    public function totalRecords()
    {
        return TfUserCardActive::count();
    }

}
