<?php namespace App\Http\Controllers\Manage\Content\Map\ProvinceProperty;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\ProvinceProperty\TfProvinceProperty;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class ProvincePropertyController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelProvinceProperty = new TfProvinceProperty();
        $dataProvinceProperty = TfProvinceProperty::where('action', 1)->orderBy('property_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'province';
        return view('manage.content.map.province-property.list', compact('modelStaff', 'modelProvinceProperty', 'dataProvinceProperty', 'accessObject'));
    }

    #View
    public function viewProvinceProperty($propertyId)
    {
        $dataProvinceProperty = TfProvinceProperty::find($propertyId);
        if (count($dataProvinceProperty) > 0) {
            return view('manage.content.map.province-property.view', compact('dataProvinceProperty'));
        }
    }

}
