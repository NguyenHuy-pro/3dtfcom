<?php namespace App\Models\Manage\Content\Building\ShareView;

use App\Models\Manage\Content\Building\Share\TfBuildingShare;
use App\Models\Manage\Content\Seller\TfSeller;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class TfBuildingShareView extends Model
{

    protected $table = 'tf_building_share_views';
    protected $fillable = ['view_id', 'accessIP', 'register', 'created_at', 'share_id'];
    protected $primaryKey = 'view_id';
    public $timestamps = false;


    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #----------- Insert -----------
    #add new
    public function insert($accessIP, $shareId)
    {
        $hFunction = new \Hfunction();
        $modelSeller = new TfSeller();
        $modelBuildingShare = new TfBuildingShare();
        $modelShareView = new TfBuildingShareView();
        $modelShareView->accessIP = $accessIP;
        $modelShareView->share_id = $shareId;
        $modelShareView->register = 0;
        $modelShareView->created_at = $hFunction->carbonNow();
        if ($modelShareView->save()) {
            //statistic for seller
            $dataBuildingShare = $modelBuildingShare->getInfo($shareId);
            $userShareId = $dataBuildingShare->userId();
            if ($modelSeller->checkExistUser($userShareId)) $modelSeller->plusBuildingShareAccessOfUser($userShareId);

            #Mark first visits.
            Session::put('buildingShareView', $modelShareView->view_id);
            return true;
        }

    }

    # check have to exist visit
    public function existAccessCode()
    {
        if (Session::has('buildingShareView')) return true; else return false;
    }

    # get access code of visitor
    public function newAccessCode()
    {
        if (Session::has('buildingShareView')) {
            return Session::get('buildingShareView');
        } else {
            return null;
        }
    }


    #----------- Update -----------
    # action status
    public function updateRegister($newUserId, $viewId = null)
    {
        $modelUser = new TfUser();
        $modelSeller = new TfSeller();
        if (empty($viewId)) $viewId = $this->viewId();
        $dataView = $this->getInfo($viewId);
        if (TfBuildingShareView::where('view_id', $viewId)->update(['register' => 1])) {
            //statistic for seller
            $dataBuildingShare = $dataView->buildingShare;
            $userShareId = $dataBuildingShare->userId();
            if ($modelSeller->checkExistUser($userShareId)) $modelSeller->plusBuildingShareRegisterOfUser($userShareId);
            //update introduce user
            $modelUser->updateUserIntroduce($userShareId, $newUserId);
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #----------- TF-BUILDING-SHARE -----------
    public function buildingShare()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\Share\TfBuildingShare', 'share_id', 'share_id');
    }

    #========== ========= ========= CHECK INFO ========= ========= =========
    #---------- TF-BUILDING-SHARE ----------
    public function existViewOfShareId($shareId)
    {
        if ($this->existAccessCode()) {
            $viewId = $this->newAccessCode();
            $dataView = TfBuildingShareView::find($viewId);
            # visit another share
            if ($dataView->shareId() != $shareId) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    # info of share
    public function infoByShare($shareId = null, $take = null, $dateTake = null)
    {
        if (empty($shareId)) {
            return null;
        } else {
            if (empty($take) && empty($dataTake)) {
                return TfBuildingShareView::where('share_id', $shareId)->orderBy('created_at', 'DESC')->get();
            } else {
                return TfBuildingShareView::where('share_id', $shareId)->where('created_at', '<', $dateTake)->orderBy('created_at', 'DESC')->skip(0)->take($take)->get();
            }
        }
    }

    #total view
    public function totalViewByShare($shareId)
    {
        return TfBuildingShareView::where('share_id', $shareId)->count();
    }

    #total view and register
    public function totalViewRegisterByShare($shareId)
    {
        return TfBuildingShareView::where(['share_id' => $shareId, 'register' => 1])->count();
    }

    #========== ========= ========= GET INFO ========= ========= =========
    public function getInfo($viewId = null, $field = null)
    {
        if (empty($viewId)) {
            return TfBuildingShareView::get();
        } else {
            $result = TfBuildingShareView::where(['view_id' => $viewId])->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuildingShareView::where('view_id', $objectId)->pluck($column);
        }
    }

    public function viewId()
    {
        return $this->view_id;
    }

    public function accessIP($viewId = null)
    {
        return $this->pluck('accessIP', $viewId);
    }

    public function register($viewId = null)
    {
        return $this->pluck('register', $viewId);
    }

    public function createdAt($viewId = null)
    {
        return $this->pluck('created_at', $viewId);
    }

    public function shareId($viewId = null)
    {
        return $this->pluck('share_id', $viewId);
    }

    # total records
    public function totalRecords()
    {
        return TfBuildingShareView::count();
    }
}
