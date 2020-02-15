<?php namespace App\Models\Manage\Content\Ads\Page;

use App\Models\Manage\Content\Ads\Banner\TfAdsBanner;
use Illuminate\Database\Eloquent\Model;

class TfAdsPage extends Model
{

    protected $table = 'tf_ads_pages';
    protected $fillable = ['page_id', 'name', 'status', 'action', 'created_at'];
    protected $primaryKey = 'page_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    //---------- Insert ----------
    public function insert($name)
    {
        $hFunction = new \Hfunction();
        $modelPage = new TfAdsPage();
        $modelPage->name = $name;
        $modelPage->created_at = $hFunction->createdAt();
        if ($modelPage->save()) {
            $this->lastId = $modelPage->page_id;
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

    #---------- Update ----------
    public function updateInfo($pageId, $name)
    {
        return TfAdsPage::where('page_id', $pageId)->update([
            'name' => $name
        ]);
    }

    public function updateStatus($pageId, $status)
    {
        return TfAdsPage::where('page_id', $pageId)->update(['status' => $status]);
    }


    //delete
    public function actionDelete($pageId = null)
    {
        $modelAdsBanner = new TfAdsBanner();
        if (empty($pageId)) $pageId = $this->typeId();
        if (TfAdsPage::where('page_id', $pageId)->update(['action' => 0])) {
            $modelAdsBanner->actionDeleteByPage($pageId);
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    #---------- TF-ADS-BANNER ----------
    public function adsBanner()
    {
        return $this->hasMany('App\Models\Manage\Content\Ads\Banner\TfAdsBanner', 'page_id', 'page_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($objectId = '', $field = '')
    {
        if (empty($objectId)) {
            return TfAdsPage::where('action', 1)->where('status', 1)->get();
        } else {
            $result = TfAdsPage::where('page_id', $objectId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }


    //create option of select
    public function getOption($selected = '')
    {
        $hFunction = new \Hfunction();
        $result = TfAdsPage::select('page_id as optionKey', 'name as optionValue')->get()->toArray();
        return $hFunction->option($result, $selected);
    }

    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfAdsPage::where('page_id', $objectId)->pluck($column);
        }
    }

    public function pageId()
    {
        return $this->page_id;
    }

    public function name($pageId = null)
    {
        return $this->pluck('name', $pageId);
    }

    public function status($pageId = null)
    {
        return $this->pluck('status', $pageId);
    }

    public function createdAt($pageId = null)
    {
        return $this->pluck('created_at', $pageId);
    }

    //total records -->return number
    public function totalRecords()
    {
        return TfAdsPage::where('action', 1)->count();
    }

    public function userPageId()
    {
        return TfAdsPage::where(['page_id' => 2])->pluck('page_id'); //1 of user page
    }

    public function buildingPageId()
    {
        return TfAdsPage::where(['page_id' =>1])->pluck('page_id'); //2 of building page
    }


    #========== ========== ========== check info ========== ========== ==========
    //check exist of name
    public function existName($name)
    {
        $result = TfAdsPage::where('name', $name)->count();
        return ($result > 0) ? true : false;
    }

    public function existEditName($name, $pageId)
    {
        $result = TfAdsPage::where('name', $name)->where('page_id', '<>', $pageId)->count();
        return ($result > 0) ? true : false;
    }

}
