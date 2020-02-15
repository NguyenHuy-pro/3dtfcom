<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * modelSellerGuideObject
 */
$title = 'Add guide';
?>
@extends('manage.content.seller.guide.index')
@section('tf_m_c_container_object')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h3 class="tf-margin-30">{!! $title !!}</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 "
              name="tf_frm_add" enctype="multipart/form-data"
              method="post" role="form" action="{!! route('tf.m.c.seller.guide.add.post') !!}">
            @if (Session::has('notifyGuide'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyGuide') !!}
                    <?php
                    Session::forget('notifyGuide');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Guide object <span class="tf-color-red">*</span>:</label>
                <select class="form-control" name="cbObject">
                    <option value="">Select object</option>
                    {!! $modelSellerGuideObject->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="control-label">Content <span class="tf-color-red">*</span>:</label>
                <textarea class="form-control" id="txtContent" name="txtContent" rows="10"
                          placeholder="Enter content"></textarea>
                <script type="text/javascript">ckeditor('txtContent')</script>
            </div>
            <div class="form-group">
                <label class="control-label">Video (Code On Youtube)</label>
                <input type="text" class="form-control" name="txtVideo" placeholder="Guide video">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.seller.guide.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection
