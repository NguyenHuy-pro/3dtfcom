<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/16/2016
 * Time: 1:52 PM
 */
?>
@extends('manage.content.sample.index')
@section('tf_m_c_content_sample')
    <div class="col-md-12 text-center">
        <h3>Report copyright of building</h3>
    </div>
    <div class="col-md-12 " style="background-color: #BFCAE6;">
        <div class="col-md-6 tf-line-height-40">
            Total : 0
        </div>
        <div class="col-md-6 tf-line-height-40 text-right">

        </div>
    </div>
    <div class="col-md-12">
        Updating
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/sample/js/building-copyright.js')}}"></script>
@endsection