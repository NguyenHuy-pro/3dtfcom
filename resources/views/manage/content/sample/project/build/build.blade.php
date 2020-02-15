<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 */
$hFunction = new Hfunction();
$title = 'Build project';

$publicTypeId = (isset($dataTool['publicTypeId'])) ? $dataTool['publicTypeId'] : '';
$projectId = $dataProjectSample->projectId();
$publish = $dataProjectSample->publish();

$banner = $dataProjectSample->bannerInfo();
$land = $dataProjectSample->landInfo();
$public = $dataProjectSample->publicInfo();

$projectBackgroundImage = $dataProjectSample->pathImageBackground();
?>
@extends('manage.content.sample.project.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 tf-line-height-40">
                <b>{!! $title !!}</b>
            </div>
            <div class="col-xs-2 col-sm-4 col-md-2 col-lg-2 tf-line-height-40 text-right">
                <a class="tf-link" href="{!! route('tf.m.c.sample.project.list') !!}">CLose</a>
            </div>
            <div class="col-xs-6 colsm-4 col-md-6 col-lg-6 tf-line-height-40 text-right">
                @if($publish ==1)
                    <em class="tf-color-red">(This project published)</em> &nbsp;&nbsp;
                @endif
                @if(!empty($dataProjectSample->backgroundId()))
                    <a class="tf_background_drop tf-link"
                       data-href="{!! route('tf.m.c.sample.project.build.background.drop') !!}">
                        Drop background
                    </a>
                    &nbsp;&nbsp;
                @endif
                <a class="tf-margin-rig-20" href="{!! route('tf.m.c.sample.project.build.background', $projectId) !!}">
                    <img class="tf-icon-20" title="Background" alt="background"
                         src="{!! asset('public/main/icons/area.gif')!!}"/>
                </a>
                <a class="tf-margin-rig-20" href="{!! route('tf.m.c.sample.project.build.land', $projectId) !!}">
                    <img class="tf-icon-20" title="add land" alt="land"
                         src="{!! asset('public/main/icons/icon-land.gif')!!}"/>
                </a>
                <a class="tf-margin-rig-20" href="{!! route('tf.m.c.sample.project.build.banner', $projectId) !!}">
                    <img class="tf-icon-20" title="add land" alt="land"
                         src="{!! asset('public/main/icons/bannerLogImg.png')!!}"/>
                </a>
                <select class="tf_project_sample_public_type"
                        data-href="{!! route('tf.m.c.sample.project.build.public', $projectId) !!}">
                    <option value="">Select public</option>
                    {!! $modelPublicType->getOption($publicTypeId) !!}
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <span class="tf-link" onclick="tf_main.tf_toggle('#tf_sample_full_image')">Turn on/off background</span>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div id="tf_project_sample_wrap" class="tf-project-sample-wrap">
                <div class="tf-sample-small-image">
                    <img alt="project" src="{!! $dataProjectSample->pathSmallImage() !!}"/>
                </div>
                <div id="tf_project_sample_background" class="tf-project-sample-background">
                    <div id="tf_project_sample" class="tf_project_sample tf-project-sample"
                         data-href-public="{!! route('tf.m.c.sample.project.build.publics.add') !!}"
                         data-href-banner="{!! route('tf.m.c.sample.project.build.banner.add.get') !!}"
                         data-href-land="{!! route('tf.m.c.sample.project.build.land.add.get') !!}"
                         ondrop="tf_m_c_sample_project.drop(event,this);"
                         ondragover="tf_m_c_sample_project.allow_drop(event);"
                         data-project="{!! $projectId !!}" style="background: url(' {!! $projectBackgroundImage !!}');">
                        <img id="tf_sample_full_image" class="tf-sample-full-image" alt="project"
                             src="{!! $dataProjectSample->pathFullImage() !!}"/>

                        <div id='tf_project_sample_grid' class='tf_project_sample_grid tf-project-sample-grid'></div>

                        {{--banner--}}
                        @if(count($banner) > 0)
                            @foreach($banner as $dataProjectSampleBanner)
                                @include('manage.content.sample.project.banner.banner', compact('dataProjectSampleBanner'))
                            @endforeach
                        @endif

                        {{--land--}}
                        @if(count($land) > 0)
                            @foreach($land as $dataProjectSampleLand)
                                @include('manage.content.sample.project.land.land', compact('dataProjectSampleLand'))
                            @endforeach
                        @endif

                        {{--public--}}
                        @if(count($public) > 0)
                            @foreach($public as $dataProjectSamplePublic)
                                @include('manage.content.sample.project.public.public', compact('dataProjectSamplePublic'))
                            @endforeach
                        @endif
                    </div>
                </div>
                @if($dataTool['buildObject'] == 'background')
                    <?php
                    $dataProjectBackground = $dataTool['dataProjectBackground'];
                    ?>
                    @include('manage.content.sample.project.build.tool-background', compact('dataProjectBackground'), ['dataProjectSample'=>$dataProjectSample])
                @elseif($dataTool['buildObject'] == 'public')
                    <?php
                    $dataPublicSample = $dataTool['dataPubicSample'];
                    ?>
                    @include('manage.content.sample.project.build.tool-public', compact('dataPublicSample'))

                @elseif($dataTool['buildObject'] == 'banner')
                    <?php
                    $dataBannerSample = $dataTool['dataBannerSample'];
                    ?>
                    @include('manage.content.sample.project.build.tool-banner', compact('dataBannerSample'))

                @elseif($dataTool['buildObject'] == 'land')
                    <?php
                    $dataSize = $dataTool['dataSize'];
                    ?>
                    @include('manage.content.sample.project.build.tool-land', compact('dataSize'))
                @endif
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tf_project_sample_background').draggable();
        });
    </script>
@endsection