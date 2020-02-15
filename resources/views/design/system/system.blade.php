@extends('design.index')
@section('titlePage')
    Design\System
@endsection
@section('tf_design_main_content')
    <div class="panel panel-default tf-border-none ">
        <!-- menu -->
        <div class="panel-heading tf-bg-none tf-border-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class="<?php if($nameSystem == 'designer' or $nameSystem == '') echo 'active'; ?>">
                    <a class="tf-link" href="{!! URL::route('tf.systemDesign','designer') !!}">Designer</a>
                </li>
                <li class="<?php if($nameSystem == 'design') echo 'active'; ?>">
                    <a class="tf-link" href="{!! URL::route('tf.systemDesign','design') !!}">Design</a>
                </li>
            </ul>
        </div>
        <!-- end menu -->

        <!-- content system -->
        <div class="panel-body">
            @if($nameSystem =='designer')
                @include('design.system.designer')
            @elseif($nameSystem == 'design')
                @include('design.system.design')
            @else
                @include('design.system.designer')
            @endif
        </div>
        <!-- end content system -->
    </div>
@endsection