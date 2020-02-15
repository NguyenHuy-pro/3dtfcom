<?php namespace App\Models\Manage\Content\Sample\BuildingSampleLicense;

use Illuminate\Database\Eloquent\Model;

class TfBuildingSampleLicense extends Model
{

    protected $table = 'tf_building_sample_licenses';
    protected $fillable = ['sample_id', 'user_id', 'status', 'created_at'];

    //public $incrementing = false;
    public $timestamps = false;

    #========== ========== ========== INSERT && UPDATE ========= ========== ==========
    #----------- Insert ----------
    public function insert($sampleId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelLicense = new TfBuildingSampleLicense();
        $modelLicense->sample_id = $sampleId;
        $modelLicense->user_id = $userId;
        $modelLicense->status = 1;
        $modelLicense->created_at = $hFunction->createdAt();
        return $modelLicense->save();
    }

    #========== ========== ========== RELATION ========= ========== ==========
    #----------- TF-BUILDING-SAMPLE -----------
    public function buildingSample()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Building\TfBuildingSample', 'sample_id', 'sample_id');
    }

    #----------- TF-USER -----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    #========== ========== ========== GET INFO ========= ========== ==========
    #list sample id of a user
    public function listSampleIdOfUser($userId)
    {
        return TfBuildingSampleLicense::where('user_id', $userId)->where('status', 1)->lists('sample_id');
    }

    # check exist sample of user
    public function existSampleOfUser($sampleId = null, $userId = null)
    {
        $result = TfBuildingSampleLicense::where('sample_id', $sampleId)->where('user_id', $userId)->count();
        return ($result > 0) ? true : false;
    }

    # total records
    public function totalRecords()
    {
        return TfBuildingSampleLicense::count();
    }

    #========== ========== ========== UPDATE INFO ========= ========== ==========
    # status
    public function updateAction($sampleId, $userId)
    {
        return TfBuildingSampleLicense::where('sample_id', $sampleId)->where('user_id', $userId)->update(['action' => 0]);
    }

}
