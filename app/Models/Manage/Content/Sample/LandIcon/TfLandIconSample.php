<?php namespace App\Models\Manage\Content\Sample\LandIcon;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class TfLandIconSample extends Model
{

    protected $table = 'tf_land_icon_samples';
    protected $fillable = ['sample_id', 'name', 'image', 'ownStatus', 'created_at', 'size_id', 'transactionStatus_id', 'staff_id'];
    protected $primaryKey = 'sample_id';
    public $timestamps = false;

    private $lastId;
    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert -----------
    public function insert($image, $onwStatus, $sizeId, $transactionStatusId, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelSample = new TfBannerSample();
        $modelSample->name = "ICON-" . $hFunction->getTimeCode();;
        $modelSample->image = $image;
        $modelSample->ownStatus = $onwStatus;
        $modelSample->size_id = $sizeId;
        $modelSample->transactionStatus_id = $transactionStatusId;
        $modelSample->staff_id = $staffId;
        $modelSample->created_at = $hFunction->createdAt();
        if ($modelSample->save()) {
            $this->lastId = $modelSample->sample_id;
            return true;
        } else {
            return false;
        }

    }

    # get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    //upload image
    public function uploadImage($file, $imageName)
    {
        $hFunction = new \Hfunction();
        $pathImage = "public/images/sample/land-icon";
        if (!is_dir($pathImage)) mkdir($pathImage);
        return $hFunction->uploadSaveNoResize($file, $pathImage . '/', $imageName);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/sample/land-icon/' . $imageName);
    }

    #---------- Update ----------
    public function actionDelete($sampleId)
    {
        #
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-STAFF ----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #---------- TF-SIZE ----------
    public function size()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Size\TfSize', 'size_id', 'size_id');
    }

    #------------ TF-TRANSACTION-STATUS -------------
    public function transactionStatus()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Transaction\TfTransactionStatus', 'transactionStatus_id', 'status_id');
    }

    #============ ========== ========== GET INFO =========== ========= ========
    public function getInfo($sampleId = '', $field = '')
    {
        if (empty($sampleId)) {
            return TfLandIconSample::get();
        } else {
            $result = TfLandIconSample::where('sample_id', $sampleId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #------------ TF-TRANSACTION-STATUS -------------
    # ge image on size and on transaction
    public function imageOnSizeAndTransaction($sizeId = '', $transactionStatusId = '', $owner = '')
    {
        if (empty($owner)) {
            return TfLandIconSample::where('size_id', $sizeId)->where('transactionStatus_id', $transactionStatusId)->pluck('image');
        } else {
            return TfLandIconSample::where('ownStatus', $owner)->where('size_id', $sizeId)->where('transactionStatus_id', $transactionStatusId)->pluck('image');
        }
    }

    # ------------ SAMPLE INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfLandIconSample::where('sample_id', $objectId)->pluck($column);
        }
    }

    public function sampleId()
    {
        return $this->sample_id;
    }

    public function name($sampleId = null)
    {
        return $this->pluck('name', $sampleId);
    }

    public function image($sampleId = null)
    {
        return $this->pluck('image', $sampleId);
    }

    public function ownStatus($sampleId = null)
    {
        return $this->pluck('ownStatus', $sampleId);
    }

    public function sizeId($sampleId = null)
    {
        return $this->pluck('size_id', $sampleId);
    }

    public function transactionStatusId($sampleId = null)
    {
        return $this->pluck('transactionStatus_id', $sampleId);
    }

    public function staffId($sampleId = null)
    {
        return $this->pluck('staff_id', $sampleId);
    }

    public function createdAt($sampleId = null)
    {
        return $this->pluck('created_at', $sampleId);
    }

    # last id
    public function lastId()
    {
        $result = TfLandIconSample::orderBy('sample_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->sample_id;
    }

    # total records
    public function totalRecords()
    {
        return TfLandIconSample::count();
    }

    #path image
    public function pathImage($image = null)
    {
        if (empty($image)) $image = $this->image;
        return (empty($image)) ? $image : asset("public/images/sample/land-icon/$image");
    }

    #get icon follow size and transaction
    public function imageOfSizeAndTransaction($sizeId, $transactionStatusId)
    {
        return TfLandIconSample::where('size_id', $sizeId)->where('transactionStatus_id', $transactionStatusId)->pluck('image');
    }
    #============ ========== ========== CHECK INFO =========== ========= ========
    # check owner
    public function checkOwner($sampleId)
    {
        $sample = TfLandIconSample::where('sample_id', $sampleId)->where('owner', 1)->count();
        return ($sample > 0) ? true : false;
    }

    # check exist icon of land status
    public function existSizeAndStatusAndOwner($sizeId = '', $transactionStatusId = '', $ownStatus = '')
    {
        $sample = TfLandIconSample::where('size_id', $sizeId)->where('transactionStatus_id', $transactionStatusId)->where('owner', $ownStatus)->count();
        return ($sample > 0) ? true : false;
    }

    public function existEditSizeAndStatusAndOwner($sampleId = '', $sizeId = '', $transactionStatusId = '', $ownStatus = '')
    {
        $sample = TfLandIconSample::where('sample_id', '<>', $sampleId)->where('size_id', $sizeId)->where('transactionStatus_id', $transactionStatusId)->where('owner', $ownStatus)->count();
        return ($sample > 0) ? true : false;
    }

}
