<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
$title = 'Transaction detail';
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
                <div class="col-md-12 text-right">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataPointTransaction->createdAt() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 tf-padding-bot-30">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="col-md-3 text-right tf-border-top-none">
                                <em>Transaction point</em>
                            </td>
                            <td class="col-md-9 tf-border-top-none">
                                {!! $dataPointTransaction->pointType->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3 text-right ">
                                <em>Point</em>
                            </td>
                            <td class="col-md-9 ">
                                {!! $dataPointTransaction->pointValue() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3 text-right">
                                <em>Usd</em>
                            </td>
                            <td class="col-md-9 ">
                                {!! $dataPointTransaction->usdValue() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Apply date</em>
                            </td>
                            <td>
                                {!! $dataPointTransaction->dateApply() !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection