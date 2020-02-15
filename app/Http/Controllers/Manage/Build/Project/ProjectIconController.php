<?php namespace App\Http\Controllers\Manage\Build\Project;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Manage\Content\Map\Project\Icon\TfProjectIcon;
use App\Models\Manage\Content\Sample\ProjectIcon\TfProjectIconSample;

//use Illuminate\Http\Request;

class ProjectIconController extends Controller
{
    #get icon sample
    public function getIconEdit($iconId = '', $iconSampleId = '')
    {
        $modelProjectIconSample = new TfProjectIconSample();
        $dataProjectIcon = TfProjectIcon::find($iconId);
        $dataProjectIconSample = $modelProjectIconSample->sampleIsUsing();
        if (count($dataProjectIcon) > 0) {
            return view('manage.build.map.project.project-icon-edit', compact('dataProjectIconSample', 'dataProjectIcon'));
        }

    }

    # add project icon
    public function postIconEdit($iconId = '', $iconSampleId = '')
    {
        $modelProjectIcon = new TfProjectIcon();
        $dataProjectIcon = TfProjectIcon::find($iconId);

        $topPosition = $dataProjectIcon->topPosition();
        $leftPosition = $dataProjectIcon->leftPosition();
        $projectId = $dataProjectIcon->projectId();
        $oldSampleId = $dataProjectIcon->sampleId();
        if ($oldSampleId !== $iconSampleId) {
            if ($modelProjectIcon->insert($topPosition, $leftPosition, $projectId, $iconSampleId)) {
                $modelProjectIcon->actionDelete($iconId);
            }
        }
        $dataProjectIconSample = TfProjectIconSample::find($iconSampleId);
        return view('manage.build.map.project.project-icon-image', compact('dataProjectIconSample'));
    }

    # set new position for project
    public function setPosition($iconId = null, $topPosition = null, $leftPosition = null, $zIndex =null)
    {
        $modelProjectIcon = new TfProjectIcon();
        if(!empty($iconId)){
            $modelProjectIcon->setPosition($iconId, $topPosition, $leftPosition,$zIndex);
        }
    }

}
