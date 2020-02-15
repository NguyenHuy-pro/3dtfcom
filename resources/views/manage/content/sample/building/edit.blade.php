<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * modelBusinessType
 * dataBuildingSample
 */

$hObject = new Hfunction();
$title = 'Edit building sample';
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-md-12 text-center">
        <h3 class="tf-margin-30">{!! $title !!} </h3>
    </div>
    <div class="col-md-12 tf-padding-bot-20">
        <form class="tf_frm_edit col-md-8 col-md-offset-2" name="tf_frm_edit" method="post"
              enctype="multipart/form-data" role="form"
              action="{!! route('tf.m.c.sample.building.edit.post',$dataBuildingSample->sampleId()) !!}">

            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group text-center">
                <img style="max-width: 128px;max-height: 128px;" src="{!! $dataBuildingSample->pathImage() !!}">
                <br/>({!! $dataBuildingSample->size->name() !!})px
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label class="control-label">Business type <span class="tf-color-red">*</span>:</label>
                    <select id="cbBusinessType" class="form-control" name="cbBusinessType">
                        {!! $modelBusinessType->getOption($dataBuildingSample->businessTypeId()) !!}
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Price <span class="tf-color-red">*</span>:</label>
                <select id="cbPrice" class="form-control" name="cbPrice">
                    @for($i = 50; $i <= 10000;$i = $i + 10)
                        <option @if($dataBuildingSample->price() == $i) selected="selected"
                                @endif value="{!! $i !!}">{!! $i !!}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <?php
                $dataSize = $dataBuildingSample->size;
                ?>
                @include('manage.content.sample.building.select-image',compact('dataSize'))
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