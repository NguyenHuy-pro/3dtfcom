<?php namespace App\Http\Controllers\Manage\Content\Map\RequestBuildPrice;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Manage\Content\Map\RequestBuildPrice\TfRequestBuildPrice;
use App\Models\Manage\Content\Sample\Size\TfSize;
use App\Models\Manage\Content\System\Staff\TfStaff;
use Illuminate\Support\Facades\Session;


//use Illuminate\Http\Request;
use DB;
use File;
use Request;

class RequestBuildPriceController extends Controller
{

    //=========== =========== =========== GET INFO =========== =========== ===========
    // get list
    public function getList()
    {
        $modelStaff = new TfStaff();
        $modelSize = new TfSize();
        $modelRequestBuildPrice = new TfRequestBuildPrice();
        $accessObject = 'tool';
        $dataRequestBuildPrice = TfRequestBuildPrice::where('action', 1)->orderBy('price_id', 'ASC')->select('*')->paginate(20);
        return view('manage.content.map.request-build-price.list', compact('modelStaff', 'modelSize', 'modelRequestBuildPrice', 'dataRequestBuildPrice', 'accessObject'));
    }

    // filter
    public function getFilter($filterSizeId = '')
    {
        $modelStaff = new TfStaff();
        $modelSize = new TfSize();
        $modelRequestBuildPrice = new TfRequestBuildPrice();
        if (empty($filterSizeId)) { // all size
            return redirect()->route('tf.m.c.map.request_build_price.list');
        } else {  // select an size
            $dataRequestBuildPrice = TfRequestBuildPrice::where('size_id', $filterSizeId)->where('action', 1)->orderBy('price_id', 'ASC')->select('*')->paginate(20);
            return view('manage.content.map.request-build-price.list', compact('modelStaff', 'modelSize', 'modelRequestBuildPrice', 'dataRequestBuildPrice', 'accessObject', 'filterSizeId'));
        }
    }

    public function viewDetail($priceId)
    {
        $modelRequestBuildPrice = new TfRequestBuildPrice();
        $dataRequestBuildPrice = $modelRequestBuildPrice->findInfo($priceId);
        if (count($dataRequestBuildPrice) > 0) {
            return view('manage.content.map.request-build-price.view', compact('dataRequestBuildPrice'));

        }
    }
    //=========== =========== =========== ADD NEW =========== =========== ===========
    // get form add
    public function getAdd()
    {
        $modelSize = new TfSize();
        $modelRequestBuildPrice = new TfRequestBuildPrice();
        $accessObject = 'tool';
        return view('manage.content.map.request-build-price.add', compact('modelSize', 'modelRequestBuildPrice', 'accessObject'));
    }

    // add
    public function postAdd()
    {
        $modelStaff = new TfStaff();
        $modelRequestBuildPrice = new TfRequestBuildPrice();
        $sizeId = Request::input('cbSize');
        $price = Request::input('txtPrice');
        if ($modelStaff->checkLogin()) {
            if ($modelRequestBuildPrice->existsPriceOfSize($price, $sizeId)) {
                Session::put('notifyAddRequestBuildPrice', "Add fail, exists this information ");
            } else {
                $modelRequestBuildPrice->insert($price, $modelStaff->loginStaffID(), $sizeId);
                Session::put('notifyAddRequestBuildPrice', "Add success, Enter info to continue");
            }
        }
    }

    //=========== =========== =========== EDIT INFO =========== =========== ===========
    // get form edit
    public function getEdit($priceId = '')
    {
        $dataRequestBuildPrice = TfRequestBuildPrice::where('price_id', $priceId)->first();
        return view('manage.content.map.request-build-price.edit', compact('dataRequestBuildPrice'));
    }

    // edit
    public function postEdit($priceId = '')
    {
        $modelStaff = new TfStaff();
        $modelRequestBuildPrice = new TfRequestBuildPrice();
        $sizeId = Request::input('cbSize');
        $price = Request::input('txtPrice');

        if ($modelStaff->checkLogin()) {
            if ($modelRequestBuildPrice->existsPriceOfSize($price, $sizeId)) {
                return 'This information existed in system';
            } else {
                if ($modelRequestBuildPrice->insert($price, $modelStaff->loginStaffID(), $sizeId)) {
                    $modelRequestBuildPrice->actionDelete($priceId);
                }
            }
        }

    }
}
