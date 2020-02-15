<?php namespace App\Models\Manage\Content\Help\Detail;

use App\Models\Manage\Content\Help\Action\TfHelpAction;
use App\Models\Manage\Content\Help\Content\TfHelpContent;
use Illuminate\Database\Eloquent\Model;
use DB;

class TfHelpDetail extends Model
{

    protected $table = 'tf_help_details';
    protected $fillable = ['detail_id', 'name', 'description', 'action', 'created_at', 'helpObject_id', 'helpAction_id'];
    protected $primaryKey = 'detail_id';
    public $timestamps = false;

    private $lastId;

    # ========== ========= ========= INSERT && UPDATE ========= ========= =========
    #---------- insert -----------
    public function insert($name, $description, $helpObjectId, $helpActionId)
    {
        $hFunction = new \Hfunction();
        $modelHelpDetail = new TfHelpDetail();
        $modelHelpDetail->name = $name;
        $modelHelpDetail->description = $description;
        $modelHelpDetail->helpObject_id = $helpObjectId;
        $modelHelpDetail->helpAction_id = $helpActionId;
        $modelHelpDetail->action = 1;
        $modelHelpDetail->created_at = $hFunction->createdAt();
        if ($modelHelpDetail->save()) {
            $this->lastId = $modelHelpDetail->detail_id;
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
    public function updateInfo($detailId, $name, $description, $helpObjectId, $helpActionId)
    {
        $modelHelpDetail = TfHelpDetail::find($detailId);
        $modelHelpDetail->name = $name;
        $modelHelpDetail->description = $description;
        $modelHelpDetail->helpObject_id = $helpObjectId;
        $modelHelpDetail->helpAction_id = $helpActionId;
        return $modelHelpDetail->save();
    }

    # delete
    public function getDelete($detailId=null)
    {
        if(empty($detailId)) $detailId = $this->detailId();
        return TfHelpDetail::where('detail_id', $detailId)->update(['action' => 0]);
    }

    # ========== ========= ========= RELATION ========= ========= =========
    #---------- TF-HELP-OBJECT ----------
    public function helpObject()
    {
        return $this->belongsTo('App\Models\Manage\Content\Help\Object\TfHelpObject', 'helpObject_id', 'object_id');
    }

    #---------- TF-HELP-ACTION ----------
    public function helpAction()
    {
        return $this->belongsTo('App\Models\Manage\Content\Help\Action\TfHelpAction', 'action_id', 'helpAction_id');
    }

    #---------- TF-HELP-CONTENT ----------
    public function helpContent()
    {
        return $this->hasMany('App\Models\Manage\Content\Help\Content\TfHelpContent', 'helpDetail_id', 'detail_id');
    }

    # ========== ========= =========  GET INFO ========= ========= =========
    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfHelpDetail::select('detail_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    # get detail of object and action
    public function infoOfObjectAndAction($helpObjectId, $helpActionId)
    {
        return TfHelpDetail::where('helpObject_id', $helpObjectId)->where('helpAction_id', $helpActionId)->where('action', 1)->get();
    }

    #---------- TF-HELP-OBJECT ----------
    #get info of help object
    public function infoOfHelpObject($helpObjectId)
    {
        return TfHelpDetail::where('helpObject_id', $helpObjectId)->where('action', 1)->get();
    }

    # action info of help object
    public function infoHelpActionOfHelpObject($helpObjectId)
    {
        $listId = $this->listActionIdOfHelpObject($helpObjectId);
        return TfHelpAction::whereIn('action_id', $listId)->orderBy('name', 'ASC')->get();
    }

    #---------- TF-HELP-ACTION ----------
    #list action id of help object
    public function listActionIdOfHelpObject($helpObjectId)
    {
        return TfHelpDetail::where('helpObject_id', $helpObjectId)->where('action', 1)->lists('helpAction_id');
    }

    #---------- TF-HELP-CONTENT ----------
    public function helpContentInfo($detailId)
    {
        $modelHelpContent = new TfHelpContent();
        return $modelHelpContent->infoOfHelpDetail($detailId);
    }

    public function getInfo($detailId = '', $field = '')
    {
        if (empty($detailId)) {
            return TfHelpDetail::where('action', 1)->get();
        } else {
            $result = TfHelpDetail::where('detail_id', $detailId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # get info default
    public function getInfoDefault()
    {
        return TfHelpDetail::where('defaultStatus', 1)->where('action', 1)->first();
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfHelpDetail::where('detail_id', $objectId)->pluck($column);
        }
    }

    public function detailId()
    {
        return $this->detail_id;
    }

    public function name($detailId = null)
    {
        return $this->pluck('name', $detailId);
    }

    public function description($detailId = null)
    {
        return $this->pluck('description', $detailId);
    }

    public function objectId($detailId = null)
    {
        return $this->pluck('helpObject_id', $detailId);
    }

    public function createdAt($detailId = null)
    {
        return $this->pluck('created_at', $detailId);
    }


    public function actionId($detailId = null)
    {
        return $this->pluck('helpAction_id', $detailId);
    }


    # total records
    public function totalRecords()
    {
        return TfHelpDetail::where('action', 1)->count();
    }

    # ========= ======== ========  check info ======== ======== ========
    # check exist of name
    public function existName($name, $helpObjectId, $helpActionId)
    { # add new
        $result = TfHelpDetail::where('name', $name)->where('helpObject_id', $helpObjectId)->where('helpAction_id', $helpActionId)->count();
        return ($result > 0) ? true : false;
    }

    # edit info
    public function existEditName($name, $helpObjectId, $helpActionId, $detailId)
    {
        $result = TfHelpDetail::where('name', $name)->where('helpObject_id', $helpObjectId)->where('helpAction_id', $helpActionId)->where('detail_id', '<>', $detailId)->count();
        return ($result > 0) ? true : false;
    }

}
