<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/8/2016
 * Time: 9:26 AM
 */
$accessObject = (isset($accessObject)) ? $accessObject : null;
$adsMenu = [
    //Page
        [
                'object' => 'tool',
                'label' => 'Tool',
                'subMenu' => [
                        [
                                'subObject' => 'page',
                                'label' => 'Page',
                                'href' => route('tf.m.c.ads.page.list')
                        ],
                        [
                                'subObject' => 'position',
                                'label' => 'Position',
                                'href' => route('tf.m.c.ads.position.list')
                        ],
                        [
                                'subObject' => 'banner',
                                'label' => 'Banner',
                                'line' => true,
                                'href' => route('tf.m.c.ads.banner.list')
                        ],
                ]
        ],

     //ads image
        [
                'object' => 'image',
                'label' => 'Ads Image',
                'subMenu' => [

                        [
                                'subObject' => 'image',
                                'label' => 'Images',
                                'href' => route('tf.m.c.ads.banner-image.list')
                        ]

                ]
        ],

    //Report
        [
                'object' => 'report',
                'label' => 'Report',
                'subMenu' => [
                        [
                                'subObject' => 'exchange',
                                'label' => 'Exchange',
                                'href' => null
                        ],
                        [
                                'subObject' => 'badInfo',
                                'label' => 'Bad info',
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
            <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left ">
                    <li class="dropdown ">
                        <a href="#" class="tf-bg tf-color-white tf-font-bold">
                            Ads system
                        </a>
                    </li>
                    @foreach($adsMenu as $menuObject)
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
