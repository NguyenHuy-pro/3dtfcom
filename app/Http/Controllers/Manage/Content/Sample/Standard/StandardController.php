<?php namespace App\Http\Controllers\Manage\Content\Sample\Standard;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;
use App\Models\Manage\Content\Sample\Standard\TfStandard;
use Input;
use File;
use DB;
use Request;

class StandardController extends Controller
{

    #========== ========== ========== GET INFO ========== ========== ==========
    # get List
    public function index()
    {
        $modelStaff = new TfStaff();
        $modelStandard = new TfStandard();
        $dataStandard = TfStandard::orderBy('standardValue', 'ASC')->select('*')->paginate(30);
        $accessObject = 'tool';;
        return view('manage.content.sample.standard.list', compact('modelStaff', 'modelStandard', 'dataStandard', 'accessObject'));
    }

    #========== ========== ========== EDIT INFO ========== ========== ==========
    # update status
    public function updateStatus($standardId)
    {
        $modelStandard = new TfStandard();
        if (!empty($standardId)) {
            $currentStatus = $modelStandard->status($standardId);
            $newStatus = ($currentStatus == 0) ? 1 : 0;
            return $modelStandard->updateStatus($standardId, $newStatus);
        }
    }

}
