<?php namespace App\Models\Manage\Content\System\Wallet;

use Illuminate\Database\Eloquent\Model;

class TfWallet extends Model
{

    protected $table = 'tf_wallets';
    protected $fillable = ['wallet_id', 'name', 'image', 'description', 'status', 'created_at', 'type_id'];
    protected $primaryKey = 'wallet_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($name, $image, $typeId, $status = 1, $description = null)
    {
        $hFunction = new \Hfunction();
        $modelWallet = new TfWallet();
        $modelWallet->name = $name;
        $modelWallet->image = $image;
        $modelWallet->description = $description;
        $modelWallet->status = $status;
        $modelWallet->type_id = $typeId;
        $modelWallet->created_at = $hFunction->carbonNow();
        if ($modelWallet->save()) {
            $this->lastId = $modelWallet->wallet_id;
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
    public function updateInfo($walletId, $name, $image, $description, $typeId)
    {
        return TfWallet::where('wallet_id', $walletId)->update(['name' => $name, 'image' => $image, 'description' => $description, 'type_id' => $typeId]);
    }


    public function updateStatus($walletId, $status)
    {
        return TfWallet::where('wallet_id', $walletId)->update(['status' => $status]);
    }

    #delete
    public function actionDelete($walletId)
    {
        $oldImage = $this->image($walletId);
        if (TfWallet::where('wallet_id', $walletId)->delete()) {
            $oldSrc = "public/images/system/wallet/image/$oldImage";
            if (File::exists($oldSrc)) {
                File::delete($oldSrc);
            }
            return true;
        } else {
            return false;
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-PAYMENT-TYPE ------------
    public function paymentType()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\PaymentType\TfPaymentType', 'type_id', 'type_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfWallet::select('wallet as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    # execute get
    public function getInfo($walletId = '', $field = '')
    {
        if (empty($walletId)) {
            return TfWallet::where('status', 1)->get();
        } else {
            $result = TfWallet::where('wallet_id', $walletId)->first();
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
            return TfWallet::where('wallet_id', $objectId)->pluck($column);
        }
    }

    public function walletId()
    {
        return $this->wallet_id;
    }

    public function name($walletId = null)
    {
        return $this->pluck('name', $walletId);
    }

    public function image($walletId = null)
    {
        return $this->pluck('image', $walletId);
    }

    public function description($walletId = null)
    {
        return $this->pluck('description', $walletId);
    }

    public function status($walletId = null)
    {
        return $this->pluck('status', $walletId);
    }

    public function createdAt($walletId = null)
    {
        return $this->pluck('created_at', $walletId);
    }

    public function pathImage($image = null)
    {
        if (empty($image)) $image = $this->image;
        return asset("public/images/system/wallet/image/$image");
    }

    # total
    public function totalRecords()
    {
        return TfWallet::count();
    }

    #============ ========== check info =========== ==========

    # check exist of name
    public function existName($name)
    {
        $result = DB::table('tf_wallets')->where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    # check exist of name (when edit info)
    public function existEditName($walletId, $name)
    {
        $result = TfWallet::where('wallet_id', '<>', $walletId)->where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

}
