<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/22/2016
 * Time: 10:16 AM
 *
 * dataMapAccess
 * dataProject
 * dataProjectBuild
 */

$hFunction = new Hfunction();

?>
<div class="tf-project-icon-publish">
    <img alt="project-publish" src="{!! $dataProject->pathImageOpening() !!}">
    <ul class="list-group">
        <li class="list-group-item">
            <label>{!! trans('frontend_map.project_icon_publish_name_label') !!}:</label>
            {!! $dataProject->name() !!}
        </li>
        <li class="list-group-item">
            <label>{!! trans('frontend_map.project_icon_publish_date_label') !!}:</label>
            {!! $dataProjectBuild->openingDate() !!}
        </li>
    </ul>
</div>
