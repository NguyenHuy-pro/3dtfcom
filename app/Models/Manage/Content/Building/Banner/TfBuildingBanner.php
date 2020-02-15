<?php namespace App\Models\Manage\Content\Building\Banner;

use App\Models\Manage\Content\Users\Activity\TfUserActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;


class TfBuildingBanner extends Model
{

    protected $table = 'tf_building_banners';
    protected $fillable = ['banner_id', 'name', 'image', 'useStatus', 'action', 'created_at', 'building_id'];
    protected $primaryKey = 'banner_id';
    public $timestamps = false;

    private $lastId;

    #========== ========== ========== INSERT && UPDATE ========== ========== ==========
    #---------- ---------- Insert ---------- ----------
    public function insert($image, $buildingId)
    {
        $hFunction = new \Hfunction();
        $modelBuildingBanner = new TfBuildingBanner();
        # get old banner if it exists
        $oldBannerId = $this->bannerIdOfBuilding($buildingId);
        $modelBuildingBanner->name = 'BUI-BAN-' . $hFunction->getTimeCode();
        $modelBuildingBanner->image = $image;
        $modelBuildingBanner->building_id = $buildingId;
        $modelBuildingBanner->created_at = $hFunction->createdAt();
        if ($modelBuildingBanner->save()) {
            $this->lastId = $modelBuildingBanner->banner_id;

            #only exists a banner of building is using.
            if (!empty($oldBannerId)) {
                $this->updateUseStatus($oldBannerId, 0);
            }
            return true;
        } else {
            return false;
        }
    }

    //get new banner id after insert
    public function insertGetId()
    {
        return $this->lastId;
    }

    //upload image
    public function uploadImage($file, $imageName)
    {
        $hFunction = new \Hfunction();
        $pathFullImage = "public/images/building/banners/full";
        $pathSmallImage = "public/images/building/banners/small";
        if (!is_dir($pathFullImage)) mkdir($pathFullImage);
        if (!is_dir($pathSmallImage)) mkdir($pathSmallImage);
        return $hFunction->uploadSave($file, $pathSmallImage . '/', $pathFullImage . '/', $imageName, 200);
    }

    //drop image
    public function dropImage($imageName)
    {
        File::delete('public/images/building/banners/small/' . $imageName);
        File::delete('public/images/building/banners/full/' . $imageName);
    }

    #---------- Update -----------
    # update status
    public function updateUseStatus($bannerId, $status)
    {
        return TfBuildingBanner::where('banner_id', $bannerId)->update(['useStatus' => $status]);
    }

    //delete (only disable)
    public function actionDelete($bannerId = null)
    {
        $modelUserActivity = new TfUserActivity();
        if (TfBuildingBanner::where('banner_id', $bannerId)->update(['action' => 0, 'useStatus' => 0])) {
            $modelUserActivity->deleteByBuildingBanner($bannerId);
        }
    }

    #when delete building
    public function actionDeleteByBuilding($buildingId = null)
    {
        if (!empty($buildingId)) {
            $listId = TfBuildingBanner::where(['building_id' => $buildingId, 'action' => 1])->lists('banner_id');
            if (!empty($listId)) {
                foreach ($listId as $value) {
                    $this->actionDelete($value);
                }
            }
        }
    }

    #========== ========== ========== RELATION ========== ========== ==========
    public function userActivity()
    {
        return $this->hasOne('App\Models\Manage\Content\Users\Activity\TfUserActivity', 'banner_id', 'buildingBanner_id');
    }

    #---------- TF-BUILDING ----------
    public function building()
    {
        return $this->belongsTo('App\Models\Manage\Content\Building\TfBuilding', 'building_id', 'building_id');
    }

    # disable banner of building
    public function disableOfBuilding($buildingId)
    {
        return TfBuildingBanner::where('building_id', $buildingId)->where('useStatus', 1)->update(['useStatus' => 0]);
    }

    #get banner info is enable of building
    public function infoUsingOfBuilding($buildingId)
    {
        return TfBuildingBanner::where('building_id', $buildingId)->where('useStatus', 1)->first();
    }

    #get image is using of building
    public function imageUsingOfBuilding($buildingId)
    {
        return TfBuildingBanner::where('building_id', $buildingId)->where('useStatus', 1)->pluck('image');
    }

    #get banner id is using of building
    public function bannerIdOfBuilding($buildingId)
    {
        return TfBuildingBanner::where('building_id', $buildingId)->where('useStatus', 1)->pluck('banner_id');
    }

    #========== ========== ========== GET INFO ========== ========== ==========
    public function getInfo($bannerId = null, $field = null)
    {
        if (empty($bannerId)) {
            return TfBuildingBanner::where('action', 1)->get();
        } else {
            $result = TfBuildingBanner::where('banner_id', $bannerId)->first();
            if (empty($field)) {
                return $result;
            } else {
                return $result->$field;
            }
        }
    }

    #---------- -----------  INFO ---------- ----------
    public function pluck($column, $objectId = null)
    {
        if (empty($objectId)) {
            return $this->$column;
        } else {
            return TfBuildingBanner::where('banner_id', $objectId)->pluck($column);
        }
    }

    public function bannerId()
    {
        return $this->banner_id;
    }

    public function name($bannerId = null)
    {
        return $this->pluck('name', $bannerId);
    }

    public function image($bannerId = null)
    {
        return $this->pluck('image', $bannerId);
    }

    public function useStatus($bannerId = null)
    {
        return $this->pluck('useStatus', $bannerId);
    }

    public function buildingId($bannerId = null)
    {
        return $this->pluck('building_id', $bannerId);
    }

    public function createdAt($bannerId = null)
    {
        return $this->pluck('created_at', $bannerId);
    }

    # total
    public function totalRecords()
    {
        return TfBuildingBanner::where('action', 1)->count();
    }

    public function pathSmallImage($image = null)
    {
        if (empty($image)) $image = $this->image;
        return asset("public/images/building/banners/small/$image");

    }

    public function pathFullImage($image = null)
    {
        if (empty($image)) $image = $this->image;
        return asset("public/images/building/banners/full/$image");
    }
}
