<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * modelUser
 * modelBuilding
 * dataBuilding
 */

$buildingId = $dataBuilding->buildingId();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Detail building
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <table class="table table-bordered tf-border-none">
                <tr>
                    <td colspan="2" class="text-right tf-border-top-none">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span style="color: black;">{!! $dataBuilding->createdAt() !!}</span>
                        <br>
                        <i class="fa fa-user"></i>&nbsp;
                        <span>{!! $modelUser->fullName($modelBuilding->userId($buildingId)) !!}</span>
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right tf-border-none">
                        <img style="max-width: 128px;" alt="{!! $dataBuilding->alias() !!}"
                             src="{!! $dataBuilding->buildingSample->pathImage() !!}"/>
                    </td>
                    <td class="col-md-10 tf-vertical-middle tf-border-none">
                        <p>
                            <label>{!! $dataBuilding->name() !!}</label>
                        </p>
                        <p>
                            <img class="tf-icon-16"
                                 src="{!! asset('public\main\icons\visited.png') !!}"
                                 alt="visit"/>{!! $dataBuilding->totalVisit() !!} &nbsp;&nbsp;
                            <img class="tf-icon-16"
                                 src="{!! asset('public\main\icons\observ.png') !!}"
                                 alt="tracking"/>{!! $dataBuilding->totalFollow() !!} &nbsp;&nbsp;
                            <img class="tf-icon-16"
                                 src="{!! asset('public\main\icons\navyBalloon.png') !!}"
                                 alt="comment"/>{!! $dataBuilding->totalComment() !!}&nbsp;&nbsp;
                            <img class="tf-icon-16"
                                 src="{!! asset('public\main\icons\favouriteAdd.png') !!}"
                                 alt="love"/>{!! $dataBuilding->totalLove() !!}&nbsp;&nbsp;
                            <img class="tf-icon-16"
                                 src="{!! asset('public\main\icons\share.png') !!}"
                                 alt="share"/>{!! $dataBuilding->totalShare() !!}
                        </p>

                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">Introduce:</td>
                    <td class="col-md-10">
                        @if(empty($dataBuilding->shortDescription()))
                            <em>None</em>
                        @else
                            {!! $dataBuilding->shortDescription() !!}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">Address:</td>
                    <td class="col-md-10">
                        @if(empty($dataBuilding->address()))
                            <em>None</em>
                        @else
                            {!! $dataBuilding->address() !!}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">Phone:</td>
                    <td class="col-md-10">
                        @if(empty($dataBuilding->phone()))
                            <em>None</em>
                        @else
                            {!! $dataBuilding->phone() !!}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="col-md-2 text-right">Website:</td>
                    <td class="col-md-10">
                        @if(empty($dataBuilding->website()))
                            <em>None</em>
                        @else
                            <a href="http://{!! $dataBuilding->website() !!}"
                               target="_blank">{!! $dataBuilding->website() !!}</a>
                        @endif
                    </td>
                </tr>
                <td class="col-md-2 text-right">Introduce:</td>
                <td class="col-md-10">
                    @if(empty($dataBuilding->description()))
                        <em>None</em>
                    @else
                        {!! $dataBuilding->description() !!}
                    @endif
                </td>
            </table>
        </div>
    </div>
@endsection