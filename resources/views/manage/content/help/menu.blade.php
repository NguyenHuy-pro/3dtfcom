<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/8/2016
 * Time: 9:26 AM
 */
$accessObject = (isset($accessObject)) ? $accessObject : '';
?>
<div class="row">
    <nav class="navbar navbar-default navbar-static-top tf-margin-padding-none" role="navigation">
        <div class="container-fluid tf-padding-lef-none ">
            <div class="navbar-header ">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left ">
                    <li>
                        <a href="#" class="tf-bg tf-color-white tf-font-bold">
                            Help system
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('tf.m.c.help.object.list.get') !!}"
                           class="@if($accessObject == 'object') tf-color-red @else tf-link @endif">
                            Object
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('tf.m.c.help.action.list.get') !!}"
                           class="@if($accessObject == 'action') tf-color-red @else tf-link @endif">
                            Action
                        </a>
                    </li>
                    <li>
                        <a href="{!! route('tf.m.c.help.detail.list.get') !!}"
                           class="@if($accessObject == 'detail') tf-color-red @else tf-link @endif">
                            Description
                        </a>
                    </li>
                    <li class="dropdown">
                        <a class="@if($accessObject == 'content') tf-color-red @else tf-link @endif"
                           href="{!! route('tf.m.c.help.content.list.get') !!}">
                            Content
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right ">
                    <li class="dropdown">
                        <a class="tf-link" href="{!! route('tf.m.index') !!}">Panel</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
