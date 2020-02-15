<?php namespace App\Models\Manage\Content\Ads\Banner;

use App\Models\Manage\Content\Ads\Banner\Image\TfAdsBannerImage;
use App\Models\Manage\Content\Ads\Banner\License\TfAdsBannerLicense;
use App\Models\Manage\Content\Ads\Banner\Price\TfAdsBannerPrice;
use App\Models\Manage\Content\Ads\Position\TfAdsPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class TfAdsBanner extends Model
{

    protected $table = 'tf_ads_banners';
    protected $fillable = ['banner_id', 'name', 'width', 'height', 'icon', 'status', 'action', 'created_at', 'page_id', 'position_id'];
    protected $primaryKey = 'banner_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========= ========= INSERT && UPDATE ========= ========= =========
    #------------ Insert ------------
    public function createdName()
    {
        $hFunction = new \Hfunction();
        $name = 'A' . $hFunction->random(3, 'int');
        if ($this->checkExistName($name)) {
            $this->createdName();
        } else {
            return $name;
        }
    }

    public function checkExistName($name)
    {
        $result = TfAdsBanner::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    public function insert($width, $height, $icon, $pageId, $positionId)
    {
        $hFunction = new \Hfunction();
        $modelBanner = new TfAdsBanner();
        $modelBanner->name = $this->createdName();
        $modelBanner->width = $width;
        $modelBanner->height = $height;
        $modelBanner->icon = $icon;
        $modelBanner->status = 1;
        $modelBanner->action = 1;
        $modelBanner->page_id = $pageId;
        $modelBanner->position_id = $positionId;
        $modelBanner->created_at = $hFunction->createdAt();
        if ($modelBanner->save()) {
            $this->lastId = $modelBanner->banner_id;
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

    //upload image
    public function uploadImage($file, $imageName)
    {
        $hFunction = new \Hfunction();
        $pathImage = "public/images/ads/banner/icons";
        if (!is_dir($pathImage)) mkdir($pathImage);
        return $hFunction->uploadSaveNoResize($file, $pathImage, $imageName);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/ads/banner/icons/' . $imageName);
    }

    public function updateIcon($bannerId, $icon)
    {
        return TfAdsBanner::where('banner_id', $bannerId)->update(['icon' => $icon]);
    }

    #------------ Update ------------
    // status
    public function updateStatus($bannerId = '', $status = '')
    {
        return TfAdsBanner::where('banner_id', $bannerId)->update(['status' => $status]);
    }

    //action
    public function actionDelete($bannerId)
    {
        $modelAdsBannerLicense = new TfAdsBannerLicense();
        $modelAdsBannerPrice = new TfAdsBannerPrice();
        if (TfAdsBanner::where(['banner_id' => $bannerId])->update(['action' => 0])) {
            //delete licenses
            $modelAdsBannerLicense->actionDeleteByBanner($bannerId);

            //delete price table
            $modelAdsBannerPrice->actionDeleteByBanner($bannerId);
        }
    }

    // delete by page
    public function actionDeleteByPage($pageId)
    {
        if (!empty($pageId)) {
            $objectId = TfAdsBanner::where(['page_id' => $pageId, 'action' => 1])->pluck('banner_id');
            if (!empty($objectId)) {
                $this->actionDelete($objectId);
            }
        }
    }

    // delete by page
    public function actionDeleteByPosition($positionId)
    {
        if (!empty($positionId)) {
            $objectId = TfAdsBanner::where(['position_id' => $positionId, 'action' => 1])->pluck('banner_id');
            if (!empty($objectId)) {
                $this->actionDelete($objectId);
            }
        }
    }

    #========== ========= ========= RELATION ========= ========= =========
    #----------- TF-ADS-BANNER-LICENSE ----------
    public function adsBannerLicense()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\License\TfAdsBannerLicense', 'banner_id', 'banner_id');
    }

    //return list
    public function licenseId($bannerId)
    {
        $modelAdsBannerLicense = new TfAdsBannerLicense();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelAdsBannerLicense->licenseIdOfBanner($bannerId);
    }

    #----------- TF-ADS-PAGE ----------
    public function adsPage()
    {
        return $this->belongsTo('App\Models\Manage\Content\Ads\Page\TfAdsPage', 'page_id', 'page_id');
    }

    #----------- TF-ADS-POSITION ----------
    public function adsPosition()
    {
        return $this->belongsTo('App\Models\Manage\Content\Ads\Position\TfAdsPosition', 'position_id', 'position_id');
    }

    #----------- TF-ADS-BANNER-PRICE ----------
    public function adsBannerPrice()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\Price\TfAdsBannerPrice', 'banner_id', 'banner_id');
    }

    //check exist price of banner with point and amount image
    public function existPriceByBanner($bannerId, $display)
    {
        $modelAdsBannerPrice = new TfAdsBannerPrice();
        return $modelAdsBannerPrice->existBannerByPointAndDisplay($bannerId, 1, $display);
    }

    public function priceIdAvailable($bannerId = null)
    {
        $modelAdsBannerPrice = new TfAdsBannerPrice();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelAdsBannerPrice->priceIdOfBanner($bannerId);
    }

    public function pointAvailable($bannerId = null)
    {
        $modelAdsBannerPrice = new TfAdsBannerPrice();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelAdsBannerPrice->pointOfBanner($bannerId);
    }

    public function displayAvailable($bannerId = null)
    {
        $modelAdsBannerPrice = new TfAdsBannerPrice();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelAdsBannerPrice->displayOfBanner($bannerId);
    }

    #========== ========= ========= GET INFO ========= ========= =========
    public function getInfo($objectId = null, $field = null)
    {
        if (empty($objectId)) {
            return TfAdsBanner::where('action', 1)->where('status', 1)->get();
        } else {
            $result = TfAdsBanner::where('banner_id', $objectId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function getInfoByName($name)
    {
        return TfAdsBanner::where(['name' => $name, 'status' => 1])->first();
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfAdsBanner::where('banner_id', $objectId)->pluck($column);
        }
    }

    public function bannerId()
    {
        return $this->banner_id;
    }

    public function name($bannerId = null)
    {
        return $this->pluck('name', $bannerId);
    }

    public function width($bannerId = null)
    {
        return $this->pluck('width', $bannerId);
    }

    public function height($bannerId = null)
    {
        return $this->pluck('height', $bannerId);
    }

    public function icon($bannerId = null)
    {
        return $this->pluck('icon', $bannerId);
    }

    public function status($bannerId = null)
    {
        return $this->pluck('status', $bannerId);
    }

    public function pageId($bannerId = null)
    {
        return $this->pluck('page_id', $bannerId);
    }

    public function positionId($bannerId = null)
    {
        return $this->pluck('position_id', $bannerId);
    }

    public function createdAt($bannerId = null)
    {
        return $this->pluck('created_at', $bannerId);
    }

    public function totalRecords()
    {
        return TfAdsBanner::where('action', 1)->count();
    }

    public function pathDefaultImage()
    {
        return asset('public\main\icons\default-ads.jpg');
    }

    public function pathIcon($iconImage = null)
    {
        if (empty($iconImage)) $iconImage = $this->icon();
        return asset("public/images/ads/banner/icons/$iconImage");
    }

    public function infoAvailable($skip = null, $take = null)
    {
        if (empty($skip) && empty($take)) {
            return TfAdsBanner::where(['status' => 1, 'action' => 1])->get();
        } else {
            return TfAdsBanner::where(['status' => 1, 'action' => 1])->skip($skip)->take($take)->get();
        }
    }

    #========== ========= ========= DISPLAY INFO ========= ========= =========
    public function bannerOfPageAndPosition($pageId, $positionId)
    {

        return TfAdsBanner::where(
            [
                'page_id' => $pageId,
                'position_id' => $positionId,
                'action' => 1,
                'status' => 1
            ])->get();

    }

    public function bannerOfPageAndRightPosition($pageId)
    {
        $modelAdsPosition = new TfAdsPosition();
        return $this->bannerOfPageAndPosition($pageId, $modelAdsPosition->rightPositionId());
    }

    public function bannerOfPageAndBottomPosition($pageId)
    {
        $modelAdsPosition = new TfAdsPosition();
        return $this->bannerOfPageAndPosition($pageId, $modelAdsPosition->bottomPositionId());
    }

    public function displayImage($bannerId = null)
    {
        $modelAdsBannerImage = new TfAdsBannerImage();
        if (empty($bannerId)) $bannerId = $this->bannerId();
        return $modelAdsBannerImage->displayImageOfBanner($bannerId);
    }
}
