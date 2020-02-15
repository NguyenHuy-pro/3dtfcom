<?php namespace App\Models\Manage\Content\Ads\Banner\ImageVisit;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TfAdsBannerImageVisit extends Model
{

    protected $table = 'tf_ads_banner_image_visits';
    protected $fillable = ['visit_id', 'accessIP', 'created_at', 'image_id', 'user_id'];
    protected $primaryKey = 'visit_id';
    #public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    public function insert($imageId, $accessIP, $userId = null)
    {
        $hFunction = new \Hfunction();
        $modelVisit = new TfAdsBannerImageVisit();
        $modelVisit->accessIP = $accessIP;
        $modelVisit->image_id = $imageId;
        $modelVisit->user_id = $userId;
        $modelVisit->created_at = $hFunction->carbonNow();
        if ($modelVisit->save()) {
            $this->lastId = $modelVisit->visit_id;
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

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-ADS-BANNER-IMAGE -----------
    //relation
    public function adsBannerImage()
    {
        return $this->belongsTo('App\Models\Manage\Content\Ads\Banner\Image\TfAdsBannerImage', 'image_id', 'image_id');
    }

    #----------- TF-USER -----------
    //relation
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //========== ========== ========== CHECK INFO ========== ========== ==========
    //visit ads image
    public function checkUserViewImage($imageId, $accessIP, $userId)
    {
        //current date
        $checkDate = Carbon::now();
        $checkDate = Carbon::parse($checkDate->format('Y-m-d'));
        //logged
        if (!empty($userId)) {
            // last visit info
            $dataBannerImageView = TfAdsBannerImageVisit::where([
                'image_id' => $imageId,
                'user_id' => $userId
            ])->orderBy('visit_id', 'DESC')->first();
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
            $dataBannerImageView = TfAdsBannerImageVisit::where([
                'image_id' => $imageId,
                'accessIP' => $accessIP
            ])->orderBy('visit_id', 'DESC')->first();
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
            return TfAdsBannerImageVisit::get();
        } else {
            $result = TfAdsBannerImageVisit::where('visit_id', $visitId)->first();
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
            return TfAdsBannerImageVisit::where('visit_id', $objectId)->pluck($column);
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
        return TfAdsBannerImageVisit::count();
    }

    //---------- TF-BANNER-IMAGE -------------
    public function totalVisitImage($imageId)
    {
        return TfAdsBannerImageVisit::where('image_id', $imageId)->count();
    }

}
