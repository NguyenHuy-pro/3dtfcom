<?php namespace App\Models\Manage\Content\System\Country;

use Illuminate\Database\Eloquent\Model;
use App\Models\Manage\Content\Map\Country\TfCountryProperty;
use App\Models\Manage\Content\System\Province\TfProvince;
use DB;
use File;

class TfCountry extends Model
{

    protected $table = 'tf_countries';
    protected $fillable = ['country_id', 'name', 'countryCode', 'flagImage', 'moneyUnit', 'build3d', 'defaultCenter', 'status', 'action', 'created_at', 'dateBuild3d'];
    protected $primaryKey = 'country_id';
    public $timestamps = false;

    private $lastId;

    #========== ============ ==========  INSERT && UPDATE ============= ========== ==========
    #----------- Insert ------------
    public function insert($name, $countryCode, $flagImage = '', $moneyUnit = '', $dateBuild3d = null)
    {
        $hFunction = new \Hfunction();
        $modelCountry = new TfCountry();
        $modelCountry->name = $name;
        $modelCountry->countryCode = $countryCode;
        $modelCountry->flagImage = $flagImage;
        $modelCountry->moneyUnit = $moneyUnit;
        $modelCountry->build3d = 0; # default not build
        $modelCountry->defaultCenter = 0; # default not center
        $modelCountry->dateBuild3d = $dateBuild3d;
        $modelCountry->created_at = $hFunction->createdAt();
        if ($modelCountry->save()) {
            $this->lastId = $modelCountry->country_id;
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

    #----------- Update -----------
    public function updateInfo($countryId, $name, $countryCode, $flagImage, $moneyUnit)
    {
        $modelCountry = TfCountry::find($countryId);
        $modelCountry->name = $name;
        $modelCountry->countryCode = $countryCode;
        $modelCountry->flagImage = $flagImage;
        $modelCountry->moneyUnit = $moneyUnit;
        return $modelCountry->save();
    }

    #========== ============ ==========  RELATION ============= ========== ==========
    #---------- TF-PROVINCE ----------
    public function province()
    {
        return $this->hasMany('App\Models\Manage\Content\System\Province\TfProvince', 'country_id', 'country_id');
    }

    #---------- TF-COUNTY-PROPERTY -----------
    public function countryProperty()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Country\TfCountryProperty', 'country_id', 'country_id');
    }

    #---------- TF-STAFF -----------
    public function countryManage()
    {
        return $this->belongsToMany('App\Models\Manage\Content\System\Staff\TfStaff', 'App\Models\Manage\Content\Map\Country\TfCountryProperty', 'country_id', 'staff_id');
    }

    #========== ============ ==========  GET INFO ============= ========== ==========
    # create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfCountry::select('country_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    # built 3D
    public function getOptionBuilt3d($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfCountry::where('build3d', 1)->select('country_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    public function getInfoBuilt3d()
    {
        return TfCountry::where('build3d', 1)->where('action', 1)->get();
    }


    public function getInfo($countryId = null, $field = null)
    {
        if (empty($countryId)) {
            return TfCountry::where('action', 1)->get();
        } else {
            $result = TfCountry::where('country_id', $countryId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }
    #---------- TF-PROVINCE ----------
    // get center province of country
    public function centerProvince($countryId = '')
    {
        $modelProvince = new TfProvince();
        return $modelProvince->centerProvinceOfCountry($countryId);
    }

    #------------- INFO ------------
    public function defaultCountryId()
    {
        return TfCountry::where(['defaultCenter' => 1, 'action' => 1])->pluck('country_id');
    }

    public function defaultCountryInfo()
    {
        return TfCountry::where(['defaultCenter' => 1, 'action' => 1])->first();
    }

    public function countryId()
    {
        return $this->country_id;
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfCountry::where('country_id', $objectId)->pluck($column);
        }
    }

    public function name($countryId = null)
    {
        return $this->pluck('name', $countryId);
    }

    public function countryCode($countryId = null)
    {
        return $this->pluck('countryCode', $countryId);
    }

    public function moneyUnit($countryId = null)
    {
        return $this->pluck('moneyUnit', $countryId);
    }

    public function flagImage($countryId = null)
    {
        return $this->pluck('flagImage', $countryId);
    }

    public function build3dStatus($countryId = null)
    {
        return $this->pluck('build3d', $countryId);
    }

    public function defaultCenter($countryId = null)
    {
        return $this->pluck('defaultCenter', $countryId);
    }

    public function status($countryId = null)
    {
        return $this->pluck('status', $countryId);
    }

    public function dateBuild3d($countryId = null)
    {
        return $this->pluck('dateBuild3d', $countryId);
    }

    public function createdAt($countryId = null)
    {
        return $this->pluck('created_at', $countryId);
    }

    public function pathImage($image = null)
    {
        if (empty($image)) $image = $this->flagImage;
        return asset("public/images/system/country/flag/$image");
    }

    # get default center of country
    public function centerCountryId()
    {
        return TfCountry::where('defaultCenter', 1)->where('action', 1)->pluck('country_id');
    }

    // total records
    public function totalRecords()
    {
        return TfCountry::count();
    }

    #============= =========== =========== CHECK INFO ========= ========== ===========
    // check exist of name (when add new)
    public function existName($name)
    {
        $result = TfCountry::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    // check exist of name (when edit info)
    public function existEditName($name, $countryId)
    {
        $result = TfCountry::where('country_id', '<>', $countryId)->where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    // check exist of code (when add new)
    public function existCodeCountry($countryCode)
    {
        $country = TfCountry::where('countryCode', $countryCode)->count();
        return ($country > 0) ? true : false;
    }

    // check exist of code (when edit info)
    public function existEditCodeCountry($countryCode, $countryId)
    {
        $result = TfCountry::where('country_id', '<>', $countryId)->where('countryCode', $countryCode)->count();
        return ($result > 0) ? true : false;
    }

    // check build3d
    public function checkBuild3d($countryId = null)
    {
        if (empty($countryId)) {
            return ($this->build3d == 1) ? true : false;
        } else {
            $result = TfCountry::where('country_id', $countryId)->where('build3d', 1)->count();
            return ($result > 0) ? true : false;
        }
    }

    #============ ========== ========== BUILD 3d ========== ========= ==========
    //share 3d
    public function build3d($countryId, $staffManageId = '', $defaultProvinceId)
    {
        $hFunction = new \Hfunction();
        $dateBegin = $hFunction->carbonNow();
        $dateEnd = $hFunction->carbonNowAddYears(10);

        # add license for manager
        $modelCountryProperty = new TfCountryProperty();
        $modelCountryProperty->insert($dateBegin, $dateEnd, $countryId, $staffManageId);

        # update build3d status for country
        $modelCountry = TfCountry::find($countryId);
        $modelCountry->build3d = 1;
        $modelCountry->dateBuild3d = $dateBegin;
        $modelCountry->save();

        # open default province 3d
        $modelProvince = new TfProvince();
        $modelProvince->build3d($defaultProvinceId, $staffManageId);
        $modelProvince->updateDefaultCenter($defaultProvinceId, 1);
    }

    #============ ========== share 3d ======== =========
    // status
    public function updateStatus($countryId, $status)
    {
        return TfCountry::where('country_id', $countryId)->update(['status' => $status]);
    }

    // delete
    public function actionDelete($countryId)
    {
        $modelCountryProperty = new TfCountryProperty();

        $oldFlag = $this->flagImage($countryId);
        if (TfCountry::where('country_id', $countryId)->delete()) {
            #delete property
            $modelCountryProperty->actionDeleteByCountry($countryId);

            $oldSrc = "public/images/system/country/flag/$oldFlag";
            if (File::exists($oldSrc)) {
                File::delete($oldSrc);
            }

            return true;
        } else {
            return false;
        }
    }
}
