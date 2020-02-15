<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/7/2016
 * Time: 3:37 PM
 */
?>
@extends('manage.content.master')
@section('tf_m_c_titlePage')
    Design info
@endsection
@section('tf_m_c_content')
    {{--menu--}}
    @include('manage.content.design.menu')

    {{--content--}}
    <div class="row">
        @yield('tf_m_c_content_design')
    </div>
@endsection
