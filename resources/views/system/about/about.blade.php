<?php
/*
 * modelAbout
 * modelUser
 * dataAbout
 */
#about info
if (count($dataAbout) > 0) {
    $metaKeyword = $dataAbout->metaKeyword();
    $metaDescription = $dataAbout->metaDescription();

} else {
    $metaKeyword = null;
    $metaDescription = null;
}
?>
@extends('system.index')

{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection

@section('metaDescription'){!! $metaDescription !!}@endsection

@section('tf_system_content')
    <div class="row">
        <div class="col-sm-12 col-md-12 tf-system-about tf-overflow-prevent">
            @if(count($dataAbout)> 0)
                {!! $dataAbout->content() !!}
            @endif
        </div>
    </div>
@endsection