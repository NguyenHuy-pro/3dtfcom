<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * modelSize
 * modelBusinessType
 */

$hObject = new Hfunction();

$title = 'Add building sample';
?>
@extends('manage.content.sample.building.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">{!! $title !!} </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-1 col-md-8 col-md-offset-2"
              name="tf_frm_add" enctype="multipart/form-data" method="post"
              role="form" action="{!! route('tf.m.c.sample.building.add.post') !!}">
            @if (Session::has('notifyAddBuildingSample'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddBuildingSample') !!}
                    <?php
                    Session::forget('notifyAddBuildingSample');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Business type <span class="tf-color-red">*</span>:</label>
                <select id="cbBusinessType" class="form-control" name="cbBusinessType">
                    <option value="">Select</option>
                    {!! $modelBusinessType->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Price <span class="tf-color-red">*</span>:</label>
                <select id="cbPrice" class="form-control" name="cbPrice">
                    <option value="">Select</option>
                    @for($i = 50; $i <= 10000;$i = $i + 10)
                        <option value="{!! $i !!}">{!! $i !!}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Size standard <span class="tf-color-red">*</span>:</label>
                <select id="cbSize" class="tf_select_size form-control" name="cbSize"
                        data-href="{!! route('tf.m.c.sample.building.image.select') !!}">
                    <option value="">Select</option>
                    {!! $modelSize->getOption() !!}
                </select>
            </div>
            <div class="tf_select_image form-group">

            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.sample.building.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection