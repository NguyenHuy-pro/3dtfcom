<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/13/2016
 * Time: 2:01 PM
 */

/*
 * dataSystemAccess
 */
$name = $dataSystemAccess['accessObject'];
?>

<div class="row">
    <div class="navbar-xs">
        <div class="navbar-primary">
            <nav class="navbar navbar-default navbar-static-top tf-system-menu" role="navigation">
                {{--Brand and toggle get grouped for better mobile display--}}
                <div class="navbar-header ">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                {{--Collect the nav links, forms, and other content for toggling--}}
                <div class="collapse navbar-collapse tf-margin-bot-10 " id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-left tf-margin-padding-none ">
                        <li class="dropdown ">
                            <a class="tf-bg @if($name == 'about') tf-link-white-bold tf-text-under @else tf-link-white @endif"
                               href="{!! URL::route('tf.system.about.get') !!}">
                                {!! trans('frontend_system.menu_about') !!}
                            </a>
                        </li>
                        <li class="dropdown ">
                            <a class="tf-bg @if($name == 'contact') tf-link-white-bold tf-text-under @else tf-link-white @endif"
                               href="{!! URL::route('tf.system.contact.get') !!}">
                                {!! trans('frontend_system.menu_contact') !!}
                            </a>
                        </li>
                        <li class="dropdown ">
                            <a class="tf-bg @if($name == 'notify') tf-link-white-bold tf-text-under @else tf-link-white @endif "
                               href="{!! URL::route('tf.system.notify.get') !!}">
                                {!! trans('frontend_system.menu_notify') !!}
                            </a>
                        </li>
                    </ul>

                </div>
            </nav>
        </div>
    </div>
</div>