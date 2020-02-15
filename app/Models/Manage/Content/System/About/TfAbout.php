<?php namespace App\Models\Manage\Content\System\About;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\File;


class TfAbout extends Model
{

    protected $table = 'tf_abouts';
    protected $fillable = ['about_id', 'name', 'content', 'image', 'metaKeyword', 'metaDescription', 'action', 'created_at', 'staff_id'];
    protected $primaryKey = 'about_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- Insert ----------
    public function insert($name, $content, $image = null, $metaKeyword = null, $metaDescription = null, $staffId)
    {
        $hFunction = new \Hfunction();
        $modelAbout = new TfAbout();
        $modelAbout->name = $name;
        $modelAbout->content = $content;
        $modelAbout->image = $image;
        $modelAbout->metaKeyword = $metaKeyword;
        $modelAbout->metaDescription = $metaDescription;
        $modelAbout->staff_id = $staffId;
        $modelAbout->created_at = $hFunction->carbonNow();
        if ($modelAbout->save()) {
            $this->lastId = $modelAbout->about_id;
            return true;
        } else {
            return false;
        }
    }

    //get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    //upload image
    public function uploadImage($file, $imageName)
    {
        $hFunction = new \Hfunction();
        $pathFullImage = "public/images/system/about/full";
        $pathSmallImage = "public/images/system/about/small";
        if (!is_dir($pathFullImage)) mkdir($pathFullImage);
        if (!is_dir($pathSmallImage)) mkdir($pathSmallImage);
        return $hFunction->uploadSave($file, $pathSmallImage.'/', $pathFullImage.'/', $imageName, 200);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/system/about/full/' . $imageName);
        File::delete('public/images/system/about/small/' . $imageName);
    }

    #----------- update ----------
    //update info
    public function updateInfo($name, $content, $image = null, $metaKeyword = null, $metaDescription = null, $aboutId = null)
    {
        if (empty($aboutId)) $aboutId = $this->aboutId();
        return TfAbout::where('about_id', $aboutId)->update(
            [
                'name' => $name,
                'content' => $content,
                'image' => $image,
                'metaKeyword' => $metaKeyword,
                'metaDescription' => $metaDescription
            ]);
    }

    //delete
    public function actionDelete($aboutId = null)
    {
        if (empty($aboutId)) $aboutId = $this->aboutId();
        return TfAbout::where('about_id', $aboutId)->update(['action' => 0]);
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-STAFF ------------
    public function staff()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Staff\TfStaff', 'staff_id', 'staff_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function defaultInfo()
    {
        return TfAbout::where(['action' => 1])->first();
    }

    public function findInfo($objectId)
    {
        return TfAbout::find($objectId);
    }

    public function getInfo($aboutId = '', $field = '')
    {
        if (empty($aboutId)) {
            return TfAbout::where('action', 1)->get();
        } else {
            $result = TfAbout::where('about_id', $aboutId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    //get info active
    public function getInfoActive()
    {
        return TfAbout::where('action', 1)->first();
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfAbout::where('about_id', $objectId)->pluck($column);
        }
    }

    public function aboutId()
    {
        return $this->about_id;
    }

    public function name($aboutId = null)
    {
        return $this->pluck('name', $aboutId);
    }

    public function content($aboutId = null)
    {
        return $this->pluck('content', $aboutId);
    }

    public function image($aboutId = null)
    {
        return $this->pluck('image', $aboutId);
    }

    public function metaKeyword($aboutId = null)
    {
        return $this->pluck('metaKeyword', $aboutId);
    }

    public function metaDescription($aboutId = null)
    {
        return $this->pluck('metaDescription', $aboutId);
    }

    public function staffId($aboutId = null)
    {
        return $this->pluck('staff_id', $aboutId);
    }

    public function createdAt($aboutId = null)
    {
        return $this->pluck('created_at', $aboutId);
    }

    // check exist of name (add new)
    public function existName($name)
    {
        $result = TfAbout::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditName($name, $aboutId)
    {
        $result = TfAbout::where('name', $name)->where('about_id', '<>', $aboutId)->count();
        return ($result > 0) ? true : false;
    }

    //total
    public function totalRecords()
    {
        return TfAbout::where('action', 1)->count();
    }

    public function pathSmallImage($image = null)
    {
        if (empty($image)) $image = $this->image;
        return asset("public/images/system/about/small/$image");

    }

    public function pathFullImage($image = null)
    {
        if (empty($image)) $image = $this->image;
        return asset("public/images/system/about/full/$image");
    }

    public function pathDefaultImage()
    {
        return asset("public/main/icons/bg_123.png");

    }

    public function pathLogoSystem()
    {
        return asset('public/main/icons/3dlogo128.png');

    }

}
