<?php namespace App\Models\Manage\Content\Design\Price;

use Illuminate\Database\Eloquent\Model;

class TfDesignPrice extends Model
{

    protected $table = 'tf_design_prices';
    protected $fillable = ['price_id', 'requestPrice', 'receivePrice', 'action', 'created_at', 'size_id'];
    protected $primaryKey = 'price_id';
    public $timestamps = false;
    private $lastId;

    #============ ========== =========== INSERT INFO ========== ========== ==========
    # new insert
    public function insert($sizeId, $requestPrice, $receivePrice)
    {
        $hFunction = new \Hfunction();
        $modelDesignPrice = new TfDesignPrice();
        $modelDesignPrice->requestPrice = $requestPrice;
        $modelDesignPrice->receivePrice = $receivePrice;
        $modelDesignPrice->size_id = $sizeId;
        $modelDesignPrice->created_at = $hFunction->carbonNow();
        if ($modelDesignPrice->save()) {
            $this->lastId = $modelDesignPrice->price_id;
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
    //delete
    public function actionDelete($priceId = null)
    {
        if (empty($priceId)) $priceId = $this->transactionId();
        return TfDesignPrice::where('price_id', $priceId)->update(['action' => 0]);
    }

    //when delete size
    public function actionDeleteBySize($sizeId = null)
    {
        if (!empty($sizeId)) {
            TfLandTransaction::where(['size_id' => $sizeId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    # --------- TF-Size ----------
    public function size()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Size', 'size_id', 'size_id');
    }

    // only get info is using of land
    public function infoOfLand($landId)
    {
        return TfLandTransaction::where('land_id', $landId)->where('action', 1)->first();
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfDesignPrice::where('price_id', $objectId)->pluck($column);
        }
    }

    public function priceId()
    {
        return $this->price_id;
    }

    public function requestPrice($objectId = null)
    {
        return $this->pluck('requestPrice', $objectId);
    }

    public function receivePrice($objectId = null)
    {
        return $this->pluck('receivePrice', $objectId);
    }

    public function sizeId($objectId = null)
    {
        return $this->pluck('size_id', $objectId);
    }

    public function createdAt($objectId = null)
    {
        return $this->pluck('created_at', $objectId);
    }

}
