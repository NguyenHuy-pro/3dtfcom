<?php namespace App\Models\Manage\Content\Seller\Payment;

use Illuminate\Database\Eloquent\Model;

class TfSellerPaymentInfo extends Model
{

    protected $table = 'tf_seller_payment_infos';
    protected $fillable = ['info_id', 'name', 'paymentCode', 'action', 'created_at', 'seller_id', 'bank_id'];
    protected $primaryKey = 'info_id';
    public $timestamps = false;

    private $lastId;

    #============ ============ ============ INSERT && UPDATE ============ ============ ============
    #---------- Insert ------------
    public function insert($name, $paymentCode, $sellerId,$bankId)
    {
        $hFunction = new \Hfunction();
        $modelInfo = new TfSellerPaymentInfo();
        $modelInfo->name = $name;
        $modelInfo->paymentCode = $paymentCode;
        $modelInfo->seller_id = $sellerId;
        $modelInfo->bank_id = $bankId;
        $modelInfo->created_at = $hFunction->carbonNow();
        if ($modelInfo->save()) {
            $this->lastId = $modelInfo->info_id;
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

    #----------- Update ----------
    //delete
    public function actionDelete($infoId)
    {
        return TfSellerPaymentInfo::where('info_id', $infoId)->update(['action' => 0]);
    }

    public function deleteBySeller($sellerId)
    {
        return TfSellerPaymentInfo::where('seller_id', $sellerId)->update(['action' => 0]);
    }

    #============ ============ ============ RELATION ============ ============ ============
    #---------- TF-SELLER-GUIDE-OBJECT ----------
    public function seller()
    {
        return $this->belongsTo('App\Models\Manage\Content\Seller\TfSeller', 'seller_id', 'seller_id');
    }

    public function infoIsActiveOfSeller($sellerId)
    {
        return TfSellerPaymentInfo::where(['seller_id' => $sellerId, 'action' => 1])->first();
    }

    public function infoIdOfSeller($sellerId)
    {
        return TfSellerPaymentInfo::where(['seller_id' => $sellerId, 'action' => 1])->pluck('info_id');
    }

    #---------- TF-SELLER-PAYMENT-DETAIL ----------
    public function sellerPaymentDetail()
    {
        return $this->hasMany('App\Models\Manage\Content\Seller\Payment\TfSellerPaymentDetail', 'info_id', 'seller_id');
    }

    #---------- TF-BANK ----------
    public function bank()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Bank\TfBank', 'bank_id', 'bank_id');
    }

    #============ ============ ============ GET INFO ============ ============ ============
    public function getInfo($infoId = null, $field = null)
    {
        if (empty($infoId)) {
            return TfSellerPaymentInfo::where('action', 1)->where('status', 1)->get();
        } else {
            $result = TfSellerPaymentInfo::where('info_id', $infoId)->first();
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
            return TfSellerPaymentInfo::where('info_id', $objectId)->pluck($column);
        }
    }

    public function infoId()
    {
        return $this->info_id;
    }

    public function name($infoId = null)
    {
        return $this->pluck('name', $infoId);
    }

    public function paymentCode($infoId = null)
    {
        return $this->pluck('paymentCode', $infoId);
    }

    public function createdAt($infoId = null)
    {
        return $this->pluck('created_at', $infoId);
    }

    public function sellerId($infoId = null)
    {
        return $this->pluck('object_id', $infoId);
    }

    #total records
    public function totalRecords()
    {
        return TfSellerPaymentInfo::where('action', 1)->count();
    }

}
