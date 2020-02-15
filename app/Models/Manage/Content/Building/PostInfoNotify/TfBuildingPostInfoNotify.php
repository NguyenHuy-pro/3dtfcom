<?php namespace App\Models\Manage\Content\Building\PostInfoNotify;

use Illuminate\Database\Eloquent\Model;

class TfBuildingPostInfoNotify extends Model
{

    protected $table = 'tf_building_post_info_notifies';
    protected $fillable = ['notify_id', 'content', 'newInfo', 'action', 'created_at', 'post_id', 'badInfo_id'];
    protected $primaryKey = 'notify_id';
    //public $incrementing = false;
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    # ------------ Insert ------------
    public function insert($content = '', $postId, $badInoId)
    {
        $hFunction = new \Hfunction();
        $modelNotify = new TfBuildingPostInfoNotify();
        $modelNotify->content = $content;
        $modelNotify->newInfo = 1;
        $modelNotify->action = 1;
        $modelNotify->post_id = $postId;
        $modelNotify->badInfo_id = $badInoId;
        $modelNotify->created_at = $hFunction->createdAt();
        if ($modelNotify->save()) {
            $this->lastId = $modelNotify->notify_id;
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


    # ------------ Update ------------
    public function updateNewINfo($notifyId = null)
    {
        if (empty($notifyId)) $notifyId = $this->notify_id;
        return TfBuildingPostInfoNotify::where('notify_id', $notifyId)->update(['newInfo' => 0]);
    }

    # delete
    public function actionDelete($notifyId = null)
    {
        if (empty($notifyId)) $notifyId = $this->notify_id;
        return TfBuildingPostInfoNotify::where('notify_id', $notifyId)->update(['action' => 0]);
    }

    #when delete post
    public function actionDeleteByPost($postId = null)
    {
        if (!empty($postId)) {
            TfBuildingPostInfoNotify::where(['post_id' => $postId, 'action' => 1])->update(['action' => 0]);
        }
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-BUILDING-POST -----------
    public function buildingPost()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Post\TfBuildingPost', 'post_id', 'post_id');
    }

    #----------- TF-BAD-INFO ----------- -
    public function badInfo()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\BadInfo\TfBadInfo', 'badInfo_id', 'badInfo_id');
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    public function getInfo($notifyId = '', $field = '')
    {
        if (empty($notifyId)) {
            return null;
        } else {
            $result = TfBuildingPostInfoNotify::where('notify_id', $notifyId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #----------- NOTIFY INFO -----------
    public function content($notifyId = null)
    {
        if (empty($notifyId)) {
            return $this->content;
        } else {
            return $this->getInfo($notifyId, 'content');
        }
    }

    # total records
    public function totalRecords()
    {
        return TfBuildingPostInfoNotify::where('action', 1)->count();
    }


}
