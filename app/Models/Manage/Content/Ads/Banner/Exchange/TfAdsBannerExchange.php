<?php namespace App\Models\Manage\Content\Ads\Banner\Exchange;

use Illuminate\Database\Eloquent\Model;

class TfAdsBannerExchange extends Model {

    protected $table = 'tf_ads_banner_exchanges';
    protected $fillable = ['exchange_id', 'point', 'created_at', 'license_id', 'card_id'];
    protected $primaryKey = 'exchange_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========= INSERT && EDIT  =========== =========== =========
    # new insert
    public function insert($exchangePoint, $cardId, $licenseId)
    {
        $hFunction = new \Hfunction();
        $modelExchange = new TfAdsBannerExchange();
        $modelExchange->point = $exchangePoint;
        $modelExchange->license_id = $licenseId;
        $modelExchange->card_id = $cardId;
        $modelExchange->created_at = $hFunction->carbonNow();
        if ($modelExchange->save()) {
            $this->lastId = $modelExchange->exchange_id;
            return true;
        } else {
            return false;
        }
    }

    //get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #----------- Update ----------
    public function actionDelete($exchangeId = '')
    {
        return TfAdsBannerExchange::where('exchange_id', $exchangeId)->update(['action' => 0]);
    }
    #========== ========== ========= RELATION =========== =========== =========
    # --------- TF-ADS-BANNER-LICENSE ----------
    public function bannerLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Ads\Banner\License\TfAdsBannerLicense', 'license_id', 'license_id');
    }

    # ---------  TF-USER-CARD ----------
    public function userCard()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Card\TfUserCard', 'card_id', 'card_id');
    }

    #========== ========== ========= GET INFO =========== =========== =========
    //extend
    public function getInfo($exchangeId = '', $field = '')
    {
        if (empty($exchangeId)) {
            return null;
        } else {
            $result = TfAdsBannerExchange::where('exchange_id', $exchangeId)->first();
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
            return TfAdsBannerExchange::where('exchange_id', $objectId)->pluck($column);
        }
    }

    public function exchangeId()
    {
        return $this->exchange_id;
    }

    public function point($exchangeId = null)
    {
        return $this->pluck('point', $exchangeId);
    }

    public function licenseId($exchangeId = null)
    {
        return $this->pluck('license_id', $exchangeId);
    }

    public function cardId($exchangeId = null)
    {
        return $this->pluck('card_id', $exchangeId);
    }

    public function created_at($exchangeId = null)
    {
        return $this->pluck('created_at', $exchangeId);
    }

    //total records
    public function totalRecords()
    {
        return TfAdsBannerExchange::count();
    }

}
