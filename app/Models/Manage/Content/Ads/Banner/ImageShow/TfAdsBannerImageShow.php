<?php namespace App\Models\Manage\Content\Ads\Banner\ImageShow;

use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Database\Eloquent\Model;

class TfAdsBannerImageShow extends Model {

    protected $table = 'tf_ads_banner_image_shows';
    protected $fillable = ['show_id', 'accessIP', 'created_at', 'image_id', 'user_id'];
    protected $primaryKey = 'show_id';
    #public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    public function insert($imageId)
    {
        $hFunction = new \Hfunction();
        $modelUser = new TfUser();
        $modelShow = new TfAdsBannerImageShow();
        $modelShow->showIP = $hFunction->getClientIP();
        $modelShow->image_id = $imageId;
        $modelShow->user_id = $modelUser->loginUserId();
        $modelShow->created_at = $hFunction->carbonNow();
        if ($modelShow->save()) {
            $this->lastId = $modelShow->show_id;
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

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($showId = null, $field = null)
    {
        if (empty($showId)) {
            return TfAdsBannerImageShow::get();
        } else {
            $result = TfAdsBannerImageShow::where('show_id', $showId)->first();
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
            return TfAdsBannerImageShow::where('show_id', $objectId)->pluck($column);
        }
    }

    public function showId()
    {
        return $this->show_id;
    }

    public function showIP($showId = null)
    {
        if (empty($showId)) $showId = $this->visitId();
        return $this->pluck('showIP', $showId);
    }

    public function imageId($showId = null)
    {
        if (empty($showId)) $showId = $this->visitId();
        return $this->pluck('image_id', $showId);
    }

    public function userId($showId = null)
    {
        if (empty($showId)) $showId = $this->visitId();
        return $this->pluck('user_id', $showId);
    }

    public function createdAt($showId = null)
    {
        if (empty($showId)) $showId = $this->visitId();
        return $this->pluck('created_at', $showId);
    }

    // total records
    public function totalRecords()
    {
        return TfAdsBannerImageShow::count();
    }

}
