<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 * $dataNotify
 *
 */

?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Detail about
            <button class="btn btn-default btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="col-md-12 text-right">
                <i class="fa fa-calendar"></i>&nbsp;
                <span style="color: black;">{!! $dataNotify->createdAt() !!}</span>
                <br/>
                <i class="glyphicon glyphicon-user"></i>
                {!! $dataNotify->staff->fullName() !!}
            </div>
            <div class="col-md-12 tf-padding-bot-30">
                <table class="table table-bordered tf-border-none">
                    <tr>
                        <td class="tf-border-none">
                            <h3>{!! $dataNotify->name() !!}</h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {!! $dataNotify->content() !!}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection