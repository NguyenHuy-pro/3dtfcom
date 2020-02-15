<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 1/19/2017
 * Time: 12:34 PM
 */
/*
 * dataProjectSample
 * dataProjectBackground
 */
$projectId = $dataProjectSample->projectId();
?>
<div class="tf_background_tool tf-project-sample-tool-wrap" data-project="{!! $projectId !!}"
    data-href-add="{!! route('tf.m.c.sample.project.build.background.add') !!}"
    data-href-view="{!! route('tf.m.c.sample.project.build.background.view') !!}">
    @foreach($dataProjectBackground as $projectBackground)
        <?php
        $backgroundId = $projectBackground->backgroundId();
        ?>
        <div class="tf_background_object thumbnail tf-margin-bot-none" data-background="{!! $backgroundId !!}">
            <img class="tf_m_c_project_sample_tool" src="{!! $projectBackground->pathSmallImage() !!}" alt="land">

            <div class="caption">
                <a class="tf_view tf-link">View</a> &nbsp; | &nbsp;
                <a class="tf_select tf-link">Select</a>
            </div>
        </div>
    @endforeach
</div>
