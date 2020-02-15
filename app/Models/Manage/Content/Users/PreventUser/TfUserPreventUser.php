<?php namespace App\Models\Manage\Content\Users\PreventUser;

use Illuminate\Database\Eloquent\Model;

class TfUserPreventUser extends Model {

    protected $table = 'tf_user_prevent_users';
    protected $fillable = ['user_id', 'preventUser_id', 'created_at'];
//    protected $primaryKey = 'share_id';
    public $timestamps = false;


    #=========== ============ ============ RELATION ============ ============ ============
    public function user()
    {
        return $this->belongsTo('App/Models/Manage/Content/Users/TfUser', 'user_id', 'user_id');
    }

    //==================== update\ delete info ==================

    //delete
    public function actionDelete($userId = '', $loveUserId = '')
    {
        return TfUserPreventUser::where('user_id', $userId)->where('preventUser_id', $loveUserId)->delete();
    }

}
