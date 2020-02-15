<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 12/7/2016
 * Time: 3:06 PM
 */
?>
@extends('manage.content.sample.index')
@section('tf_m_c_content_sample')

    <div class="col-md-12 tf_m_c_sample_banner">
        @yield('tf_m_c_container_object')
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/sample/banner/js/banner-sample.js')}}"></script>
@endsection
