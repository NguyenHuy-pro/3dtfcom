<?php namespace App\Models\Manage\Content\Seller\Price;

use Illuminate\Database\Eloquent\Model;

class TfSellerPaymentPrice extends Model
{

    protected $table = 'tf_seller_payment_prices';
    protected $fillable = ['price_id', 'paymentPrice', 'shareValue', 'accessValue', 'registerValue', 'paymentLimit', 'action', 'created_at'];
    protected $primaryKey = 'price_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    //---------- Insert ----------
    public function insert($paymentPrice, $shareValue, $accessValue, $registerValue, $paymentLimit = 100)
    {
        $hFunction = new \Hfunction();
        $modelPrice = new TfSellerPaymentPrice();
        $modelPrice->paymentPrice = $paymentPrice;
        $modelPrice->shareValue = $shareValue;
        $modelPrice->accessValue = $accessValue;
        $modelPrice->registerValue = $registerValue;
        $modelPrice->paymentLimit = $paymentLimit;
        $modelPrice->created_at = $hFunction->carbonNow();

        $this->disablePrice();

        if ($modelPrice->save()) {
            $this->lastId = $modelPrice->price_id;
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

    #---------- Update ----------
    public function disablePrice()
    {
        return TfSellerPaymentPrice::where('action', 1)->update(['action' => 0]);
    }

    # delete
    public function actionDelete($priceId = null)
    {
        if (empty($priceId)) $priceId = $this->typeId();
        return TfSellerPaymentPrice::where('price_id', $priceId)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    //---------- TF-SELLER-PAYMENTS ----------
    public function sellerPayment()
    {
        return $this->hasMany('App\Models\Manage\Content\Seller\Payment\TfSellerPayment', 'price_id', 'price_id');
    }

    #========== ========== ========== CHECK INFO ========== ========== ==========
    public function existPriceInfo($price, $accessNumber, $registerNumber)
    {
        $result = TfSellerPaymentPrice::where(['paymentPrice' => $price, 'accessValue' => $accessNumber, 'registerValue' => $registerNumber, 'action' => 1])->count();
        return ($result > 0) ? true : false;
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function infoIsActive()
    {
        return TfSellerPaymentPrice::where('action', 1)->first();
    }

    public function getInfo($priceId = null, $field = null)
    {
        if (empty($priceId)) {
            return TfSellerPaymentPrice::where('action', 1)->where('status', 1)->get();
        } else {
            $result = TfSellerPaymentPrice::where('price_id', $priceId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }


    public function pluck($column, $priceId = null)
    {
        if (empty($priceId)) {
            return $this->$column;
        } else {
            return TfSellerPaymentPrice::where('price_id', $priceId)->pluck($column);
        }
    }

    public function priceId()
    {
        return $this->price_id;
    }

    public function paymentPrice($priceId = null)
    {
        return $this->pluck('paymentPrice', $priceId);
    }

    public function shareValue($priceId = null)
    {
        return $this->pluck('shareValue', $priceId);
    }

    public function accessValue($priceId = null)
    {
        return $this->pluck('accessValue', $priceId);
    }

    public function registerValue($priceId = null)
    {
        return $this->pluck('registerValue', $priceId);
    }

    public function paymentLimit($priceId = null)
    {
        return $this->pluck('paymentLimit', $priceId);
    }

    public function status($priceId = null)
    {
        return $this->pluck('status', $priceId);
    }

    public function createdAt($priceId = null)
    {
        return $this->pluck('created_at', $priceId);
    }

    //total records -->return number
    public function totalRecords()
    {
        return TfSellerPaymentPrice::where('action', 1)->count();
    }

}
