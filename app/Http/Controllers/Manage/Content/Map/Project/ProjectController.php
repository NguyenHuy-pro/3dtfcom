<?php namespace App\Http\Controllers\Manage\Content\Map\Project;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\Project\TfProject;
use App\Models\Manage\Content\Map\ProvinceArea\TfProvinceArea;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelProvinceArea = new TfProvinceArea();
        $modelProject = new TfProject();
        $dataProject = TfProject::where('action', 1)->orderBy('project_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'project';
        return view('manage.content.map.project.project.list', compact('modelStaff', 'modelProvinceArea', 'modelProject', 'dataProject', 'accessObject'));
    }

    #View
    public function viewProject($projectId)
    {
        $modelProvinceArea = new TfProvinceArea();
        $dataProject = TfProject::find($projectId);
        if (count($dataProject) > 0) {
            return view('manage.content.map.project.project.view', compact('modelProvinceArea', 'dataProject'));
        }
    }

    # update status
    public function updateStatus($projectId)
    {
        $modelProject = new TfProject();
        if (!empty($projectId)) {
            $currentStatus = $modelProject->getInfo($projectId, 'status');
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelProject->updateStatus($projectId, $newStatus);
        }
    }

    #Delete
    public function deleteProject($projectId)
    {
        $modelProject = new TfProject();
        $modelProject->getDelete($projectId);
    }

}
