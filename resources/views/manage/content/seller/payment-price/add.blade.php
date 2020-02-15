<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 */

$title = 'Add payment price';
?>
@extends('manage.content.seller.payment-price.index')
@section('tf_m_c_container_object')
    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <h3 class="tf-margin-30">{!! $title !!}</h3>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <form class="tf_frm_add col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2 "
              name="tf_frm_add"
              method="post" role="form" action="{!! route('tf.m.c.seller.payment-price.add.post') !!}">
            @if (Session::has('notifyPaymentPrice'))
                <div class="form-group text-center tf-color-red">
                    {!! Session::get('notifyPaymentPrice') !!}
                    <?php
                    Session::forget('notifyPaymentPrice');
                    ?>
                </div>
            @endif
            <div class="form-group">
                <label class="control-label">Payment price ($usd) <span class="tf-color-red">*</span>:</label>
                <input type="text" class="form-control" name="txtPrice" readonly value="1">
            </div>
            <div class="form-group">
                <input type="hidden" class="form-control" name="txtShare" readonly value="0">
            </div>
            <div class="form-group">
                <label class="control-label">Access number /1 $usd <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" name="txtAccess" placeholder="Enter access Value"
                       value="10000">
            </div>
            <div class="form-group">
                <label class="control-label">Register number /1 $usd <span class="tf-color-red">*</span>:</label>
                <input type="number" class="form-control" name="txtRegister" placeholder="Enter name" value="1000">
            </div>
            <div class="form-group">
                <label class="control-label">Payment limit <span class="tf-color-red">*</span>:</label>
                <select class="form-control" name="cbPaymentLimit">
                    @for($i=100; $i<=10000;$i = $i + 100)
                        <option value="{!! $i !!}">{!! $i !!}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group text-center">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="button" class="tf_save btn btn-primary">Save</button>
                <button type="reset" class="btn btn-default">Reset</button>
                <a href="{!! route('tf.m.c.seller.payment-price.list') !!}">
                    <button type="button" class="btn btn-default">Close</button>
                </a>
            </div>
        </form>
    </div>
@endsection
