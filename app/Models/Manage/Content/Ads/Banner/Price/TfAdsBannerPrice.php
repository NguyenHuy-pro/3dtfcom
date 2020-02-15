<?php namespace App\Models\Manage\Content\Ads\Banner\Price;

use Illuminate\Database\Eloquent\Model;

class TfAdsBannerPrice extends Model
{

    protected $table = 'tf_ads_banner_prices';
    protected $fillable = ['price_id', 'point', 'display', 'action', 'created_at', 'banner_id'];
    protected $primaryKey = 'price_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========= ========= INSERT && UPDATE ========= ========= =========
    #------------ Insert ------------
    public function insert($point, $display, $bannerId)
    {
        $hFunction = new \Hfunction();
        $modelPrice = new TfAdsBannerPrice();
        $modelPrice->point = $point;
        $modelPrice->display = $display;
        $modelPrice->action = 1;
        $modelPrice->banner_id = $bannerId;
        $modelPrice->created_at = $hFunction->carbonNow();
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

    #------------ Update ------------
    //action
    public function actionDelete($priceId)
    {
        return TfAdsBannerPrice::where(['price_id' => $priceId])->update(['action' => 0]);
    }

    //delete by ads banner
    public function actionDeleteByBanner($bannerId = null)
    {
        return TfAdsBannerPrice::where(['banner_id' => $bannerId, 'action' => 1])->update(['action' => 0]);
    }

    #========== ========= ========= RELATION ========= ========= =========
    #----------- TF-ADS-BANNER ----------
    public function adsBanner()
    {
        return $this->belongsTo('App\Models\Manage\Content\Ads\Banner\TfAdsBanner', 'banner_id', 'banner_id');
    }

    public function priceIdOfBanner($bannerId = null)
    {
        return TfAdsBannerPrice::where(['banner_id' => $bannerId, 'action' => 1])->pluck('price_id');
    }

    public function pointOfBanner($bannerId = null)
    {
        return TfAdsBannerPrice::where(['banner_id' => $bannerId, 'action' => 1])->pluck('point');
    }

    public function displayOfBanner($bannerId = null)
    {
        return TfAdsBannerPrice::where(['banner_id' => $bannerId, 'action' => 1])->pluck('display');
    }

    //check exist banner with point and amount image
    public function existBannerByPointAndDisplay($bannerId, $point, $display)
    {
        $result = TfAdsBannerPrice::where(
            [
                'banner_id' => $bannerId,
                'point' => $point,
                'display' => $display,
                'action' => 1
            ])->count();
        return ($result > 0) ? true : false;
    }

    #========== ========= ========= GET INFO ========= ========= =========
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfAdsBannerPrice::where('price_id', $objectId)->pluck($column);
        }
    }

    public function priceId()
    {
        return $this->price_id;
    }

    public function point($priceId = null)
    {
        return $this->pluck('point', $priceId);
    }

    public function display($priceId = null)
    {
        return $this->pluck('display', $priceId);
    }

    public function bannerId($licenseId = null)
    {
        return $this->pluck('banner_id', $licenseId);
    }

    public function createdAt($licenseId = null)
    {
        return $this->pluck('created_at', $licenseId);
    }

}
