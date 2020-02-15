<?php namespace App\Models\Manage\Content\Map\Project\PropertyCancel;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfProjectPropertyCancel extends Model
{

    protected $table = 'tf_project_property_cancels';
    protected $fillable = ['cancel_id', 'content', 'reason', 'newInfo', 'created_at', 'property_id'];
    protected $primaryKey = 'cancel_id';
    public $timestamps = false;

    private $lastId;
    #=========== =========== =========== INSERT && UPDATE =========== ========== ===========
    #------------ Insert -----------
    public function insert($content, $reason, $propertyId)
    {
        $hFunction = new \Hfunction();
        $modelPropertyCancel = new TfProjectPropertyCancel();
        $modelPropertyCancel->content = $content;
        $modelPropertyCancel->reason = $reason;
        $modelPropertyCancel->newInfo = 1; # default
        $modelPropertyCancel->property_id = $propertyId;
        $modelPropertyCancel->created_at = $hFunction->createdAt();
        if ($modelPropertyCancel->save()) {
            $this->listId = $modelPropertyCancel->cancel_id;
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

    #========== ========== ========= RELATION =========== =========== =========
    # ---------- TF-PROJECT-PROPERTY ----------
    public function projectProperty()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\Property\TfProjectProperty', 'property_id', 'property_id');
    }

    #========== ========== ========= GET INFO =========== =========== =========
    public function cancelId()
    {
        return $this->cancel_id;
    }

    public function reason($cancelId = null)
    {
        if (empty($cancelId)) {
            return $this->reason;
        } else {
            return TfProjectPropertyCancel::where('cancel_id', $cancelId)->pluck('reason');
        }
    }

    # get notify content
    public function content($cancelId = null)
    {
        if (empty($cancelId)) {
            return $this->content;
        } else {
            return TfProjectPropertyCancel::where('cancel_id', $cancelId)->pluck('content');
        }
    }

    public function createdAt($cancelId = null)
    {
        if (empty($cancelId)) {
            return $this->created_at;
        } else {
            return TfProjectPropertyCancel::where('cancel_id', $cancelId)->pluck('created_at');
        }
    }

}
