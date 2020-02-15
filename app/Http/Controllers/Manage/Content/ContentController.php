<?php namespace App\Http\Controllers\Manage\Content;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Manage\Content\System\Staff\TfStaff;

class ContentController extends Controller
{
    // control panel
    public function index()
    {
        $modelStaff = new TfStaff();
        if ($modelStaff->checkLogin()) {
            $dataStaff = $modelStaff->loginStaffInfo();
            return view('manage.panel', compact('dataStaff'));
        }
    }

    // system
    public function getSystem($object = null)
    {
        return view('manage.content.system.index', compact('object'));
    }

    // map
    public function getMap($object = null)
    {
        return view('manage.content.map.index', compact('object'));
    }

    // user
    public function getUser($object = null)
    {
        return view('manage.content.user.index', compact('object'));
    }

    // building
    public function getBuilding($object = null)
    {
        return view('manage.content.building.index', compact('object'));
    }

    // design
    public function getDesign($object = null)
    {
        return view('manage.content.design.index', compact('object'));
    }

    // sample tool
    public function getSample($object = null)
    {
        return view('manage.content.sample.index', compact('object'));
    }

    // help
    public function getHelp($object = null)
    {
        return view('manage.content.help.index', compact('object'));
    }

    // ad
    public function getAds($object = null)
    {
        return view('manage.content.ads.index', compact('object'));
    }

    // ad
    public function getSeller($object = null)
    {
        return view('manage.content.seller.index', compact('object'));
    }
}
