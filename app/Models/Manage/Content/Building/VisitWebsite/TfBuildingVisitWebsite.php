<?php namespace App\Models\Manage\Content\Building\VisitWebsite;

use App\Models\Manage\Content\Building\TfBuilding;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TfBuildingVisitWebsite extends Model
{

    protected $table = 'tf_building_visit_websites';
    protected $fillable = ['visit_id', 'accessIP', 'created_at', 'building_id', 'user_id'];
    protected $primaryKey = 'visit_id';
    //public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($buildingId = '', $userId = null)
    {
        $hFunction = new \Hfunction();
        $modelVisitWebsite = new TfBuildingVisitWebsite();
        $accessIP = $hFunction->getClientIP();
        if (!$this->checkUserViewWebsite($buildingId, $accessIP, $userId)) {
            $modelVisitWebsite->accessIP = $hFunction->getClientIP();
            $modelVisitWebsite->building_id = $buildingId;
            $modelVisitWebsite->user_id = $userId;
            $modelVisitWebsite->created_at = $hFunction->createdAt();
            $modelVisitWebsite->save();
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-BUILDING -----------
    //relation
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    #----------- TF-USER -----------
    //relation
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //visit website of building on  a day
    public function checkUserViewWebsite($buildingId, $accessIP, $userId = null)
    {
        //current date
        $checkDate = Carbon::now();
        $checkDate = Carbon::parse($checkDate->format('Y-m-d'));
        //logged
        if (!empty($userId)) {
            // last visit info
            $dataBuildingVisitWebsite = TfBuildingVisitWebsite::where([
                'building_id' => $buildingId,
                'user_id' => $userId
            ])->orderBy('visit_id', 'DESC')->first();
            if (count($dataBuildingVisitWebsite) > 0) {
                //last date
                $viewDate = $dataBuildingVisitWebsite->createdAt();
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
            $dataBuildingVisitWebsite = TfBuildingVisitWebsite::where([
                'building_id' => $buildingId,
                'accessIP' => $accessIP
            ])->orderBy('visit_id', 'DESC')->first();
            if (count($dataBuildingVisitWebsite) > 0) {
                //last date
                $viewDate = $dataBuildingVisitWebsite->createdAt();
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
            return TfBuildingVisitWebsite::get();
        } else {
            $result = TfBuildingVisitWebsite::where('visit_id', $visitId)->first();
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
            return TfBuildingVisitWebsite::where('visit_id', $objectId)->pluck($column);
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

    public function totalVisitOfBuilding($buildingId)
    {
        return TfBuildingVisitWebsite::where('building_id', $buildingId)->count();
    }

    // total visit
    public function totalRecords()
    {
        return TfBuildingVisitWebsite::count();
    }

}
