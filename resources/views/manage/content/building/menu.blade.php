<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/8/2016
 * Time: 9:26 AM
 */

$accessObject = (isset($accessObject)) ? $accessObject : null;
$buildingMenu = [
    #building
        [
                'object' => 'building',
                'label' => trans('backend_building.menu_building_label'),
                'subMenu' => [
                        [
                                'subObject' => 'building',
                                'label' => trans('backend_building.menu_building_building_label'),
                                'href' => route('tf.m.c.building.building.list')
                        ],
                        [
                                'subObject' => 'banner',
                                'label' => trans('backend_building.menu_building_banner_label'),
                                'line' => true,
                                'href' => route('tf.m.c.building.banner.list')
                        ],
                        [
                                'subObject' => 'comment',
                                'label' => trans('backend_building.menu_building_comment_label'),
                                'href' => route('tf.m.c.building.comment.list')
                        ],
                        [
                                'subObject' => 'share',
                                'label' => trans('backend_building.menu_building_share_label'),
                                'href' => route('tf.m.c.building.share.list')
                        ]

                ]
        ],

    # post
        [
                'object' => 'post',
                'label' => trans('backend_building.menu_post_label'),
                'subMenu' => [
                        [
                                'subObject' => 'post',
                                'label' => trans('backend_building.menu_post_post_label'),
                                'href' => route('tf.m.c.building.post.list')
                        ],
                        [
                                'subObject' => 'comment',
                                'label' => trans('backend_building.menu_post_comment_label'),
                                'line' => true,
                                'href' => route('tf.m.c.building.post.comment.list')
                        ]

                ]
        ],

    # Report
        [
                'object' => 'report',
                'label' => trans('backend_building.menu_report_label'),
                'subMenu' => [
                        [
                                'subObject' => 'badInfo',
                                'label' => trans('backend_building.menu_report_bad_info_label'),
                                'href' => null
                        ],
                        [
                                'subObject' => 'copyright',
                                'label' => trans('backend_building.menu_report_copyright_label'),
                                'href' => null
                        ]

                ]
        ],


]
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
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left ">
                    <li class="dropdown ">
                        <a href="#" class="tf-bg tf-color-white tf-font-bold">
                            Buildings System
                        </a>
                    </li>
                    @foreach($buildingMenu as $menuObject)
                        <li class="dropdown active">
                            <a class="dropdown-toggle @if($accessObject == $menuObject['object']) tf-color-red @else tf-link @endif"
                               data-toggle="dropdown">
                                {!! $menuObject['label'] !!} <span class="caret"></span>
                            </a>
                            @if(!empty($menuObject['subMenu']))
                                <ul class="dropdown-menu tf-padding-none">
                                    @foreach($menuObject['subMenu'] as $subMenuObject)
                                        <li @if(isset($subMenuObject['line']) && $subMenuObject['line']) class="tf-border-top" @endif >
                                            <a href="{!! $subMenuObject['href'] !!}">{!! $subMenuObject['label'] !!}</a>
                                        </li>
                                    @endforeach
                                </ul>

                            @endif
                        </li>
                    @endforeach
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
