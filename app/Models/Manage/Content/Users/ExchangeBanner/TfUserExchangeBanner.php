<?php namespace App\Models\Manage\Content\Users\ExchangeBanner;

use App\Models\Manage\Content\Map\Banner\License\TfBannerLicense;
use Illuminate\Database\Eloquent\Model;

class TfUserExchangeBanner extends Model
{

    protected $table = 'tf_user_exchange_banners';
    protected $fillable = ['exchange_id', 'point', 'action', 'created_at', 'license_id', 'card_id'];
    protected $primaryKey = 'exchange_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========= INSERT && EDIT  =========== =========== =========
    //new insert
    public function insert($exchangePoint, $cardId, $licenseId)
    {
        $hFunction = new \Hfunction();
        $modelExchange = new TfUserExchangeBanner();
        $modelExchange->point = $exchangePoint;
        $modelExchange->license_id = $licenseId;
        $modelExchange->card_id = $cardId;
        $modelExchange->created_at = $hFunction->createdAt();
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
        return TfUserExchangeBanner::where('exchange_id', $exchangeId)->update(['action' => 0]);
    }
    #========== ========== ========= RELATION =========== =========== =========
    # --------- TF-BANNER-LICENSE ----------
    public function bannerLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\License\TfBannerLicense', 'license_id', 'license_id');
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
            $result = TfUserExchangeBanner::where('exchange_id', $exchangeId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    //check exist free exchange of user
    public function existFreeExchangeOfUser($userId = '')
    {
        $modelBannerLicense = new TfBannerLicense();
        return $modelBannerLicense->existFreeLicenseOfUser($userId);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserExchangeBanner::where('exchange_id', $objectId)->pluck($column);
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

    public function createdAt($exchangeId = null)
    {
        return $this->pluck('created_at', $exchangeId);
    }

    //total records
    public function totalRecords()
    {
        return TfUserExchangeBanner::where('action', 1)->count();
    }


}
