@extends('design.index')
@section('titlePage')
    Confirm
@endsection
@section('tf_design_main_content')
    <div class="panel panel-default tf-border-none">
        <!-- menu -->
        <div class="panel-heading tf-bg-none tf-border-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class="<?php if($nameConfirm == 'success' or $nameConfirm == '') echo 'active'; ?>">
                    <a class="tf-link" href="{!! URL::route('tf.confirmDesign','success') !!}">Success</a>
                </li>
                <li class="<?php if($nameConfirm == 'fail') echo 'active'; ?>">
                    <a class="tf-link" href="{!! URL::route('tf.confirmDesign','fail') !!}">Fail</a>
                </li>
            </ul>
        </div>
        <!-- end menu -->

        <!-- content system -->
        <div class="panel-body">
            @if($nameConfirm =='success')
                @include('design.confirm.success')
            @elseif($nameConfirm == 'fail')
                @include('design.confirm.fail')
            @else
                @include('design.confirm.success')
            @endif
        </div>
        <!-- end content system -->
    </div>
@endsection