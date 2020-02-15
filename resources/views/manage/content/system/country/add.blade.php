<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 */
$hObject = new Hfunction();
?>
@extends('manage.content.system.province.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <h3 class="tf-margin-30">Add Country</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2" name="tf_frm_add" enctype="multipart/form-data" method="post"
              role="form" action="{!! route('tf.m.c.system.country.add.post') !!}">
            @if (Session::has('notifyAddCountry'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddCountry') !!}
                    <?php
                    Session::forget('notifyAddCountry');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Name <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtName" name="txtName" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="control-label">Code of country <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtCode" name="txtCode" placeholder="Enter code">
            </div>
            <div class="form-group">
                <label class="control-label">Money unit <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" id="txtMoney" name="txtMoney" placeholder="Enter money unit">
            </div>
            <div class="form-group">
                <label class="control-label">Flag <span class="tf-color-red">*</span>:</label>
                <?php
                $hObject->selectOneImage('txtFlag', 'txtFlag');
                ?>
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.system.country.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection