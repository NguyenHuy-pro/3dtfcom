<?php namespace App\Models\Manage\Content\Seller\Guide;

use Illuminate\Database\Eloquent\Model;

class TfSellerGuide extends Model
{

    protected $table = 'tf_seller_guides';
    protected $fillable = ['guide_id', 'name', 'content', 'video', 'status', 'action', 'created_at', 'object_id'];
    protected $primaryKey = 'guide_id';
    public $timestamps = false;

    private $lastId;

    #============ ============ ============ INSERT && UPDATE ============ ============ ============
    #---------- Insert ------------
    public function insert($name, $content, $video = null, $objectId)
    {
        $hFunction = new \Hfunction();
        $modelGuide = new TfSellerGuide();
        $modelGuide->name = $name;
        $modelGuide->content = $content;
        $modelGuide->video = $video;
        $modelGuide->object_id = $objectId;
        $modelGuide->created_at = $hFunction->carbonNow();
        if ($modelGuide->save()) {
            $this->lastId = $modelGuide->guide_id;
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

    #----------- Update ----------
    public function updateInfo($guideId, $name, $content, $video, $objectId)
    {
        return TfSellerGuide::where('guide_id', $guideId)->update([
            'name' => $name,
            'content' => $content,
            'video' => $video,
            'object_id' => $objectId
        ]);
    }

    public function updateStatus($guideId, $status)
    {
        return TfSellerGuide::where('guide_id', $guideId)->update(['status' => $status]);
    }

    //delete
    public function actionDelete($guideId)
    {
        return TfSellerGuide::where('guide_id', $guideId)->update(['action' => 0, 'status' => 0]);
    }

    public function deleteByObject($objectId)
    {
        return TfSellerGuide::where('object_id', $objectId)->update(['action' => 0, 'status' => 0]);
    }
    #============ ============ ============ RELATION ============ ============ ============
    #---------- TF-SELLER-GUIDE-OBJECT ----------
    public function sellerGuideObject()
    {
        return $this->belongsTo('App\Models\Manage\Content\Seller\Guide\TfSellerGuideObject', 'object_id', 'object_id');
    }

    //get info of banner
    public function infoOfBanner()
    {
        $modelSellerGuideObject = new TfSellerGuideObject();
        return $this->infoOfObject($modelSellerGuideObject->bannerObjectId());
    }

    //get info of land
    public function infoOfLand()
    {
        $modelSellerGuideObject = new TfSellerGuideObject();
        return $this->infoOfObject($modelSellerGuideObject->landObjectId());
    }

    //get info of Building
    public function infoOfBuilding()
    {
        $modelSellerGuideObject = new TfSellerGuideObject();
        return $this->infoOfObject($modelSellerGuideObject->buildingObjectId());
    }

    //get info of payment
    public function infoOfPayment()
    {
        $modelSellerGuideObject = new TfSellerGuideObject();
        return $this->infoOfObject($modelSellerGuideObject->paymentObjectId());
    }

    public function infoOfObject($objectId)
    {
        return TfSellerGuide::where(['object_id' => $objectId, 'status' => 1, 'action' => 1])->get();
    }

    #============ ============ ============ GET INFO ============ ============ ============
    public function getInfo($guideId = null, $field = null)
    {
        if (empty($guideId)) {
            return TfSellerGuide::where('action', 1)->where('status', 1)->get();
        } else {
            $result = TfSellerGuide::where('guide_id', $guideId)->first();
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
            return TfSellerGuide::where('guide_id', $objectId)->pluck($column);
        }
    }

    public function guideId()
    {
        return $this->guide_id;
    }

    public function name($guideId = null)
    {
        return $this->pluck('name', $guideId);
    }

    public function content($guideId = null)
    {
        return $this->pluck('content', $guideId);
    }

    public function video($guideId = null)
    {
        return $this->pluck('video', $guideId);
    }

    public function status($guideId = null)
    {
        return $this->pluck('status', $guideId);
    }

    public function createdAt($guideId = null)
    {
        return $this->pluck('created_at', $guideId);
    }

    public function objectId($guideId = null)
    {
        return $this->pluck('object_id', $guideId);
    }

    #total records
    public function totalRecords()
    {
        return TfSellerGuide::where('action', 1)->count();
    }
    #============ ============ ============ CHECK INFO ============ ============ ============
    #check exist of name (add new)
    public function existName($name)
    {
        $result = TfSellerGuide::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    #check exist of name (edit info)
    public function existEditName($name, $guideId)
    {
        $result = TfSellerGuide::where('name', $name)->where('guide_id', '<>', $guideId)->count();
        return ($result > 0) ? true : false;
    }

}
