<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
$hFunction = new Hfunction();
?>
@extends('manage.content.system.about.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <h3 class="tf-margin-30">Add About </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_add col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2"
              method="post" enctype="multipart/form-data" role="form"
              action="{!! route('tf.m.c.system.about.add.post') !!}">
            @if (Session::has('notifyAddAbout'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddAbout') !!}
                    <?php
                    Session::forget('notifyAddAbout');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="control-label">Content <span class="tf-color-red">*</span>:</label>
                <textarea class="form-control" id="txtContent" name="txtContent" rows="10"
                          placeholder="Enter content"></textarea>
                <script type="text/javascript">ckeditor('txtContent')</script>
            </div>
            <div class="form-group">
                <label class="control-label">New Image:</label>
                <?php
                $hFunction->selectOneImage('fileImage', 'fileImage');
                ?>
            </div>
            <div class="form-group">
                <label class="control-label">Meta keywords:</label>
                <input type="text" class="form-control" id="txtKeyword" name="txtKeyword" value="">
            </div>
            <div class="form-group">
                <label class="control-label">Meta description:</label>
                <input type="text" class="form-control" id="txtDescription" name="txtDescription" value="">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="button" class="tf_page_back btn btn-default">Close</button>
            </div>
        </form>
    </div>
@endsection