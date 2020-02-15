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
    Seller system
@endsection

{{--menu--}}
@section('tf_m_c_menu')
    {{--menu sytem--}}
    @include('manage.content.seller.menu')
@endsection

@section('tf_m_c_content')
    {{--content--}}
    <div class="row">
        @yield('tf_m_c_content_seller')
    </div>
@endsection

