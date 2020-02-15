<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * dataProjectSample
 */
$hFunction = new Hfunction();
$title = 'Edit project sample';
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            {!! $title !!}
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_edit" enctype="multipart/form-data"
                  method="post" role="form" action="{!! route('tf.m.c.sample.project.edit.post', $dataProjectSample->projectId() ) !!}">
                <div class="form-group tf_frm_notify text-center tf-color-red"></div>
                <div class="form-group">
                    <label class="control-label">Manager <span class="tf-color-red">*</span>:</label>
                    <select class="form-control" id="cbStaff" name="cbStaff">
                        {!! $hFunction->option($dataStaff, $dataProjectSample->staffId()) !!}
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Image <span class="tf-color-red">*</span>:</label>
                    <img class="tf-img-100" src="{!! $dataProjectSample->pathSmallImage() !!}">
                </div>
                <div class="form-group">
                    <label class="control-label">New Image <span class="tf-color-red">*</span>:</label>
                    <?php
                    $hFunction->selectOneImage('fileImage', 'fileImage');
                    ?>
                </div>
                <div class="form-group">
                    <label class="control-label">Description <span class="tf-color-red">*</span>:</label>
                    <textarea class="form-control" name="txtDescription" rows="5"
                              placeholder="content">{!! $dataProjectSample->description()  !!}</textarea>
                </div>
                <div class="form-group texte-center">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button type="button" class="tf_save btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="button" class="tf_m_c_container_close btn btn-default">Close</button>
                </div>
            </form>
        </div>
    </div>
@endsection