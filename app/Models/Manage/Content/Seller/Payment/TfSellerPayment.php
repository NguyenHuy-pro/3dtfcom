<?php namespace App\Models\Manage\Content\Seller\Payment;

use App\Models\Manage\Content\Seller\TfSeller;
use Illuminate\Database\Eloquent\Model;

class TfSellerPayment extends Model
{

    protected $table = 'tf_seller_payments';
    protected $fillable = ['payment_id', 'paymentCode', 'fromDate', 'toDate', 'totalAccess', 'totalRegister', 'totalPay', 'payStatus', 'status', 'action', 'created_at', 'seller_id', 'price_id'];
    protected $primaryKey = 'payment_id';
    public $timestamps = false;

    private $lastId;

    #============ ============ ============ INSERT && UPDATE ============ ============ ============
    #---------- Insert ------------
    public function insert($fromDate, $toDate, $totalAccess, $totalRegister, $totalPay, $sellerId, $priceId)
    {
        $hFunction = new \Hfunction();
        $modelPayment = new TfSellerPayment();
        $modelPayment->paymentCode = $hFunction->getTimeCode();
        $modelPayment->fromDate = $fromDate;
        $modelPayment->toDate = $toDate;
        $modelPayment->totalAccess = $totalAccess;
        $modelPayment->totalRegister = $totalRegister;
        $modelPayment->totalPay = $totalPay;
        $modelPayment->seller_id = $sellerId;
        $modelPayment->price_id = $priceId;
        $modelPayment->created_at = $hFunction->carbonNow();
        if ($modelPayment->save()) {
            $this->lastId = $modelPayment->payment_id;
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
    public function confirmPayStatus($paymentId)
    {
        return TfSellerPayment::where('payment_id', $paymentId)->update([
            'payStatus' => 1
        ]);
    }

    public function updateStatus($paymentId, $status)
    {
        return TfSellerPayment::where('payment_id', $paymentId)->update(['status' => $status]);
    }

    //delete
    public function actionDelete($paymentId)
    {
        return TfSellerPayment::where('payment_id', $paymentId)->update(['action' => 0, 'status' => 0]);
    }

    public function deleteBySeller($sellerId)
    {
        return TfSellerPayment::where('seller_id', $sellerId)->update(['action' => 0, 'status' => 0]);
    }
    #============ ============ ============ RELATION ============ ============ ============
    #---------- TF-SELLER-PAYMENT-PRICE ----------
    public function sellerGuideObject()
    {
        return $this->belongsTo('App\Models\Manage\Content\Seller\Price\TfSellerPaymentPrice', 'price_id', 'price_id');
    }

    #---------- TF-SELLER-----------
    public function seller()
    {
        return $this->belongsTo('App\Models\Manage\Content\Seller\TfSeller', 'seller_id', 'seller_id');
    }

    public function infoOfSeller($sellerId, $take = null, $dateTake = null)
    {
        if (empty($sellerId)) {
            return null;
        } else {
            if (empty($take) && empty($dataTake)) {
                return TfSellerPayment::where(['seller_id' => $sellerId])->orderBy('created_at', 'DESC')->get();
            } else {
                return TfSellerPayment::where(['seller_id' => $sellerId])->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
            }
        }
    }

    #---------- TF-SELLER-PAYMENT-DETAIL ----------
    public function sellerPaymentDetail()
    {
        return $this->hasMany('App\Models\Manage\Content\Seller\Payment\TfSellerPaymentDetail', 'info_id', 'seller_id');
    }

    public function checkPaid($paymentId = null)
    {
        return ($this->payStatus($paymentId) == 0) ? false : true;
    }

    public function infoDetailOfPayment($paymentId = null)
    {
        $modelSellerPaymentDetail = new TfSellerPaymentDetail();
        $paymentId = (empty($paymentId)) ? $this->paymentId() : $paymentId;
        return $modelSellerPaymentDetail->infoOfPayment($paymentId);
    }

    #============ ============ ============ GET INFO ============ ============ ============
    public function infoByCode($paymentCode)
    {
        return TfSellerPayment::where('paymentCode', $paymentCode)->first();
    }

    public function getInfo($paymentId = null, $field = null)
    {
        if (empty($paymentId)) {
            return TfSellerPayment::where('action', 1)->where('status', 1)->get();
        } else {
            $result = TfSellerPayment::where('payment_id', $paymentId)->first();
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
            return TfSellerPayment::where('payment_id', $objectId)->pluck($column);
        }
    }

    public function paymentId()
    {
        return $this->payment_id;
    }

    public function paymentCode($paymentId = null)
    {
        return $this->pluck('paymentCode', $paymentId);
    }

    public function fromDate($paymentId = null)
    {
        return $this->pluck('fromDate', $paymentId);
    }

    public function toDate($paymentId = null)
    {
        return $this->pluck('toDate', $paymentId);
    }

    public function totalAccess($paymentId = null)
    {
        return $this->pluck('totalAccess', $paymentId);
    }

    public function totalRegister($paymentId = null)
    {
        return $this->pluck('totalRegister', $paymentId);
    }

    public function totalPay($paymentId = null)
    {
        return $this->pluck('totalPay', $paymentId);
    }

    public function payStatus($paymentId = null)
    {
        return $this->pluck('payStatus', $paymentId);
    }

    public function status($paymentId = null)
    {
        return $this->pluck('status', $paymentId);
    }

    public function createdAt($paymentId = null)
    {
        return $this->pluck('created_at', $paymentId);
    }

    public function priceId($paymentId = null)
    {
        return $this->pluck('priceId', $paymentId);
    }

    public function sellerId($paymentId = null)
    {
        return $this->pluck('sellerId', $paymentId);
    }

    #total records
    public function totalRecords()
    {
        return TfSellerPayment::where('action', 1)->count();
    }

}
