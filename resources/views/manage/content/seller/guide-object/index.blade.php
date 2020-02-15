<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 12/7/2016
 * Time: 3:06 PM
 */
?>
@extends('manage.content.seller.index')
@section('tf_m_c_content_seller')

    <div class="tf_m_c_seller_guide_object col-xs-12 col-md-12 col-md-12 col-lg-12">
        @yield('tf_m_c_container_object')
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/seller/guide-object/js/guide-object.js')}}"></script>
@endsection
