<?php namespace App\Models\Manage\Content\Map\Project\Transaction;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfProjectTransaction extends Model
{

    protected $table = 'tf_project_transactions';
    protected $fillable = ['transaction_id', 'action', 'created_at', 'project_id', 'transactionStatus_id'];
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;

    private $lastId;
    #=========== =========== =========== INSERT && UPDATE =========== ========== ===========
    #---------- Insert -----------
    public function insert($projectId, $transactionStatusId)
    {
        $hFunction = new \Hfunction();
        $modelProjectTransaction = new TfProjectTransaction();
        $modelProjectTransaction->project_id = $projectId;
        $modelProjectTransaction->transactionStatus_id = $transactionStatusId;
        $modelProjectTransaction->created_at = $hFunction->createdAt();
        if ($modelProjectTransaction->save()) {
            $this->listId = $modelProjectTransaction->transaction_id;
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

    # ------------- Update -------------
    # delete
    public function actionDelete($transactionId)
    {
        return TfProjectTransaction::where('transaction_id', $transactionId)->update(['action' => 0]);
    }

    #delete by project (when delete project)
    public function actionDeleteByProject($projectId = null)
    {
        if (!empty($projectId)) {
            TfProjectTransaction::where(['project_id' => $projectId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-PROJECT -----------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'project_id', 'project_id');
    }

    # --------- TF-TRANSACTION-STATUS ----------
    public function transactionStatus()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Transaction\TfTransactionStatus', 'transactionStatus_id', 'status_id');
    }

    #=========== ============ ========== GET INFO =========== ============= ===========
    public function getInfo($transactionId = '', $field = '')
    {
        if (empty($transactionId)) {
            return TfProjectTransaction::where('action', 1)->get();
        } else {
            $result = TfProjectTransaction::where('transaction_id', $transactionId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function transactionId()
    {
        return $this->transaction_id;
    }

    public function projectId($transactionId = null)
    {
        if (empty($transactionId)) {
            return $this->project_id;
        } else {
            return TfProjectTransaction::where('transaction_id', $transactionId)->pluck('project_id');
        }
    }

    public function transactionStatusId($transactionId = null)
    {
        if (empty($transactionId)) {
            return $this->transactionStatus_id;
        } else {
            return TfProjectTransaction::where('transaction_id', $transactionId)->pluck('transactionStatus_id');
        }
    }

    # get transaction info of project
    public function transactionInfoOfProject($projectId)
    {
        return TfProjectTransaction::where('project_id', $projectId)->where('action', 1)->first();
    }
}
