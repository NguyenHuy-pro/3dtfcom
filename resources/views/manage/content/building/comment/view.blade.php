<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * modelBuilding
 * dataBuildingComment
 */
use Carbon\Carbon;

$buildingId = $dataBuildingComment->buildingId();
$content = $dataBuildingComment->content();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Detail Comment
            <button class="btn btn-default btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <table class="table table-bordered tf-border-none">
                <tr>
                    <td colspan="2" class="text-right tf-border-top-none">
                        <i class="glyphicon glyphicon-calendar"></i>
                        {!! $dataBuildingComment->createdAt() !!}
                        <br/>
                        <i class="fa fa-user"></i>
                        <span>{!! $dataBuildingComment->user->fullName() !!}</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right tf-border-top-none">
                        <img src="{!! $modelBuilding->pathImageSample($modelBuilding->sampleId($buildingId)) !!}">
                    </td>
                    <td class="col-md-10 tf-vertical-middle tf-border-top-none">
                        <h4>{!! $modelBuilding->name($buildingId) !!}</h4>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">
                        Content
                    </td>
                    <td  class="col-md-10">
                        {!! $dataBuildingComment->content() !!}
                    </td>
                </tr>

            </table>
        </div>
    </div>
@endsection