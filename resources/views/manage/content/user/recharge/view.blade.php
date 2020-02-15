<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 */
/*
 * dataRecharge
 */
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            Recharge detail
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="tf-padding-20 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <em>Customer :</em>
                <span class="tf-em-1-5">
                    {!! $dataRecharge->userCard->user->fullName() !!}
                </span>
            </div>
            <div class="tf-padding-bot-30 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <table class="table table-bordered tf-border-none">
                    <tr>
                        <th>Name card</th>
                        <th>Recharge code</th>
                        <th>Point</th>
                        <th>Payment</th>
                        <th>Date</th>
                    </tr>
                    <tr>
                        <td>
                            {!! $dataRecharge->userCard->name() !!}
                        </td>
                        <td>
                            {!! $dataRecharge->code() !!}
                        </td>
                        <td>
                            {!! $dataRecharge->point() !!}
                        </td>
                        <td>
                            {!! $dataRecharge->totalPayment() !!}
                        </td>
                        <td>
                            {!! $dataRecharge->createdAt() !!}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <em>Staff confirm: </em>
                @if(empty($dataRecharge->staffId()))
                    <span class="tf-em-1-5">Unconfirmed</span>
                @else
                    <span class="tf-em-1-5">
                        {!! $dataRecharge->staff->fullName() !!}
                    </span>
                @endif
            </div>
        </div>
    </div>
@endsection