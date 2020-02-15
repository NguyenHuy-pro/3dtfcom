<?php namespace App\Models\Manage\Content\System\LinkRun;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class TfLinkRun extends Model
{
    protected $table = 'tf_link_runs';
    protected $fillable = ['link_id', 'name', 'description', 'link', 'status', 'action', 'created_at', 'staff_id'];
    protected $primaryKey = 'link_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($name, $description, $link, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelLink = new TfLinkRun();
        $modelLink->name = $name;
        $modelLink->description = $description;
        $modelLink->link = $link;
        $modelLink->status = 1;
        $modelLink->action = 1;
        $modelLink->staff_id = $staffId;
        $modelLink->created_at = $hFunction->createdAt();
        if ($modelLink->save()) {
            $this->lastId = $modelLink->link_id;
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
    public function updateInfo($linkId, $name, $description, $link)
    {
        return TfLinkRun::where('link_id', $linkId)->update([
            'name' => $name,
            'description' => $description,
            'link' => $link
        ]);
    }

    #update status
    public function updateStatus($linkId, $status)
    {
        return TfLinkRun::where('link_id', $linkId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($link)
    {
        return TfLinkRun::where('link_id', $link)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-STAFF ------------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($linkId = '', $field = '')
    {
        if (empty($linkId)) {
            return TfLinkRun::where('action', 1)->get();
        } else {
            $result = TfLinkRun::find($linkId);
            if (empty($field)) {
                return (!empty($result)) ? $result : null;
            } else {
                return (!empty($result)) ? $result->$field : null;
            }
        }
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfLinkRun::where('link_id', $objectId)->pluck($column);
        }
    }

    public function linkId()
    {
        return $this->link_id;
    }


    public function name($linkId = null)
    {
        return $this->pluck('name', $linkId);
    }

    public function description($linkId = null)
    {
        return $this->pluck('description', $linkId);
    }

    public function link($linkId = null)
    {
        return $this->pluck('link', $linkId);
    }

    public function status($linkId = null)
    {
        return $this->pluck('status', $linkId);
    }

    public function createdAt($linkId = null)
    {
        return $this->pluck('created_at', $linkId);
    }

    public function staffId($linkId = null)
    {
        return $this->pluck('staff_id', $linkId);
    }

    # check exist of name
    public function existName($name)
    {
        $linkRun = DB::table('tf_link_runs')->where('name', $name)->count();
        return ($linkRun > 0) ? true : false;
    }

    public function existEditName($name = '', $linkId = '')
    {
        $linkRun = DB::table('tf_link_runs')->where('name', $name)->where('link_id', '<>', $linkId)->count();
        return ($linkRun > 0) ? true : false;
    }

    # total records
    public function totalRecords()
    {
        return TfLinkRun::where('action', 1)->count();
    }
}
