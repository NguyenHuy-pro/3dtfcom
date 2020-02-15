<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
$hFunction = new Hfunction();
$title = 'Add project sample';
?>
@extends('manage.content.sample.project.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">{!! $title !!} </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_add" method="post" role="form"
              enctype="multipart/form-data" action="{!! route('tf.m.c.sample.project.add.post') !!}">
            @if (Session::has('notifyAddProjectSample'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddProjectSample') !!}
                    <?php
                    Session::forget('notifyAddProjectSample');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Manager <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbStaff" name="cbStaff">
                    <option value="">Select staff</option>
                    {!! $hFunction->option($dataStaff) !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Image <span class="tf-color-red">*</span>:</label>
                <?php
                $hFunction->selectOneImage('fileImage', 'fileImage');
                ?>
            </div>
            <div class="form-group">
                <label class="control-label">Description <span class="tf-color-red">*</span>:</label>
                <textarea class="form-control" name="txtDescription" rows="5" placeholder="content"></textarea>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.sample.project.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection