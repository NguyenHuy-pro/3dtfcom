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

    <div class="col-md-12 tf_m_c_map_rule_banner_rank">
        @yield('tf_m_c_container_object')
    </div>
@endsection

@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/map/ruleBannerRank/js/rule-banner-rank.js')}}"></script>
@endsection