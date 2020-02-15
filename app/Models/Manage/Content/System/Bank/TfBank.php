<?php namespace App\Models\Manage\Content\System\Bank;

use Illuminate\Database\Eloquent\Model;
use App\Models\Manage\Content\System\Staff\TfStaff;
use DB;

class TfBank extends Model
{

    protected $table = 'tf_banks';
    protected $fillable = ['bank_id', 'name', 'image', 'status', 'created_at'];
    protected $primaryKey = 'bank_id';
    public $timestamps = false;

    private $lastId;

    //========== ========== ========== INSERT && UPDATE ========== ========== ==========
    //---------- Insert ----------
    public function insert($name, $image)
    {
        $hFunction = new \Hfunction();
        $modelBank = new TfBank();
        $modelBank->name = $name;
        $modelBank->image = $image;
        $modelBank->status = 1;
        $modelBank->created_at = $hFunction->createdAt();
        if ($modelBank->save()) {
            $this->lastId = $modelBank->bank_id;
            return true;
        } else {
            return false;
        }
    }

    // get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    //----------- update ----------
    //update info
    public function updateInfo($bankId, $name, $image)
    {
        return TfBank::where('bank_id', $bankId)->update(['name' => $name, 'image' => $image]);
    }


    public function updateStatus($bankId, $status)
    {
        return TfBank::where('bank_id', $bankId)->update(['status' => $status]);
    }

    //delete
    public function actionDelete($bankId)
    {
        $oldImage = $this->image($bankId);
        if (TfBank::where('bank_id', $bankId)->delete()) {
            $oldSrc = "public/images/system/bank/logo/$oldImage";
            if (File::exists($oldSrc)) {
                File::delete($oldSrc);
            }
            return true;
        } else {
            return false;
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    ##----------- TF-PAYMENT ------------
    public function payment()
    {
        return $this->hasMany('App\Models\Manage\Content\System\Payment\TfPayment', 'bank_id', 'bank_id');
    }

    ##----------- TF-SELLER-PAYMENT-INFO ------------
    public function sellerPaymentInfo()
    {
        return $this->hasMany('App\Models\Manage\Content\Seller\Payment\TfSellerPaymentInfo', 'bank_id', 'bank_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    // create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $bank = TfBank::select('bank_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($bank, $selected);
    }

    // execute get
    public function getInfo($bankId = '', $field = '')
    {
        if (empty($bankId)) {
            return TfBank::where('status', 1)->get();
        } else {
            $result = TfBank::where('bank_id', $bankId)->first();
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
            return TfBank::where('bank_id', $objectId)->pluck($column);
        }
    }

    public function bankId()
    {
        return $this->bank_id;
    }

    public function name($bankId = null)
    {
        return $this->pluck('name', $bankId);
    }

    public function image($bankId = null)
    {
        return $this->pluck('image', $bankId);
    }

    public function status($bankId = null)
    {
        return $this->pluck('status', $bankId);
    }

    public function createdAt($bankId = null)
    {
        return $this->pluck('created_at', $bankId);
    }

    public function pathImage($image=null)
    {
        if(empty($image)) $image = $this->image;
        return asset("public/images/system/bank/logo/$image");
    }

    // total
    public function totalRecords()
    {
        return TfBank::count();
    }

    //============ ========== check info =========== ==========

    // check exist of name
    public function existName($name)
    {
        $bank = DB::table('tf_banks')->where('name', $name)->count();
        return ($bank > 0) ? true : false;
    }

    // check exist of name (when edit info)
    public function existEditName($bankId, $name)
    {
        $result = TfBank::where('bank_id', '<>', $bankId)->where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

}
