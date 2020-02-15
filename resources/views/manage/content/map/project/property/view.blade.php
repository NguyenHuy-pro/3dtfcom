<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */

/*
 * dataProjectProperty
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Property detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataProjectProperty->dateBegin() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-padding-bot-30">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="col-xs-4 col-sm-3 col-md-2 col-lg-2 text-right tf-border-top-none">
                                <em>Code</em>
                            </td>
                            <td colspan="3" class="col-xs-8 col-sm-9 col-md-10 col-lg-10 tf-border-top-none">
                                <b>{!! $dataProjectProperty->code() !!}</b>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
                                <em>Begin</em>
                            </td>
                            <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                {!! $dataProjectProperty->dateBegin() !!}
                            </td>
                            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
                                <em>Project</em>
                            </td>
                            <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                {!! $dataProjectProperty->project->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>End</em>
                            </td>
                            <td >
                                {!! $dataProjectProperty->dateEnd() !!}
                            </td>
                            <td class="text-right">
                                <em>Manager</em>
                            </td>
                            <td >
                                {!! $dataProjectProperty->staff->fullName() !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection