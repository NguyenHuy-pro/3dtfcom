<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/8/2016
 * Time: 9:26 AM
 *
 */
$accessObject = (isset($accessObject)) ? $accessObject : '';
$sampleMenu = [
    #tool
        [
                'object' => 'tool',
                'label' => 'Tool',
                'subMenu' => [
                        [
                                'subObject' => 'standard',
                                'label' => 'Standard',
                                'href' => route('tf.m.c.sample.standard.list')
                        ],
                        [
                                'subObject' => 'size',
                                'label' => 'Size',
                                'href' => route('tf.m.c.sample.size.list')
                        ],
                        [
                                'subObject' => 'publicType',
                                'label' => 'Public type',
                                'line' => true,
                                'href' => route('tf.m.c.sample.public-type.list')
                        ]

                ]
        ],

    # banner
        [
                'object' => 'banner',
                'label' => 'Banner',
                'subMenu' => [
                        [
                                'subObject' => 'banner',
                                'label' => 'List banner',
                                'href' => route('tf.m.c.sample.banner.list')
                        ]

                ]
        ],

    # land
        [
                'object' => 'land',
                'label' => 'Land',
                'subMenu' => [
                        [
                                'subObject' => 'icon',
                                'label' => 'List icon',
                                'href' => route('tf.m.c.sample.land-icon.list')
                        ],
                        [
                                'subObject' => 'requestBuild',
                                'label' => 'Request build',
                                'line' => true,
                                'href' => route('tf.m.c.sample.land_request_build.list')
                        ],
                        [
                                'subObject' => 'requestBuildDesign',
                                'label' => 'Build design',
                                'href' => route('tf.m.c.sample.land_request_build_design.list')
                        ]

                ]
        ],

    # building
        [
                'object' => 'building',
                'label' => 'Building',
                'subMenu' => [
                        [
                                'subObject' => 'building',
                                'label' => 'Sample',
                                'href' => route('tf.m.c.sample.building.list')
                        ],
                        [
                                'subObject' => 'Ornament',
                                'label' => 'Ornament',
                                'href' => null
                        ]

                ]
        ],

    # public
        [
                'object' => 'public',
                'label' => 'Public',
                'subMenu' => [
                        [
                                'subObject' => 'public',
                                'label' => 'Sample',
                                'href' => route('tf.m.c.sample.public.list')
                        ]

                ]
        ],

    # project
        [
                'object' => 'project',
                'label' => 'Project',
                'subMenu' => [
                        [
                                'subObject' => 'icon',
                                'label' => 'Icon sample',
                                'href' => route('tf.m.c.sample.project-icon.list')
                        ],
                        [
                                'subObject' => 'projectBackground',
                                'label' => 'Project background',
                                'href' => route('tf.m.c.sample.project-background.list'),
                        ],
                        [
                                'subObject' => 'projectSample',
                                'label' => 'Project sample',
                                'href' => route('tf.m.c.sample.project.list'),
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
                {{--Right menu--}}
                <ul class="nav navbar-nav navbar-left ">

                    {{--Label of page--}}
                    <li class="dropdown ">
                        <a href="#" class="tf-bg tf-color-white tf-font-bold">
                            Sample system
                        </a>
                    </li>

                    @foreach($sampleMenu as $menuObject)
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

                {{--Right menu--}}
                <ul class="nav navbar-nav navbar-right ">
                    <li class="dropdown">
                        <a class="tf-link" href="{!! route('tf.m.index') !!}">Panel</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</div>
