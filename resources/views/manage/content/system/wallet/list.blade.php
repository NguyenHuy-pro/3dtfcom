<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
?>
@extends('manage.content.system.index')
@section('tf_m_c_content_system')
    <div class="col-md-12 text-center">
        <h3>Wallet</h3>
        <em>(develop later.)</em>
    </div>
    <div class="col-md-12 " style="background-color: #BFCAE6;">
        <div class="col-md-6 tf-line-height-40">
            Total : 0
        </div>
        <div class="col-md-6 tf-line-height-40 text-right">
            <a class="tf-link-bold" href="{!! route('tf.m.c.system.wallet.getAdd') !!}" >
                Add new
            </a>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table table-hover">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th class="text-center">Logo</th>
                <th class="text-center">Status</th>
                <th class="text-center">Edit</th>
                <th class="text-center">Delete</th>
            </tr>
            <tr>
                <td>
                    1
                </td>
                <td>
                    wallet name 1
                </td>
                <td class="text-center">
                    <img class="tf-img-100" src="{!! asset('public/imgsample/addPoint.png') !!}">
                </td>
                <td class="text-center">
                    <img class="tf-icon-16" src="{!! asset('public/main/icons/active.png') !!}">
                </td>
                <td class="text-center">
                    <a href="{!! route('tf.m.c.system.wallet.postEdit',1) !!}">
                        <img class="tf-icon-16" src="{!! asset('public/main/icons/edit.png') !!}">
                    </a>
                </td>
                <td class="text-center">
                    <a class="tf-m-c-wallet-del-a" data-wallet="1" data-href="{!! URL::route('tf.m.c.system.wallet.getDelete') !!}">
                        <img class=" tf-icon-16" src="{!! asset('public/main/icons/del.png') !!}">
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    2
                </td>
                <td>
                    wallet name 2
                </td>
                <td class="text-center">
                    <img class="tf-img-100" src="{!! asset('public/imgsample/iconPublic.jpg') !!}">
                </td>
                <td class="text-center">
                    <img class="tf-icon-16" src="{!! asset('public/main/icons/active.png') !!}">
                </td>
                <td class="text-center">
                    <a href="{!! route('tf.m.c.system.wallet.postEdit',1) !!}">
                        <img class="tf-icon-16" src="{!! asset('public/main/icons/edit.png') !!}">
                    </a>
                </td>
                <td class="text-center">
                    <a class="tf-m-c-wallet-del-a" data-wallet="2" data-href="{!! URL::route('tf.m.c.system.wallet.getDelete') !!}">
                        <img class=" tf-icon-16" src="{!! asset('public/main/icons/del.png') !!}">
                    </a>
                </td>
            </tr>
        </table>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/system/js/wallet.js')}}"></script>
@endsection