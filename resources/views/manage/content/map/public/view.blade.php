<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * dataPublic
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Public detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataPublic->createdAt() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="col-md-2 tf-vertical-middle text-right tf-border-top-none">
                                <em>Sample</em>
                            </td>
                            <td class="col-md-10 tf-border-top-none">
                                <img src="{!! $dataPublic->pathImageSample($dataPublic->sampleId()) !!}">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Project</em>
                            </td>
                            <td class="col-md-10">
                                {!! $dataPublic->project->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-2 text-right">
                                <em>Publish</em>
                            </td>
                            <td class="col-md-10">
                                @if($dataPublic->publish() == 1)
                                    Published
                                @else
                                    Waiting publish
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection