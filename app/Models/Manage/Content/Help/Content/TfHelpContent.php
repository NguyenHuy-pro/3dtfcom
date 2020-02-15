<?php namespace App\Models\Manage\Content\Help\Content;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfHelpContent extends Model
{

    protected $table = 'tf_help_contents';
    protected $fillable = ['content_id', 'name', 'content', 'status', 'action', 'created_at', 'helpDetail_id', 'staff_id'];
    protected $primaryKey = 'content_id';
    public $timestamps = false;

    private $lastId;

    # ========== ========= ========= INSERT && UPDATE ========= ========= =========
    #---------- insert -----------
    public function insert($name, $content, $helpDetailId, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelHelpContent = new TfHelpContent();
        $modelHelpContent->name = $name;
        $modelHelpContent->content = $content;
        $modelHelpContent->helpDetail_id = $helpDetailId;
        $modelHelpContent->staff_id = $staffId;
        $modelHelpContent->status = 1;
        $modelHelpContent->action = 1;
        $modelHelpContent->created_at = $hFunction->createdAt();
        if ($modelHelpContent->save()) {
            $this->lastId = $modelHelpContent->content_id;
            return true;
        } else {
            return false;
        }
    }

    #get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- update ------------
    public function updateInfo($contentId, $name, $content, $helpDetailId)
    {
        $modelHelpContent = TfHelpContent::find($contentId);
        $modelHelpContent->name = $name;
        $modelHelpContent->content = $content;
        $modelHelpContent->helpDetail_id = $helpDetailId;
        return $modelHelpContent->save();
    }

    # update status
    public function updateStatus($contentId = '', $status = '')
    {
        return TfHelpContent::where('content_id', $contentId)->update(['status' => $status]);
    }

    # delete
    public function getDelete($detailId = '')
    { # don't use delete
        return TfHelpContent::where('content_id', $detailId)->update(['action' => 0]);
    }

    # ========== ========== ========= RELATION ========== ========== ==========
    #----------- help detail -----------
    public function helpDetail()
    {
        return $this->belongsTo('App\Models\Manage\Content\Help\Detail\TfHelpDetail', 'detail_id', 'helpDetail_id');
    }

    #----------- TF-STAFF -----------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    # =========== ========== ========== GET INFO ========== ========== ==========
    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfHelpContent::select('content_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    #----------- TF-HELP-DETAIL -----------
    #info of help detail
    public function infoOfHelpDetail($helpDetailId)
    {
        return TfHelpContent::where('helpDetail_id', $helpDetailId)->where('action', 1)->orderBy('name', 'ASC')->get();
    }

    #----------- content info -----------
    public function getInfo($contentId = '', $field = '')
    {
        if (empty($contentId)) {
            return TfHelpContent::where('action', 1);
        } else {
            $result = TfHelpContent::where('content_id', $contentId)->first();
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
            return TfHelpContent::where('content_id', $objectId)->pluck($column);
        }
    }

    public function contentId()
    {
        return $this->content_id;
    }

    public function name($contentId = null)
    {
        return $this->pluck('name', $contentId);
    }

    public function content($contentId = null)
    {
        return $this->pluck('content', $contentId);
    }

    public function status($contentId = null)
    {
        return $this->pluck('status', $contentId);
    }

    public function createdAt($contentId = null)
    {
        return $this->pluck('created_at', $contentId);
    }

    public function helpDetailId($contentId = null)
    {
        return $this->pluck('helpDetail_id', $contentId);
    }

    public function staffId($contentId = null)
    {
        return $this->pluck('staff_id', $contentId);
    }

    # check exist of name
    public function existName($name)
    {
        $result = TfHelpContent::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditName($name, $contentId)
    {
        $result = TfHelpContent::where('name', $name)->where('content_id', '<>', $contentId)->count();
        return ($result > 0) ? true : false;
    }

    # total records
    public function totalRecords()
    {
        return TfHelpContent::where('action', 1)->count();
    }

}
