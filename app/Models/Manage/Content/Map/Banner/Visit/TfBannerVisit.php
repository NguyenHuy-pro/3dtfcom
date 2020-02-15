<?php namespace App\Models\Manage\Content\Map\Banner\Visit;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TfBannerVisit extends Model
{

    protected $table = 'tf_banner_visits';
    protected $fillable = ['visit_id', 'accessIP', 'created_at', 'banner_id', 'user_id'];
    protected $primaryKey = 'visit_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    # ========== ========== ========== INSERT && EDIT ========= ========== ==========
    public function insert($accessIP, $bannerId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelBannerVisit = new TfBannerVisit();
        $modelBannerVisit->accessIP = $accessIP;
        $modelBannerVisit->banner_id = $bannerId;
        $modelBannerVisit->user_id = $userId;
        $modelBannerVisit->created_at = $hFunction->createdAt();
        if ($modelBannerVisit->save()) {
            $this->lastId = $modelBannerVisit->visit_id;
            return true;
        } else {
            return false;
        }
    }

    #get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-BANNER -----------
    public function banner()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Banner\TfBanner', 'banner_id', 'banner_id');
    }

    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #========== ========== ========== CHECK INFO ========== ========== ==========
    #visit banner on  a day
    public function checkUserVisited($bannerId, $accessIP, $userId = null)
    {
        #current date
        $checkDate = Carbon::now();
        $checkDate = Carbon::parse($checkDate->format('Y-m-d'));
        #logged
        if (!empty($userId)) {
            # last visit info
            $dataBannerVisit = TfBannerVisit::where([
                'banner_id' => $bannerId,
                'user_id' => $userId
            ])->orderBy('visit_id', 'DESC')->first();
            if (count($dataBannerVisit) > 0) {
                #last date
                $viewDate = $dataBannerVisit->createdAt();
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
            $dataBannerVisit = TfBannerVisit::where([
                'banner_id' => $bannerId,
                'accessIP' => $accessIP
            ])->orderBy('visit_id', 'DESC')->first();
            if (count($dataBannerVisit) > 0) {
                #last date
                $viewDate = $dataBannerVisit->createdAt();
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

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($visitId = '', $field = '')
    {
        if (empty($visitId)) {
            return TfBannerVisit::get();
        } else {
            $result = TfBannerVisit::where('visit_id', $visitId)->first();
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
            return TfBannerVisit::where('visit_id', $objectId)->pluck($column);
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

    # total records
    public function totalRecords()
    {
        return TfBannerVisit::count();
    }

}
