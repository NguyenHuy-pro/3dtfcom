<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 * $dataAdsBanner
 *
 */
$dataAdsBannerPrice = $dataAdsBanner->adsBannerPrice;
if (count($dataAdsBannerPrice) > 0) {
    foreach ($dataAdsBannerPrice as $value) {
        $point = $value->point();
        $show = $value->display();
    }
} else {
    $point = 0;
    $show = 0;
}
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Banner detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataAdsBanner->createdAt() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="tf-padding-bot-30 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="text-right tf-border-top-none col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>Name</em>
                            </td>
                            <td class="tf-em-1-5 tf-border-top-none col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                {!! $dataAdsBanner->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right tf-border-top-none col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>Page</em>
                            </td>
                            <td class="tf-em-1-5 tf-border-top-none col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                {!! $dataAdsBanner->adsPage->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right tf-border-top-none col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>Position</em>
                            </td>
                            <td class="tf-em-1-5 tf-border-top-none col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                {!! $dataAdsBanner->adsPosition->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right tf-border-top-none col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>Image size</em>
                            </td>
                            <td class="tf-em-1-5 tf-border-top-none col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                {!! $dataAdsBanner->width().' x '. $dataAdsBanner->height() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right tf-border-top-none col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>Point</em>
                            </td>
                            <td class="tf-em-1-5 tf-border-top-none col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                {!! $point !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right tf-border-top-none col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <em>Show</em>
                            </td>
                            <td class="tf-em-1-5 tf-border-top-none col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                {!! $show !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Action status</em>
                            </td>
                            <td>
                                {!! ($dataAdsBanner->status() == 0)?'Disable': 'Enable' !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection