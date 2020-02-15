<?php namespace App\Http\Controllers\Manage\Content\Sample\BuildingSampleCopyright;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class BuildingCopyrightController extends Controller {

	public function getList(){
        return view('manage.content.sample.building-copyright.list');
    }

}
