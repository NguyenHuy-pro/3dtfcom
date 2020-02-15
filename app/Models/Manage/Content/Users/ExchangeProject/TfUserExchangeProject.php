<?php namespace App\Models\Manage\Content\Users\Exchange;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfUserExchangeProject extends Model
{

    protected $table = 'tf_user_exchange_projects';
    protected $fillable = ['exchange_id', 'point', 'action', 'created_at', 'transactionStatus_id', 'project_id', 'card_id'];
    protected $primaryKey = 'exchange_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========= INSERT && UPDATE =========== =========== =========
    #new insert
    public function insert($exchangePoint, $transactionStatusId, $projectId, $cardId)
    {
        $hFunction = new \Hfunction();
        $modelExchange = new TfUserExchangeLand();
        $modelExchange->point = $exchangePoint;
        $modelExchange->transactionStatus_id = $transactionStatusId;
        $modelExchange->project_id = $projectId;
        $modelExchange->card_id = $cardId;
        $modelExchange->created_at = $hFunction->createdAt();
        if ($modelExchange->save()) {
            $this->lastId = $modelExchange->exchange_id;
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

    #------------- Update ------------
    public function actionDelete($exchangeId = null)
    {
        if (empty($exchangeId)) $exchangeId = $this->exchange_id;
        return TfUserExchangeProject::where('exchange_id', $exchangeId)->update(['action' => 0]);
    }

    #========== ========== ========= RELATION =========== =========== =========
    # ----------- TF-PROJECT ------------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'project_id', 'project_id');
    }

    # ---------  TF-USER-CARD ----------
    public function userCard()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Card\TfUserCard', 'card_id', 'card_id');
    }

    # --------- TF-TRANSACTION-STATUS ----------
    public function transactionStatus()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Transaction\TfTransactionStatus', 'status_id', 'transactionStatus_id');
    }

    #========== ========== ========= GET INFO =========== =========== =========
    public function exchangePoint($exchangeId = null)
    {
        if (empty($exchangeId)) {
            return $this->exchangePoint;
        } else {
            return TfUserExchangeProject::where('exchange_id', $exchangeId)->pluck('exchangePoint');
        }

    }


    # total records
    public function totalRecords()
    {
        return TfUserExchangeProject::where('action', 1)->count();
    }

}
