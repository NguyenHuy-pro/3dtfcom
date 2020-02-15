<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/1/2016
 * Time: 8:58 AM
 */
/*
 * dataProject
 */
?>
<div class="btn-toolbar tf_m_build_project_menu  tf-m-build-project-menu tf-display-none tf-border-radius-4"
     role="toolbar" data-project="{!! $dataProject->projectId() !!}">
    <div class="btn-group btn-group-xs">
        <span class="tf_m_build_project_icon_move glyphicon glyphicon-move tf-link"></span>
    </div>
    <div class="btn-group btn-group-xs">
        <span class="dropdown-toggle glyphicon glyphicon-cog tf-link " data-toggle="dropdown"></span>
        <ul class="dropdown-menu tf-padding-none">
            <li>
                <a class="tf_m_build_project_icon_edit tf-link"
                   data-href="{!! route('tf.m.build.project.icon.edit.get') !!}">Edit icon</a>
            </li>
            @if(!empty($dataProject->backgroundId()))
                <li>
                    <a class="tf_m_build_project_drop_background tf-link"
                       data-href="{!! route('tf.m.build.map.tool.build.project-background.drop') !!}">Drop background</a>
                </li>
            @endif
        </ul>
    </div>
</div>
