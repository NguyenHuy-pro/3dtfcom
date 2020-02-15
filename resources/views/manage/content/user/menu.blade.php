<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/8/2016
 * Time: 9:26 AM
 */
$accessObject = (isset($accessObject)) ? $accessObject : '';

$userMenu = [
    #user
        [
                'object' => 'user',
                'label' => 'User',
                'subMenu' => [
                        [
                                'subObject' => 'list',
                                'label' => 'List',
                                'href' => route('tf.m.c.user.user.list')
                        ],
                        [
                                'subObject' => 'access',
                                'label' => 'Access info',
                                'line' => true,
                                'href' => route('tf.m.c.user.access.list')
                        ]
                ]
        ],

    #friend
        [
                'object' => 'friend',
                'label' => 'Friend',
                'subMenu' => [
                    /*
                        [
                                'subObject' => 'request',
                                'label' => 'Friend request',
                                'href' => null
                        ]
                      */
                ]
        ],

    #image
        [
                'object' => 'image',
                'label' => 'Image',
                'subMenu' => [
                        [
                                'subObject' => 'type',
                                'label' => 'Image type',
                                'href' => route('tf.m.c.user.image-type.list')
                        ],
                        [
                                'subObject' => 'image',
                                'label' => 'List image',
                                'href' => route('tf.m.c.user.image.list')
                        ]
                ]
        ],

    #card
        [
                'object' => 'card',
                'label' => 'Card',
                'subMenu' => [
                    /*
                        [
                                'subObject' => 'card',
                                'label' => 'Point card',
                                'href' => null
                        ],
                    */
                        [
                                'subObject' => 'recharge',
                                'label' => 'Recharge',
                                'line' => true,
                                'href' => route('tf.m.c.user.recharge.list')
                        ],
                        [
                                'subObject' => 'nganluong',
                                'label' => 'nganLuong.vn',
                                'line' => true,
                                'href' => route('tf.m.c.user.nganluong.list')
                        ]
                ]
        ],

    #warning
        [
                'object' => 'warning',
                'label' => 'Warning',
                'subMenu' => [
                    /*
                        [
                                'subObject' => 'warning',
                                'label' => 'List warning',
                                'href' => null
                        ]
                        */
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

                    {{--================ Label of page ================--}}
                    <li class="dropdown ">
                        <a href="#" class="tf-bg tf-color-white tf-font-bold">
                            User system
                        </a>
                    </li>

                    @foreach($userMenu as $menuObject)
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
