<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * dataProjectBackground
 *
 */
$hFunction = new Hfunction();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Edit background of project </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_edit"
              enctype="multipart/form-data" method="post" role="form"
              action="{!! route('tf.m.c.sample.project-background.edit.post',$dataProjectBackground->backgroundId()) !!}">
            <div class="form-group text-center">
                <img style="max-width: 128px;max-height: 128px;"
                     src="{!! $dataProjectBackground->pathSmallImage() !!}">
            </div>
            <div class="tf_frm_notify form-group text-center">

            </div>
            <div class="form-group">
                <label class="control-label">Image <span class="tf-color-red">*</span>:</label>
                <?php
                $hFunction->selectOneImageFollowSize('fileImage', 'fileImage', '', 'checkImgSize', '', 896, 896);
                ?>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="button" class="tf_m_c_container_close btn btn-default">Close</button>
            </div>
        </form>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/sample/projectBackground/js/project-background.js')}}"></script>
@endsection
