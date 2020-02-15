<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 12/7/2016
 * Time: 3:06 PM
 */
?>
@extends('manage.content.sample.index')

@section('tf_m_c_css_page')
    <link href="{{ url('public/manage/content/sample/projectBackground/css/project-background.css')}}" rel="stylesheet">
@endsection

@section('tf_m_c_content_sample')
    <div class="tf_m_c_sample_project_background col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        @yield('tf_m_c_container_object')
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/sample/projectBackground/js/project-background.js')}}"></script>
@endsection
