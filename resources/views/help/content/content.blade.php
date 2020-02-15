<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/14/2016
 * Time: 2:35 PM
 */
?>

<div class="panel panel-default tf_help_content_wrap tf-help-content-wrap tf-margin-padding-none tf-border-none">
    <div class="tf_content_name panel-heading tf-bg-none">
        <span class="tf-color glyphicon glyphicon-chevron-right"></span>
        <a class="tf-link">{!! $content->name !!}</a>
    </div>
    <div class="panel-body tf-display-none">
        <div class="tf-overflow-prevent col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {!! $content->content !!}
        </div>
    </div>
</div>
