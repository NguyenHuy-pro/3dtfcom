<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * dataAdsBannerImage
 */
#banner info

?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Image detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                <i class="fa fa-calendar"></i>&nbsp;
                <span style="color: black;">{!! $dataAdsBannerImage->createdAt() !!}</span>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="col-xs-4 col-sm-3 col-md-2 col-lg-2 text-right tf-border-top-none">
                                <em>Image</em>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10 tf-border-top-none">
                                <img src="{!! $dataAdsBannerImage->pathImage() !!}">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Business type</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataAdsBannerImage->businessType->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Website</em>
                            </td>
                            <td class="col-md-10">
                                @if(empty($dataAdsBannerImage->website()))
                                    Null
                                @else
                                    {!! $dataAdsBannerImage->website() !!}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>User</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataAdsBannerImage->adsBannerLicense->user->fullName() !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection