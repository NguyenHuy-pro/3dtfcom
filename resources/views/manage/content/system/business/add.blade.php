<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $modelBusinessType
 *
 */

?>
@extends('manage.content.system.business.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Add business </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_add" method="post" role="form"
              action="{!! route('tf.m.c.system.business.add.post') !!}">
            @if (Session::has('notifyAddBusiness'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddBusiness') !!}
                    <?php
                    Session::forget('notifyAddBusiness');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Business type <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbBusinessType" name="cbBusinessType">
                    <option value="">Select type</option>
                    {!! $modelBusinessType->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control"  name="txtName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="control-label">Description:</label>
                <textarea class="form-control" rows="10" id="txtDescription" name="txtDescription" placeholder="Enter description"></textarea>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.system.business.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection