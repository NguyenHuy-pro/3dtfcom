<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/7/2016
 * Time: 3:50 PM
 */
?>
@extends('manage.content.master')
@section('tf_m_c_titlePage')
    Sample info
@endsection

{{--menu--}}
@section('tf_m_c_menu')
    {{--menu sytem--}}

    @include('manage.content.sample.menu')
@endsection

@section('tf_m_c_content')
    {{--content--}}
    <div class="row">
            @yield('tf_m_c_content_sample')
    </div>
@endsection

