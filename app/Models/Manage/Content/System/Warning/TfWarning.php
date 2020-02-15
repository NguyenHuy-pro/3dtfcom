<?php namespace App\Models\Manage\Content\System\Warning;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfWarning extends Model
{

    protected $table = 'tf_warnings';
    protected $fillable = ['warning_id', 'name', 'action', 'created_at'];
    protected $primaryKey = 'warning_id';
    public $timestamps = false;

    private $lastId;

    #========= =========== =========== INSERT && UPDATE =========== =========== ===========
    #--------- Insert -----------
    public function insert($name)
    {
        $hFunction = new \Hfunction();
        $modelWarning = new TfWarning();
        $modelWarning->name = $name;
        $modelWarning->action = 1;
        $modelWarning->created_at = $hFunction->createdAt();
        if ($modelWarning->save()) {
            $this->lastId = $modelWarning->badInfo_id;
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

    #--------- Update -----------#
    public function updateInfo($warningId, $name)
    {
        return TfWarning::where('warning_id', $warningId)->update(['name' => $name]);
    }

    # delete
    public function actionDelete($warningId)
    {
        return TfWarning::where('warning_id', $warningId)->update(['action' => 0]);
    }

    #========= =========== =========== RELATION =========== =========== ===========

    #----------- TF-USER -----------
    public function user()
    {

    }

    #========= =========== =========== GET INFO =========== =========== ===========
    public function warningId(){
        return $this->warning_id;
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfWarning::where('warning_id', $objectId)->pluck($column);
        }
    }

    public function name($warningId = null)
    {
        return $this->pluck('name', $warningId);
    }

    public function createdAt($warningId = null)
    {
        return $this->pluck('created_at', $warningId);
    }

    # check exist of name
    public function existName($name)
    {
        $warning = DB::table('tf_warnings')->where('name', $name)->count();
        return ($warning > 0) ? true : false;
    }

    public function existEditName($warningId, $name)
    {
        $result = TfWarning::where('name', $name)->where('warning_id', '<>', $warningId)->count();
        return ($result > 0) ? true : false;
    }

    public function totalRecords()
    {
        return DB::table('tf_warnings')->where('action', 1)->count();
    }

}
