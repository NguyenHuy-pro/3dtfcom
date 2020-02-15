<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/8/2016
 * Time: 9:26 AM
 */
?>
<div class="row">
    <nav class="navbar navbar-default navbar-static-top tf-margin-padding-none" role="navigation">
        <div class="container-fluid tf-padding-lef-none ">
            <div class="navbar-header ">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse "  id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left ">
                    <li class="dropdown ">
                        <a href="#" class="tf-bg tf-color-white tf-font-bold">
                            Playground Design
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle tf-link" data-toggle="dropdown">
                            Tool <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu tf-padding-none">
                            <li>
                                <a class="tf-link" href="#">Design price</a>
                            </li>
                            <li>
                                <a class="tf-link" href="#">Design style</a>
                            </li>
                            <li class="tf-border-top">
                                <a class="tf-link" href="#">Notify content</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Design store<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu tf-padding-none">
                            <li>
                                <a href="{!! route('tf.m.c.design.store.getList') !!}">
                                    List
                                </a>
                            </li>
                            <li class="tf-border-top">
                                <a href="#">
                                    Confirm design
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Request<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu tf-padding-none">
                            <li>
                                <a href="{!! route('tf.m.c.design.request.getList') !!}">
                                    List
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Receive<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu tf-padding-none">
                            <li>
                                <a href="{!! route('tf.m.c.design.receive.getList') !!}">
                                    List
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle tf-link" data-toggle="dropdown">
                            Shop
                        </a>
                    </li>
                    <li class="dropdown ">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Design upload<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu tf-padding-none">
                            <li>
                                <a href="{!! route('tf.m.c.design.direct.getList') !!}">
                                    List
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right ">
                    <li class="dropdown">
                        <a class="tf-link" href="{!! route('tf.m.index') !!}" >Panel</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
