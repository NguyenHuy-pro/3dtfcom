<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 1:31 PM
 *
 * modelUser
 * dataAdsBanner
 *
 *
 */
$dataUserLogin = $modelUser->loginUserInfo();
?>
@extends('components.container.contain-action-6')
@section('tf_main_action_content')
    <table class="table tf-height-full tf-margin-padding-none ">
        <tr>
            <td class="text-center tf-padding-30">
                {!! trans('frontend_ads.banner_order_success_notify') !!}
            </td>
        </tr>
        <tr>
            <td class="text-center ">
                <a class="btn btn-primary" href="{!! route('tf.user.ads.get', $dataUserLogin->nameCode()) !!}">
                    {!! trans('frontend_ads.banner_order_success_set_img') !!}
                </a>
                <a class="btn btn-default" href="{!! route('tf.ads.banner.list.get') !!}">
                    {!! trans('frontend_ads.banner_order_success_continue') !!}
                </a>
                <a class="btn btn-default" href="{!! route('tf.home') !!}">
                    {!! trans('frontend_ads.banner_order_success_close') !!}
                </a>
            </td>
        </tr>
    </table>
@endsection
