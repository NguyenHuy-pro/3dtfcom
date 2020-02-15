<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 * dataRequestBuildPrice
 *
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Detail info
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataRequestBuildPrice->createdAt() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="tf-padding-bot-30 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="text-right tf-border-top-none col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <label><em>Size</em></label>
                            </td>
                            <td class="tf-border-top-none col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                ({!! $dataRequestBuildPrice->size->width().' x '.$dataRequestBuildPrice->size->height() !!})px
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <label><em>Price</em></label>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                {!! $dataRequestBuildPrice->price() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right col-xs-4 col-sm-3 col-md-2 col-lg-2 ">
                                <label><em>Staff</em></label>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                                {!! $dataRequestBuildPrice->staff->fullName() !!}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection