<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
/*
 * modelSize
 * $dataRuleBannerRank
 */
$sizeId = $dataRuleBannerRank->sizeId();
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <h3 class="tf-margin-30">Edit rule of banner rank </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_edit col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2" name="tf_frm_edit" method="post" role="form"
              action="{!! route('tf.m.c.map.rule_banner_rank.edit.get',$dataRuleBannerRank->rankId()) !!}">
            @if (Session::has('notifyEditRuleBannerRank'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyEditRuleBannerRank') !!}
                    <?php
                    Session::forget('notifyEditRuleBannerRank');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Size:</label>
                <select class="form-control" id="cbSize" name="cbSize">
                    <option value="{!! $sizeId !!}">{!! $modelSize->name($sizeId) !!}</option>
                </select>
            </div>
            <div class="form-group text-center">
                <em class="tf-color-red">This price is root</em>
            </div>
            <div class="form-group">
                <label class="control-label">Sale price <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" id="txtSalePrice" name="txtSalePrice"
                       value="{!! $dataRuleBannerRank->salePrice() !!}" placeholder="Enter sale price (number type)">
            </div>
            <div class="form-group">
                <label class="control-label">Sale month <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" id="txtSaleMonth" name="txtSaleMonth"
                       value="{!! $dataRuleBannerRank->saleMonth() !!}" placeholder="Enter sale month (number type)">
            </div>
            <div class="form-group">
                <label class="control-label">Free month <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" id="txtFreeMonth" name="txtFreeMonth"
                       value="{!! $dataRuleBannerRank->freeMonth() !!}" placeholder="Enter free month (number type)">
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