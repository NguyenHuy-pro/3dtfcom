<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * modelBuilding
 * dataBuildingPost
 */
use Carbon\Carbon;

$buildingId = $dataBuildingPost->buildingId();
$content = $dataBuildingPost->content();
$image = $dataBuildingPost->image();
$buildingIntroId = $dataBuildingPost->buildingIntroId();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Detail Post
            <button class="btn btn-default btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <table class="table table-bordered tf-border-none">
                <tr>
                    <td colspan="2" class="text-right tf-border-top-none">
                        <i class="glyphicon glyphicon-calendar"></i>
                        {!! $dataBuildingPost->createdAt() !!}
                    </td>
                </tr>
                <tr>
                    <td class="text-right">
                        Building :
                    </td>
                    <td>
                        {!! $dataBuildingPost->building->name() !!}
                    </td>
                </tr>
                <tr>
                    <td class="text-right">
                        User
                    </td>
                    <td>
                        {!! $dataBuildingPost->user->fullName() !!}
                    </td>
                </tr>
                <tr>
                    <td class="text-right">
                        Content
                    </td>
                    <td>
                        {{--text--}}
                        @if(!empty($content))
                            <div class="col-md-12">
                                {!! $content !!}
                            </div>
                        @endif

                        {{--image--}}
                        @if(!empty($image))
                            <div class="col-md-12">
                                <img style="max-width: 100%" src="{!! $modelBuildingPost->pathFullImage($image) !!}">
                            </div>
                        @endif

                        {{--building intro--}}
                        @if(!empty($buildingIntroId))
                            <div class="col-md-12">
                                <img src="{!! $modelBuilding->pathImageSample($modelBuilding->sampleId($buildingIntroId)) !!}">
                            </div>
                        @endif
                    </td>
                </tr>

            </table>
        </div>
    </div>
@endsection