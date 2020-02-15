<?php namespace App\Models\Manage\Content\Map\RequestBuildPrice;

use App\Models\Manage\Content\Map\Land\RequestBuild\TfLandRequestBuild;
use Illuminate\Database\Eloquent\Model;

class TfRequestBuildPrice extends Model
{

    protected $table = 'tf_request_build_prices';
    protected $fillable = ['price_id', 'price', 'action', 'created_at', 'staff_id', 'size_id'];
    protected $primaryKey = 'price_id';
    public $timestamps = false;

    private $lastId;
    #=========== =========== =========== INSERT && UPDATE =========== =========== ===========
    #----------- Insert -----------
    public function insert($price, $staffId, $sizeId)
    {
        $hFunction = new \Hfunction();
        $modelPrice = new TfRequestBuildPrice();
        $modelPrice->price = $price;
        $modelPrice->action = 1;
        $modelPrice->staff_id = $staffId;
        $modelPrice->size_id = $sizeId;
        $modelPrice->created_at = $hFunction->carbonNow();
        if ($modelPrice->save()) {
            $this->lastId = $modelPrice->price_id;
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

    #---------- Update ------------
    public function actionDelete($priceId)
    {
        return TfRequestBuildPrice::where('price_id', $priceId)->update(['action' => 0]);
    }

    public function disableOldSize($sizeId)
    {
        return TfRequestBuildPrice::where('size_id', $sizeId)->where('action', 1)->update(['action' => 0]);
    }

    #=========== ========== ========== RELATION =========== ========== =========
    #-----------TF-STAFF -----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #-----------TF-SIZE -----------
    public function size()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Size\TfSize', 'size_id', 'size_id');
    }

    public function infoEnableOfSize($sizeId)
    {
        return TfRequestBuildPrice::where(['size_id' => $sizeId, 'action' => 1])->first();
    }

    public function priceOfSize($sizeId)
    {
        return TfRequestBuildPrice::where(['size_id' => $sizeId, 'action' => 1])->pluck('price');
    }

    #=========== ========== ========== GET INFO INFO =========== ========== =========
    public function findInfo($priceId)
    {
        return TfRequestBuildPrice::find($priceId);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfRequestBuildPrice::where('price_id', $objectId)->pluck($column);
        }
    }

    public function priceId()
    {
        return $this->price_id;
    }

    public function price($priceId = null)
    {
        return $this->pluck('price', $priceId);
    }

    public function staffId($priceId = null)
    {
        return $this->pluck('staff_id', $priceId);
    }

    public function sizeId($priceId = null)
    {
        return $this->pluck('size_id', $priceId);
    }

    public function createdAt($priceId = null)
    {
        return $this->pluck('created_at', $priceId);
    }

    # total records -->return number
    public function totalRecords()
    {
        return TfRequestBuildPrice::where('action', 1)->count();
    }

    #=========== ========== ========== CHECK INFO =========== ========== =========
    # exist info
    public function existsPriceOfSize($price, $sizeId)
    {
        $rule = TfRequestBuildPrice::where('price', $price)->where('size_id', $sizeId)->where('action', 1)->count();
        return ($rule > 0) ? true : false;
    }

    #exist size
    public function existSize($sizeId)
    {
        $rule = TfRequestBuildPrice::where('size_id', $sizeId)->where('action', 1)->count();
        return ($rule > 0) ? true : false;
    }

}
