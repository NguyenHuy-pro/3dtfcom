<?php namespace App\Models\Manage\Content\Users\Contact;

use Illuminate\Database\Eloquent\Model;


class TfUserContact extends Model
{

    protected $table = 'tf_user_contacts';
    protected $fillable = ['contact_id', 'address', 'phone', 'email', 'action', 'created_at', 'user_id', 'province_id'];
    protected $primaryKey = 'contact_id';
    //public $incrementing = false;
    public $timestamps = false;
    public $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #----------- Insert -----------
    public function insert($address, $phone, $email, $userId, $provinceId = null)
    {
        $hFunction = new \Hfunction();
        $modelContact = new TfUserContact();
        $modelContact->address = $address;
        $modelContact->phone = $phone;
        $modelContact->email = $email;
        $modelContact->action = 1;
        $modelContact->user_id = $userId;
        $modelContact->province_id = $provinceId;
        $modelContact->created_at = $hFunction->createdAt();
        if ($modelContact->save()) {
            $this->lastId = $modelContact->contact_id;
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

    #----------- Update -----------
    #update  (update is replaced by new insert --> save old info)
    public function updateInfoOfUser($userId, $address, $phone, $email, $provinceId)
    {
        #delete old contact of user
        $this->deleteOfUser($userId);
        if (!empty($address) or !empty($phone) or !empty($email) or !empty($provinceId)) {
            # insert new contact
            $this->insert($address, $phone, $email, $userId, $provinceId);
        }
    }

    #delete
    public function actionDelete($contactId=null)
    {
        return TfUserContact::where('contact_id', $contactId)->update(['action' => 0]);
    }

    public function deleteOfUser($userId)
    {
        return TfUserContact::where('user_id', $userId)->where('action', 1)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-USER --------------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }
    #--------- TF-PROVINCE -----------
    public function province()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Province\TfProvince', 'province_id', 'province_id');
    }


    #========== ========== ========== Get info ========== ========== ==========
    public function getInfo($contactId = '', $field = '')
    {
        if (empty($contactId)) {
            return TfUserContact::where('action', 1)->get();
        } else {
            $result = TfUserContact::where('contact_id', $contactId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #---------- User ---------
    #info of user
    public function infoOfUser($userId)
    {
        return TfUserContact::where('user_id', $userId)->where('action', 1)->first();
    }

    #--------- INFO ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfUserContact::where('contact_id', $objectId)->pluck($column);
        }
    }

    public function contactId()
    {
        return $this->contact_id;
    }

    public function address($contactId=null)
    {
        return $this->pluck('address', $contactId);
    }

    public function phone($contactId=null)
    {
        return $this->pluck('phone', $contactId);
    }

    public function email($contactId=null)
    {
        return $this->pluck('email', $contactId);
    }

    public function userId($contactId=null)
    {
        return $this->pluck('user_id', $contactId);
    }

    public function provinceId($contactId=null)
    {
        return $this->pluck('province_id', $contactId);
    }

    public function createdAt($contactId=null)
    {
        return $this->pluck('created_at', $contactId);
    }

    # total records
    public function totalRecords()
    {
        return TfUserVisit::count();
    }

}
