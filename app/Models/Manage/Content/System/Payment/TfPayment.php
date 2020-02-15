<?php namespace App\Models\Manage\Content\System\Payment;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfPayment extends Model
{

    protected $table = 'tf_payments';
    protected $fillable = ['payment_id', 'contactName', 'paymentName', 'paymentCode', 'created_at', 'status', 'action', 'type_id', 'bank_id'];
    protected $primaryKey = 'payment_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($contactName, $paymentName, $paymentCode, $typeId, $bankId)
    {
        $hFunction = new \Hfunction();
        $modelPayment = new TfPayment();
        $modelPayment->contactName = $contactName;
        $modelPayment->paymentName = $paymentName;
        $modelPayment->paymentCode = $paymentCode;
        $modelPayment->status = 1;
        $modelPayment->action = 1;
        $modelPayment->type_id = $typeId;
        $modelPayment->bank_id = $bankId;
        $modelPayment->created_at = $hFunction->createdAt();
        if ($modelPayment->save()) {
            $this->lastId = $modelPayment->bank_id;
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

    #----------- update ----------
    public function updateInfo($paymentId, $contactName, $paymentName, $paymentCode, $typeId, $bankId)
    {
        return TfPayment::where('payment_id', $paymentId)->update([
            'contactName' => $contactName,
            'paymentName' => $paymentName,
            'paymentCode' => $paymentCode,
            'type_id' => $typeId,
            'bank_id' => $bankId
        ]);
    }

    public function updateStatus($paymentId, $status)
    {
        return TfPayment::where('payment_id', $paymentId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($paymentId = null)
    {
        if (empty($paymentId)) $paymentId = $this->paymentId();
        return TfPayment::where('payment_id', $paymentId)->update(['action' => 0]);
    }

    #============ ============ ============ RELATION ============ ============ ============
    # ---------- TF-BANK ----------
    public function bank()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Bank\TfBank', 'bank_id', 'bank_id');
    }

    # ---------- TF-PAYMENT-TYPE ----------
    public function paymentType()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\PaymentType\TfPaymentType', 'type_id', 'type_id');
    }

    # ---------- TF-RECHARGE ----------
    public function recharge()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Recharge\TfRecharge', 'payment_id', 'payment_id');
    }


    #============ ============ ============ GET INFO ============ ============ ============
    # ---------- TF-PAYMENT-TYPE ----------
    public function infoOfPaymentType($typeId)
    {
        return TfPayment::where(['type_id' => $typeId, 'action' => 1])->get();
    }

    public function getInfo($paymentId = null, $field = null)
    {
        if (empty($paymentId)) {
            return TfPayment::where('action', 1)->get();
        } else {
            $result = TfPayment::where(['payment_id' => $paymentId, 'action' => 1])->first();
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
            return TfPayment::where('payment_id', $objectId)->pluck($column);
        }
    }

    public function paymentId()
    {
        return $this->payment_id;
    }


    public function contactName($paymentId = null)
    {
        return $this->pluck('contactName', $paymentId);
    }

    public function paymentName($paymentId = null)
    {
        return $this->pluck('paymentName', $paymentId);
    }

    public function paymentCode($paymentId = null)
    {
        return $this->pluck('paymentCode', $paymentId);
    }

    public function status($paymentId = null)
    {
        return $this->pluck('status', $paymentId);
    }

    public function typeId($paymentId = null)
    {
        return $this->pluck('type_id', $paymentId);
    }

    public function bankId($paymentId = null)
    {
        return $this->pluck('bank_id', $paymentId);
    }

    public function createdAt($paymentId = null)
    {
        return $this->pluck('created_at', $paymentId);
    }


    # total payment
    public function totalRecords()
    {
        return TfPayment::where('action', 1)->count();
    }

}
