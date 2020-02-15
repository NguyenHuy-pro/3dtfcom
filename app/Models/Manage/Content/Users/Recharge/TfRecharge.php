<?php namespace App\Models\Manage\Content\Users\Recharge;

use Illuminate\Database\Eloquent\Model;

class TfRecharge extends Model
{

    protected $table = 'tf_recharges';
    protected $fillable = ['recharge_id', 'code', 'point', 'totalPayment', 'confirm', 'status', 'created_at', 'card_id', 'payment_id', 'transaction_id', 'staff_id'];
    protected $primaryKey = 'recharge_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========= INSERT && EDIT  =========== =========== =========
    # new insert
    public function insert($rechargeCode, $point, $totalPayment, $confirm, $status, $cardId, $paymentId, $transactionId, $staffId = null)
    {
        $hFunction = new \Hfunction();
        $modelRecharge = new TfRecharge();
        $modelRecharge->code = $rechargeCode;
        $modelRecharge->point = $point;
        $modelRecharge->totalPayment = $totalPayment;
        $modelRecharge->confirm = $confirm;
        $modelRecharge->status = $status;
        $modelRecharge->card_id = $cardId;
        $modelRecharge->payment_id = $paymentId;
        $modelRecharge->transaction_id = $transactionId;
        $modelRecharge->staff_id = $staffId;
        $modelRecharge->created_at = $hFunction->carbonNow();
        if ($modelRecharge->save()) {
            $this->lastId = $modelRecharge->recharge_id;
            return true;
        } else {
            return false;
        }
    }

    #get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #========== ========== ========= RELATION =========== =========== =========
    # --------- TF-CARD ----------
    public function userCard()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Card\TfUserCard', 'card_id', 'card_id');
    }

    # --------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Recharge\TfRecharge', 'App\Models\Manage\Content\Users\Card\TfUserCard', 'user_id', 'card_id');
    }

    # --------- TF-STAFF ----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    # --------- TF-POINT-TRANSACTION ----------
    public function pointTransaction()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\PointTransaction\TfPointTransaction', 'transaction_id', 'transaction_id');
    }

    # --------- TF-PAYMENT ----------
    public function payment()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Payment\TfPayment', 'payment_id', 'payment_id');
    }

    #========== ========== ========= CHECK INFO =========== =========== =========
    public function existRechargeCode($rechargeCode)
    {
        $result = TfRecharge::where(['code' => $rechargeCode])->count();
        return ($result > 0) ? true : false;
    }

    #========== ========== ========= GET INFO =========== =========== =========
    public function findInfo($objectId)
    {
        return TfRecharge::find($objectId);
    }

    # extend
    public function getInfo($rechargeId = null, $field = null)
    {
        if (empty($rechargeId)) {
            return null;
        } else {
            $result = TfRecharge::where('recharge_id', $rechargeId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # --------- TF-CARD ----------
    #info of card
    public function infoOfCard($cardId, $take = null, $dateTake = null)
    {
        if (empty($cardId)) {
            return null;
        } else {
            if (empty($take) && empty($dataTake)) {
                return TfRecharge::where(['card_id' => $cardId])->orderBy('created_at', 'DESC')->get();
            } else {
                return TfRecharge::where(['card_id' => $cardId])->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
            }
        }
    }


    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfRecharge::where('recharge_id', $objectId)->pluck($column);
        }
    }

    public function rechargeId()
    {
        return $this->recharge_id;
    }

    public function code($rechargeId = null)
    {
        return $this->pluck('code', $rechargeId);
    }

    public function point($rechargeId = null)
    {
        return $this->pluck('point', $rechargeId);
    }

    public function totalPayment($rechargeId = null)
    {
        return $this->pluck('totalPayment', $rechargeId);
    }

    public function confirm($rechargeId = null)
    {
        return $this->pluck('confirm', $rechargeId);
    }

    public function status($rechargeId = null)
    {
        return $this->pluck('status', $rechargeId);
    }

    public function createdAt($rechargeId = null)
    {
        return $this->pluck('created_at', $rechargeId);
    }

    public function cardId($rechargeId = null)
    {
        return $this->pluck('card_id', $rechargeId);
    }

    public function paymentId($rechargeId = null)
    {
        return $this->pluck('payment_id', $rechargeId);
    }

    public function transactionId($rechargeId = null)
    {
        return $this->pluck('transaction_id', $rechargeId);
    }

    public function staffId($rechargeId = null)
    {
        return $this->pluck('staff_id', $rechargeId);
    }

    #total records
    public function totalRecords()
    {
        return TfRecharge::count();
    }
}
