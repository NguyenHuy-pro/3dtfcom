<?php namespace App\Models\Manage\Content\System\PaymentType;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfPaymentType extends Model
{

    protected $table = 'tf_payment_types';
    protected $fillable = ['type_id', 'name', 'description', 'status', 'created_at'];
    protected $primaryKey = 'type_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($name, $description)
    {
        $hFunction = new \Hfunction();
        $modelType = new TfPaymentType();
        $modelType->name = $name;
        $modelType->description = $description;
        $modelType->status = 1;
        $modelType->created_at = $hFunction->createdAt();
        if ($modelType->save()) {
            $this->lastId = $modelType->type_id;
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

    #----------- update ----------
    #update info
    public function updateInfo($typeId, $name, $description)
    {
        return TfPaymentType::where('type_id', $typeId)->update(['name' => $name, 'description' => $description]);
    }

    public function updateStatus($typeId, $status)
    {
        return TfPaymentType::where('type_id', $typeId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($typeId = null)
    {
        if (empty($typeId)) $typeId = $this->typeId();
        return TfPaymentType::where('type_id', $typeId)->delete();
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-PAYMENT ------------
    public function payment()
    {
        return $this->hasMany('App\Models\Manage\Content\System\Payment\TfPayment', 'type_id', 'type_id');
    }

    #----------- TF-WALLET ------------
    public function wallet()
    {
        return $this->hasMany('App\Models\Manage\Content\System\Wallet\TfWallet', 'type_id', 'type_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    #create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $paymentType = TfPaymentType::select('type_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($paymentType, $selected);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfPaymentType::where('type_id', $objectId)->pluck($column);
        }
    }

    public function typeId()
    {
        return $this->type_id;
    }


    public function name($typeId = null)
    {
        return $this->pluck('name', $typeId);
    }

    public function status($typeId = null)
    {
        return $this->pluck('status', $typeId);
    }

    public function description($typeId = null)
    {
        return $this->pluck('description', $typeId);

    }

    public function createdAt($typeId = null)
    {
        return $this->pluck('created_at', $typeId);

    }

    public function transferTypeId()
    {
        return 2;
    }

    public function messageTypeId()
    {
        return 3;
    }

    public function directTypeId()
    {
        return 4;
    }

    public function electronicWalletTypeId()
    {
        return 5;
    }

    # check exist of name
    public function existName($name)
    {
        $paymentType = DB::table('tf_payment_types')->where('name', $name)->count();
        return ($paymentType > 0) ? true : false;
    }

    public function existEditName($typeId, $name)
    {
        $result = TfPaymentType::where('name', $name)->where('type_id', '<>', $typeId)->count();
        return ($result > 0) ? true : false;
    }

    #total records
    public function totalRecords()
    {
        return TfPaymentType::count();
    }

}
