<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 12/7/2016
 * Time: 3:06 PM
 */
?>
@extends('manage.content.user.index')
@section('tf_m_c_content_user')
    <div class="col-md-12 tf_m_c_user_user">
        @yield('tf_m_c_container_object')
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/user/user/js/user.js')}}"></script>
@endsection
