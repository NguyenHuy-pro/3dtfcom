@extends('design.index')
@section('titlePage')
    Design\Store
@endsection
@section('tf_design_main_content')
    <div class="panel panel-default tf-border-none ">
        <!-- menu store -->
        <div class="panel-heading tf-bg-none tf-border-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class="<?php if($nameStore == 'design' or $nameStore == '') echo 'active'; ?>">
                    <a class="tf-link" href="{!! URL::route('tf.design.store.get','design') !!}">Design</a>
                </li>
                <li class="<?php if($nameStore == 'request') echo 'active'; ?>">
                    <a class="tf-link" href="{!! URL::route('tf.design.store.get','request') !!}">Request</a>
                </li>
                <li class="<?php if($nameStore == 'receive') echo 'active'; ?>">
                    <a class="tf-link" href="{!! URL::route('tf.design.store.get','receive') !!}">Receive</a>
                </li>
            </ul>
        </div>
        <!-- end menu store -->

        <!-- content store -->
        <div class="panel-body">
            @if($nameStore =='receive')
                @include('design.store.receive')
            @elseif($nameStore == 'request')
                @include('design.store.request')
            @elseif($nameStore == 'design')
                @include('design.store.design')
            @else
                @include('design.store.design')
            @endif
        </div>
        <!-- end content store !-->
    </div>
@endsection