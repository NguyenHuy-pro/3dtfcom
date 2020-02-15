<?php namespace App\Models\Manage\Content\Map\Land\Transaction;

use App\Models\Manage\Content\Map\Land\TfLand;
use App\Models\Manage\Content\Map\Project\TfProjectTransaction;
use App\Models\Manage\Content\Map\Transaction\TfTransactionStatus;
use Illuminate\Database\Eloquent\Model;

class TfLandTransaction extends Model
{

    protected $table = 'tf_land_transactions';
    protected $fillable = ['transaction_id', 'action', 'created_at', 'land_id', 'transactionStatus_id'];
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;
    private $lastId;

    #============ ========== =========== INSERT INFO ========== ========== ==========
    # new insert
    public function insert($landId, $transactionStatusId)
    {
        $hFunction = new \Hfunction();
        $modelLand = new TfLand();
        # disable old transaction of land (sale)
        $modelLand->transactionDisable($landId);
        # add transaction
        $modelLandTransaction = new TfLandTransaction();
        $modelLandTransaction->land_id = $landId;
        $modelLandTransaction->transactionStatus_id = $transactionStatusId;
        $modelLandTransaction->created_at = $hFunction->createdAt();
        if ($modelLandTransaction->save()) {
            $this->lastId = $modelLandTransaction->transaction_id;
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

    #--------- Update ----------
    public function disableOfLand($landId)
    {
        return TfLandTransaction::where('land_id', $landId)->where('action', 1)->update(['action' => 0]);
    }

    # delete
    public function actionDelete($transactionId = null)
    {
        if (empty($transactionId)) $transactionId = $this->transactionId();
        return TfLandTransaction::where('transaction_id', $transactionId)->update(['action' => 0]);
    }

    #when delete land
    public function actionDeleteByLand($landId = null)
    {
        if (!empty($landId)) {
            TfLandTransaction::where(['land_id' => $landId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    # --------- TF-LAND ----------
    public function land()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\TfLand', 'land_id', 'land_id');
    }

    // only get info is using of land
    public function infoOfLand($landId)
    {
        return TfLandTransaction::where('land_id', $landId)->where('action', 1)->first();
    }

    //only get info is using of land
    public function transactionStatusIdOfLand($landId)
    {
        return TfLandTransaction::where('land_id', $landId)->where('action', 1)->pluck('transactionStatus_id');
    }

    # --------- TF-TRANSACTION-STATUS ----------
    public function transactionStatus()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Transaction\TfTransactionStatus', 'transactionStatus_id', 'status_id');
    }

    public function landIdOfTransactionStatus($statusId)
    {
        return TfLandTransaction::where(['transactionStatus_id' => $statusId, 'action' => 1])->lists('land_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function checkTransactionBuy($transactionId = null)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $saleStatusId = $modelTransactionStatus->saleStatusId();
        $transactionStatusId = $this->transactionStatusId($transactionId);
        return ($saleStatusId == $transactionStatusId) ? true : false;

    }

    public function checkTransactionFree($transactionId = null)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $saleStatusId = $modelTransactionStatus->freeStatusId();
        $transactionStatusId = $this->transactionStatusId($transactionId);
        return ($saleStatusId == $transactionStatusId) ? true : false;

    }

    public function checkTransactionNormal($transactionId = null)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $saleStatusId = $modelTransactionStatus->normalStatusId();
        $transactionStatusId = $this->transactionStatusId($transactionId);
        return ($saleStatusId == $transactionStatusId) ? true : false;

    }

    public function checkTransactionReserve($transactionId = null)
    {
        $modelTransactionStatus = new TfTransactionStatus();
        $saleStatusId = $modelTransactionStatus->reserveStatusId();
        $transactionStatusId = $this->transactionStatusId($transactionId);
        return ($saleStatusId == $transactionStatusId) ? true : false;

    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfLandTransaction::where('transaction_id', $objectId)->pluck($column);
        }
    }

    public function transactionId()
    {
        return $this->transaction_id;
    }

    public function transactionStatusId($transactionId = null)
    {
        return $this->pluck('transactionStatus_id', $transactionId);
    }

    public function landId($transactionId = null)
    {
        return $this->pluck('land_id', $transactionId);
    }

    public function createdAt($transactionId = null)
    {
        return $this->pluck('created_at', $transactionId);
    }

}
