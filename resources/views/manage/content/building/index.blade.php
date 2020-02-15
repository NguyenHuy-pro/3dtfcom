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
    Manage building
@endsection

@section('tf_m_c_css_page')
    <link href="{{ url('public/manage/content/building/css/building.css')}}" rel="stylesheet">
@endsection

@section('tf_m_c_content')
    {{--menu--}}
    @include('manage.content.building.menu')

    {{--content--}}
    @yield('tf_m_c_building_content')
@endsection
