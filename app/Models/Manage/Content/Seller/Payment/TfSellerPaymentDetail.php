<?php namespace App\Models\Manage\Content\Seller\Payment;

use Illuminate\Database\Eloquent\Model;

class TfSellerPaymentDetail extends Model
{

    protected $table = 'tf_seller_payment_details';
    protected $fillable = ['detail_id', 'created_at', 'payment_id', 'info_id', 'staff_id'];
    protected $primaryKey = 'detail_id';
    public $timestamps = false;

    private $lastId;

    #============ ============ ============ INSERT && UPDATE ============ ============ ============
    #---------- Insert ------------
    public function insert($paymentId, $infoId, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelInfo = new TfSellerPaymentDetail();
        $modelInfo->payment_id = $paymentId;
        $modelInfo->info_id = $infoId;
        $modelInfo->staff_id = $staffId;
        $modelInfo->created_at = $hFunction->carbonNow();
        if ($modelInfo->save()) {
            $this->lastId = $modelInfo->detail_id;
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

    #============ ============ ============ RELATION ============ ============ ============
    #---------- TF-SELLER-PAYMENT ----------
    public function sellerPayment()
    {
        return $this->belongsTo('App\Models\Manage\Content\Seller\Payment\TfSellerPayment', 'payment_id', 'payment_id');
    }

    public function infoOfPayment($paymentId)
    {
        return TfSellerPaymentDetail::where('payment_id', $paymentId)->first();
    }

    //check exist payment
    public function existPayment($paymentId)
    {
        return (count($this->infoOfPayment($paymentId)) > 0) ? true : false;
    }

    #---------- TF-SELLER-PAYMENT-INFO ----------
    public function sellerPaymentInfo()
    {
        return $this->belongsTo('App\Models\Manage\Content\Seller\Payment\TfSellerPaymentInfo', 'info_id', 'info_id');
    }

    #---------- TF-STAFF ----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #============ ============ ============ GET INFO ============ ============ ============
    public function getInfo($detailId = null, $field = null)
    {
        if (empty($detailId)) {
            return TfSellerPaymentDetail::get();
        } else {
            $result = TfSellerPaymentDetail::where('detail_id', $detailId)->first();
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
            return TfSellerPaymentDetail::where('detail_id', $objectId)->pluck($column);
        }
    }

    public function detailId()
    {
        return $this->detail_id;
    }

    public function createdAt($detailId = null)
    {
        return $this->pluck('created_at', $detailId);
    }

    public function infoId($detailId = null)
    {
        return $this->pluck('info_id', $detailId);
    }

    public function paymentId($detailId = null)
    {
        return $this->pluck('payment_id', $detailId);
    }

    public function staffId($detailId = null)
    {
        return $this->pluck('staff_id', $detailId);
    }

    #total records
    public function totalRecords()
    {
        return TfSellerPaymentDetail::count();
    }

}
