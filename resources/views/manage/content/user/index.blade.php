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
    User info
@endsection

{{--menu--}}
@section('tf_m_c_menu')
    {{--menu user--}}
    @include('manage.content.user.menu')
@endsection

@section('tf_m_c_content')
    {{--content--}}
    <div class="row" >
        @yield('tf_m_c_content_user')
    </div>
@endsection
