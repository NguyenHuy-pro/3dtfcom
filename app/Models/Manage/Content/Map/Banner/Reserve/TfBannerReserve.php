<?php namespace App\Models\Manage\Content\Map\Banner\Reserve;

use Illuminate\Database\Eloquent\Model;

class TfBannerReserve extends Model
{

    protected $table = 'tf_banner_reserves';
    protected $fillable = ['reserve_id', 'receive', 'action', 'created_at', 'banner_id', 'user_id'];
    protected $primaryKey = 'reserve_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========= INSERT && EDIT =========== =========== =========
    #----------- Insert --------------
    public function insert($bannerId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelReserve = new TfBannerReserve();
        $modelReserve->receive = 0;
        $modelReserve->action = 1;
        $modelReserve->banner_id = $bannerId;
        $modelReserve->user_id = $userId;
        $modelReserve->created_at = $hFunction->createdAt();
        if ($modelReserve->save()) {
            $this->lastId = $modelReserve->reserve_id;
            return true;
        } else {
            return false;
        }
    }

    #get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- Update -----------
    public function updateReserve($reserveId=null)
    {
        if(empty($reserveId)) $reserveId = $this->reserveId();
        return TfBannerReserve::where('reserve_id', $reserveId)->update(['receive' => 1]);
    }

    # delete
    public function actionDelete($reserveId=null)
    {
        if(empty($reserveId)) $reserveId = $this->reserveId();
        return TfBannerReserve::where('reserve_id', $reserveId)->update(['action' => 0]);
    }

    #when delete banner
    public function actionDeleteByBanner($bannerId = null)
    {
        if (!empty($bannerId)) {
            TfBannerReserve::where(['banner_id' => $bannerId, 'action' => 1])->update(['action' => 0]);
        }
    }

    # ========== ========== ========= RELATION ========= ========== ==========
    #---------- TF-BANNER ----------
    public function banner()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\TfBanner', 'banner_id', 'banner_id');
    }

    # ---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    # ========== ========== ========= GET INFO ========= ========== ==========
    public function getInfo($reserveId = null, $field = null)
    {
        if (empty($reserveId)) {
            return TfBannerReserve::where('action', 1)->get();
        } else {
            $result = TfBannerReserve::where('reserve_id', $reserveId)->first();
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
            return TfBannerReserve::where('reserve_id', $objectId)->pluck($column);
        }
    }

    public function reserveId()
    {
        return $this->reserve_id;
    }

    public function receive($reserveId = null)
    {
        return $this->pluck('receive', $reserveId);
    }

    public function createdAt($reserveId = null)
    {
        return $this->pluck('created_at', $reserveId);
    }

    public function bannerId($reserveId = null)
    {
        return $this->pluck('banner_id', $reserveId);
    }

    public function userId($reserveId = null)
    {
        return $this->pluck('user_id', $reserveId);
    }

    # total records
    public function totalRecords()
    {
        return TfBannerReserve::count();
    }

}
