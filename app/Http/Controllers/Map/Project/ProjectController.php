<?php namespace App\Http\Controllers\Map\Project;

use App\Http\Requests;
use App\Http\Controllers\Controller;

//use Illuminate\Http\Request;
use DB,File,Request;

class ProjectController extends Controller {
    public function getEditAvatar($projectId=null){
        return view('map.project.avatar-edit');
    }
}
