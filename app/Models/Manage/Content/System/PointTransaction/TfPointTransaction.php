<?php namespace App\Models\Manage\Content\System\PointTransaction;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfPointTransaction extends Model
{

    protected $table = 'tf_point_transactions';
    protected $fillable = ['transaction_id', 'pointValue', 'usdValue', 'dateApply', 'action', 'type_id', 'created_at'];
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($pointValue, $usdValue, $dateApply, $typeId)
    {
        $hFunction = new \Hfunction();
        $modelTransaction = new TfPointTransaction();
        $modelTransaction->pointValue = $pointValue;
        $modelTransaction->usdValue = $usdValue;
        $modelTransaction->dateApply = $dateApply;
        $modelTransaction->action = 1;
        $modelTransaction->type_id = $typeId;
        $modelTransaction->created_at = $hFunction->createdAt();
        if ($modelTransaction->save()) {
            $this->lastId = $modelTransaction->transaction_id;
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

    #---------- Update ----------
    public function updateInfo($transactionId, $pointValue, $usdValue)
    {
        return TfPointTransaction::where('transaction_id', $transactionId)->update([
            'pointValue' => $pointValue,
            'usdValue' => $usdValue
        ]);
    }

    public function actionDelete($transactionId = null)
    {
        if (empty($transactionId)) $transactionId = $this->transactionId();
        return TfPointTransaction::where('transaction_id', $transactionId)->update(['action' => 0]);
    }

    #============ ============ ============ RELATION ============ ============ ============

    # ---------- TF-POINT-TYPE ----------
    public function pointType()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\PointType\TfPointType', 'type_id', 'type_id');
    }

    #============ ============ ============ GET INFO ============ ============ ============
    #info of type
    public function infoOfPointType($typeId)
    {
        return TfPointTransaction::where('type_id', $typeId)->where('action', 1)->first();
    }

    public function getInfo($transactionId = '', $field = '')
    {
        if (empty($transactionId)) {
            return TfPointTransaction::where('action', 1)->get();
        } else {
            $result = TfPointTransaction::where('transaction_id', $transactionId)->first();
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
            return TfPointTransaction::where('transaction_id', $objectId)->pluck($column);
        }
    }

    public function transactionId()
    {
        return $this->transaction_id;
    }


    public function point($transactionId = null) #old
    {
        return $this->pluck('pointValue', $transactionId);
    }

    public function pointValue($transactionId = null)
    {
        return $this->pluck('pointValue', $transactionId);
    }

    public function usdValue($transactionId = null)
    {
        return $this->pluck('usdValue', $transactionId);
    }

    public function dateApply($transactionId = null)
    {
        return $this->pluck('dateApply', $transactionId);
    }

    public function typeId($transactionId = null)
    {
        return $this->pluck('type_id', $transactionId);
    }

    public function createdAt($transactionId = null)
    {
        return $this->pluck('created_at', $transactionId);
    }

    // total records
    public function totalRecords()
    {
        return TfPointTransaction::where('action', 1)->count();
    }

}
