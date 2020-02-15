<?php namespace App\Models\Manage\Content\System\NotifyUser;

use Illuminate\Database\Eloquent\Model;

class TfNotifyUser extends Model {

    protected $table = 'tf_notify_users';
    protected $fillable = ['notify_id', 'user_id','newInfo', 'status', 'created_at'];
    #protected $primaryKey = '';
    //public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #insert
    public function insert($notifyId, $userId)
    {
        $hFunction = new \Hfunction();
        $model = new TfNotifyUser();
        $model->notify_id = $notifyId;
        $model->user_id = $userId;
        $model->newInfo = 1;
        $model->status = 1;
        $model->created_at = $hFunction->createdAt();
        return $model->save();
    }

    # disable new info
    public function updateNewInfo($notifyId, $userId)
    {
        return TfNotifyUser::where(['notify_id'=> $notifyId, 'user_id' => $userId])->update(['newInfo'=> 0]);
    }

    #status
    public function updateStatus($notifyId, $userId)
    {
        return TfNotifyUser::where(['notify_id'=> $notifyId, 'user_id' => $userId])->update(['status'=> 0]);
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-Notify -----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\TfNotify', 'notify_id', 'notify_id');
    }

    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }


    #========== ========== ========== GET INFO ========= ========== ==========
    # total records
    public function totalRecords()
    {
        return TfNotifyUser::count();
    }

}
