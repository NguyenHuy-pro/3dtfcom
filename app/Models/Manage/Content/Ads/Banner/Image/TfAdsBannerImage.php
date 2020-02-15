<?php namespace App\Models\Manage\Content\Ads\Banner\Image;

use App\Models\Manage\Content\Ads\Banner\ImageShow\TfAdsBannerImageShow;
use App\Models\Manage\Content\Ads\Banner\ImageVisit\TfAdsBannerImageVisit;
use App\Models\Manage\Content\Ads\Banner\License\TfAdsBannerLicense;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TfAdsBannerImage extends Model
{

    protected $table = 'tf_ads_banner_images';
    protected $fillable = ['image_id', 'name', 'image', 'website', 'confirm', 'publish', 'dateConfirm', 'action', 'created_at', 'license_id', 'type_id'];
    protected $primaryKey = 'image_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    # ========== ========== ========== INSERT && UPDATE ========= ========== ==========
    public function insert($image, $website = null, $confirm = 1, $publish = 1, $dateConfirm = null, $licenseId, $typeId)
    {
        $hFunction = new \Hfunction();
        $model = new TfAdsBannerImage();
        $model->name = "AI" . $hFunction->getTimeCode();
        $model->image = $image;
        $model->website = $website;
        $model->confirm = $confirm;
        $model->publish = $publish;
        $model->dateConfirm = $dateConfirm;
        $model->license_id = $licenseId;
        $model->type_id = $typeId;
        $model->created_at = $hFunction->carbonNow();
        if ($model->save()) {
            $this->lastId = $model->image_id;
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

    #---------- Update -----------
    //status
    public function updateConfirm($imageId, $status)
    {
        return TfAdsBannerImage::where('image_id', $imageId)->update(['action' => $status]);
    }

    // delete
    public function actionDelete($imageId = null)
    {
        if (empty($imageId)) $imageId = $this->imageId();
        return TfAdsBannerImage::where('image_id', $imageId)->update(['action' => 0]);
    }

    //when delete ads banner
    public function actionDeleteByLicense($licenseId = null)
    {
        if (!empty($licenseId)) {
            $objectId = TfAdsBannerImage::where(['license_id' => $licenseId, 'action' => 1])->pluck('image_id');
            if (!empty($objectId)) {
                $this->actionDelete($objectId);
            }
        }
    }

    //upload image
    public function uploadImage($file, $imageName)
    {
        $hFunction = new \Hfunction();
        $pathImage = "public/images/ads/images";
        if (!is_dir($pathImage)) mkdir($pathImage);
        return $hFunction->uploadSaveNoResize($file, $pathImage, $imageName);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/ads/images/' . $imageName);
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #---------- TF-ADS-BANNER-LICENSE -----------
    public function businessType()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\BusinessType\TfBusinessType', 'type_id', 'type_id');
    }

    #---------- TF-ADS-BANNER-LICENSE -----------
    public function adsBannerLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Ads\Banner\License\TfAdsBannerLicense', 'license_id', 'license_id');
    }

    public function infoAvailableOfLicense($licenseId)
    {
        return TfAdsBannerImage::where(['license_id' => $licenseId, 'publish' => 1, 'action' => 1])->first();
    }

    #---------- TF-ADS-BANNER-IMAGE-VISIT -----------
    public function adsBannerImageVisit()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\ImageVisit\TfAdsBannerImageVisit', 'image_id', 'image_id');
    }

    //total visit image
    public function totalVisitImage($imageId = null)
    {
        $modelImageVisit = new TfAdsBannerImageVisit();
        if (empty($imageId)) $imageId = $this->imageId();
        return $modelImageVisit->totalVisitImage($imageId);
    }

    #---------- TF-ADS-BANNER-IMAGE-SHOW -----------
    public function adsBannerImageShow()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\ImageShow\TfAdsBannerImageShow', 'image_id', 'image_id');
    }

    #----------- TF-ADS-BANNER-IMAGE-REPORT -----------
    public function adsBannerImageReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\ImageReport\TfAdsBannerImageReport', 'image_id', 'image_id');
    }

    //relation
    public function adsBannerImagePrevent()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\ImagePrevent\TfAdsBannerImagePrevent', 'image_id', 'image_id');
    }

    # ========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($imageId = null, $field = null)
    {
        if (empty($imageId)) {
            return TfAdsBannerImage::where('action', 1)->get();
        } else {
            $result = TfAdsBannerImage::where('image_id', $imageId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function getInfoOfName($name)
    {
        return TfAdsBannerImage::where(['name' => $name, 'action' => 1])->first();
    }

    #---------- BANNER -----------
    //get image is using of license
    public function infoOfLicense($licenseId)
    {
        return TfAdsBannerImage::where(['publish' => 1, 'license_id' => $licenseId, 'action' => 1])->first();
    }

    #---------- BANNER IMAGE INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfAdsBannerImage::where('image_id', $objectId)->pluck($column);
        }
    }

    public function imageId()
    {
        return $this->image_id;
    }

    public function name($imageId = null)
    {
        return $this->pluck('name', $imageId);
    }

    public function image($imageId = null)
    {
        return $this->pluck('image', $imageId);
    }

    public function licenseId($imageId = null)
    {
        return $this->pluck('license_id', $imageId);
    }

    public function typeId($imageId = null)
    {
        return $this->pluck('type_id', $imageId);
    }

    public function website($imageId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('website', $imageId));
    }

    public function confirm($imageId = null)
    {
        return $this->pluck('confirm', $imageId);
    }

    public function dateConfirm($imageId = null)
    {
        return $this->pluck('dateConfirm', $imageId);
    }

    public function createdAt($imageId = null)
    {
        return $this->pluck('created_at', $imageId);
    }

    // total records
    public function totalRecords()
    {
        return TfAdsBannerImage::where('action', 1)->count();
    }

    // last id
    public function lastId()
    {
        $result = TfAdsBannerImage::orderBy('image_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->image_id;
    }

    public function pathImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset("public/images/ads/images/$image");
    }

    public function pathImageDefault()
    {
        return asset("public/main/icons/default-ads.jpg");
    }

    # ========== ========== ========== DISPLAY INFO ON PAGE ========= ========== ==========
    public function displayImageOfBanner($bannerId)
    {
        $modelUser = new TfUser();
        $modelAdsBannerLicense = new TfAdsBannerLicense();
        $modelAdsBannerImageShow = new TfAdsBannerImageShow();
        $dataUserLogin = $modelUser->loginUserInfo();
        $preventStatus = false;
        if (count($dataUserLogin) > 0) {
            $preventImageId = $dataUserLogin->preventImageOfUser();
            if (count($preventImageId) > 0) $preventStatus = true;
        }
        $listLicenseId = $modelAdsBannerLicense->licenseIdOfBanner($bannerId);
        if ($preventStatus) {
            $result = TfAdsBannerImage::whereIn('license_id', $listLicenseId)->whereNotIn('image_id', $preventImageId)->orderBy(DB::raw('RAND()'))->first();
        } else {
            $result = TfAdsBannerImage::whereIn('license_id', $listLicenseId)->orderBy(DB::raw('RAND()'))->first();
        }

        if (count($result) > 0) {
            if ($modelAdsBannerImageShow->insert($result->imageId())) {
                $modelAdsBannerLicense->addDisplay($result->licenseId());
            }
        }
        return $result;
    }

}
