<?php namespace App\Models\Manage\Content\Map\Publics;

use App\Models\Manage\Content\Sample\Publics\TfPublicSample;
use Illuminate\Database\Eloquent\Model;

class TfPublic extends Model
{

    protected $table = 'tf_publics';
    protected $fillable = ['public_id', 'name', 'topPosition', 'leftPosition', 'zindex', 'publish', 'status', 'action', 'created_at', 'project_id', 'sample_id'];
    protected $primaryKey = 'public_id';
    #public $incrementing = false;
    public $timestamps = false;

    private $lastId = null;

    #========== ========== ========== INSERT && UPDATE ========== ========== =========
    #---------- insert ----------
    public function insert($topPosition, $leftPosition, $zIndex, $publish, $projectId, $sampleId)
    {
        $hFunction = new \Hfunction();
        $modelPublic = new TfPublic();
        $modelPublic->name = 'PUBLIC' . ($this->lastId() + 1);
        $modelPublic->topPosition = $topPosition;
        $modelPublic->leftPosition = $leftPosition;
        $modelPublic->zindex = $zIndex;
        $modelPublic->publish = $publish;
        $modelPublic->status = 1;
        $modelPublic->action = 1;
        $modelPublic->project_id = $projectId;
        $modelPublic->sample_id = $sampleId;
        $modelPublic->created_at = $hFunction->createdAt();
        if ($modelPublic->save()) {
            $this->lastId = $modelPublic->public_id;
            return true;
        } else {
            return false;
        }
    }

    # get new ind
    public function insertGetId()
    {
        return $this->lastId;
    }

    #---------- Update -------------
    # position
    public function updatePosition($publicId, $topPosition, $leftPosition, $zIndex = '')
    {
        return TfPublic::where('public_id', $publicId)->update(['topPosition' => $topPosition, 'leftPosition' => $leftPosition, 'zindex' => $zIndex]);
    }

    # status
    public function updateStatus($publicId, $status)
    {
        return TfPublic::where('public_id', $publicId)->update(['action' => $status]);
    }

    # publish status
    public function updatePublish($publicId)
    {
        return TfPublic::where('public_id', $publicId)->update(['publish' => 1]);
    }

    # delete
    public function actionDelete($publicId)
    {
        return TfPublic::where('public_id', $publicId)->update(['action' => 0]);
    }

    #delete by project
    public function actionDeleteByProject($projectId = null)
    {
        if (!empty($projectId)) {
            TfPublic::where(['project_id' => $projectId, 'action' => 1])->update(['action' => 0]);
        }
    }

    # delete when setup (does not publish)
    public function setupDelete($publicId)
    {
        return TfPublic::where('public_id', $publicId)->delete();
    }

    #========== ========== ========== RELATION ========== ========== =========
    # ----------  TF-PROJECT ----------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'project_id', 'project_id');
    }

    #----------- TF-PUBLIC-SAMPLE -----------
    public function publicSample()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Publics\TfPublicSample', 'sample_id', 'sample_id');
    }

    #========== ========== ========== GET INFO ========== ========== =========
    public function getInfo($publicId = '', $field = '')
    {
        if (empty($publicId)) {
            return TfPublic::where('action', 1)->get();
        } else {
            $result = TfPublic::where('public_id', $publicId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # ----------  TF-PROJECT ----------
    # only get public are using of project
    public function infoOfProject($projectId = null)
    {
        return TfPublic::where('project_id', $projectId)->where('action', 1)->get();
    }

    #----------- TF-PUBLIC-SAMPLE -----------
    #get path image  of sample
    public function pathImageSample($sampleId)
    {
        $modelPublicSample = new TfPublicSample();
        return $modelPublicSample->pathImage($modelPublicSample->image($sampleId));
    }

    # ----------- PUBLIC INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfPublic::where('public_id', $objectId)->pluck($column);
        }
    }

    public function publicId()
    {
        return $this->public_id;
    }

    public function projectId($publicId = null)
    {
        return $this->pluck('project_id', $publicId);
    }

    public function sampleId($publicId = null)
    {
        return $this->pluck('sample_id', $publicId);
    }


    public function name($publicId = null)
    {
        return $this->pluck('name', $publicId);
    }

    # top position
    public function topPosition($publicId = null)
    {
        return $this->pluck('topPosition', $publicId);
    }

    # left position
    public function leftPosition($publicId = null)
    {
        return $this->pluck('leftPosition', $publicId);
    }

    # z-index
    public function zIndex($publicId = null)
    {
        return $this->pluck('zindex', $publicId);
    }

    public function publish($publicId = null)
    {
        return $this->pluck('publish', $publicId);
    }

    public function status($publicId = null)
    {
        return $this->pluck('status', $publicId);
    }

    public function createdAt($publicId = null)
    {
        return $this->pluck('created_at', $publicId);
    }

    # total records
    public function totalRecords()
    {
        return TfPublic::where('action', 1)->count();
    }

    # last id
    public function lastId()
    {
        $result = TfPublic::orderBy('public_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->public_id;
    }

}
