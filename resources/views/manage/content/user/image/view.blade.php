<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Image detail
            <button class="btn btn-default btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <i class="fa fa-calendar"></i>&nbsp;
                <span style="color: black;">{!! $dataUserImage->created_at !!}</span>
            </div>
            <div class="tf-padding-bot-30 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-bordered tf-border-none">
                    <tr>
                        <td class="col-xs-4 col-sm-3 col-md-2 col-lg-2 tf-border-top-none">
                            <em>User: </em>&nbsp;
                            <span class="tf-em-1-5">
                                {!! $dataUserImage->user->fullName() !!}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                            <img style="max-width: 100%" src="{!! $dataUserImage->pathFullImage() !!}">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection