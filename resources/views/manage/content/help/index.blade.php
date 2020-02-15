<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/7/2016
 * Time: 3:56 PM
 */
?>
@extends('manage.content.master')
@section('tf_m_c_content')
    {{--menu--}}
    @include('manage.content.help.menu')

    {{--content--}}
    <div class="row">
        @yield('tf_m_c_help_content')
    </div>
@endsection

