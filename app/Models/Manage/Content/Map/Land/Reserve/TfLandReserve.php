<?php namespace App\Models\Manage\Content\Map\Land\Reserve;

use Illuminate\Database\Eloquent\Model;

class TfLandReserve extends Model {

    protected $table = 'tf_land_reserves';
    protected $fillable = ['reserve_id','receive','action','created_at','land_id','user_id'];
    protected $primaryKey = 'reserve_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========= INSERT && EDIT =========== =========== =========
    #----------- Insert --------------
    public function insert($landId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelReserve = new TfLandReserve();
        $modelReserve->receive = 0;
        $modelReserve->action = 1;
        $modelReserve->land_id = $landId;
        $modelReserve->user_id = $userId;
        $modelReserve->created_at = $hFunction->createdAt();
        if ($modelReserve->save()) {
            $this->lastId = $modelReserve->reserve_id;
            return true;
        } else {
            return false;
        }
    }

    #get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- Update -----------
    public function updateReserve($reserveId)
    {
        return TfLandReserve::where('reserve_id', $reserveId)->update(['receive' => 1]);
    }

    # delete
    public function actionDelete($reserveId)
    {
        return TfLandReserve::where('reserve_id', $reserveId)->update(['action' => 0]);
    }

    #when delete land
    public function actionDeleteByLand($landId = null)
    {
        if (!empty($landId)) {
            TfLandReserve::where(['land_id' => $landId, 'action' => 1])->update(['action' => 0]);
        }
    }

    # ========== ========== ========= RELATION ========= ========== ==========
    #---------- TF-LAND ----------
    public function land()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Land\TfLand', 'land_id', 'land_id');
    }

    # ---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    # ========== ========== ========= GET INFO ========= ========== ==========
    public function getInfo($reserveId ='',$field=''){
        if(empty($reserveId)){
            return null;
        }else{
            $result = TfLandReserve::where('reserve_id',$reserveId)->first();
            if(empty($field)){
                return $result;
            }else{
                return $result->$field;
            }
        }
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfLandReserve::where('reserve_id', $objectId)->pluck($column);
        }
    }

    public function reserveId()
    {
        return $this->reserve_id;
    }

    public function receive($reserveId = null)
    {
        return $this->pluck('receive', $reserveId);
    }

    public function createdAt($reserveId = null)
    {
        return $this->pluck('created_at', $reserveId);
    }

    public function landId($reserveId = null)
    {
        return $this->pluck('land_id', $reserveId);
    }

    public function userId($reserveId = null)
    {
        return $this->pluck('user_id', $reserveId);
    }

    public function dateReserve($reserveId=null){
        return $this->getInfo($reserveId,'created_at');
    }

    # total records
    public function totalRecords(){
        return TfLandReserve::where('action', 1)->count();
    }

}
