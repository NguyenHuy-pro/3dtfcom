<?php namespace App\Http\Controllers\Design;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class DesignController extends Controller {
    public function index($name='',$objectID = ''){
        $modelUser = new TfUser();
        $name = 'storeDesign';
        $nameStore = 'design';
        return view('design.store.store',compact('modelUser', 'name','nameStore','objectID'));
        //return view('design.index',compact('name','objectID'));
    }
    public function getStore($nameStore='',$objectID = ''){
        $modelUser = new TfUser();
        $name = 'storeDesign';
        //return view('design.store',compact('name','nameStore','objectID'));
        return view('design.store.store',compact('modelUser', 'name','nameStore','objectID'));
    }
    public function getShop($nameTypeBuisness='',$objectID = ''){
        $modelUser = new TfUser();
        $name = 'shopDesign';
        return view('design.shop.shop',compact('modelUser', 'name','$nameTypeBuisness','objectID'));
    }
    public function getSystem($nameSystem='',$objectID = ''){
        $modelUser = new TfUser();
        $name = 'systemDesign';
        return view('design.system.system',compact('modelUser', 'name','nameSystem','objectID'));
    }
    public function getUpload($nameUpload='',$areaID=''){
        $modelUser = new TfUser();
        $name = 'uploadDesign';
        return view('design.upload.upload',compact('modelUser', 'name','nameUpload','areaID'));
    }
    public function getRequest($nameRequest='',$areaID=''){
        $modelUser = new TfUser();
        $name = 'requestDesign';
        return view('design.request.request',compact('modelUser', 'name','nameRequest','areaID'));
    }
    public function getConfirm($nameConfirm=''){
        $modelUser = new TfUser();
        $name = 'confirmDesign';
        return view('design.confirm.confirm',compact('modelUser', 'name','nameConfirm'));
    }
}
