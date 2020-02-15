<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/8/2016
 * Time: 9:26 AM
 */
$accessObject = (isset($accessObject)) ? $accessObject : null;
$sellerMenu = [
    //Page
        [
                'object' => 'tool',
                'label' => 'Tool',
                'subMenu' => [
                        [
                                'subObject' => 'object',
                                'label' => 'Guide object',
                                'href' => route('tf.m.c.seller.guide.object.list')
                        ],
                        [
                                'subObject' => 'price',
                                'label' => 'Payment price',
                                'line' => true,
                                'href' => route('tf.m.c.seller.payment-price.list')
                        ],
                ]
        ],

    //seller content
        [
                'object' => 'content',
                'label' => 'Content',
                'subMenu' => [

                        [
                                'subObject' => 'guide',
                                'label' => 'Guide',
                                'href' => route('tf.m.c.seller.guide.list')
                        ]

                ]
        ],

    //Report
        [
                'object' => 'report',
                'label' => 'Report',
                'subMenu' => [
                        [
                                'subObject' => 'seller',
                                'label' => 'Affiliate',
                                'href' => route('tf.m.c.seller.seller.list')
                        ],
                        [
                                'subObject' => 'payment',
                                'label' => 'Payment',
                                'line' => true,
                                'href' => route('tf.m.c.seller.payment.list')
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
                            Seller system
                        </a>
                    </li>
                    @foreach($sellerMenu as $menuObject)
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
