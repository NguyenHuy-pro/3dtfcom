<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * dataProjectIconSample
 *
 */
$hObject = new Hfunction();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Edit icon sample of project </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_edit col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_edit"
              enctype="multipart/form-data" method="post" role="form"
              action="{!! route('tf.m.c.sample.project-icon.edit.post',$dataProjectIconSample->sampleId()) !!}">
            @if (Session::has('notifyEditProjectIconSample'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyEditProjectIconSample') !!}
                    <?php
                    Session::forget('notifyEditProjectIconSample');
                    ?>
                </div>
            @endif
            <div class="form-group text-center" style="background-color: green;">
                <img style="max-width: 128px;max-height: 128px;"
                     src="{!! $dataProjectIconSample->pathImage() !!}">
                <br/>({!! $dataProjectIconSample->size->name() !!})px
            </div>
            <div class="form-group">
                <label class="control-label">Price <span class="tf-color-red">*</span>:</label>
                <select id="cbPrice" class="form-control" name="cbPrice">
                    @for($i = 50; $i <= 10000;$i = $i + 10)
                        <option @if($dataProjectIconSample->price() == $i) selected="selected"
                                @endif value="{!! $i !!}">{!! $i !!}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <?php
                $dataSize = $dataProjectIconSample->size;
                ?>
                @include('manage.content.sample.project-icon.select-image',compact('dataSize'))
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="submit" class="tf_frm_edit btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.sample.project-icon.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection
@section('tf_m_js_page_footer')
    <script src="{{ url('public/manage/content/sample/js/project-sample.js')}}"></script>
@endsection