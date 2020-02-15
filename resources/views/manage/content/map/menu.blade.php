<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/8/2016
 * Time: 9:26 AM
 */

$accessObject = (isset($accessObject)) ? $accessObject : '';
$mapMenu = [
    #tool
        [
                'object' => 'tool',
                'label' => 'Tool',
                'subMenu' => [
                        [
                                'subObject' => 'area',
                                'label' => 'Area',
                                'href' => route('tf.m.c.map.area.getList')
                        ],
                        [
                                'subObject' => 'rank',
                                'label' => 'Rank',
                                'href' => route('tf.m.c.map.rank.getList')
                        ],
                        [
                                'subObject' => 'rankProject',
                                'label' => 'Rule - Project - Rank',
                                'line' => true,
                                'href' => route('tf.m.c.map.rule_project_rank.list')
                        ],
                        [
                                'subObject' => 'rankBanner',
                                'label' => 'Rule - Banner - Rank',
                                'href' => route('tf.m.c.map.rule_banner_rank.list')
                        ],
                        [
                                'subObject' => 'rankLand',
                                'label' => 'Rule - Land - Rank',
                                'href' => route('tf.m.c.map.rule_land_rank.list')
                        ],
                        [
                                'subObject' => 'buildPrice',
                                'label' => 'Request - build - price',
                                'href' => route('tf.m.c.map.request_build_price.list')
                        ],
                        [
                                'subObject' => 'transactionStatus',
                                'label' => 'Transaction status',
                                'line' => true,
                                'href' => route('tf.m.c.map.transactionStatus.list')
                        ]

                ]
        ],

    #province
        [
                'object' => 'province',
                'label' => 'Province',
                'subMenu' => [
                        [
                                'subObject' => 'province',
                                'label' => 'Province',
                                'href' => route('tf.m.c.map.province.list')
                        ],
                        [
                                'subObject' => 'property',
                                'label' => 'Property',
                                'href' => route('tf.m.c.map.province-property.list')
                        ]

                ]
        ],

    #project
        [
                'object' => 'project',
                'label' => 'Project',
                'subMenu' => [
                        [
                                'subObject' => 'project',
                                'label' => 'Project',
                                'href' => route('tf.m.c.map.project.list')
                        ],
                        [
                                'subObject' => 'property',
                                'label' => 'Property',
                                'href' => route('tf.m.c.map.project-property.list')
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
                                'label' => 'Banner',
                                'href' => route('tf.m.c.map.banner.list')
                        ],
                        [
                                'subObject' => 'license',
                                'label' => 'License',
                                'line' => true,
                                'href' => route('tf.m.c.map.banner.license.list')
                        ],
                        [
                                'subObject' => 'image',
                                'label' => 'Image',
                                'line' => true,
                                'href' => route('tf.m.c.map.banner.image.list')
                        ],
                        [
                                'subObject' => 'visit',
                                'label' => 'Visit image',
                                'href' => route('tf.m.c.map.banner.image.visit.list')
                        ],
                        [
                                'subObject' => 'share',
                                'label' => 'Share',
                                'href' => route('tf.m.c.map.banner.share.list')
                        ]

                ]
        ],

    # land
        [
                'object' => 'land',
                'label' => 'Land',
                'subMenu' => [
                        [
                                'subObject' => 'land',
                                'label' => 'Land',
                                'href' => route('tf.m.c.map.land.list')
                        ],
                        [
                                'subObject' => 'license',
                                'label' => 'License',
                                'line' => true,
                                'href' => route('tf.m.c.map.land.license.list')
                        ],
                        [
                                'subObject' => 'share',
                                'label' => 'Share',
                                'line' => true,
                                'href' => route('tf.m.c.map.land.share.list')
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
                                'label' => 'Public',
                                'href' => route('tf.m.c.map.public.list')
                        ]

                ]
        ],

]
?>
<div class="row">
    <nav class="navbar navbar-default navbar-static-top tf-margin-padding-none" role="navigation">
        <div class="container-fluid tf-padding-lef-none">
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
                    <li class="dropdown">
                        <a href="#" class="tf-bg tf-color-white tf-font-bold">
                            Content of map
                        </a>
                    </li>

                    @foreach($mapMenu as $menuObject)
                        <li class="dropdown active">
                            <a class="dropdown-toggle  @if($accessObject == $menuObject['object']) tf-color-red @else tf-link @endif"
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
