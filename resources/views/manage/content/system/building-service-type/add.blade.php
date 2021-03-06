<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */

$title = 'Add Service';
?>
@extends('manage.content.system.building-service-type.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">{!! $title !!}</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_add" enctype="multipart/form-data" method="post"
              role="form" action="{!! route('tf.m.c.system.building-service-type.add.post') !!}">
            @if (Session::has('notifyAddBuildingServiceType'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddBuildingServiceType') !!}
                    <?php
                    Session::forget('notifyAddBuildingServiceType');
                    ?>
                </div>
            @endif
                <div class="form-group">
                    <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                    <input type="text" class="form-control" name="txtName" placeholder="Enter name">
                </div>
                <div class="form-group text-center">
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <button type="button" class="tf_save btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                    <a href="{!! route('tf.m.c.system.building-service-type.list') !!}">
                        <button type="button" class="btn btn-default">Close</button>
                    </a>
                </div>
        </form>
    </div>
@endsection
