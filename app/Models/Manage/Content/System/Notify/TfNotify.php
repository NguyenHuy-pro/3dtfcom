<?php namespace App\Models\Manage\Content\System\Notify;

use Illuminate\Database\Eloquent\Model;

class TfNotify extends Model
{

    protected $table = 'tf_notifies';
    protected $fillable = ['notify_id', 'name', 'content', 'action', 'created_at', 'staff_id'];
    protected $primaryKey = 'notify_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($name, $content, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelNotify = new TfNotify();
        $modelNotify->name = $name;
        $modelNotify->content = $content;
        $modelNotify->staff_id = $staffId;
        $modelNotify->created_at = $hFunction->createdAt();
        if ($modelNotify->save()) {
            $this->lastId = $modelNotify->notify_id;
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
    public function updateInfo($name, $content, $notifyId = null)
    {
        if (empty($notifyId)) $notifyId = $this->aboutId();
        return TfNotify::where('notify_id', $notifyId)->update(['name' => $name, 'content' => $content]);
    }

    # delete
    public function actionDelete($notifyId = null)
    {
        if (empty($notifyId)) $notifyId = $this->notifyId();
        return TfNotify::where('notify_id', $notifyId)->update(['action' => 0]);
    }

    public function drop($notifyId = null)
    {
        if (empty($notifyId)) $notifyId = $this->notifyId();
        return TfNotify::where('notify_id', $notifyId)->delete();
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-STAFF ------------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    #info is using
    public function infoIsUsing($take = null, $dateTake = null)
    {
        if (!empty($take) && !empty($dateTake)) {
            return TfNotify::where(['action' => 1])->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
        } else{
            return TfNotify::where(['action' => 1])->orderBy('created_at', 'DESC')->get();
        }
    }

public
function getInfo($notifyId = '', $field = '')
{
    if (empty($notifyId)) {
        return TfNotify::where('action', 1)->get();
    } else {
        $result = TfNotify::where('notify_id', $notifyId)->first();
        if (empty($field)) {
            return $result;
        } else {
            return $result->$field;
        }
    }
}

public
function pluck($column, $objectId = null)
{
    if (empty($objectId)) {
        return $this->$column;
    } else {
        return TfNotify::where('notify_id', $objectId)->pluck($column);
    }
}

public
function notifyId()
{
    return $this->notify_id;
}

public
function name($notifyId = null)
{
    return $this->pluck('name', $notifyId);
}

public
function content($notifyId = null)
{
    return $this->pluck('content', $notifyId);
}

public
function staffId($notifyId = null)
{
    return $this->pluck('staff_id', $notifyId);
}

public
function createdAt($notifyId = null)
{
    return $this->pluck('created_at', $notifyId);
}

# total
public
function totalRecords()
{
    return TfNotify::where('action', 1)->count();
}

}
