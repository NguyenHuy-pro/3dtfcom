<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $modelSellerGuideObject
 * $dataSellerGuide
 */
$title = 'Edit info';
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h3 class="tf-margin-30">{!! $title !!}</h3>
    </div>
    <div class="tf-padding-bot-20 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_edit"
              method="post" role="form" enctype="multipart/form-data"
              action="{!! route('tf.m.c.seller.guide.edit.post',$dataSellerGuide->guideId()) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Guide object <span class="tf-color-red">*</span>:</label>
                <select class="form-control" name="cbObject">
                    {!! $modelSellerGuideObject->getOption($dataSellerGuide->objectId()) !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtName"
                       value="{!! $dataSellerGuide->name() !!}" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="control-label">Content <span class="tf-color-red">*</span>:</label>
                <textarea class="form-control" id="txtContent" name="txtContent" rows="10"
                          placeholder="Enter content">{!! $dataSellerGuide->content() !!}</textarea>
                <script type="text/javascript">ckeditor('txtContent')</script>
            </div>
            <div class="form-group">
                <label class="control-label">Video (Code On Youtube)</label>
                <input type="text" class="form-control" name="txtVideo" placeholder="Guide video"
                       value="{!! $dataSellerGuide->video() !!}">
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