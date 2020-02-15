<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 12/7/2016
 * Time: 3:06 PM
 */
?>
@extends('manage.content.system.index')
@section('tf_m_c_content_system')

    <div class="col-md-12 tf_m_c_system_bad_info">
        @yield('tf_m_c_container_object')
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/system/badInfo/js/bad-info.js')}}"></script>
@endsection
