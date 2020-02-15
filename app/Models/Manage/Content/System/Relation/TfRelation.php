<?php namespace App\Models\Manage\Content\System\Relation;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfRelation extends Model
{

    protected $table = 'tf_relations';
    protected $fillable = ['relation_id', 'name', 'icon', 'status', 'created_at'];
    protected $primaryKey = 'relation_id';
    public $timestamps = false;

    #========== ========== ========= INSERT UPDATE ========== ========= =========
    #----------- Update ----------
    public function updateStatus($relationId, $status)
    {
        return TfRelation::where('relation_id', $relationId)->update(['status' => $status]);
    }

    #========== ========== ========= RELATION ========== ========= =========
    #----------- TF-BUILDING -----------
    public function building()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\TfBuilding', 'postRelation_id', 'relation_id');
    }

    #========== ========== ========= CHECK INFO ========== ========= =========
    public function publicRelation($relationId = null)
    {
        $relationId = (empty($relationId)) ? $this->relationId() : $relationId;
        return ($relationId == 1) ? true : false;
    }

    public function friendRelation($relationId = null)
    {
        $relationId = (empty($relationId)) ? $this->relationId() : $relationId;
        return ($relationId == 2) ? true : false;
    }

    public function privateRelation($relationId = null)
    {
        $relationId = (empty($relationId)) ? $this->relationId() : $relationId;
        return ($relationId == 3) ? true : false;
    }

    # check exist of name when add new
    public function existName($name)
    {
        $result = TfRelation::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    # check exist of name when update info
    public function existEditName($name, $relationId)
    {
        $result = TfRelation::where('name', $name)->where('relation_id', '<>', $relationId)->count();
        return ($result > 0) ? true : false;
    }

    #========== ========== ========= GET INFO ========== ========= =========
    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfRelation::select('relation_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    # get info
    public function getInfo($relationId = '', $field = '')
    {
        if (empty($relationId)) {
            return TfRelation::where('status', 1)->get();
        } else {
            $result = TfRelation::where('relation_id', $relationId)->first();
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
            return TfRelation::where('relation_id', $objectId)->pluck($column);
        }
    }

    public function relationId()
    {
        return $this->relation_id;
    }

    public function name($relationId = null)
    {
        return $this->pluck('name', $relationId);
    }

    public function icon($relationId = null)
    {
        return $this->pluck('icon', $relationId);
    }

    public function createdAt($relationId = null)
    {
        return $this->pluck('created_at', $relationId);
    }

    # total records
    public function totalRecords()
    {
        return TfRelation::count();
    }

    public function publicRelationId()
    {
        return TfRelation::where('name', 'public')->pluck('relation_id');
    }

    public function privateRelationId()
    {
        return TfRelation::where('name', 'private')->pluck('relation_id');
    }

    public function friendRelationId()
    {
        return TfRelation::where('name', 'friend')->pluck('relation_id');
    }
}
