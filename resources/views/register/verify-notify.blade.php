<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/10/2016
 * Time: 4:04 PM
 *
 *
 * $dataUser
 *
 */
/*
 * modelAbout
 */
#about info
$dataAbout = $modelAbout->defaultInfo();
if (count($dataAbout) > 0) {
    $metaKeyword = $dataAbout->metaKeyword();
    $metaDescription = $dataAbout->metaDescription();

} else {
    $metaKeyword = null;
    $metaDescription = null;
}
?>
@extends('master')

{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection
@section('metaDescription'){!! $metaDescription !!}@endsection

@section('titlePage')
    verify account
@endsection

@section('shortcutPage')
    <link rel="shortcut icon" href="{!! asset('public/main/icons/3dlogo128.png') !!}"/>
@endsection


@section('tf_main_content')
    <div class="col-xs-12 col-sm-12 col-md-12  tf-height-full tf-overflow-auto tf-padding-bot-50">
        <div class="container tf-bg-white">
            <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" style="min-height: 1000px;">
                <div class="panel panel-default tf-margin-top-32 tf-margin-bot-32">
                    <div class="panel-body text-center tf-padding-32">
                        Welcome to
                        <h3>
                            {!! $dataUser->fullName() !!}
                        </h3>
                        Your account has been activated. Log in to use full features on 3dtf.com

                        <p>
                            Go to <a class="tf-link tf-text-under" href="{!! route('tf.home')  !!}"> Map </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
