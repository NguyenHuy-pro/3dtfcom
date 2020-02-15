<?php namespace App\Models\Manage\Content\Sample\ProjectIconLicense;

use Illuminate\Database\Eloquent\Model;

class TfProjectIconSampleLicense extends Model {

    protected $table = 'tf_project_icon_sample_licenses';
    protected $fillable = ['projectIconSample_id','user_id','created_at'];
    //protected $primaryKey = 'exchange_id';
    public $timestamps = false;

    # get icon sample
    public function projectIconSample(){
        return $this->belongsTo('App\Models\Manage\Content\Sample\ProjectIcon\TfProjectIconSample');
    }

    # get user
    public  function user(){
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }
}
