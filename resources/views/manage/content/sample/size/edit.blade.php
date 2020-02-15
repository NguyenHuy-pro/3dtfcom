<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * dataSize
 */
$hObject = new Hfunction();
$title = 'Edit size';
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">{!! $title !!} </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">

        <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_edit" method="post"
              enctype="multipart/form-data" role="form"
              action="{!! route('tf.m.c.sample.size.edit.post',$dataSize->sizeId()) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Width:</label>
                <select class="form-control" name="cbWidth">
                    <option value="{!! $dataSize->width() !!}">{!! $dataSize->width() !!}</option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Height <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbHeight" name="cbHeight">
                    @for($i = 1;$i <= 28;$i++)
                        <option value="{!! $i*32 !!}"
                                @if($dataSize->height == ($i*32)) selected="selected" @endif >{!! $i*32 !!}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Icon:</label>
                <img style="max-width: 150px;max-height: 150px;"
                     src="{!! $dataSize->pathImage() !!}">
            </div>
            <div class="form-group">
                <label class="control-label">New Icon :</label>
                <?php
                $hObject->selectOneImage('txtImage', 'txtImage');
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