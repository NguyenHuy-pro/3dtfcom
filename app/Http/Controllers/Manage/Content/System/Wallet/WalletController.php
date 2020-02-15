<?php namespace App\Http\Controllers\Manage\Content\System\Payment;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class WalletController extends Controller
{

    public function getList()
    {
        return view('manage.content.system.wallet.list');
    }

    public function getAdd()
    {
        return view('manage.content.system.wallet.add');
    }

    public function postAdd()
    {
        return view('manage.content.system.wallet.add');
    }

    public function getEdit($walletID = '')
    {
        return view('manage.content.system.wallet.edit');
    }

    public function postEdit($walletID = '')
    {
        return redirect()->back();
    }

    public function getDelete($walletID = '')
    {
        return redirect()->back();
    }

}
