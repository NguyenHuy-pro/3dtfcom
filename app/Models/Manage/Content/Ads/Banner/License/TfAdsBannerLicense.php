<?php namespace App\Models\Manage\Content\Ads\Banner\License;

use App\Models\Manage\Content\Ads\Banner\Image\TfAdsBannerImage;
use Illuminate\Database\Eloquent\Model;

class TfAdsBannerLicense extends Model
{

    protected $table = 'tf_ads_banner_licenses';
    protected $fillable = ['license_id', 'name', 'display', 'displayed', 'status', 'action', 'created_at', 'banner_id', 'user_id'];
    protected $primaryKey = 'license_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========= ========= INSERT && UPDATE ========= ========= =========
    #------------ Insert ------------
    public function insert($display, $bannerId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelBannerLicense = new TfAdsBannerLicense();
        $modelBannerLicense->name = 'AL' . $hFunction->getTimeCode();
        $modelBannerLicense->display = $display;
        $modelBannerLicense->displayed = 0;
        $modelBannerLicense->status = 1;
        $modelBannerLicense->action = 1;
        $modelBannerLicense->banner_id = $bannerId;
        $modelBannerLicense->user_id = $userId;
        $modelBannerLicense->created_at = $hFunction->createdAt();
        if ($modelBannerLicense->save()) {
            $this->lastId = $modelBannerLicense->license_id;
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
    // add displayed
    public function addDisplay($license)
    {
        $displayed = $this->displayed($license);
        if (TfAdsBannerLicense::where('license_id', $license)->update(['displayed' => $displayed + 1])) {
            $this->checkDisplay($license);
        }

    }

    // status
    public function updateStatus($licenseId = '', $status = '')
    {
        return TfAdsBannerLicense::where('license_id', $licenseId)->update(['status' => $status]);
    }

    // disable
    public function disableLicense($licenseId = null)
    {
        if (empty($licenseId)) $licenseId = $this->licenseId();
        return TfAdsBannerLicense::where('license_id', $licenseId)->update(['status' => 0]);
    }

    //action
    public function actionDelete($licenseId)
    {
        $modelAdsBannerImage = new TfAdsBannerImage();
        if (TfAdsBannerLicense::where(['license_id' => $licenseId])->update(['action' => 0])) {
            $modelAdsBannerImage->actionDeleteByLicense($licenseId);
        }
    }

    //delete by ads banner
    public function actionDeleteByBanner($bannerId = null)
    {
        if (!empty($bannerId)) {
            $objectId = TfAdsBannerLicense::where(['banner_id' => $bannerId, 'action' => 1])->pluck('license_id');
            if (!empty($objectId)) {
                $this->actionDelete($objectId);
            }
        }
    }

    #========== ========= ========= RELATION ========= ========= =========
    #----------- TF-ADS-BANNER-EXCHANGE ----------
    public function adsBannerExchange()
    {
        return $this->hasOne('App\Models\Manage\Content\Ads\Banner\Exchange\TfAdsBannerExchange', 'license_id', 'license_id');
    }

    #----------- TF-ADS-BANNER ----------
    public function adsBanner()
    {
        return $this->belongsTo('App\Models\Manage\Content\Ads\Banner\TfAdsBanner', 'banner_id', 'banner_id');
    }

    //return list id
    public function licenseIdOfBanner($bannerId)
    {
        return TfAdsBannerLicense::where(['banner_id' => $bannerId, 'status' => 1])->lists('license_id');
    }

    #----------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //list license info of user
    public function infoOfUser($userId, $skip = null, $take = null)
    {
        if (empty($skip) && empty($take)) {
            return TfAdsBannerLicense::where('user_id', $userId)->where('action', 1)->orderBy('license_id', 'DESC')->get();
        } else {
            return TfAdsBannerLicense::where('user_id', $userId)->where('action', 1)->skip($skip)->take($take)->orderBy('license_id', 'DESC')->get();
        }
    }

    //list license id of user
    public function listIdOfUser($userId)
    {
        return TfAdsBannerLicense::where('user_id', $userId)->where('action', 1)->orderBy('license_id', 'DESC')->lists('license_id');
    }

    #----------- TF-ADS-BANNER-IMAGE ----------
    public function adsBannerImage()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\Image', 'license_id', 'license_id');
    }

    public function adsBannerImageAvailable($licenseId = null)
    {
        $modelAdsBannerImage = new TfAdsBannerImage();
        if (empty($licenseId)) $licenseId = $this->licenseId();
        return $modelAdsBannerImage->infoAvailableOfLicense($licenseId);
    }

    #========== ========= ========= CHECK INFO ========= ========= =========
    public function checkDisplay($licenseId)
    {
        $dataAdsBannerLicense = $this->getInfo($licenseId);
        if (count($dataAdsBannerLicense)) {
            $display = $dataAdsBannerLicense->display();
            $displayed = $dataAdsBannerLicense->displayed();
            if ($display <= $displayed) {
                // disable license
                $dataAdsBannerLicense->disableLicense();
            }
        }

    }

    #========== ========= ========= GET INFO ========= ========= =========
    public function getInfo($licenseId = null, $field = null)
    {
        if (empty($licenseId)) {
            return TfAdsBannerLicense::where('action', 1)->get();
        } else {
            $result = TfAdsBannerLicense::where('license_id', $licenseId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function getInfoOfName($name)
    {
        return TfAdsBannerLicense::where('name', $name)->first();
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfAdsBannerLicense::where('license_id', $objectId)->pluck($column);
        }
    }

    public function licenseId()
    {
        return $this->license_id;
    }

    public function name($licenseId = null)
    {
        return $this->pluck('name', $licenseId);
    }

    public function display($licenseId = null)
    {
        return $this->pluck('display', $licenseId);
    }

    public function displayed($licenseId = null)
    {
        return $this->pluck('displayed', $licenseId);
    }

    public function status($licenseId = null)
    {
        return $this->pluck('status', $licenseId);
    }

    public function bannerId($licenseId = null)
    {
        return $this->pluck('banner_id', $licenseId);
    }

    public function userId($licenseId = null)
    {
        return $this->pluck('userId', $licenseId);
    }

    public function createdAt($licenseId = null)
    {
        return $this->pluck('created_at', $licenseId);
    }

}
