<?php namespace App\Models\Manage\Content\System\AdvisoryReply;

use Illuminate\Database\Eloquent\Model;

class TfAdvisoryReply extends Model {

    protected $table = 'tf_advisory_replies';
    protected $fillable = ['reply_id', 'content', 'newInfo', 'action', 'created_at', 'advisory_id', 'staff_id'];
    protected $primaryKey = 'reply_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #------------ Insert ------------
    public function insert($content, $advisoryId, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelAdvisoryReply = new TfAdvisoryReply();
        $modelAdvisoryReply->content = $content;
        $modelAdvisoryReply->newInfo = 1;
        $modelAdvisoryReply->action = 1;
        $modelAdvisoryReply->advisory_id = $advisoryId;
        $modelAdvisoryReply->staff_id = $staffId;
        $modelAdvisoryReply->created_at = $hFunction->createdAt();
        if($modelAdvisoryReply->save()){
            $this->lastId = $modelAdvisoryReply->reply_id;
            return true;
        }else{
            return false;
        }

    }

    #get new id
    public function insertGetId(){
        return $this->lastId;
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-STAFF ------------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #---------- TF-ADVISORY -----------
    public function advisory()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Advisory\TfAdvisory', 'advisory_id', 'advisory_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    # get info
    public function getInfo($replyId = '', $field = '')
    {
        if (empty($replyId)) {
            return TfAdvisoryReply::where('action', 1)->get();
        } else {
            $result = TfAdvisoryReply::where('reply_id', $replyId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

}
