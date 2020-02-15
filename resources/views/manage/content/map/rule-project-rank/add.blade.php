<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */
?>
@extends('manage.content.map.rule-project-rank.index')
@section('tf_m_c_container_object')
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
        <h3 class="tf-margin-30">Add rule of project rank </h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_add col-xs-12 col-sm-12 col-md-8 col-md-offset-2" name="tf_frm_add" method="post" role="form"
              action="{!! route('tf.m.c.map.rule-project-rank.add.post') !!}">
            @if (Session::has('notifyAddRuleProjectRank'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyAddRuleProjectRank') !!}
                    <?php
                    Session::forget('notifyAddRuleProjectRank');
                    ?>
                </div>
            @endif
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
                       placeholder="Enter month (number type)">
            </div>
            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.map.rule-project-rank.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection