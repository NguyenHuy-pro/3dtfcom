<?php
/*
 * modelUser
 * dataPointAccess
 */
?>

@extends('point.index')
@section('titlePage')
    payment online
@endsection

@section('point_menu')
    @include('point.components.menu.menu', ['dataPointAccess' => $dataPointAccess])
@endsection

@section('point_content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('point.direct.default')
    </div>
@endsection