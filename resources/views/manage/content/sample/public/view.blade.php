<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * dataPublicType
 *
 */
$title = 'Public sample detail';
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
                    <span style="color: black;">{!! $dataPublicSample->createdAt() !!}</span>
                    <br/>
                    <em>
                        <i class="glyphicon glyphicon-user"></i>Designer:
                    </em>
                    <span>{!! $dataPublicSample->staff->fullName() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 tf-padding-bot-30">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="text-right tf-border-top-none">
                                <img src="{!! $dataPublicSample->pathImage() !!}">
                            </td>
                            <td class="tf-border-top-none">
                                <ul class="list-group">
                                    <li class="list-group-item tf-border-none">
                                        <label><em>Name:</em></label>&nbsp;&nbsp;
                                        <span>{!! $dataPublicSample->name() !!}</span>
                                    </li>
                                    <li class="list-group-item tf-border-none">
                                        <label><em>Size:</em></label>&nbsp;&nbsp;
                                        <span>{!! $dataPublicSample->size->name() !!}</span>
                                    </li>
                                    <li class="list-group-item tf-border-none">
                                        <label><em>Public type:</em></label>&nbsp;&nbsp;
                                        <span>{!! $dataPublicSample->publicType->name() !!}</span>
                                    </li>
                                    <li class="list-group-item tf-border-none">
                                        <label><em>Action satus:</em></label>&nbsp;&nbsp;
                                        <span>{!! ($dataPublicSample->status() == 0)?'Disable': 'Enable' !!}</span>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection