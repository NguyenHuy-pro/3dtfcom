<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $dataNotify
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Edit Notification </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        @if(!empty($dataNotify))
            <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1"
                  enctype="multipart/form-data" method="post" role="form"
                  action="{!! route('tf.m.c.system.notify.edit.post',$dataNotify->notifyId()) !!}">
                <div class="form-group tf_frm_notify text-center tf-color-red">

                </div>
                <div class="form-group">
                    <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                    <input type="text" class="form-control" id="txtName" name="txtName" value="{!! $dataNotify->name() !!}"
                           placeholder="Enter name">
                </div>
                <div class="form-group">
                    <label class="control-label">Content <span class="tf-color-red">*</span>:</label>
                    <textarea class="form-control" id="txtContent" name="txtContent" rows="10"
                              placeholder="Enter content">{!! $dataNotify->content() !!}</textarea>
                    <script type="text/javascript">ckeditor('txtContent')</script>
                </div>
                <div class="form-group text-center">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button type="button" class="tf_save btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="button" class="tf_m_c_container_close btn btn-default">Close</button>
                </div>
            </form>
        @endif
    </div>
@endsection