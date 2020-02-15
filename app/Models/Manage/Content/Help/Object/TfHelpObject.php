<?php namespace App\Models\Manage\Content\Help\Object;

use App\Models\Manage\Content\Help\Detail\TfHelpDetail;
use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class TfHelpObject extends Model
{

    protected $table = 'tf_help_objects';
    protected $fillable = ['object_id', 'name', 'alias', 'displayRank', 'action', 'created_at'];
    protected $primaryKey = 'object_id';
    public $timestamps = false;

    private $lastId;

    # ========== ========= ========= INSERT && UPDATE ========= ========= =========
    #---------- insert -----------
    public function insert($name, $displayRank)
    {
        $hFunction = new \Hfunction();
        $modelObject = new TfHelpObject();
        $modelObject->name = $name;
        $modelObject->alias = $hFunction->alias($name, '-');
        $modelObject->displayRank = $displayRank;
        $modelObject->action = 1;
        $modelObject->created_at = $hFunction->createdAt();
        if ($modelObject->save()) {
            $this->lastId = $modelObject->object_id;
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
    public function updateInfo($objectId, $name)
    {
        $hFunction = new \Hfunction();
        $modelObject = TfHelpObject::find($objectId);
        $modelObject->name = $name;
        $modelObject->alias = $hFunction->alias($name, '-');
        return $modelObject->save();
    }

    # delete
    public function actionDelete($objectId = null)
    {
        if(empty($objectId)) $objectId = $this->objectId();
        return TfHelpObject::where('object_id', $objectId)->update(['action' => 0]);
    }

    # ========== ========= ========= RELATION ========= ========= =========
    #---------- TF-HELP-DETAIL ----------
    public function helpDetail()
    {
        return $this->hasMany('App\Models\Manage\Content\Help\Detail\TfHelpDetail', 'helpObject_id', 'object_id');
    }

    #---------- TF-HELP-ACTION ----------
    public function helpAction()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Help\Action\TfHelpAction', 'App\Models\Manage\Content\Help\TfHelpDetail', 'object_id', 'action_id');
    }

    # ========== ========= ========= GET INFO ========= ========= =========
    #help action info
    public function helpActionInfo($objectId)
    {
        $modelHelpDetail = new TfHelpDetail();
        return $modelHelpDetail->infoHelpActionOfHelpObject($objectId);
    }

    #get detail info
    public function helpDetailInfo($objectId)
    {
        $modelHelpDetail = new TfHelpDetail();
        return $modelHelpDetail->infoOfHelpObject($objectId);
    }

    public function getInfo($objectId = null, $field = null)
    {
        if (empty($objectId)) {
            return TfHelpObject::where('action', 1)->orderBy('displayRank', 'ASC')->get();
        } else {
            $result = TfHelpObject::where('object_id', $objectId)->first();
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
        return TfHelpObject::where('alias', $alias)->first();
    }

    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfHelpObject::select('object_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }


    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfHelpObject::where('object_id', $objectId)->pluck($column);
        }
    }

    public function objectId()
    {
        return $this->object_id;
    }

    public function name($objectId = null)
    {
        return $this->pluck('name', $objectId);
    }

    public function alias($objectId = null)
    {
        return $this->pluck('alias', $objectId);
    }

    public function displayRank($objectId = null)
    {
        return $this->pluck('displayRank', $objectId);
    }

    public function createdAt($objectId = null)
    {
        return $this->pluck('created_at', $objectId);
    }



    # check exist of name
    public function existName($name)
    { # add new
        $result = TfHelpObject::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    # edit info
    public function existEditName($name, $objectId)
    {
        $result = TfHelpObject::where('name', $name)->where('object_id', '<>', $objectId)->count();
        return ($result > 0) ? true : false;
    }

    # get max rank
    public function maxRank()
    {
        return TfHelpObject::max('displayRank');
    }

    # total records
    public function totalRecords()
    {
        return TfHelpObject::where('action', 1)->count();
    }

}
