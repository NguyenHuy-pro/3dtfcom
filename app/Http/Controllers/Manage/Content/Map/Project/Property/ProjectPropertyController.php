<?php namespace App\Http\Controllers\Manage\Content\Map\Project\Property;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Project\Property\TfProjectProperty;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class ProjectPropertyController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelProjectProperty = new TfProjectProperty();
        $dataProjectProperty = TfProjectProperty::where('action', 1)->orderBy('property_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'province';
        return view('manage.content.map.project.property.list', compact('modelStaff', 'modelProjectProperty', 'dataProjectProperty', 'accessObject'));
    }

    #View
    public function viewProjectProperty($propertyId)
    {
        $dataProjectProperty = TfProjectProperty::find($propertyId);
        if (count($dataProjectProperty) > 0) {
            return view('manage.content.map.project.property.view', compact('dataProjectProperty'));
        }
    }

}
