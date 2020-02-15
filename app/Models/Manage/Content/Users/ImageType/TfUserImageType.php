<?php namespace App\Models\Manage\Content\Users\ImageType;

use Illuminate\Database\Eloquent\Model;

class TfUserImageType extends Model
{

    protected $table = 'tf_user_image_types';
    protected $fillable = ['type_id', 'name', 'action'];
    protected $primaryKey = 'type_id';
    public $timestamps = false;

    private $lastId;

    #========== ========= INSERT && UPDATE ========= ========= =========
    #----------- insert -----------
    public function insert($name)
    {
        $modelType = new TfUserImageType();
        $modelType->name = $name;
        if ($modelType->save()) {
            $this->lastId = $modelType->type_id;
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

    #----------- update -------------
    public function updateInfo($typeId, $name)
    {
        return TfUserImageType::where('type_id', $typeId)->update(['name' => $name]);
    }

    # delete
    public function actionDelete($typeId = null)
    {
        if (empty($typeId)) $typeId = $this->type_id;
        return TfUserImageType::where('type_id', $typeId)->update(['action' => 0]);
    }

    #========= ========= =========  RELATION ========== ========== =========
    #---------- TF-USER-IMAGE -----------
    public function userImage()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Users\Image\TfUserImage', 'tf_user_image_details', 'type_id', 'image_id');
    }

    #---------- TF-USER-IMAGE-DETAIL -----------
    public function userImageDetail()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\ImageDetail\TfUserImageDetail', 'type_id', 'type_id');
    }

    #========== ======== ======== GET INFO ======== ========== ==========
    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfUserImageType::select('type_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    public function getInfo($typeId = '', $field = '')
    {
        if (empty($typeId)) {
            return TfUserImageType::where('action', 1)->get();
        } else {
            $result = TfUserImageType::where('type_id', $typeId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function typeId()
    {
        return $this->type_id;
    }

    public function typeIdAvatar()
    {
        return 2; #default avatar

    }

    public function typeIdBanner()
    {
        return 3; #default banner

    }


    public function name($typeId = null)
    {
        if (empty($typeId)) {
            return $this->name;
        } else {
            return $this->getInfo($typeId, 'name');
        }
    }

    # total records -->return number
    public function totalRecords()
    {
        return TfUserImageType::where('action', 1)->count();
    }

    #========== ======== check info ========== ==========
    # check exist of name
    public function existName($name)
    { # add new
        $result = TfUserImageType::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditName($name = '', $typeID = '')
    { # edit info
        $result = TfUserImageType::where('name', $name)->where('type_id', '<>', $typeID)->count();
        return ($result > 0) ? true : false;
    }


}
