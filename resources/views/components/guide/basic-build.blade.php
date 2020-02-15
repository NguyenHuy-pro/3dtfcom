<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/9/2017
 * Time: 10:54 PM
 *
 *
 * $modelUser
 *
 */

$dataUserLogin = $modelUser->loginUserInfo()
?>
@extends('components.container.contain-action-8')
@section('tf_main_action_content')
    <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
        <table class="table">
            <tr>
                <td class="text-center tf-border-top-none">
                    <h3>{!! trans('frontend.guide_basic_build_title') !!}</h3>
                    @if(empty($dataUserLogin))
                        <a href="{!! route('tf.register.get') !!}">
                            <button type="button" class="tf-link-hover-white tf-bg-hover btn btn-warning pull-right">
                                {!! trans('frontend.guide_label_register') !!}
                            </button>
                        </a>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="tf-border-top-none">
                    <em class="pull-left">{!! trans('frontend.guide_label_welcome') !!} !</em>
                </td>
            </tr>
            <tr>
                <td class="text-left">
                    {!! trans('frontend.guide_label_select_land') !!}
                </td>
            </tr>
            <tr>
                <td class="text-left tf-border-none">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                        <img style="width: 64px; height: 32px;"
                             src="{!! asset('public/main/icons/icon_freeblock.gif') !!}"/>&nbsp;&nbsp;&nbsp;
                        <i class="glyphicon glyphicon-arrow-right"></i>&nbsp;&nbsp;&nbsp;
                        <img src="{!! asset('public/main/icons/house.png') !!}"/>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
                        + <a class="tf-link" target="_blank" href="{!! route('tf.help','land/activities') !!}">
                            {!! trans('frontend.guide_label_more_land') !!}
                        </a><br/>
                        + <a class="tf-link" target="_blank" href="{!! route('tf.help','building/activities') !!}">
                            {!! trans('frontend.guide_label_more_building') !!}
                        </a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-left">
                    {!! trans('frontend.guide_label_select_banner') !!}
                </td>
            </tr>
            <tr>
                <td class="text-left tf-border-none">
                    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6">
                        <img src="{!! asset('public/main/icons/bannerLog.png') !!}"/>&nbsp;&nbsp;&nbsp;
                        <i class="glyphicon glyphicon-arrow-right"></i>&nbsp;&nbsp;&nbsp;
                        <img src="{!! asset('public/main/icons/bannerLogImg.png') !!}"/>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-6 col-lg-6">
                        + <a class="tf-link" target="_blank"
                             href="{!! route('tf.help','advertising-banner/activities') !!}">
                            {!! trans('frontend.guide_label_more_banner') !!}
                        </a>

                    </div>
                </td>
            </tr>
            <tr>
                <td class="text-left">
                    {!! trans('frontend.guide_label_move_map') !!}?
                </td>
            </tr>
            <tr>
                <td class="text-left tf-border-none">
                    1. {!! trans('frontend.guide_label_move_select') !!} &nbsp;
                    <i class="glyphicon glyphicon-chevron-left"></i>&nbsp; | &nbsp;
                    <i class="glyphicon glyphicon-chevron-up"></i>&nbsp; | &nbsp;
                    <i class="glyphicon glyphicon-chevron-right"></i>&nbsp; | &nbsp;
                    <i class="glyphicon glyphicon-chevron-down"></i>
                    <br/>
                    2. {!! trans('frontend.guide_label_move_drag') !!}
                    <img style="width: 32px; height: 32px"
                         src="{!! asset('public/main/icons/dragMap.png') !!}"/><br/>
                    3.{!! trans('frontend.guide_label_move_click') !!}
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <button class="btn btn-primary tf_main_contain_action_close">{!! trans('frontend.button_close') !!}</button>
                </td>
            </tr>
        </table>
    </div>
@endsection
