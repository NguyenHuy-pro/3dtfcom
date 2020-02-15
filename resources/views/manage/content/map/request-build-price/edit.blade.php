<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * $dataRequestBuildPrice
 *
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <h3 class="tf-margin-30">Edit rule of land</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_edit col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2"
              name="tf_frm_edit" method="post" role="form"
              action="{!! route('tf.m.c.map.request_build_price.edit.post',$dataRequestBuildPrice->priceId() ) !!}">
            <div class="form-group tf_frm_notify text-center tf-color-red"></div>
            <div class="form-group">
                <label class="control-label">Size:</label>
                <select class="form-control" id="cbSize" name="cbSize">
                    <option value="{!! $dataRequestBuildPrice->sizeId() !!}">
                        {!! $dataRequestBuildPrice->size->name() !!}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label">Price <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" id="txtSalePrice" name="txtPrice"
                       placeholder="Enter price (point number)" value="{!! $dataRequestBuildPrice->price() !!}">
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