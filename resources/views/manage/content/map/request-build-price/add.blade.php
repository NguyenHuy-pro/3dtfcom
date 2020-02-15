<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * modelSize
 * modelRulandRank
 *
 */
?>
@extends('manage.content.map.request-build-price.index')
@section('tf_m_c_container_object')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h3 class="tf-margin-30">Add New</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_add col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2" name="tf_frm_add" method="post" role="form"
              action="{!! route('tf.m.c.map.request_build_price.add.post') !!}">
            @if (Session::has('notifyAddRequestBuildPrice'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddRequestBuildPrice') !!}
                    <?php
                    Session::forget('notifyAddRequestBuildPrice');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Size <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbSize" name="cbSize">
                    <option value="">select</option>
                    {!! $modelSize->getOption() !!}
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Price <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" id="txtSalePrice" name="txtPrice"
                       placeholder="Enter price (point number)">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.map.request_build_price.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection

