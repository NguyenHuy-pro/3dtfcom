<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 * $dataDepartmentContact
 *
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Contact detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                <i class="fa fa-calendar"></i>&nbsp;
                <span style="color: black;">{!! $dataDepartmentContact->createdAt() !!}</span>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 tf-padding-bot-30">
                <table class="table table-bordered tf-border-none">
                    <tr>
                        <td class="col-xs-4 col-sm-10 col-md-2 text-right tf-border-top-none">
                            <em>Department</em>
                        </td>
                        <td class="col-xs-8 col-sm-2 col-md-10 tf-border-top-none">
                            {!! $dataDepartmentContact->department->name() !!}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right">
                            <em>Email</em>
                        </td>
                        <td>
                            {!! $dataDepartmentContact->email() !!}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right">
                            <em>Phone</em>
                        </td>
                        <td>
                            {!! $dataDepartmentContact->phone() !!}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection