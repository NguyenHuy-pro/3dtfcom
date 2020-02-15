<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */

/*
 * modelStandard
 */

$hObject = new Hfunction();
$title = 'Add Size';
?>
@extends('manage.content.sample.size.index')
@section('tf_m_c_container_object')
    <div class="col-md-12 text-center">
        <h3 class="tf-margin-30">{!! $title !!} </h3>
    </div>
    <div class="col-md-12">
        <form class="tf_frm_add col-md-8 col-md-offset-2" name="tf_frm_add" method="post" enctype="multipart/form-data"
              role="form" action="{!! route('tf.m.c.sample.size.add.post') !!}">
            @if (Session::has('notifyAddSize'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddSize') !!}
                    <?php
                    Session::forget('notifyAddSize');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Standard <span class="tf-color-red">*</span>:</label>
                <select class="tf_standard form-control" id="cbStandard" name="cbStandard">
                    <option value="">Select</option>
                    {!! $modelStandard->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Width:</label>
                <input type="text" class="form-control" id="txtWidth" name="txtWidth" disabled="true" value="0">
            </div>
            <div class="form-group">
                <label class="control-label">Height <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbHeight" name="cbHeight">
                    <option value="0">Select</option>
                    @for($i = 1;$i <= 28;$i++)
                        <option value="{!! $i*32 !!}">{!! $i*32 !!}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Icon <span class="tf-color-red">*</span>:</label>
                <?php
                $hObject->selectOneImage('txtImage', 'txtImage');
                ?>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.sample.size.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection