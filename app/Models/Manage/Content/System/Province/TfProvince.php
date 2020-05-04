<?php namespace App\Models\Manage\Content\System\Province;

use App\Models\Manage\Content\System\Country\TfCountry;
use App\Models\Manage\Content\System\LinkRun\TfLinkRun;
use Illuminate\Database\Eloquent\Model;
use App\Models\Manage\Content\Map\ProvinceArea\TfProvinceArea;
use App\Models\Manage\Content\Map\ProvinceProperty\TfProvinceProperty;
use App\Models\Manage\Content\Map\Project\TfProject;

use DB;
use File;
use Request;

class TfProvince extends Model
{

    protected $table = 'tf_provinces';
    protected $fillable = ['province_id', 'name', 'build3d', 'defaultCenter', 'status', 'action', 'created_at', 'dateBuild3d', 'type_id', 'country_id'];
    protected $primaryKey = 'province_id';
    public $timestamps = false;

    private $lastId;

    #============ ============ ============ INSERT && UPDATE ============ ========== =========
    #----------- Insert ------------
    public function insert($name, $build3d = '', $defaultCenter = '', $countryId, $typeId)
    {
        $hFunction = new \Hfunction();
        $modelProvince = new TfProvince();
        $modelProvince->name = $name;
        $modelProvince->build3d = $build3d;
        $modelProvince->defaultCenter = $defaultCenter;
        $modelProvince->country_id = $countryId;
        $modelProvince->type_id = $typeId;
        $modelProvince->dateBuild3d = 0;
        $modelProvince->created_at = $hFunction->createdAt();
        if ($modelProvince->save()) {
            $this->lastId = $modelProvince->province_id;
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

    #----------- Update ------------
    //update default center
    public function updateDefaultCenter($provinceId, $default)
    {
        return TfProvince::where('province_id', $provinceId)->update(['defaultCenter' => $default]);
    }

    // status
    public function updateStatus($provinceId, $status)
    {
        return TfProvince::where('province_id', $provinceId)->update(['status' => $status]);
    }

    public function updateInfo($provinceId, $name, $typeId, $countryId)
    {
        return TfProvince::where('province_id', $provinceId)->update(['name' => $name, 'type_id' => $typeId, 'country_id' => $countryId]);
    }


    //delete
    public function actionDelete($provinceId = null)
    {
        $modelProvinceProperty = new TfProvinceProperty();
        $modelProject = new TfProject();

        if (empty($provinceId)) $provinceId = $this->provinceId();
        if (TfProvince::where('province_id', $provinceId)->update(['action' => 0])) {
            #delete property
            $modelProvinceProperty->actionDeleteByProvince($provinceId);

            #delete project
            $modelProject->actionDeleteByProvince($provinceId);
        }
    }

    #delete by country
    public function actionDeleteByCountry($countryId = null)
    {
        if (!empty($countryId)) {
            $listId = TfCountry::where(['country_id' => $countryId, 'action' => 1])->lists('province_id');
            if (!empty($listId)) {
                foreach ($listId as $value) {
                    $this->actionDelete($value);
                }
            }
        }
    }
    #========== ========== ========= RELATION ========== ========= ==========
    #--------- TF-USER ----------
    public function user()
    {
        return $this->belongsToMany('App\Models\Manage\Content\Users\TfUser', 'tf_user_contacts', 'province_id', 'user_id');
    }

    # --------- TF-USER-CONTACT ----------
    public function userContact()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Contact\TfUserContact', 'province_id', 'province_id');
    }

    #---------- TF-PROVINCE-TYPE -----------
    public function provinceType()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\ProvinceType\TfProvinceType', 'type_id', 'type_id');
    }

