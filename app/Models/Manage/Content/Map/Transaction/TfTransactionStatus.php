<?php namespace App\Models\Manage\Content\Map\Transaction;

use Illuminate\Database\Eloquent\Model;

use DB;

class TfTransactionStatus extends Model
{

    protected $table = 'tf_transaction_statuses';
    protected $fillable = ['status_id', 'name', 'status', 'created_at'];
    protected $primaryKey = 'status_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== =========
    public function insert($name)
    {
        $hFunction = new \Hfunction();
        $modelTransactionStatus = new TfTransactionStatus();
        $modelTransactionStatus->name = $name;
        $modelTransactionStatus->status = 1;
        $modelTransactionStatus->created_at = $hFunction->createdAt();
        if ($modelTransactionStatus->save()) {
            $this->lastId = $modelTransactionStatus->status_id;
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

    #----------- update ------------
    public function updateInfo($statusId, $name)
    {
        $modelTransaction = TfTransactionStatus::find($statusId);
        $modelTransaction->name = $name;
        return $modelTransaction->save();
    }

    public function updateStatus($statusId, $status)
    {
        return TfTransactionStatus::where('status_id', $statusId)->update(['status' => $status]);
    }

    #========== ========== ========== RELATION ========== ========== =========
    # ---------- TF-PROJECT-TRANSACTION ----------
    public function projectTransaction()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Transaction\TfProjectTransaction', 'transactionStatus_id', 'status_id');
    }

    # ---------- TF-BANNER-TRANSACTION ----------
    public function bannerTransaction()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\Transaction\TfBannerTransaction', 'transactionStatus_id', 'status_id');
    }

    # ---------- TF-BANNER-LICENSE ----------
    public function bannerLicense()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\License\TfBannerLicense', 'transactionStatus_id', 'status_id');
    }

    # ---------- TF-LAND-TRANSACTION ----------
    public function landTransaction()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\Transaction\TfLandTransaction', 'transactionStatus_id', 'status_id');
    }

    # ---------- TF-LAND-LICENSE ----------
    public function landLicense()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\License\TfLandLicense', 'transactionStatus_id', 'status_id');
    }

    #----------- TF-LAND-ICON-SAMPLE -----------
    public function landIconSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\LandIcon\TfLandIconSample', 'transactionStatus_id', 'status_id');
    }

    #========== ========== ========== GET INFO ========== ========== =========
    #create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfTransactionStatus::select('status_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    #check exist of name (add new)
    public function existName($name)
    {
        $result = TfTransactionStatus::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    #check exist of name (edit)
    public function existEditName($name, $statusId)
    {
        $result = TfTransactionStatus::where('name', $name)->where('status_id', '<>', $statusId)->count();
        return ($result > 0) ? true : false;
    }

    public function findInfo($statusId)
    {
        return TfTransactionStatus::find($statusId);
    }

    public function getInfo($statusId = null, $field = null)
    {
        if (empty($statusId)) {
            return TfTransactionStatus::get();
        } else {
            $result = TfTransactionStatus::where('status_id', $statusId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function statusId()
    {
        return $this->status_id;
    }

    public function name($statusId = null)
    {
        if (empty($statusId)) {
            return $this->name;
        } else {
            return TfTransactionStatus::where('status_id', $statusId)->pluck('name');
        }
    }

    public function status($statusId = null)
    {
        if (empty($statusId)) {
            return $this->status;
        } else {
            return TfTransactionStatus::where('status_id', $statusId)->pluck('status');
        }
    }

    #get total records
    public function totalRecords()
    {
        return TfTransactionStatus::count();
    }


    public function saleStatusId()
    {
        return TfTransactionStatus::where(['status_id' => 1, 'status' => 1])->pluck('status_id');
    }

    public function freeStatusId()
    {
        return TfTransactionStatus::where(['status_id' => 2, 'status' => 1])->pluck('status_id');
    }

    public function normalStatusId()
    {
        return TfTransactionStatus::where(['status_id' => 3, 'status' => 1])->pluck('status_id');
    }

    public function reserveStatusId()
    {
        return TfTransactionStatus::where(['status_id' => 4, 'status' => 1])->pluck('status_id');
    }

    public function inviteStatusId()
    {
        return TfTransactionStatus::where(['status_id' => 5, 'status' => 1])->pluck('status_id');
    }


    #========== ========== ========== CHECK INFO ========== ========== =========
    #check sale
    public function checkSaleStatus($transactionStatusId = null)
    {
        if (empty($transactionStatusId)) $transactionStatusId = $this->statusId();
        return ($transactionStatusId == 1) ? true : false;
    }

    #check free
    public function checkFreeStatus($transactionStatusId = null)
    {
        if (empty($transactionStatusId)) $transactionStatusId = $this->statusId();
        return ($transactionStatusId == 2) ? true : false;
    }

    #check free
    public function checkNormalStatus($transactionStatusId = null)
    {
        if (empty($transactionStatusId)) $transactionStatusId = $this->statusId();
        return ($transactionStatusId == 3) ? true : false;
    }

    #check free
    public function checkReserveStatus($transactionStatusId = null)
    {
        if (empty($transactionStatusId)) $transactionStatusId = $this->statusId();
        return ($transactionStatusId == 4) ? true : false;
    }
}
