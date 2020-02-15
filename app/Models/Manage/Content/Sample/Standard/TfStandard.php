<?php namespace App\Models\Manage\Content\Sample\Standard;

use App\Models\Manage\Content\Sample\Size\TfSize;
use Illuminate\Database\Eloquent\Model;
use DB;

class TfStandard extends Model
{

    protected $table = 'tf_standards';
    protected $fillable = ['standard_id', 'standardValue', 'status'];
    protected $primaryKey = 'standard_id';
    public $timestamps = false;

    #=========== =========== =========== INSERT && UDATE =========== =========== ===========
    #----------- Update -----------
    public function updateStatus($standardId, $status)
    {
        return TfStandard::where('standard_id', $standardId)->update(['status' => $status]);
    }

    #=========== =========== =========== RELATION =========== =========== ===========
    #----------- TF-SIZE -----------
    public function size()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Size\TfSize', 'standard_id', 'standard_id');
    }

    #=========== =========== =========== GET INFO =========== =========== ===========
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfStandard::where('standard_id', $objectId)->pluck($column);
        }
    }

    public function standardId()
    {
        return $this->standard_id;
    }

    public function standardValue($standardId = null)
    {
        return $this->pluck('standardValue', $standardId);
    }

    public function status($standardId = null)
    {
        return $this->pluck('status', $standardId);
    }

    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $standard = TfStandard::select('standard_id as optionKey', 'standardValue as optionValue')->get()->toArray();
        return $hFunction->option($standard, $selected);
    }

    #----------- TF-SIZE -----------
    #get list size id  of a standard
    public function listSizeID($standardId)
    {
        $modelSize = new TfSize();
        return $modelSize->listSizeIDOfStandard($standardId);
    }

    #----------- STANDARD INFO ----------- ----------
    # total records
    public function totalRecords()
    {
        return TfStandard::count();
    }

}
