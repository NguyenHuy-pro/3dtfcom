<?php namespace App\Models\Manage\Content\Users\ExchangeLand;

use App\Models\Manage\Content\Map\Land\License\TfLandLicense;
use Illuminate\Database\Eloquent\Model;

class TfUserExchangeLand extends Model
{

    protected $table = 'tf_user_exchange_lands';
    protected $fillable = ['exchange_id', 'point', 'action', 'created_at', 'card_id', 'license_id'];
    protected $primaryKey = 'exchange_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========= INSERT && UPDATE =========== =========== =========
    //new insert
    public function insert($exchangePoint, $cardId, $licenseId)
    {
        $hFunction = new \Hfunction();
        $modelExchange = new TfUserExchangeLand();
        $modelExchange->point = $exchangePoint;
        $modelExchange->card_id = $cardId;
        $modelExchange->license_id = $licenseId;
        $modelExchange->created_at = $hFunction->createdAt();
        if ($modelExchange->save()) {
            $this->lastId = $modelExchange->exchange_id;
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

    #------------- Update -------------
    public function actionDelete($exchangeId = null)
    {
        if (empty($exchangeId)) $exchangeId = $this->exchange_id;
        return TfUserExchangeLand::where('exchange_id', $exchangeId)->update(['action' => 0]);
    }

    #========== ========== ========= RELATION =========== =========== =========
    # ----------- TF-LAND-LICENSE ------------
    public function landLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'license_id', 'license_id');
    }

    # ---------  TF-USER-CARD ----------
    public function userCard()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\Card\TfUserCard', 'card_id', 'card_id');
    }

    #========== ========== ========= GET INFO =========== =========== =========
    public function getInfo($exchangeId = '', $field = '')
    {
        if (empty($exchangeId)) {
            return TfUserExchangeLand::get();
        } else {
            $result = TfUserExchangeLand::where('exchange_id', $exchangeId)->first();
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
        $modelLandLicense = new TfLandLicense();
        return $modelLandLicense->existFreeLicenseOfUser($userId);
    }


    # --------- --------- EXCHANGE INFO ---------- ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserExchangeLand::where('exchange_id', $objectId)->pluck($column);
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
    public function totalLandExchange()
    {
        return TfUserExchangeLand::where('action', 1)->count();
    }


}
