<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 12/7/2016
 * Time: 3:06 PM
 */
?>
@extends('manage.content.map.index')
@section('tf_m_c_content_map')
    <div class="tf_m_c_map_request_build_price col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @yield('tf_m_c_container_object')
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/map/requestBuildPrice/js/request-build-price.js')}}"></script>
@endsection