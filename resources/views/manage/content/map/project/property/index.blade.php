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
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf_m_c_map_project_property">
        @yield('tf_m_c_container_object')
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/map/project/property/js/property.js')}}"></script>
@endsection