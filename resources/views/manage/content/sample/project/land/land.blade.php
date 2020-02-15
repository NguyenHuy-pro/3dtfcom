<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 1/19/2017
 * Time: 4:20 PM
 */
use App\Models\Manage\Content\Sample\LandIcon\TfLandIconSample;
$modelLandIconSample = new TfLandIconSample();
$landId = $dataProjectSampleLand->landId();
$projectId = $dataProjectSampleLand->projectId();
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
<div id="tf_m_c_project_sample_land_{!! $landId !!}" class="tf_m_c_project_sample_land tf-position-abs" data-land="{!! $landId !!}"
     data-href-position="{!! route('tf.m.c.sample.project.build.land.position.set') !!}"
     style="width: {!! $landWidth !!}px;height: {!! $landHeight !!}px;top: {!! $top !!}px; left: {!! $left !!}px;z-index: {!! $zIndex !!}">

    <img src="{!! $modelLandIconSample->pathImage($icon) !!}">

    <div class="btn-toolbar tf_m_c_project_sample_land_menu tf-m-c-project-sample-land-menu tf-display-none tf-border-radius-4" role="toolbar">
        <div class="btn-group btn-group-xs">
            <span class="tf_m_c_project_sample_land_move_status glyphicon glyphicon-move tf-link"  data-href="#"></span>
        </div>
        <div class="btn-group btn-group-xs">
        <span class="tf_m_c_project_sample_land_delete glyphicon glyphicon-remove tf-link"
              data-href="{!! route('tf.m.c.sample.project.build.land.delete') !!}" ></span>
        </div>
    </div>
</div>