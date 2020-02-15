<?php namespace App\Models\Manage\Content\Map\Project\License;

use Illuminate\Database\Eloquent\Model;
use DB;

class TfProjectLicense extends Model
{

    protected $table = 'tf_project_licenses';
    protected $fillable = ['license_id', 'name', 'dateBegin', 'dateEnd', 'status', 'action', 'project_id', 'user_id', 'created_at'];
    protected $primaryKey = 'license_id';
    public $timestamps = false;
    private $lastId;

    #========= ======== ========= INSERT && UPDATE ========= ======== =========
    #----------- Insert -----------
    public function insert($dateBegin, $dateEnd, $projectId, $userId)
    {
        $hFunction = new \Hfunction();
        $modelLicense = new TfProjectLicense();
        $name = 'PL' . $hFunction->getTimeCode();
        $modelLicense->name = $name;
        $modelLicense->dateBegin = $dateBegin;
        $modelLicense->dateEnd = $dateEnd;
        $modelLicense->status = 1; # default
        $modelLicense->action = 1; # default
        $modelLicense->project_id = $projectId;
        $modelLicense->user_id = $userId;
        $modelLicense->created_at = $hFunction->createdAt();
        if ($modelLicense->save()) {
            $this->lastId = $modelLicense->license_id;
            return true;
        } else {
            return false;
        }
    }

    # get new id
    public function insertGetId()
    {
        return $this->lastId;
    }

    #----------- Update -----------
    public function updateStatus($licenseId, $status)
    {
        return TfProjectLicense::where('license_id', $licenseId)->update(['status' => $status]);
    }

    public function actionDelete($licenseId = null)
    {
        if (empty($licenseId)) $licenseId = $this->licenseId();
        return TfProjectLicense::where('license_id', $licenseId)->update(['action' => 0]);
    }

    #delete by project (when delete project)
    public function actionDeleteByProject($projectId = null)
    {
        if (!empty($projectId)) {
            $objectId = TfProjectLicense::where(['project_id' => $projectId, 'action' => 1])->pluck('license_id');
            if(!empty($objectId)){
                $this->actionDelete($objectId);
            }
        }
    }

    #============ ============ ============ RELATION =========== ============ ============
    # ---------- TF-PROJECT ----------
    public function project()
    {
        return $this->belongsTo('App\Models\Manage\Content\Map\Project\TfProject', 'project_id', 'project_id');
    }

    # ---------- TF-USER ----------
    public function user()
    {
        return $this->belongsTo('App\Models\Manage\Content\Users\TfUser', 'user_id', 'user_id');
    }

    # ---------- TF-PROJECT-LICENSE-CANCEL ----------
    public function projectLicenseCancel()
    {
        return $this->hasOne('App\Models\Manage\Content\Map\Project\LicenseCancel\TfProjectLicenseCancel', 'license_id', 'license_id');
    }

    # ---------- TF-PROJECT-LICENSE-EXPIRY ----------
    public function projectLicenseExpiry()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\LicenseExpiry\TfProjectLicenseExpiry', 'license_id', 'license_id');
    }

    #========== ======== =========  GET INFO ========== ======== =========
    public function getInfo($licenseId = '', $field = '')
    {
        if (empty($licenseId)) {
            return TfProjectLicense::where('action', 1)->get();
        } else {
            $result = TfProjectLicense::where('license_id', $licenseId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    # only license is using of a project
    public function infoOfProject($projectId)
    {
        return TfProjectLicense::where('project_id', $projectId)->where('action', 1)->first();
    }

    # exist project. (user bought)
    public function existProject($projectId)
    {
        $result = TfProjectLicense::where('project_id', $projectId)->where('action', 1)->count();
        return ($result > 0) ? true : false;
    }

    #----------- INFO ----------------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfProjectLicense::where('license_id', $objectId)->pluck($column);
        }
    }

    public function licenseId()
    {
        return $this->license_id;
    }


    public function name($licenseId = null)
    {
        return $this->pluck('name', $licenseId);
    }

    public function dateBegin($licenseId = null)
    {
        return $this->pluck('dateBegin', $licenseId);
    }

    public function dateEnd($licenseId = null)
    {
        return $this->pluck('dateEnd', $licenseId);
    }

    public function status($licenseId = null)
    {
        return $this->pluck('status', $licenseId);
    }

    public function projectId($licenseId = null)
    {
        return $this->pluck('project_id', $licenseId);
    }

    public function userId($licenseId = null)
    {
        return $this->pluck('user_id', $licenseId);
    }

    public function createdAt($licenseId = null)
    {
        return $this->pluck('created_at', $licenseId);
    }

    # inspect projects under its management staff.
    public function checkExistProject($projectId)
    {
        $result = TfProjectLicense::where('project_id', $projectId)->where('action', 1)->count();
        return ($result > 0) ? true : false;
    }

    # Last id
    public function lastId()
    {
        $objectLicense = TfProjectLicense::orderBy('license_id', 'DESC')->first();
        return (empty($objectLicense)) ? 0 : $objectLicense->license_id;
    }

    # total records
    public function totalRecords()
    {
        return TfProjectLicense::count();
    }

    #========= ========= access map ========== ==========

    # get license info of user login (only one license)
    public function accessLicenseOfUser($userId)
    {
        return TfProjectLicense::where('user_id', $userId)->where('action', 1)->orderBy('license_id', 'DESC')->first();
    }
}
