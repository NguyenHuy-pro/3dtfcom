<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
?>
@extends('manage.content.system.department.index')
@section('tf_m_c_map_container')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Add department</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_add col-xs-12 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2" method="post"
              name="tf_frm_add" role="form"
              action="{!! route('tf.m.c.system.department.add.post') !!}">
            @if (Session::has('notifyAddDepartment'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddDepartment') !!}
                    <?php
                    Session::forget('notifyAddDepartment');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="control-label">Code <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtCodeDepartment" placeholder="Enter code">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.system.department.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection
