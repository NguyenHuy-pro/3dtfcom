<?php
/*
 * modelUser
 * dataPointAccess
 */
?>

@extends('point.index')

@section('titlePage')
    payment direct
@endsection

@section('point_menu')
    @include('point.components.menu.menu', ['dataPointAccess' => $dataPointAccess])
@endsection

@section('point_content')
    <div class="row">
        <div class=" tf-padding-top-30 col-xs-12 col-sm col-md-12 col-lg-12">
            @yield('online_content')
        </div>
    </div>
@endsection