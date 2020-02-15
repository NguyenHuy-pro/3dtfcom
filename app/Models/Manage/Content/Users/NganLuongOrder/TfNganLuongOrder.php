<?php namespace App\Models\Manage\Content\Users\NganLuongOrder;

use Illuminate\Database\Eloquent\Model;

class TfNganLuongOrder extends Model
{

    protected $table = 'tf_ngan_luong_orders';
    protected $fillable = ['order_id', 'orderCode', 'point', 'moneyCode', 'transactionInfo', 'price', 'paymentId', 'paymentType', 'errorText', 'sourceCode', 'transactionStatus', 'status', 'created_at', 'card_id', 'wallet_id', 'pointType_id'];
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========= INSERT && EDIT  =========== =========== =========
    # new insert
    public function insert($orderCode, $point, $moneyCode, $transactionInfo, $price, $paymentId, $paymentType, $errorText, $sourceCode, $transactionStatus, $status, $cardId, $walletId, $transactionId)
    {
        $hFunction = new \Hfunction();
        $modelOrder = new TfNganLuongOrder();
        $modelOrder->orderCode = $orderCode;
        $modelOrder->point = $point;
        $modelOrder->moneyCode = $moneyCode;
        $modelOrder->transactionInfo = $transactionInfo;
        $modelOrder->price = $price;
        $modelOrder->paymentId = $paymentId;
        $modelOrder->paymentType = $paymentType;
        $modelOrder->errorText = $errorText;
        $modelOrder->sourceCode = $sourceCode;
        $modelOrder->transactionStatus = $transactionStatus;
        $modelOrder->status = $status;
        $modelOrder->card_id = $cardId;
        $modelOrder->wallet_id = $walletId;
        $modelOrder->transaction_id = $transactionId;
        $modelOrder->created_at = $hFunction->carbonNow();
        if ($modelOrder->save()) {
            $this->lastId = $modelOrder->order_id;
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

    # --------- TF-WALLET ----------
    public function wallet()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Wallet', 'wallet_id', 'wallet_id');
    }

    # --------- TF-POINT-TRANSACTION ----------
    public function pointTransaction()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\PointTransaction\TfPointTransaction', 'transaction_id', 'transaction_id');
    }

    #========== ========== ========= GET INFO =========== =========== ========
    # extend
    public function getInfo($objectId = null, $field = null)
    {
        if (empty($objectId)) {
            return TfNganLuongOrder::get();
        } else {
            $result = TfNganLuongOrder::where('order_id', $objectId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # --------- TF-CARD ----------
    #info of card
    public function infoOfCard($cardId, $take = '', $dateTake = '')
    {
        if (empty($cardId)) {
            return null;
        } else {
            if (empty($take) && empty($dateTake)) {
                return  TfNganLuongOrder::where('card_id',$cardId)->orderBy('created_at', 'DESC')->get();
            } else {
                if(empty($dateTake)){
                    return TfNganLuongOrder::where('card_id', $cardId)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
                }else{
                    return  TfNganLuongOrder::where('card_id' ,$cardId)->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
                }

            }
        }
    }


    public function findInfo($id)
    {
        return TfNganLuongOrder::find($id);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfNganLuongOrder::where('order_id', $objectId)->pluck($column);
        }
    }

    public function orderId()
    {
        return $this->order_id;
    }

    public function orderCode($orderId = null)
    {
        return $this->pluck('orderCode', $orderId);
    }

    public function point($orderId = null)
    {
        return $this->pluck('point', $orderId);
    }

    public function moneyCode($orderId = null)
    {
        return $this->pluck('moneyCode', $orderId);
    }

    public function transactionInfo($orderId = null)
    {
        return $this->pluck('transactionInfo', $orderId);
    }

    public function price($orderId = null)
    {
        return $this->pluck('price', $orderId);
    }

    public function paymentId($orderId = null)
    {
        return $this->pluck('paymentId', $orderId);
    }

    public function paymentType($orderId = null)
    {
        return $this->pluck('paymentType', $orderId);
    }

    public function errorText($orderId = null)
    {
        return $this->pluck('errorText', $orderId);
    }

    public function sourceCode($orderId = null)
    {
        return $this->pluck('sourceCode', $orderId);
    }

    public function transactionStatus($orderId = null)
    {
        return $this->pluck('transactionStatus', $orderId);
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

    public function walletId($rechargeId = null)
    {
        return $this->pluck('wallet_id', $rechargeId);
    }

    public function transactionId($rechargeId = null)
    {
        return $this->pluck('transaction_id', $rechargeId);
    }

    #total records
    public function totalRecords()
    {
        return TfNganLuongOrder::count();
    }

    #========== ============ CHECK INFO =========== ==============
    public function checkExistOrderCode($orderCode)
    {
        if (TfNganLuongOrder::where(['orderCode' => $orderCode])->exists()) {
            return true;
        } else {
            return false;
        }
    }

}
