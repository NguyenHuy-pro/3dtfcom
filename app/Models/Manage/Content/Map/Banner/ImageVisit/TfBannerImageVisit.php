<?php namespace App\Models\Manage\Content\Map\Banner\ImageVisit;

use App\Models\Manage\Content\Map\Banner\Image\TfBannerImage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TfBannerImageVisit extends Model
{

    protected $table = 'tf_banner_image_visits';
    protected $fillable = ['visit_id', 'accessIP', 'website', 'created_at', 'image_id', 'user_id'];
    protected $primaryKey = 'visit_id';
    #public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    public function insert($accessIP, $imageId, $userId, $website = null)
    {
        $hFunction = new \Hfunction();
        $modelBannerImageVisit = new TfBannerImageVisit();
        $modelBannerImageVisit->accessIP = $accessIP;
        $modelBannerImageVisit->website = $website;
        $modelBannerImageVisit->image_id = $imageId;
        $modelBannerImageVisit->user_id = $userId;
        $modelBannerImageVisit->created_at = $hFunction->createdAt();
        if ($modelBannerImageVisit->save()) {
            $this->lastId = $modelBannerImageVisit->visit_id;
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

    //delete visit website of image
    public function deleteVisitWebsiteByImage($bannerImageId = null)
    {
        if (!empty($bannerImageId)) {
            return TfBannerImageVisit::where('image_id', $bannerImageId)->whereNotNull('website')->delete();
        }
    }

    //delete view image of banner image
    public function deleteVisitImageByImage($bannerImageId = null)
    {
        if (!empty($bannerImageId)) {
            return TfBannerImageVisit::where('image_id', $bannerImageId)->whereNull('website')->delete();
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-BANNER-IMAGE -----------
    //relation
    public function bannerImage()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\Image\TfBannerImage', 'image_id', 'image_id');
    }

    #----------- TF-USER -----------
    //relation
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //========== ========== ========== CHECK INFO ========== ========== ==========
    //visit image of banner on  a day
    public function checkUserViewImage($bannerImageId, $accessIP, $userId)
    {
        //current date
        $checkDate = Carbon::now();
        $checkDate = Carbon::parse($checkDate->format('Y-m-d'));
        //logged
        if (!empty($userId)) {
            // last visit info
            $dataBannerImageView = TfBannerImageVisit::where([
                'image_id' => $bannerImageId,
                'user_id' => $userId
            ])->whereNull('website')->orderBy('visit_id', 'DESC')->first();
            if (count($dataBannerImageView) > 0) {
                //last date
                $viewDate = $dataBannerImageView->createdAt();
                $viewDate = Carbon::parse($viewDate->format('Y-m-d'));
                if ($viewDate != $checkDate) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            $dataBannerImageView = TfBannerImageVisit::where([
                'image_id' => $bannerImageId,
                'accessIP' => $accessIP
            ])->whereNull('website')->orderBy('visit_id', 'DESC')->first();
            if (count($dataBannerImageView) > 0) {
                //last date
                $viewDate = $dataBannerImageView->createdAt();
                $viewDate = Carbon::parse($viewDate->format('Y-m-d'));
                if ($viewDate != $checkDate) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    //visit website of banner on  a day
    public function checkUserViewWebsite($bannerImageId, $accessIP, $userId=null)
    {
        //current date
        $checkDate = Carbon::now();
        $checkDate = Carbon::parse($checkDate->format('Y-m-d'));
        //logged
        if (!empty($userId)) {
            // last visit info
            $dataBannerImageView = TfBannerImageVisit::where([
                'image_id' => $bannerImageId,
                'user_id' => $userId
            ])->whereNotNull('website')->orderBy('visit_id', 'DESC')->first();
            if (count($dataBannerImageView) > 0) {
                //last date
                $viewDate = $dataBannerImageView->createdAt();
                $viewDate = Carbon::parse($viewDate->format('Y-m-d'));
                if ($viewDate != $checkDate) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            $dataBannerImageView = TfBannerImageVisit::where([
                'image_id' => $bannerImageId,
                'accessIP' => $accessIP
            ])->whereNotNull('website')->orderBy('visit_id', 'DESC')->first();
            if (count($dataBannerImageView) > 0) {
                //last date
                $viewDate = $dataBannerImageView->createdAt();
                $viewDate = Carbon::parse($viewDate->format('Y-m-d'));
                if ($viewDate != $checkDate) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        }
    }

    //========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($visitId = null, $field = null)
    {
        if (empty($visitId)) {
            return TfBannerImageVisit::get();
        } else {
            $result = TfBannerImageVisit::where('visit_id', $visitId)->first();
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
            return TfBannerImageVisit::where('visit_id', $objectId)->pluck($column);
        }
    }

    public function visitId()
    {
        return $this->visit_id;
    }

    public function accessIP($visitId = null)
    {
        if (empty($visitId)) $visitId = $this->visitId();
        return $this->pluck('accessIP', $visitId);
    }

    public function website($visitId = null)
    {
        if (empty($visitId)) $visitId = $this->visitId();
        return $this->pluck('website', $visitId);
    }

    public function imageId($visitId = null)
    {
        if (empty($visitId)) $visitId = $this->visitId();
        return $this->pluck('image_id', $visitId);
    }

    public function userId($visitId = null)
    {
        if (empty($visitId)) $visitId = $this->visitId();
        return $this->pluck('user_id', $visitId);
    }

    public function createdAt($visitId = null)
    {
        if (empty($visitId)) $visitId = $this->visitId();
        return $this->pluck('created_at', $visitId);
    }

    // total records
    public function totalRecords()
    {
        return TfBannerImageVisit::count();
    }

    //---------- TF-BANNER-IMAGE -------------
    //total view image of image
    public function totalVisitImage($imageId)
    {
        return TfBannerImageVisit::where(['image_id' => $imageId, 'website' => null])->count();
    }

    //total view website of image
    public function totalVisitWebsite($imageId)
    {
        return TfBannerImageVisit::where(['image_id' => $imageId, 'website' => 1])->count();
    }

}
