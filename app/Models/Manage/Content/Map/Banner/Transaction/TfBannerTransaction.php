<?php namespace App\Models\Manage\Content\Map\Banner\Transaction;

use App\Models\Manage\Content\Map\Banner\TfBanner;
use Illuminate\Database\Eloquent\Model;

class TfBannerTransaction extends Model
{

    protected $table = 'tf_banner_transactions';
    protected $fillable = ['transaction_id', 'action', 'created_at', 'banner_id', 'transactionStatus_id'];
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;

    private $lastId;

    #============ ========== =========== INSERT && EDIT ========== ========== ==========
    #--------- Insert ----------
    public function insert($bannerId, $transactionStatusId)
    {
        $hFunction = new \Hfunction();
        $modelBanner = new TfBanner();
        # disable old transaction of banner (sale)
        $modelBanner->transactionDisable($bannerId);
        # add transaction
        $modelBannerTransaction = new TfBannerTransaction();
        $modelBannerTransaction->banner_id = $bannerId;
        $modelBannerTransaction->transactionStatus_id = $transactionStatusId;
        $modelBannerTransaction->created_at = $hFunction->createdAt();
        if ($modelBannerTransaction->save()) {
            $this->lastId = $modelBannerTransaction->transaction_id;
            return true;
        } else {
            return false;
        }
    }

    #--------- Update ----------
    # disable transaction of a banner
    public function disableOfBanner($bannerId)
    {
        return TfBannerTransaction::where('banner_id', $bannerId)->where('action', 1)->update(['action' => 0]);
    }

    # delete
    public function actionDelete($transactionId = null)
    {
        if (empty($transactionId)) $transactionId = $this->transactionId();
        return TfBannerTransaction::where('transaction_id', $transactionId)->update(['action' => 0]);
    }

    #when delete banner
    public function actionDeleteByBanner($bannerId = null)
    {
        if (!empty($bannerId)) {
            TfBannerTransaction::where(['banner_id' => $bannerId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    # --------- TF-BANNER ----------
    public function banner()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\TfBanner', 'banner_id', 'banner_id');
    }

    # --------- TF-TRANSACTION-STATUS ----------
    public function transactionStatus()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Transaction\TfTransactionStatus', 'transactionStatus_id', 'status_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    # ---------- TF-LAND ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBannerTransaction::where('transaction_id', $objectId)->pluck($column);
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

    public function bannerId($transactionId = null)
    {
        return $this->pluck('banner_id', $transactionId);
    }

    public function createdAt($transactionId = null)
    {
        return $this->pluck('created_at', $transactionId);
    }
    # --------- TF-BANNER ----------
    # only get info is using of banner
    public function infoOfBanner($bannerId)
    {
        return TfBannerTransaction::where('banner_id', $bannerId)->where('action', 1)->first();
    }

    # only get info is using of banner
    public function transactionStatusOfBanner($bannerId)
    {
        return TfBannerTransaction::where('banner_id', $bannerId)->where('action', 1)->pluck('transactionStatus_id');
    }

    # ---------- TF-TRANSACTION-STATUS ----------
    public function bannerIdOfTransactionStatus($statusId)
    {
        return TfBannerTransaction::where(['transactionStatus_id' => $statusId, 'action' => 1])->lists('banner_id');
    }

}
