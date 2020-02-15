<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/10/2016
 * Time: 2:43 PM
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
    Register success
@endsection
@section('shortcutPage')
    <link rel="shortcut icon" href="{!! asset('public/main/icons/3dlogo128.png') !!}"/>
@endsection
@section('tf_main_content')
    <div class="col-md-12  tf-height-full tf-overflow-auto tf-padding-bot-50">
        <div class="container tf-bg-white">
            <div class="col-md-8 col-md-offset-2" style="min-height:1000px;">
                <div class="panel panel-default tf-margin-top-32 tf-margin-bot-32">
                    <div class="panel-body text-center tf-padding-32" >
                        Success register, Please <span class="tf-color-red">check</span> your email to verify account.<br/>
                        <em class="tf-color-red">(If you don't find in inbox, please check in Spam)</em>
                        Go to <a class="tf-link tf-text-under" href="{!! route('tf.home')  !!}"> Map </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection