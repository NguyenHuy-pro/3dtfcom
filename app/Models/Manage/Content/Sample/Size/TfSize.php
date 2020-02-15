<?php namespace App\Models\Manage\Content\Sample\Size;

use App\Models\Manage\Content\Map\RuleLandRank\TfRuleLandRank;
use Illuminate\Database\Eloquent\Model;
use DB;
use File;

class TfSize extends Model
{

    protected $table = 'tf_sizes';
    protected $fillable = ['size_id', 'name', 'width', 'height', 'image', 'status', 'standard_id', 'created_at'];
    protected $primaryKey = 'size_id';
    public $timestamps = false;

    private $lastId;
    #=========== =========== =========== INSERT && UPDATE =========== =========== ===========
    #----------- Insert -----------
    public function insert($width, $height, $image, $standardId)
    {
        $hFunction = new \Hfunction();
        $modelSize = new TfSize();
        $modelSize->name = $width . ' x ' . $height;
        $modelSize->width = $width;
        $modelSize->height = $height;
        $modelSize->image = $image;
        $modelSize->standard_id = $standardId;
        $modelSize->created_at = $hFunction->createdAt();
        if ($modelSize->save()) {
            $this->lastId = $modelSize->size_id;
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

    #----------- Update -----------
    public function updateInfo($sizeId, $width, $height, $image)
    {
        return TfSize::where('size_id', $sizeId)->update([
            'name' => $width . ' x ' . $height,
            'width' => $width,
            'height' => $height,
            'image' => $image
        ]);
    }

    public function updateStatus($sizeId, $status)
    {
        return TfSize::where('size_id', $sizeId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($sizeId)
    {
        $oldImage = $this->image($sizeId);
        if (TfSize::where('size_id', $sizeId)->delete()) {
            $oldSrc = "public/images/sample/size/icons/$oldImage";
            if (File::exists($oldSrc)) {
                File::delete($oldSrc);
            }
            return true;
        } else {
            return false;
        }
    }

    #=========== =========== =========== RELATION =========== =========== ===========
    #----------- TF-STANDARD -----------
    public function standard()
    {
        return $this->belongsTo('App\Models\Manage\Content\Sample\Standard\TfStandard', 'standard_id', 'standard_id');
    }

    public function infoOfStandard($standardId)
    {
        return TfSize::where('standard_id', $standardId)->get();
    }

    # get list size id of standard
    public function listSizeIDOfStandard($standardId)
    {
        return TfSize::where('standard_id', $standardId)->where('status', 1)->lists('size_id');
    }

    #----------- TF-RULE-BANNER-RANK -----------
    public function ruleBannerRank()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\RuleBannerRank\TfRuleBannerRank', 'size_id', 'size_id');
    }

    #----------- TF-RULE-LAND-RANK -----------
    public function ruleLandRank()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\RuleLandRank\TfRuleLandRank', 'size_id', 'size_id');
    }

    #----------- TF-BANNER-SAMPLE -----------
    public function bannerSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Banner\TfBannerSample', 'size_id', 'size_id');
    }

    #----------- TF-BUILDING-SAMPLE -----------
    public function buildingSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Building\TfBuildingSample', 'size_id', 'size_id');
    }

    #----------- TF-LAND-REQUEST-BUILD -----------
    public function landRequestBuild()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\RequestBuildDesign\TfLandRequestBuild', 'size_id', 'size_id');
    }

    #----------- TF-LAND-ICON-SAMPLE -----------
    public function landIconSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Land\TfLandIconSample', 'size_id', 'size_id');
    }

    #----------- TF-PROJECT-ICON-SAMPLE -----------
    public function projectIconSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Project\TfProjectIconSample', 'size_id', 'size_id');
    }

    #----------- TF-PUBLIC-SAMPLE -----------
    public function publicSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Publics\TfPublicSample', 'size_id', 'size_id');
    }

    # ---------- TF-REQUEST-BUILD-PRICE ---------
    public function requestBuildPrice()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\RequestBuildPrice\TfRequestBuildPrice', 'size_id', 'size_id');
    }

    #=========== =========== =========== GET INFO =========== =========== ===========
    public function getInfo($sizeId = null, $field = null)
    {
        if (empty($sizeId)) {
            return TfSize::where('status', 1)->get();
        } else {
            $result = TfSize::where('size_id', $sizeId)->first();;
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfSize::orderBy('width', 'ASC')->orderBy('height', 'ASC')->select('size_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    #list size id same width (standard) size of a size
    public function listSizeIDSameSize($sizeId)
    {
        $width = $this->width($sizeId);
        return TfSize::where('width', $width)->where('status', 1)->lists('size_id');
    }

    #----------- SIZE INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfSize::where('size_id', $objectId)->pluck($column);
        }
    }

    public function sizeId()
    {
        return $this->size_id;
    }

    public function name($sizeId = null)
    {
        return $this->pluck('name', $sizeId);
    }

    public function image($sizeId = null)
    {
        return $this->pluck('image', $sizeId);
    }

    public function width($sizeId = null)
    {
        return $this->pluck('width', $sizeId);
    }

    public function height($sizeId = null)
    {
        return $this->pluck('height', $sizeId);
    }

    public function standardId($sizeId = null)
    {
        return $this->pluck('standard_id', $sizeId);
    }

    public function status($sizeId = null)
    {
        return $this->pluck('status', $sizeId);
    }

    public function createdAt($sizeId = null)
    {
        return $this->pluck('created_at', $sizeId);
    }

    #path image
    public function pathImage($image = null)
    {
        if (empty($image)) {
            return asset("public/images/sample/size/icons/" . $this->image);
        } else {
            return asset("public/images/sample/size/icons/$image");
        }
    }

    #------------ SIZE INFO -----------
    # check exist of size when add new
    public function existSize($width, $height)
    {
        $size = TfSize::where('width', $width)->where('height', $height)->count();
        return ($size > 0) ? true : false;
    }

    # when edit info
    public function existEditSize($width, $height, $sizeId)
    {
        $size = TfSize::where('width', $width)->where('height', $height)->where('size_id', '<>', $sizeId)->count();
        return ($size > 0) ? true : false;
    }

    # total records
    public function totalRecords()
    {
        return TfSize::count();
    }

    # build tool
    public function sizeTool()
    {
        # default tool is land
        # just select the site has been managed within the rules of the land.
        $listSize = TfRuleLandRank::where('action', 1)->lists('size_id');
        return TfSize::whereIn('size_id', $listSize)->where('status', 1)->orderBy('width', 'ASC')->get();
    }
}
