<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/7/2016
 * Time: 2:59 PM
 */
?>
@extends('manage.content.master')
@section('tf_m_c_titlePage')
    Map info
@endsection

{{--menu--}}
@section('tf_m_c_menu')
    {{--menu map--}}
    @include('manage.content.map.menu')
@endsection

@section('tf_m_c_content')
    {{--content--}}
    <div class="row">
        @yield('tf_m_c_content_map')
    </div>
@endsection
