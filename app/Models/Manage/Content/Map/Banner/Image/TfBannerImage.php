<?php namespace App\Models\Manage\Content\Map\Banner\Image;

use App\Models\Manage\Content\Map\Banner\BadInfoNotify\TfBannerBadInfoNotify;
use App\Models\Manage\Content\Map\Banner\BadInfoReport\TfBannerBadInfoReport;
use App\Models\Manage\Content\Map\Banner\CopyrightNotify\TfBannerCopyrightNotify;
use App\Models\Manage\Content\Map\Banner\ImageVisit\TfBannerImageVisit;
use App\Models\Manage\Content\Map\Banner\License\TfBannerLicense;
use App\Models\Manage\Content\Users\Activity\TfUserActivity;
use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class TfBannerImage extends Model
{

    protected $table = 'tf_banner_images';
    protected $fillable = ['image_id', 'name', 'image', 'website', 'status', 'action', 'created_at', 'license_id'];
    protected $primaryKey = 'image_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    # ========== ========== ========== INSERT && UPDATE ========= ========== ==========
    public function insert($image, $website = null, $licenseId)
    {
        $hFunction = new \Hfunction();
        $modelBannerImage = new TfBannerImage();
        $modelBannerImage->name = "BM" . $hFunction->getTimeCode();
        $modelBannerImage->image = $image;
        $modelBannerImage->website = $website;
        $modelBannerImage->license_id = $licenseId;
        $modelBannerImage->created_at = $hFunction->carbonNow();
        if ($modelBannerImage->save()) {
            $this->lastId = $modelBannerImage->image_id;
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
    public function updateStatus($imageId, $status)
    {
        return TfBannerImage::where('image_id', $imageId)->update(['status' => $status]);
    }

    //delete
    public function actionDelete($imageId = null)
    {
        $modelUserActivity = new TfUserActivity();
        $modelBannerBadInfoNotify = new TfBannerBadInfoNotify();
        $modelBannerBadInfoReport = new TfBannerBadInfoReport();
        $modelBannerCopyrightNotify = new TfBannerCopyrightNotify();
        if (empty($imageId)) $imageId = $this->imageId();
        if (TfBannerImage::where('image_id', $imageId)->update(['action' => 0])) {
            //delete notify
            $modelBannerBadInfoNotify->actionDeleteByImage($imageId);

            //delete report
            $modelBannerBadInfoReport->actionDeleteByImage($imageId);

            $modelBannerCopyrightNotify->actionDeleteByImage($imageId);
            //update user activity
            $modelUserActivity->deleteByBannerImage($imageId);
        }
    }

    //when delete banner
    public function actionDeleteByLicense($licenseId = null)
    {
        if (!empty($licenseId)) {
            $objectId = TfBannerImage::where(['license_id' => $licenseId, 'action' => 1])->pluck('image_id');
            if (!empty($objectId)) {
                $this->actionDelete($objectId);
            }
        }
    }

    public function uploadImage($file, $imageName, $resize)
    {
        $hFunction = new \Hfunction();
        $pathFullImage = "public/images/map/banner/full";
        $pathSmallImage = "public/images/map/banner/small";
        if (!is_dir($pathFullImage)) mkdir($pathFullImage);
        if (!is_dir($pathSmallImage)) mkdir($pathSmallImage);
        return $hFunction->uploadSave($file, $pathSmallImage . '/', $pathFullImage . '/', $imageName, $resize);
    }

    //drop image
    public function dropImage($imageName)
    {
        $oldSmallSrc = "public/images/map/banner/small/$imageName";
        $oldFullSrc = "public/images/map/banner/full/$imageName";
        if (File::exists($oldSmallSrc)) File::delete($oldSmallSrc);
        if (File::exists($oldFullSrc)) File::delete($oldFullSrc);

    }

    # ========== ========== ========== RELATION ========= ========== ==========
    # ---------- TF-BANNER ----------
    //only get info is using of banner
    public function infoOfBanner($bannerId)
    {
        $modelBannerLicense = new TfBannerLicense();
        $dataBannerLicense = $modelBannerLicense->infoOfBanner($bannerId);
        if (count($dataBannerLicense) > 0) {
            $licenseId = $dataBannerLicense->licenseId();
            return TfBannerImage::where('license_id', $licenseId)->where('action', 1)->first();
        } else {
            return null;
        }
    }

    //building id of land
    public function imageIdOfBanner($bannerId)
    {
        $dataBannerImage = $this->infoOfBanner($bannerId);
        if (count($dataBannerImage) > 0) {
            return $dataBannerImage->imageId();
        } else {
            return null;
        }
    }

    public function bannerId($imageId = null)
    {
        if (empty($imageId)) $imageId = $this->imageId();
        $dataBannerImage = $this->getInfo($imageId);
        if (count($dataBannerImage) > 0) {
            return $dataBannerImage->bannerLicense->bannerId();
        } else {
            return null;
        }
    }

    public function bannerImage()
    {
        return $this->hasOne('App\Models\Manage\Content\Users\Activity\TfUserActivity', 'image_id', 'bannerImage_id');
    }

    #---------- TF-BANNER-LICENSE -----------
    public function bannerLicense()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\License\TfBannerLicense', 'license_id', 'license_id');
    }

    #---------- TF-BANNER-IMAGE-VISIT -----------
    public function bannerImageVisit()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\ImageVisit\TfBannerImageVisit', 'image_id', 'image_id');
    }

    #---------- TF-BANNER-BAD-INFO-NOTIFY -----------
    public function bannerBadInfoNotify()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Report\TfBannerBadInfoNotify', 'image_id', 'image_id');
    }

    #----------- TF-BAD-INFO -----------
    public function badInfo()
    {
        return $this->belongsToMany('App\Models\Manage\Content\System\BadInfo\TfBadInfo', 'App\Models\Manage\Content\Map\Banner\Report\TfBannerBadInfoNotify', 'image_id', 'badInfo_id');
    }

    #---------- TF-BANNER-BAD-INFO-REPORT -----------
    public function bannerBadInfoReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Report\TfBannerBadInfoReport', 'image_id', 'image_id');
    }

    #---------- TF-BANNER-COPYRIGHT-REPORT -----------
    public function bannerCopyrightReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Report\TfBannerCopyrightReport', 'image_id', 'image_id');
    }

    # ========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($imageId = null, $field = null)
    {
        if (empty($imageId)) {
            return TfBannerImage::where('action', 1)->get();
        } else {
            $result = TfBannerImage::where('image_id', $imageId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #---------- BANNER IMAGE INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBannerImage::where('image_id', $objectId)->pluck($column);
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

    public function website($imageId = null)
    {
        $hFunction = new \Hfunction();
        return $hFunction->htmlEntities($this->pluck('website', $imageId));
    }

    public function status($imageId = null)
    {
        return $this->pluck('status', $imageId);
    }

    public function createdAt($imageId = null)
    {
        return $this->pluck('created_at', $imageId);
    }

    // total records
    public function totalRecords()
    {
        return TfBannerImage::where('action', 1)->count();
    }

    // last id
    public function lastId()
    {
        $result = TfBannerImage::orderBy('image_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->image_id;
    }

    /*old function */
    public function pathImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset("public/images/map/banner/small/$image");
    }

    public function pathSmallImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset("public/images/map/banner/small/$image");
    }

    public function pathFullImage($image = null)
    {
        if (empty($image)) $image = $this->image();
        return asset("public/images/map/banner/full/$image");
    }

    //recent image
    public function recentImage($take = null)
    {
        if (empty($take)) {
            return TfBannerImage::where(['action' => 1, 'status' => 1])->orderBy('created_at', 'desc')->get();
        } else {
            return TfBannerImage::where(['action' => 1, 'status' => 1])->orderBy('created_at', 'desc')->skip(0)->take($take)->get();
        }
    }

    #--------------- TF-BANNER-IMAGE-VISIT --------------
    //total visit image
    public function totalVisitImage($imageId = null)
    {
        $modelBannerImageVisit = new TfBannerImageVisit();
        if (empty($imageId)) $imageId = $this->imageId();
        return $modelBannerImageVisit->totalVisitImage($imageId);
    }

    //total visit image
    public function totalVisitWebsite($imageId = null)
    {
        $modelBannerImageVisit = new TfBannerImageVisit();
        if (empty($imageId)) $imageId = $this->imageId();
        return $modelBannerImageVisit->totalVisitWebsite($imageId);
    }

}
