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
@extends('manage.content.map.rule-land-rank.index')
@section('tf_m_c_container_object')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h3 class="tf-margin-30">Add rule of land</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_add col-xs-12 col-sm-12 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2" name="tf_frm_add" method="post" role="form"
              action="{!! route('tf.m.c.map.rule_land_rank.add.post') !!}">
            @if (Session::has('notifyAddRuleLandRank'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddRuleLandRank') !!}
                    <?php
                    Session::forget('notifyAddRuleLandRank');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Size <span class="tf-color-red">*</span>:</label>
                <select class="form-control" id="cbSize" name="cbSize">
                    <option value="">select</option>
                    <?php
                    $objectSize = $modelSize->getInfo();
                    ?>
                    @foreach($objectSize as $itemSize)
                        <option value="{!! $itemSize->sizeId() !!}">
                            {!! $itemSize->name() !!}
                            @if($modelRuleLandRank->existSize($itemSize->sizeId()))
                                &nbsp;&nbsp; <em>(Exist)</em>
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group text-center">
                <em class="tf-color-red">This price is root</em>
            </div>
            <div class="form-group">
                <label class="control-label">Sale price <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" id="txtSalePrice" name="txtSalePrice"
                       placeholder="Enter sale price (number type)">
            </div>
            <div class="form-group">
                <label class="control-label">Sale month <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" id="txtSaleMonth" name="txtSaleMonth"
                       placeholder="Enter sale month (number type)">
            </div>
            <div class="form-group">
                <label class="control-label">Free month <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" id="txtFreeMonth" name="txtFreeMonth"
                       placeholder="Enter free month (number type)">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.map.rule_land_rank.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection

