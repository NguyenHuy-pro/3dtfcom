<?php namespace App\Http\Controllers\Manage\Content\Design;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DesignReceiveController extends Controller
{

    # get list
    public function getList()
    {
        $dataBusiness = '';//TfBusiness::where('action',1)->orderBy('name','ASC')->select('*')->paginate(30);
        return view('manage.content.design.design-receive.list', compact('dataBusiness'));
    }
    # end list

    # filter
    public function getFilter($filterBusinessTypeID = '')
    {
        /*
        if(empty($filterBusinessTypeID)){ // all country
            return redirect()->route('tf.m.c.system.business.getList');
        }
        else{  // select an country
            $dataBusiness = TfBusiness::where('businessType_id',$filterBusinessTypeID)->where('action',1)->orderBy('name','ASC')->select('*')->paginate(5);
            return view('manage.content.system.business.list',compact('dataBusiness','filterBusinessTypeID'));
        }
        */
    }
    # end filter

    # get form add
    public function getAdd()
    {
        return redirect()->back();
    }
    # end get form add

    # add
    public function postAdd(Request $request)
    {
        return redirect()->back();
    }
    # end add

    # get form edit
    public function getEdit($businessID = '')
    {
        return redirect()->back();
    }
    # end get form edit

    # edit info
    public function postEdit($businessID = '')
    {
        return redirect()->back();
    }
    # end edit info

    # update status
    public function statusUpdate($businessID = '', $status = '')
    {
        return redirect()->back();
    }
    # end update status

    # delete
    public function getDelete($businessID = '')
    {
        return redirect()->back();
    }
    # end delete
}
