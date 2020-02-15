<?php namespace App\Http\Controllers\Manage\Content\System\Advisory;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Advisory\TfAdvisory;
use App\Models\Manage\Content\System\Staff\TfStaff;
use App\Models\Manage\Content\Users\TfUser;
use Illuminate\Http\Request;

class AdvisoryController extends Controller
{

    public function index()
    {
        $modelStaff = new TfStaff();
        $modelUser = new TfUser();
        $modelAdvisory = new TfAdvisory();
        $dataAdvisory = TfAdvisory::where('action', 1)->orderBy('advisory_id', 'DESC')->select('*')->paginate(30);
        $accessObject = 'advisory';
        return view('manage.content.system.advisory.list', compact('modelStaff', 'modelUser', 'modelAdvisory', 'dataAdvisory', 'accessObject'));
    }

    #View
    public function viewAdvisory($advisoryId)
    {
        $modelUser = new TfUser();
        $dataAdvisory = TfAdvisory::find($advisoryId);
        if (count($dataAdvisory)) {
            return view('manage.content.system.advisory.view', compact('modelUser', 'dataAdvisory'));
        }
    }

    #delete
    public function deleteAdvisory($advisoryId)
    {
        $modelAdvisory = new TfAdvisory();
        return $modelAdvisory->actionDelete($advisoryId);
    }

}
