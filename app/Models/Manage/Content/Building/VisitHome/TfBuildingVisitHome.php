<?php namespace App\Models\Manage\Content\Building\VisitHome;

use App\Models\Manage\Content\Building\TfBuilding;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TfBuildingVisitHome extends Model
{

    protected $table = 'tf_building_visit_homes';
    protected $fillable = ['visit_id', 'accessIP', 'created_id', 'building_id', 'user_id'];
    protected $primaryKey = 'visit_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    //---------- Insert ----------
    public function insert($buildingId, $userId = null)
    {
        $hFunction = new \Hfunction();
        $modelBuilding = new TfBuilding();
        $modelBuildingVisitHome = new TfBuildingVisitHome();

        $accessIP = $hFunction->getClientIP();
        if (!$this->checkUserViewHome($buildingId, $accessIP, $userId)) {
            $modelBuildingVisitHome->accessIP = $accessIP;
            $modelBuildingVisitHome->building_id = $buildingId;
            $modelBuildingVisitHome->user_id = $userId;
            $modelBuildingVisitHome->created_at = $hFunction->createdAt();
            if ($modelBuildingVisitHome->save()) {
                $this->lastId = $modelBuildingVisitHome->visit_id;
                $modelBuilding->plusVisit($buildingId);
                return true;
            } else {
                return false;
            }

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
    #----------- TF-BUILDING -----------
    //relation
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    public function totalVisitOfBuilding($buildingId)
    {
        return TfBuildingVisitHome::where('building_id', $buildingId)->count();
    }

    #----------- TF-USER -----------
    //relation
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    //visit home page of building on  a day
    public function checkUserViewHome($buildingId, $accessIP, $userId = null)
    {
        //current date
        $checkDate = Carbon::now();
        $checkDate = Carbon::parse($checkDate->format('Y-m-d'));
        //logged
        if (!empty($userId)) {
            // last visit info
            $dataBuildingVisitHome = TfBuildingVisitHome::where([
                'building_id' => $buildingId,
                'user_id' => $userId
            ])->orderBy('visit_id', 'DESC')->first();
            if (count($dataBuildingVisitHome) > 0) {
                //last date
                $viewDate = $dataBuildingVisitHome->createdAt();
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
            $dataBuildingVisitHome = TfBuildingVisitHome::where([
                'building_id' => $buildingId,
                'accessIP' => $accessIP
            ])->orderBy('visit_id', 'DESC')->first();
            if (count($dataBuildingVisitHome) > 0) {
                //last date
                $viewDate = $dataBuildingVisitHome->createdAt();
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
            return TfBuildingVisitHome::get();
        } else {
            $result = TfBuildingVisitHome::where('visit_id', $visitId)->first();
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
            return TfBuildingVisitHome::where('visit_id', $objectId)->pluck($column);
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

    // total records
    public function totalRecords()
    {
        return TfBuildingVisitHome::count();
    }

}
