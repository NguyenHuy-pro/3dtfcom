<?php namespace App\Models\Manage\Content\Users\Card;

use App\Models\Manage\Content\Users\CardActive\TfUserCardActive;
use App\Models\Manage\Content\Users\NganLuongOrder\TfNganLuongOrder;
use App\Models\Manage\Content\Users\Recharge\TfRecharge;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Database\Eloquent\Model;

class TfUserCard extends Model
{

    protected $table = 'tf_user_cards';
    protected $fillable = ['card_id', 'name', 'pointValue', 'status', 'created_at', 'user_id'];
    protected $primaryKey = 'card_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    public function insert($pointValue, $userId)
    {
        $hFunction = new \Hfunction();
        $modelUserCard = new TfUserCard();
        $modelUserCardActive = new TfUserCardActive();
        $cardName = $hFunction->getTimeCode();
        $modelUserCard->name = $cardName;
        $modelUserCard->pointValue = $pointValue;
        $modelUserCard->user_id = $userId;
        $modelUserCard->created_at = $hFunction->createdAt();
        if ($modelUserCard->save()) {
            $newCardId = $modelUserCard->card_id;
            $this->lastId = $newCardId;
            $modelUserCardActive->insert($pointValue, $pointValue, 0, 'New user', $newCardId);
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

    #----------- Status ----------
    public function updateStatus($cardId = null)
    {
        if (empty($cardId)) $cardId = $this->cardId();
        return TfUserCard::where('card_id', $cardId)->update(['status' => 0]);
    }

    #=========== ============= =========== RELATION =========== ============ ===========
    #--------- TF-ADS-BANNER-EXCHANGE ----------
    public function adsBannerExchange()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\Exchange\TfAdsBannerExchange', 'card_id', 'card_id');
    }

    #--------- TF-RECHARGE ----------
    public function recharge()
    {
        return $this->hasMany('App\Models\Manage\Content\User\Recharge\TfRecharge', 'card_id', 'card_id');
    }

    #---------  TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //get card info of user
    public function infoOfUser($userId)
    {

        return TfUserCard::where('user_id', $userId)->first();
    }

    //only get card id of user
    public function cardIdOfUser($userId)
    {
        return TfUserCard::where('user_id', $userId)->pluck('card_id');
    }

    //only get point of user
    public function pointOfUser($userId)
    {
        return TfUserCard::where('user_id', $userId)->pluck('pointValue');
    }

    //check exist user card
    public function existCardOfUser($userId)
    {
        $result = TfUserCard::where('user_id', $userId)->count();
        return ($result > 0) ? true : false;
    }

    # --------- TF-USER-EXCHANGE-LAND ----------
    public function exchangeLand()
    {
        return $this->hasMany('App\Models\Manage\Content\User\ExchangeLand\TfUserExchangeLand', 'card_id', 'card_id');
    }

    #--------- TF-USER-EXCHANGE-BANNER ----------
    public function exchangeBanner()
    {
        return $this->hasMany('App\Models\Manage\Content\User\ExchangeBanner\TfUserExchangeBanner', 'card_id', 'card_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    #--------- TF-NGANLUONG-ORDER ----------
    public function infoNganLuongOrder($cardId, $take = null, $dateTake = null)
    {
        $modelNganLuong = new TfNganLuongOrder();
        return $modelNganLuong->infoOfCard($cardId, $take, $dateTake);
    }

    #--------- TF-RECHARGE ----------
    public function infoRecharge($cardId, $take = null, $dateTake = null)
    {
        $modelRecharge = new TfRecharge();
        return $modelRecharge->infoOfCard($cardId, $take, $dateTake);
    }

    public function getInfo($cardId = null, $field = null)
    {
        if (empty($cardId)) {
            return TfUserCard::get();
        } else {
            $result = TfUserCard::where('card_id', $cardId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function getInfoOfName($name)
    {
        return TfUserCard::where('name', $name)->first();
    }

    #--------- CARD INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserCard::where('card_id', $objectId)->pluck($column);
        }
    }

    public function cardId()
    {
        return $this->card_id;
    }

    public function name($cardId = null)
    {
        return $this->pluck('name', $cardId);
    }

    public function pointValue($cardId = null)
    {
        return $this->pluck('pointValue', $cardId);
    }

    public function status($cardId = null)
    {
        return $this->pluck('status', $cardId);
    }

    public function createdAt($cardId = null)
    {
        return $this->pluck('created_at', $cardId);
    }

    public function userId($cardId = null)
    {
        return $this->pluck('user_id', $cardId);
    }

    //last id
    public function lastId()
    {
        $result = TfUserCard::orderBy('card_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->card_id;
    }

    //total records
    public function totalRecords()
    {
        return TfUserCard::count();
    }

    #========== ========== ========== UPDATE INFO ========== ========== ==========
    #----------- -----------  point ----------- -----------
    //the card increase point
    public function increasePoint($cardId, $point, $reason)
    {
        return $this->updatePointValue($cardId, $point, 1, $reason);
    }

    //the card decrease point
    public function decreasePoint($cardId, $point, $reason)
    {
        return $this->updatePointValue($cardId, $point, 0, $reason);
    }

    //update point
    public function updatePointValue($cardId, $point, $pointStatus, $reason)
    {
        $modelUserCard = TfUserCard::find($cardId);
        $oldPoint = $modelUserCard->pointValue;
        if ($pointStatus == 1) {
            #increase
            $newPoint = $oldPoint + $point;
            $increase = $point;
            $decrease = null;

        } else {
            #decrease
            $newPoint = $oldPoint - $point;
            $increase = null;
            $decrease = $point;
        }
        $modelUserCard->pointValue = $newPoint;
        if ($modelUserCard->save()) {
            # add active of card
            $modelUserCardActive = new TfUserCardActive();
            $modelUserCardActive->insert($newPoint, $increase, $decrease, $reason, $cardId);
            return true;
        } else {
            return false;
        }
    }


}
