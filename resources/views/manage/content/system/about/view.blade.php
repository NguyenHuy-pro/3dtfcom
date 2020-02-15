<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 * dataAbout
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
            <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                <i class="fa fa-calendar"></i>&nbsp;
                <span style="color: black;">{!! $dataAbout->createdAt() !!}</span>
                <br/>
                <i class="glyphicon glyphicon-user"></i>
                {!! $dataAbout->staff->fullName() !!}
            </div>
            <div class="col-xs-12 col-sm-1 col-md-12 tf-padding-bot-30">
                <table class="table table-bordered tf-border-none">
                    <tr>
                        <td class="tf-border-none">
                            <h3>{!! $dataAbout->name() !!}</h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {!! $dataAbout->content() !!}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection