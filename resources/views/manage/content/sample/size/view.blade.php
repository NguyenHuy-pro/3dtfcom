<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * dataSize
 */
$title = 'Size detail';
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            {!! $title !!}
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataSize->createdAt() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-30">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="col-xs-4 col-sm-3 col-md-3 text-right tf-border-top-none">
                                <em>Standard</em>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-9 tf-border-top-none">
                                {!! $dataSize->standard->standardValue() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-xs-4 col-sm-3 col-md-3 text-right ">
                                <em>Name</em>
                            </td>
                            <td class="col-xs-8 col-sm-9 col-md-9 tf-em-1-5 ">
                                {!! $dataSize->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Size (W-H)</em>
                            </td>
                            <td>
                                {!! $dataSize->width().' x '.$dataSize->height() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Action status</em>
                            </td>
                            <td>
                                {!! ($dataSize->status() == 0)?'Disable': 'Enable' !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection