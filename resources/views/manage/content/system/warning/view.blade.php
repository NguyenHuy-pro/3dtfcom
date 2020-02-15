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
            Warning detail
            <button class="btn btn-default btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                <i class="fa fa-calendar"></i>&nbsp;
                <span style="color: black;">{!! $dataWarning->createdAt() !!}</span>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-30">
                <table class="table table-bordered tf-border-none">
                    <tr>
                        <td class="col-xs-4 col-sm-3 col-md-3 text-right tf-border-top-none">
                            <em>Name</em>
                        </td>
                        <td class="col-xs-8 col-sm-9 col-md-9 tf-em-1-5 tf-border-top-none">
                            {!! $dataWarning->name() !!}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection