<?php namespace App\Models\Manage\Content\System\Staff;

use App\Models\Manage\Content\Map\Project\Property\TfProjectProperty;
use App\Models\Manage\Content\Map\ProvinceProperty\TfProvinceProperty;
use App\Models\Manage\Content\System\StaffAccess\TfStaffAccess;
use App\Models\Manage\Content\System\StaffManage\TfStaffManage;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;
use DB;

class TfStaff extends Model
{

    protected $table = 'tf_staffs';
    protected $fillable = ['staff_id', 'nameCode', 'firstName', 'lastName', 'alias', 'account', 'password', 'birthday', 'gender', 'image', 'address'
        , 'phone', 'level', 'new', 'confirm', 'status', 'action', 'created_at', 'staffAdd_id', 'department_id', 'province_id', 'remember_token'];
    protected $primaryKey = 'staff_id';
    public $timestamps = false;

    private $lastId;

    #========== ========= ========= INSERT && UPDATE ========== ========= =========
    #---------- Insert ----------
    #create password for user
    public function createStaffPass($password, $nameCode)
    {
        return md5($nameCode . 'DTF') . md5('DTF' . $password . $nameCode);
    }

    # insert
    public function insert($firstName, $lastName, $account, $birthday = null, $gender, $image = null, $address = null, $phone = null,
                           $level, $staffAddId, $departmentId, $provinceId, $token = '')
    {
        $hFunction = new \Hfunction();
        $modelStaff = new TfStaff();
        #create code
        $nameCode = "3DTF" . $hFunction->getTimeCode();

        if ($level == 0) { # root staff of system
            $pass = '3dtf123456';
            $newPass = $this->createStaffPass($pass, $nameCode);
            $confirm = 1;
        } else {
            $newPass = $hFunction->random(6, 'int');
            $confirm = 0;
        }

        # insert
        $modelStaff->nameCode = $nameCode;
        $modelStaff->firstName = $firstName;
        $modelStaff->lastName = $lastName;
        $modelStaff->alias = $hFunction->alias($firstName . ' ' . $lastName, '-') . '-' . $hFunction->getTimeCode();
        $modelStaff->account = $account;
        $modelStaff->password = $newPass;
        $modelStaff->birthday = $birthday;
        $modelStaff->gender = $gender;
        $modelStaff->image = $image;
        $modelStaff->address = $address;
        $modelStaff->phone = $phone;
        $modelStaff->level = $level;
        $modelStaff->new = 1;
        $modelStaff->confirm = $confirm;
        $modelStaff->status = 1;
        $modelStaff->action = 1;
        $modelStaff->staffAdd_id = $staffAddId;
        $modelStaff->department_id = $departmentId;
        $modelStaff->province_id = $provinceId;
        $modelStaff->created_at = $hFunction->createdAt();
        $modelStaff->remember_token = $token;
        if ($modelStaff->save()) {
            $this->lastId = $modelStaff->staff_id;
            return true;
        } else {
            return false;
        }
    }

    # get new id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    #----------- Update -----------
    #Update
    public function confirmAccount($staffId, $password, $nameCode)
    {
        $objectStaff = TfStaff::find($staffId);
        $objectStaff->password = $this->createStaffPass($password, $nameCode);
        $objectStaff->new = 0;
        $objectStaff->confirm = 1;
        return $objectStaff->save();
    }

    # new info
    public function updateNew($staffId = null)
    {
        if (empty($staffId)) $staffId = $this->staffId();
        return TfStaff::where('staff_id', $staffId)->update(['new' => 0]);
    }

    # confirm
    public function updateConfirm($staffId = null)
    {
        if (empty($staffId)) $staffId = $this->staffId();
        return TfStaff::where('staff_id', $staffId)->update(['confirm' => 1]);
    }

    # status
    public function updateStatus($staffId, $status)
    {
        return TfStaff::where('staff_id', $staffId)->update(['status' => $status]);
    }

    # delete
    public function actionDelete($staffId = null)
    {
        if (empty($staffId)) $staffId = $this->staffId();
        return TfStaff::where('staff_id', $staffId)->update(['action' => 0]);
    }

    #========== ========= ========= RELATION ========== ========= ==========

    #*********** ************ SYSTEM ********** **********

    #---------- TF-STAFF-MANAGE -----------
    public function staffManage()
    {
        return $this->hasMany('App\Models\Manage\Content\System\StaffManage\TfStaffManage', 'staff_id', 'staff_id');
    }

    #---------- TF-STAFF-ACCESS -----------
    public function staffAccess()
    {
        return $this->hasMany('App\Models\Manage\Content\System\StaffAccess\TfStaffAccess', 'staff_id', 'staff_id');
    }

    #---------- TF-ABOUT -----------
    public function about()
    {
        return $this->hasMany('App\Models\Manage\Content\System\About\TfAbout', 'staff_id', 'staff_id');
    }

    #---------- TF-ADVISORY-REPLY -----------
    public function advisoryReply()
    {
        return $this->hasMany('App\Models\Manage\Content\System\Advisory\TfAdvisoryReply', 'staff_id', 'staff_id');
    }

    #---------- TF-LINK-RUN -----------
    public function linkRun()
    {
        return $this->hasMany('App\Models\Manage\Content\System\Link\TfLinkRun', 'staff_id', 'staff_id');
    }

    #---------- TF-COUNTY -----------
    public function countryManage()
    {
        return $this->belongsToMany('App\Models\Manage\Content\System\Country\TfCountry', 'App\Models\Manage\Content\Map\Country\TfCountryProperty', 'staff_id', 'country_id');
    }

    # ---------- TF-PROVINCE ---------
    public function province()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Province\TfProvince', 'province_id', 'province_id');
    }

    # ---------- TF-DEPARTMENT ---------
    public function department()
    {
        return $this->belongsTo('App\Models\Manage\Content\System\Department\TfDepartment', 'department_id', 'department_id');
    }

    #*********** ************ USER ********** **********

    # ---------- TF-RECHARGE ---------
    public function recharge()
    {
        return $this->hasMany('App\Models\Manage\Content\Users\Recharge\TfRecharge', 'staff_id', 'staff_id');
    }

    #*********** ************ MAP ********** **********

    #---------- TF-BANNER-BAD-INFO-REPORT -----------
    public function bannerBadInfoReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\BadInfoReport\TfBannerBadInfoReport', 'staff_id', 'staff_id');
    }

    #---------- TF-BANNER-COPYRIGHT-REPORT -----------
    public function bannerCopyrightReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Banner\CopyrightReport\TfBannerCopyrightReport', 'staff_id', 'staff_id');
    }

    #---------- TF-COUNTY-PROPERTY -----------
    public function countryProperty()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Country\TfCountryProperty', 'staff_id', 'staff_id');
    }

    # ---------- TF-PROVINCE-PROPERTY ---------
    public function provinceProperty()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\ProvinceProperty\TfProvinceProperty', 'staff_id', 'staff_id');
    }

    # ---------- TF-PROJECT-PROPERTY ---------
    public function projectProperty()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Project\Property\TfProjectProperty', 'staff_id', 'staff_id');
    }

    # ---------- TF-REQUEST-BUILD-PRICE ---------
    public function requestBuildPrice()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\RequestBuildPrice\TfRequestBuildPrice', 'staff_id', 'staff_id');
    }

    # ---------- TF-LAND-REQUEST-BUILD-DESIGN ---------
    public function landRequestBuildDesign()
    {
        return $this->hasMany('App\Models\Manage\Content\Map\Land\RequestBuildDesign\TfLandRequestBuildDesign', 'staff_id', 'staff_id');
    }


    #*********** ************ HELP ********** **********

    # ---------- TF-HELP-CONTENT ---------
    public function helpContent()
    {
        return $this->hasMany('App\Models\Manage\Content\Help\Content\TfHelpContent', 'staff_id', 'staff_id');
    }

    #*********** ************ BUILDING ********** **********

    #----------- TF-BUILDING-POST-INFO-REPORT -----------
    public function buildingPostInfoReport()
    {
        return $this->hasMany('App\Models\Manage\Content\Building\Post\TfBuildingPostInfoReport', 'staff_id', 'staff_id');
    }

    #*********** ************ SELLER ********** **********

    # ---------- TF-SELLER-PAYMENT-DETAIL ---------
    public function sellerPaymentDetail()
    {
        return $this->hasMany('App\Models\Manage\Content\Seller\Payment\TfSellerPaymentDetail', 'staff_id', 'staff_id');
    }

    #*********** ************ SAMPLE ********** **********

    # ---------- TF-PROJECT-SAMPLE ---------
    public function projectSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Project\TfProjectSample', 'project_id', 'project_id');
    }

    # ---------- TF-BANNER-SAMPLE ---------
    public function bannerSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Banner\TfBannerSample', 'staff_id', 'staff_id');
    }

    #----------- TF-BUILDING-SAMPLE -----------
    public function buildingSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Building\TfBuildingSample', 'staff_id', 'staff_id');
    }

    #----------- TF-LAND-ICON-SAMPLE -----------
    public function landIconSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Land\TfLandIconSample', 'staff_id', 'staff_id');
    }

    #----------- TF-PROJECT-ICON-SAMPLE -----------
    public function projectIconSample()
    {
        return $this->hasMany('App\Models\Manage\Content\Sample\Project\TfProjectIconSample', 'staff_id', 'staff_id');
    }

    #========== ========== ========== LOGIN ========== ========== ==========
    public function login($account = '', $password = '')
    {
        //$passLog = Hash::make($pass);
        $nameCode = TfStaff::where('account', $account)->pluck('nameCode');
        $passLog = $this->createStaffPass($password, $nameCode);
        $staff = TfStaff::where('account', $account)->where('password', $passLog)->first();
        if (!empty($staff)) { # login success
            Session::put('loginStaff', $staff);
            return true;
        } else {
            return false;
        }
    }

    # check login ->return true\false
    public function checkLogin()
    {
        if (Session::has('loginStaff')) return true; else return false;
    }

    # info login
    public function loginStaffInfo($field = '')
    {
        if (Session::has('loginStaff')) { # logged
            $staff = Session::get('loginStaff');
            if (empty($field)) { # have not to select a field -> return all field
                return $staff;
            } else { // # have not to select a field -> return one field
                return $staff->$field;
            }
        } else { # have not to login
            return null;
        }
    }

    # staff id login
    public function loginStaffID()
    {
        return $this->loginStaffInfo('staff_id');
    }

    #========== ========== ========== LOGOUT ========= ========== ==========
    public function logout()
    {
        $hFunction = new \Hfunction();
        $modelStaffAccess = new TfStaffAccess();
        $loginStaffId = $this->loginStaffID();
        $modelStaffAccess->updateAction($loginStaffId); # disable old access status
        if (!empty($loginStaffId)) $modelStaffAccess->insert($hFunction->getClientIP(), 2, $loginStaffId);
        return Session::flush();
    }

    #========= ========== ========== GET INFO ========== ========== ==========
    public function getInfo($staffId = '', $field = '')
    {
        if (empty($staffId)) {
            return TfStaff::where('action', 1)->get();
        } else {
            $result = TfStaff::where('staff_id', $staffId)->first();
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
        $dataStaff = DB::select("select staff_id as optionKey, CONCAT(firstName,lastName) as optionValue from tf_staffs ");
        return $hFunction->option($dataStaff, $selected);
    }

    # ---------- TF-DEPARTMENT ---------
    # get root staff id of department
    public function rootStaffOfDepartment($departmentId)
    {
        return TfStaff::where('department_id', $departmentId)->where('action', 1)->where('level', 0)->pluck('staff_id');
    }

    # ---------- TF-STAFF-MANAGE ---------
    #manage staff info by department
    public function infoManageByDepartment($departmentId = null)
    {
        if (!empty($department)) {
            return TfStaff::where('department_id', $departmentId)->where('level', 1)->select('staff_id as optionKey', 'account as optionValue')->get()->toArray();
        }
    }

    # get info on condition
    public function manager($staffId = null)
    {
        $modelStaffManage = new TfStaffManage();
        if (empty($staffId)) $staffId = $this->staffId();
        return $modelStaffManage->managerOfStaff($staffId);
    }

    public function listStaffManage($staffId = null)
    {
        $modelStaffManage = new TfStaffManage();
        if (empty($staffId)) $staffId = $this->staffId();
        return $modelStaffManage->listStaffManage($staffId);
    }

    public function infoListOfManageStaff($staffId = null)
    {
        $listStaff = $this->listStaffManage($staffId);
        return TfStaff::whereIn('staff_id', $listStaff)->get();
    }

    public function optionListOfStaff($staffId = null, $selected=null)
    {
        $hFunction = new \Hfunction();
        $listStaff = $this->listStaffManage($staffId);
        return $hFunction->option(TfStaff::whereIn('staff_id', $listStaff)->select('staff_id as optionKey', 'account as optionValue')->get()->toArray(), $selected);
    }

    # ---------- ---------- STAFF INFO --------- -------
    public function staffId()
    {
        return $this->staff_id;
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfStaff::where('staff_id', $objectId)->pluck($column);
        }
    }

    public function fullName($staffId = null)
    {
        if (empty($staffId)) {
            return $this->lirstName . ' ' . $this->lastName;
        } else {
            $staff = TfStaff::find($staffId);
            return (!empty($staff)) ? $staff->firstName . ' ' . $staff->lastName : '';
        }
    }

    public function firstName($staffId = null)
    {
        return $this->pluck('firstName', $staffId);
    }

    public function lastName($staffId = null)
    {
        return $this->pluck('lastName', $staffId);
    }

    public function alias($staffId = null)
    {
        return $this->pluck('alias', $staffId);
    }

    public function nameCode($staffId = null)
    {
        return $this->pluck('nameCode', $staffId);
    }

    public function account($staffId = null)
    {
        return $this->pluck('account', $staffId);
    }

    public function birthday($staffId = null)
    {

        return $this->pluck('birthday', $staffId);
    }

    public function departmentId($staffId = null)
    {
        return $this->pluck('department_id', $staffId);
    }

    public function provinceId($staffId = null)
    {
        return $this->pluck('province_id', $staffId);
    }

    public function createdAt($staffId = null)
    {
        return $this->pluck('created_at', $staffId);
    }

    public function level($staffId = null)
    {
        return $this->pluck('level', $staffId);
    }

    public function image($staffId = null)
    {
        return $this->pluck('image', $staffId);
    }

    # get path image
    public function pathSmallImage($image)
    {
        if (empty($image)) {
            return asset('public/main/icons/people.jpeg');
        } else {
            return asset('public/images/system/staff/small/' . $image);
        }
    }

    public function pathFullImage($image)
    {
        if (empty($image)) {
            return asset('public/main/icons/people.jpeg');
        } else {
            return asset('public/images/system/staff/full/' . $image);
        }
    }

    public function phone($staffId = null)
    {
        return $this->pluck('phone', $staffId);
    }

    public function address($staffId = null)
    {
        return $this->pluck('address', $staffId);
    }

    public function newInfo($staffId = null)
    {
        return $this->pluck('new', $staffId);
    }

    public function gender($staffId = null)
    {
        return $this->pluck('gender', $staffId);
    }

    public function confirm($staffId = null)
    {
        return $this->pluck('confirm', $staffId);
    }

    public function status($staffId = null)
    {
        return $this->pluck('status', $staffId);
    }

    # get info verification
    public function getInfoVerification($account, $verificationCode)
    {
        if (empty($account) && empty($verificationCode)) {
            return null;
        } else {
            $result = TfStaff::where('account', $account)->where('password', $verificationCode)->first();
            return (!empty($result)) ? $result : null;
        }
    }

    # total records
    public function totalRecords()
    {
        return TfStaff::where('action', 1)->count();
    }

    # last id
    public function lastId()
    {
        $result = TfStaff::orderBy('staff_id', 'DESC')->first();
        return (empty($result)) ? 0 : $result->staff_id;
    }

    #========== ========== ========= CHECK INFO ========== ========= =========
    # exist of account
    public function existAccount($account)
    {
        $staff = TfStaff::where('account', $account)->count();
        return ($staff > 0) ? true : false;
    }

    # system department
    public function checkDepartmentSystem($staffId = null)
    {
        if (empty($staffId)) $staffId = $this->staffId();
        return ($this->departmentId($staffId) == 1) ? true : false;
    }

    # build department
    public function checkDepartmentBuild($staffId = null)
    {
        if (empty($staffId)) $staffId = $this->staffId();
        return ($this->departmentId($staffId) == 5) ? true : false;
    }

    # design department
    public function checkDepartmentDesign($staffId = null)
    {
        if (empty($staffId)) $staffId = $this->staffId();
        return ($this->departmentId($staffId) == 6) ? true : false;
    }

    # business department
    public function checkDepartmentBusiness($staffId = null)
    {
        if (empty($staffId)) $staffId = $this->staffId();
        return ($this->departmentId($staffId) == 7) ? true : false;
    }

    # financial department
    public function checkDepartmentFinancial($staffId = null)
    {
        if (empty($staffId)) $staffId = $this->staffId();
        return ($this->departmentId($staffId) == 8) ? true : false;
    }

    public function checkManageProject($projectId, $staffId = null)
    {
        $modelProjectProperty = new TfProjectProperty();
        if (empty($staffId)) $staffId = $this->staffId();
        return $modelProjectProperty->checkStaffManageProject($staffId, $projectId);
    }

    #========== ========== ========= ACCESS INFO ========== ========= =========
    public function provincePropertyLogin($staffId = null)
    {
        $modelProperty = new TfProvinceProperty();
        if (empty($staffId)) $staffId = $this->staffId();
        return $modelProperty->accessProperty($staffId);
    }

    public function projectPropertyLogin($staffId = null)
    {
        $modelProperty = new TfProjectProperty();
        if (empty($staffId)) $staffId = $this->staffId();
        return $modelProperty->accessProperty($staffId);
    }

    public function listProvinceId($staffId = null)
    {
        $modelProperty = new TfProvinceProperty();
        if (empty($staffId)) $staffId = $this->staffId();
        return $modelProperty->listProvinceOfStaff($staffId);
    }

    public function listProjectId($staffId = null)
    {
        $modelProperty = new TfProjectProperty();
        if (empty($staffId)) $staffId = $this->staffId();
        return $modelProperty->listProjectOfStaff($staffId);
    }
}
