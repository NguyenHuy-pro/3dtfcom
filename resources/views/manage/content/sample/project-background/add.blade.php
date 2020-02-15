<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * modelSize
 */

$hFunction = new Hfunction();

$title = 'Add project background';
?>
@extends('manage.content.sample.project-icon.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">{!! $title !!} </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-1 col-md-8 col-md-offset-2"
              name="tf_frm_add" enctype="multipart/form-data" method="post"
              role="form" action="{!! route('tf.m.c.sample.project-background.add.post') !!}">
            @if (Session::has('notifyAddProjectBackground'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddProjectBackground') !!}
                    <?php
                    Session::forget('notifyAddProjectBackground');
                    ?>
                </div>
            @endif
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
                <a href="{!! route('tf.m.c.sample.project-background.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection