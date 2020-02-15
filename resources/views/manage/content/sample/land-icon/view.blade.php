<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * dataLandIconSample
 */
$title = 'Land icon sample detail';
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
                    <span style="color: black;">{!! $dataLandIconSample->createdAt() !!}</span>
                    <br/>
                    <em>
                        <i class="glyphicon glyphicon-user"></i>Designer:
                    </em>
                    <span>{!! $dataLandIconSample->staff->fullName() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-30">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="text-right tf-vertical-middle tf-border-top-none">
                                <em>Sample</em>
                            </td>
                            <td class="tf-border-top-none">
                                <img src="{!! $dataLandIconSample->pathImage() !!}">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3 text-right ">
                                <em>Size</em>
                            </td>
                            <td class="col-md-9 tf-em-1-5 ">
                                {!! $dataLandIconSample->size->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Transaction</em>
                            </td>
                            <td>
                                {!! $dataLandIconSample->transactionStatus->name() !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection