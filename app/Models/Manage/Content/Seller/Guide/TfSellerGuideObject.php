<?php namespace App\Models\Manage\Content\Seller\Guide;

use Illuminate\Database\Eloquent\Model;

class TfSellerGuideObject extends Model
{

    protected $table = 'tf_seller_guide_objects';
    protected $fillable = ['object_id', 'name', 'status', 'action', 'created_at'];
    protected $primaryKey = 'object_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    //---------- Insert ----------
    public function insert($name)
    {
        $hFunction = new \Hfunction();
        $modelObject = new TfSellerGuideObject();
        $modelObject->name = $name;
        $modelObject->created_at = $hFunction->carbonNow();
        if ($modelObject->save()) {
            $this->lastId = $modelObject->object_id;
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

    #---------- Update ----------
    public function updateInfo($objectId, $name)
    {
        return TfSellerGuideObject::where('object_id', $objectId)->update([
            'name' => $name
        ]);
    }

    public function updateStatus($objectId, $status)
    {
        return TfSellerGuideObject::where('object_id', $objectId)->update(['status' => $status]);
    }


    # delete
    public function actionDelete($objectId = null)
    {
        $modelSellerGuide = new TfSellerGuide();
        if (empty($objectId)) $objectId = $this->typeId();
        if (TfSellerGuideObject::where('object_id', $objectId)->update(['action' => 0])) {
            return $modelSellerGuide->deleteByObject($objectId);
        } else {
            return false;
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    //---------- TF-SELLER-GUIDE ----------
    public function sellerGuide()
    {
        return $this->hasMany('App\Models\Manage\Content\Seller\Guide\TfSellerGuide', 'object_id', 'object_id');
    }

    public function landObjectId()
    {
        return 2; //default
    }
    public function bannerObjectId()
    {
        return 1; //default
    }
    public function buildingObjectId()
    {
        return 3; //default
    }
    public function paymentObjectId()
    {
        return 4; //default
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($objectId = null, $field = null)
    {
        if (empty($objectId)) {
            return TfSellerGuideObject::where('action', 1)->where('status', 1)->get();
        } else {
            $result = TfSellerGuideObject::where('object_id', $objectId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }


    //create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfSellerGuideObject::select('object_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfSellerGuideObject::where('object_id', $objectId)->pluck($column);
        }
    }

    public function objectId()
    {
        return $this->object_id;
    }

    public function name($objectId = null)
    {
        return $this->pluck('name', $objectId);
    }

    public function status($objectId = null)
    {
        return $this->pluck('status', $objectId);
    }

    public function createdAt($objectId = null)
    {
        return $this->pluck('created_at', $objectId);
    }

    //total records -->return number
    public function totalRecords()
    {
        return TfSellerGuideObject::where('action', 1)->count();
    }

    #========== ========== ========== check info ========== ========== ==========
    //check exist of name
    public function existName($name)
    {
        $result = TfSellerGuideObject::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditName($name, $objectId)
    {
        $result = TfSellerGuideObject::where('name', $name)->where('object_id', '<>', $objectId)->count();
        return ($result > 0) ? true : false;
    }
}
