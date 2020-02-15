<?php namespace App\Models\Manage\Content\Help\Action;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfHelpAction extends Model
{

    protected $table = 'tf_help_actions';
    protected $fillable = ['action_id', 'name', 'alias', 'action', 'created_at'];
    protected $primaryKey = 'action_id';
    public $timestamps = false;

    private $lastId;

    # ========== ========= ========= INSERT && UPDATE ========= ========= =========
    public function insert($name)
    {
        $hFunction = new \Hfunction();
        $modelAction = new TfHelpAction();
        $modelAction->name = $name;
        $modelAction->alias = $hFunction->alias($name, '-');
        $modelAction->action = 1;
        $modelAction->created_at = $hFunction->createdAt();
        if ($modelAction->save()) {
            $this->lastId = $modelAction->action_id;
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

    #--------- Update -----------
    public function updateInfo($actionId, $name)
    {
        $hFunction = new \Hfunction();
        $modelAction = TfHelpAction::find($actionId);
        $modelAction->name = $name;
        $modelAction->alias = $hFunction->alias($name, '-');
        return $modelAction->save();
    }

    # delete
    public function getDelete($actionId)
    {
        return TfHelpAction::where('action_id', $actionId)->update(['action' => 0]);
    }

    # ========== ========= ========= RELATION ========= ========= =========
    #---------- TF-HELP-DETAIL ----------
    public function helpDetail()
    {
        return $this->hasMany('App\Models\Manage\Content\Help\Detail\TfHelpDetail', 'helpAction_id', 'action_id');
    }

    #---------- TF-HELP-OBJECT ----------
    public function helpObject()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Help\Object\TfHelpObject', 'App\Models\Manage\Content\Help\Detail\TfHelpDetail', 'action_id', 'object_id');
    }

    # ========== ========= ========= GET INFO ========= ========= =========

    public function getInfo($actionId = '', $field = '')
    {
        if (empty($actionId)) {
            return TfHelpAction::where('action', 1)->get();
        } else {
            $result = TfHelpAction::where('action_id', $actionId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # get info by alias
    public function getInfoOfAlias($alias)
    {
        return TfHelpAction::where('alias', $alias)->first();
    }

    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfHelpAction::select('action_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfHelpAction::where('action_id', $objectId)->pluck($column);
        }
    }

    public function actionId()
    {
        return $this->action_id;
    }

    public function name($actionId = null)
    {
        return $this->pluck('name', $actionId);
    }

    public function alias($actionId = null)
    {
        return $this->pluck('alias', $actionId);
    }

    public function createdAt($actionId = null)
    {
        return $this->pluck('created_at', $actionId);
    }

    # total records
    public function totalRecords()
    {
        return TfHelpAction::where('action', 1)->count();
    }

    # ========= Check info ========
    # check exist of name
    public function existName($name)
    {
        $result = TfHelpAction::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditName($name, $actionId)
    {
        $result = TfHelpAction::where('name', $name)->where('action_id', '<>', $actionId)->count();
        return ($result > 0) ? true : false;
    }

}
