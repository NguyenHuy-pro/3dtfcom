<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/7/2016
 * Time: 4:00 PM
 */
?>
@extends('manage.content.master')
@section('tf_m_c_titlePage')
    Ads system
@endsection

{{--menu--}}
@section('tf_m_c_menu')
    {{--menu sytem--}}
    @include('manage.content.ads.menu')
@endsection

@section('tf_m_c_content')
    {{--content--}}
    <div class="row">
        @yield('tf_m_c_content_ads')
    </div>
@endsection

