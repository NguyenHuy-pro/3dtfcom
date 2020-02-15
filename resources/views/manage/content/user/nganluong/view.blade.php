<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * dataNganLuongOrder
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Order detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="tf-padding-20 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <em>Customer :</em>
                <span class="tf-em-1-5">
                    {!! $dataNganLuongOrder->userCard->user->fullName() !!}
                </span>
            </div>
            <div class="tf-padding-bot-30 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-bordered tf-border-none">
                    <tr>
                        <th>Name card</th>
                        <th>Order code</th>
                        <th>Point</th>
                        <th>Payment</th>
                        <th>Date</th>
                    </tr>
                    <tr>
                        <td>
                            {!! $dataNganLuongOrder->userCard->name() !!}
                        </td>
                        <td>
                            {!! $dataNganLuongOrder->orderCode() !!}
                        </td>
                        <td>
                            {!! $dataNganLuongOrder->point() !!}
                        </td>
                        <td>
                            {!! $dataNganLuongOrder->price() !!}. {!! $dataNganLuongOrder->moneyCode() !!}
                        </td>
                        <td>
                            {!! $dataNganLuongOrder->createdAt() !!}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection