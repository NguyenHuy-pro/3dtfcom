<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/7/2016
 * Time: 3:24 PM
 */
?>
@extends('manage.content.master')
@section('tf_m_c_titlePage')
    System info
@endsection

{{--menu--}}
@section('tf_m_c_menu')
    {{--menu sytem--}}
    @include('manage.content.system.menu')
@endsection

@section('tf_m_c_content')
    {{--content--}}
    <div class="row">
        @yield('tf_m_c_content_system')
    </div>
@endsection