    #---------- TF-PROVINCE-AREA -----------
    public function provinceArea()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\ProvinceArea\TfProvinceArea', 'province_id', 'province_id');
    }

    # ---------- TF-PROVINCE-PROPERTY ---------
    public function provinceProperty()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\ProvinceProperty\TfProvinceProperty', 'province_d', 'province_id');
    }

    #---------- TF-COUNTRY -----------
    public function country()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Country\TfCountry', 'country_id', 'country_id');
    }

    #---------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'province_id', 'province_id');
    }

    #========== ========== ========= GET INFO ========== ========= ==========
    public function findInfo($provinceId)
    {
        return TfProvince::find($provinceId);
    }

    public function getInfo($provinceId = '', $field = '')
    {
        if (empty($provinceId)) {
            return TfProvince::where('action', 1)->get();
        } else {
            $result = TfProvince::where('province_id', $provinceId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    //project built 3protected
    public function infoBuilt3D()
    {
        return TfProvince::where('build3d', 1)->where('action', 1)->get();
    }

    // create option of select
    public function getOption($selected = '', $countryId = null)
    {
        $hFunction = new \Hfunction();
        if (empty($countryId)) {
            $result = TfProvince::select('province_id as optionKey', 'name as optionValue')->get()->toArray();
        } else {
            $result = TfProvince::where('country_id', $countryId)->select('province_id as optionKey', 'name as optionValue')->get()->toArray();
        }
        return $hFunction->option($result, $selected);
    }

    # built 3d
    public function getOptionBuilt3d($selectedProvinceId = '', $countryId = null)
    {
        $hFunction = new \Hfunction();
        if (!empty($countryId)) {
            $result = TfProvince::where(['country_id' => $countryId, 'build3d' => 1])->select('province_id as optionKey', 'name as optionValue')->get()->toArray();
        } else {
            $result = TfProvince::where('build3d', 1)->select('province_id as optionKey', 'name as optionValue')->get()->toArray();
        }

        return $hFunction->option($result, $selectedProvinceId);
    }

    public function getInfoBuilt3d()
    {
        return TfProvince::where('build3d', 1)->where('action', 1)->get();
    }


    # center province of country
    public function centerProvinceOfCountry($countryId)
    {
        return TfProvince::where('country_id', $countryId)->where('defaultCenter', 1)->pluck('province_id');
    }

    #---------- TF-PROVINCE-PROPERTY -----------
    public function propertyInfo($provinceId = null)
    {
        $modelProperty = new TfProvinceProperty();
        if (empty($provinceId)) $provinceId = $this->provinceId();
        return $modelProperty->infoOfProvince($provinceId);
    }

    #---------- AREA -----------
    # get center area
    public function centerArea($provinceId = null)
    {
        $modelProvinceArea = new TfProvinceArea();
        if (empty($provinceId)) $provinceId = $this->provinceId();
        return $modelProvinceArea->centerAreaOfProvince($provinceId);
    }

    #---------- TF-PROJECT ----------
    public function listProjectId($provinceId = null)
    {
        $modelProject = new TfProject();
        if (empty($provinceId)) $provinceId = $this->provinceId();
        return $modelProject->listIdOfProvince($provinceId);
    }

    #---------- PROVINCE INFO -----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProvince::where('province_id', $objectId)->pluck($column);
        }
    }

    public function provinceId()
    {
        return $this->province_id;
    }

    public function countryId($provinceId = null)
    {
        return $this->pluck('country_id', $provinceId);
    }

    public function typeId($provinceId = null)
    {
        return $this->pluck('type_id', $provinceId);
    }

    public function name($provinceId = null)
    {
        return $this->pluck('name', $provinceId);
    }

    public function build3dStatus($provinceId = null)
    {
        return $this->pluck('build3d', $provinceId);
    }

    public function defaultCenter($provinceId = null)
    {
        return $this->pluck('defaultCenter', $provinceId);
    }

    public function status($provinceId = null)
    {
        return $this->pluck('status', $provinceId);
    }

    public function dateBuild3d($provinceId = null)
    {
        return $this->pluck('dareBuild3d', $provinceId);
    }

    public function createdAt($provinceId = null)
    {
        return $this->pluck('created_at', $provinceId);
    }

    # total province
    public function totalRecords()
    {
        return TfProvince::where('action', 1)->count();
    }

    #========== ========== ========= CHECK INFO ========== ========= ==========
    # check exist of name
    public function existName($name)
    {
        $result = TfProvince::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditName($name, $provinceId)
    {
        $result = TfProvince::where('province_id', '<>', $provinceId)->where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    # get info on map
    public function getLinkRun()
    {
        $modelLinkRun = new TfLinkRun();
        return $modelLinkRun->getInfo();
    }
    #========== ========== ========= BUILD 3D ========== ========= ==========
    # build 3D
    public function build3d($provinceId = '', $staffManageId = '')
    {
        $hFunction = new \Hfunction();
        $dateBegin = $hFunction->carbonNow();
        $dateEnd = $hFunction->carbonNowAddYears(10);

        # add license for manager
        $modelProvinceProperty = new TfProvinceProperty();
        $modelProvinceProperty->insert($dateBegin, $dateEnd, $provinceId, $staffManageId);

        # add detail area for province
        #DB::select(DB::raw("INSERT INTO tf_province_areas(province_id,area_id) SELECT $provinceId,area_id FROM tf_areas"));

        DB::statement("INSERT INTO tf_province_areas(province_id,area_id) SELECT $provinceId,area_id FROM tf_areas");

        # set default area (area) fo province
        TfProvinceArea::where('province_id', $provinceId)->where('area_id', 5101)->update(['defaultCenter' => 1]);


        # update build3d status for province
        $modelProvince = TfProvince::find($provinceId);
        $modelProvince->build3d = 1;
        $modelProvince->dateBuild3d = $dateBegin;
        $modelProvince->save();
    }

}
