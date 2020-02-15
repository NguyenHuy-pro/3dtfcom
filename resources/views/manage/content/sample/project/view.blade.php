<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * $modelLandIconSample
 */
$title = 'Project sample detail';

$banner = $dataProjectSample->bannerInfo();
$land = $dataProjectSample->landInfo();
$public = $dataProjectSample->publicInfo();

$projectBackgroundImage = $dataProjectSample->pathImageBackground();
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
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataProjectSample->createdAt() !!}</span>
                    <br/>
                    <em>
                        <i class="glyphicon glyphicon-user"></i>&nbsp;Designer:
                    </em>
                    <span>{!! $dataProjectSample->staff->fullName() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-padding-bot-30">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="tf-border-top-none">
                                <a class="tf-link" onclick="tf_main.tf_toggle('#sampleImageFull')">View sample</a>
                            </td>
                        </tr>
                        <tr id="sampleImageFull" class="tf-display-none">
                            <td class="tf-border-top-none">
                                <img src="{!! $dataProjectSample->pathFullImage() !!}">
                                <br/>
                                <a class="tf-link-red" onclick="tf_main.tf_toggle('#sampleImageFull')">Hide</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="tf-m-c-project-sample-view" style="background: url(' {!! $projectBackgroundImage !!}');">
                                    {{--banner--}}
                                    @if(count($banner) > 0)
                                        @foreach($banner as $dataProjectSampleBanner)
                                            <?php
                                            $top = $dataProjectSampleBanner->topPosition();
                                            $left = $dataProjectSampleBanner->leftPosition();
                                            $zIndex = $dataProjectSampleBanner->zIndex();
                                            ?>
                                            <div class="tf_m_c_project_sample_banner tf-position-abs"
                                                 style="top: {!! $top !!}px; left: {!! $left !!}px;z-index: {!! $zIndex !!}">
                                                {{--sample image--}}
                                                <img src="{!! $dataProjectSampleBanner->bannerSample->pathImage() !!}">

                                                <div class="tf-m-c-project-sample-banner-transaction">
                                                    {!! $dataProjectSampleBanner->transactionStatus->name() !!}
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    {{--land--}}
                                    @if(count($land) > 0)
                                        @foreach($land as $dataProjectSampleLand)
                                            <?php
                                            $sizeId = $dataProjectSampleLand->sizeId();
                                            $top = $dataProjectSampleLand->topPosition();
                                            $left = $dataProjectSampleLand->leftPosition();
                                            $zIndex = $dataProjectSampleLand->zIndex();
                                            $transactionStatusId = $dataProjectSampleLand->transactionStatusId();

                                            # get size of land
                                            $landWidth = $dataProjectSampleLand->size->width();
                                            $landHeight = $dataProjectSampleLand->size->height();

                                            $icon = $modelLandIconSample->imageOfSizeAndTransaction($sizeId, $transactionStatusId);
                                            ?>
                                            <div class="tf_m_c_project_sample_land tf-position-abs"
                                                 style="width: {!! $landWidth !!}px;height: {!! $landHeight !!}px;top: {!! $top !!}px; left: {!! $left !!}px;z-index: {!! $zIndex !!}">
                                                <img src="{!! $modelLandIconSample->pathImage($icon) !!}">
                                            </div>
                                        @endforeach
                                    @endif

                                    {{--public--}}
                                    @if(count($public) > 0)
                                        @foreach($public as $dataProjectSamplePublic)
                                            <?php
                                            $top = $dataProjectSamplePublic->topPosition();
                                            $left = $dataProjectSamplePublic->leftPosition();
                                            $zIndex = $dataProjectSamplePublic->zIndex();
                                            ?>
                                            <div class="tf_m_c_project_sample_public tf-m-c-project-sample-public"
                                                 style="top: {!! $top !!}px; left: {!! $left !!}px;z-index: {!! $zIndex !!}">

                                                {{--sample image--}}
                                                <img alt="{!! $dataProjectSamplePublic->publicSample->publicType->name() !!}"
                                                     src="{!! $dataProjectSamplePublic->publicSample->pathImage() !!}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection