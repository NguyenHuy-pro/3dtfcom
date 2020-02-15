<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/29/2016
 * Time: 4:02 PM
 */

?>
<ul class="nav nav-pills tf_m_build_building_menu tf-m-build-building-menu " role="tablist">
    <li class="tf-padding-rig-4">
        <a class="glyphicon glyphicon-question-sign tf-link-red tf-margin-padding-none"
           href="{!! route('tf.help') !!}" title="help" target="_blank"></a>
    </li>
    {{--logged--}}
    <li>
        <a class="dropdown-toggle glyphicon glyphicon-cog tf-link-bold tf-margin-padding-none"
           data-toggle="dropdown"></a>
        <ul class="dropdown-menu tf-padding-none">
            {{-- not exist image of banner--}}
            <li title="">
                <a class="obj-delete-a" href="#">Delete</a>
            </li>
        </ul>
    </li>
</ul>