<?php namespace App\Models\Manage\Content\System\Advisory;

use Illuminate\Database\Eloquent\Model;

class TfAdvisory extends Model
{

    protected $table = 'tf_advisories';
    protected $fillable = ['advisory_id', 'content', 'name', 'phone', 'email', 'confirm', 'newInfo', 'action', 'created_at', 'user_id'];
    protected $primaryKey = 'advisory_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #----------- Insert -----------
    public function insert($content, $name, $phone, $email, $userId)
    {
        $hFunction = new \Hfunction();
        $modelAdvisory = new TfAdvisory();
        $modelAdvisory->content = $content;
        $modelAdvisory->name = $name;
        $modelAdvisory->phone = $phone;
        $modelAdvisory->email = $email;
        $modelAdvisory->confirm = 0;
        $modelAdvisory->newInfo = 1;
        $modelAdvisory->action = 1;
        $modelAdvisory->user_id = $userId;
        $modelAdvisory->created_at = $hFunction->createdAt();
        if ($modelAdvisory->save()) {
            $this->lastId = $modelAdvisory->advisory_id;
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
    public function actionDelete($advisoryId)
    {
        return TfAdvisory::where('advisory_id', $advisoryId)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-USER ------------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #---------- TF-ADVISORY-REPLY -----------
    public function advisoryReply()
    {
        return $this->hasOne('App\Models\Manage\Content\System\AdvisoryReply\TfAdvisoryReply', 'advisory_id', 'advisory_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($advisoryId = '', $field = '')
    {
        if (empty($advisoryId)) {
            return TfAdvisory::where('action', 1)->get();
        } else {
            $result = TfAdvisory::where('advisory_id', $advisoryId)->first();
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
            return TfAdvisory::where('advisory_id', $objectId)->pluck($column);
        }
    }

    public function advisoryId()
    {
        return $this->advisory_id;
    }

    public function content($advisoryId = null)
    {
        return $this->pluck('content', $advisoryId);
    }

    public function name($advisoryId = null)
    {
        return $this->pluck('name', $advisoryId);
    }

    public function phone($advisoryId = null)
    {
        return $this->pluck('phone', $advisoryId);
    }

    public function email($advisoryId = null)
    {
        return $this->pluck('email', $advisoryId);
    }

    public function confirm($advisoryId = null)
    {
        return $this->pluck('confirm', $advisoryId);
    }

    public function newInfo($advisoryId = null)
    {
        return $this->pluck('newInfo', $advisoryId);
    }

    public function createdAt($advisoryId = null)
    {
        return $this->pluck('created_at', $advisoryId);
    }

    public function userId($advisoryId = null)
    {
        return $this->pluck('usert_id', $advisoryId);
    }

    #total advisory
    public function totalRecords()
    {
        return TfAdvisory::where('action', 1)->count();
    }

}
