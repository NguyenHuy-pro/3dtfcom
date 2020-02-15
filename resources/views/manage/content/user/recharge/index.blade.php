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
    <div class="tf_m_c_user_recharge col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @yield('tf_m_c_container_object')
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/user/recharge/js/recharge.js')}}"></script>
@endsection
