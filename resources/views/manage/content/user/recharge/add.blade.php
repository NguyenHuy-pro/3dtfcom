<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:43 AM
 *
 * modelPointTransaction
 * dataPayment
 */
#get point transaction of normal (point type == 1)
$hFunction = new Hfunction();


?>
@extends('manage.content.user.recharge.index')
@section('tf_m_c_container_object')
    <div class="col-md-12">
        <div class="text-Left tf-padding-20 tf-font-size-20 tf-font-bold col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <span class="fa fa-plus"></span>
            <span>Buy point</span>
        </div>
    </div>
    @if( count($dataPointTransaction) > 0)
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <form class="tf_frm_add col-xs-12 col-sm-12 col-md-12 col-lg-12" enctype="multipart/form-data"
                  name="tf_frm_add"
                  method="POST" role="form" action="{!! route('tf.m.c.user.recharge.add.post') !!}">
                @if (Session::has('notifyAddRecharge'))
                    <div class="form-group text-center tf-color-red">
                        {!! Session::get('notifyAddRecharge') !!}
                        <?php
                        Session::forget('notifyAddRecharge');
                        ?>
                    </div>
                @endif
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label class="control-label">Account or Name card <span class="tf-color-red">*</span>:</label>
                        <input type="text" class="form-control" name="txtAccount" placeholder="Account \ Name card">
                        <input type="hidden" name="txtPointTransaction"
                               value="{!! $dataPointTransaction->transactionId()  !!}">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Select package <span class="tf-color-red"></span>:</label>

                        <div class="row">
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                                <ul class="list-group">
                                    @for($i = 5; $i <= 25; $i += 5)
                                        <li class="list-group-item tf-vertical-middle">
                                            <span class="badge">{!! $i*$dataPointTransaction->pointValue() !!}
                                                - Point</span>
                                            <input type="radio" name="txtPayment" value="{!! $i !!}">
                                            <b>{!! $i*$dataPointTransaction->usdValue() !!}</b> USD
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                                <ul class="list-group">
                                    @for($i = 30; $i <= 50; $i+= 5)
                                        <li class="list-group-item tf-vertical-middle">
                                            <span class="badge">{!! $i*$dataPointTransaction->pointValue() !!}
                                                - Point</span>
                                            <input type="radio" name="txtPayment" value="{!! $i !!}">
                                            {!! $i*$dataPointTransaction->usdValue() !!} USD
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                                <ul class="list-group">
                                    @for($i = 55; $i <= 75; $i+= 5)
                                        <li class="list-group-item tf-vertical-middle">
                                            <span class="badge">{!! $i*$dataPointTransaction->pointValue() !!}
                                                - Point</span>
                                            <input type="radio" name="txtPayment" value="{!! $i !!}">
                                            {!! $i*$dataPointTransaction->usdValue() !!} USD
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                                <ul class="list-group">
                                    @for($i = 80; $i <= 100; $i+= 5)
                                        <li class="list-group-item tf-vertical-middle">
                                            <span class="badge">{!! $i*$dataPointTransaction->pointValue() !!}
                                                - Point</span>
                                            <input type="radio" name="txtPayment" value="{!! $i !!}">
                                            {!! $i*$dataPointTransaction->usdValue() !!} USD
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <label class="control-label">Recharge place <span class="tf-color-red">*</span>:</label>
                    <ul class="list-group">
                        @if(count($dataPayment) > 0)
                            @foreach($dataPayment as $payment)
                                <li class="list-group-item tf-vertical-middle">
                                    <input type="radio" name="txtPlace" value="{!! $payment->paymentId() !!}">
                                    &nbsp;{!! $payment->contactName() !!}
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group text-center">
                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <input type="hidden" name="txtRechargeCode" value="{!! $hFunction->getTimeCode() !!}">
                        <button type="button" class="tf_save btn btn-primary">Accept</button>
                        <a href="{!! route('tf.m.c.user.recharge.list') !!}">
                            <button type="button" class="btn btn-default">Close</button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endsection