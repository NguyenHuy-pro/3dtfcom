<?php
/**
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 1:31 PM
 *
 *
 * dataBRecharge
 *
 *
 */
#$dataUserRecharge = $dataRecharge->user;
$dataUserCard = $dataRecharge->userCard;
?>
@extends('components.container.contain-action-10')
@section('tf_main_action_content')
    <div class="tf_action_height_fix col-xs-12 col-sm-12 col-md-12">
        <table class="table">
            <tr>
                <th class="tf-padding-bot-30 tf-text-under" colspan="2">
                    {!! trans('frontend_user.recharge_detail_title') !!}
                </th>
            </tr>
            <tr>
                <td class="col-xs-3 col-sm-2 col-md-1 tf-border-none tf-vertical-middle">
                    {!! trans('frontend_user.recharge_detail_label_customer') !!}:
                </td>
                <td class="col-xs-9 col-sm-10 col-md-11 tf-border-none tf-vertical-middle">
                    <span class="tf-em-1-5 tf-font-bold">
                        {!! $dataUserCard->user->fullName() !!}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="col-xs-3 col-sm-2 col-md-1 tf-border-none">
                    {!! trans('frontend_user.recharge_detail_label_date') !!}:
                </td>
                <td class="col-xs-9 col-sm-10 col-md-11 tf-border-none">
                    {!! $dataRecharge->createdAt() !!}
                </td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <th>
                    {!! trans('frontend_user.recharge_detail_label_card') !!}
                </th>
                <th>
                    {!! trans('frontend_user.recharge_detail_label_code') !!}
                </th>
                <th>
                    {!! trans('frontend_user.recharge_detail_label_point') !!}
                </th>
                <th>
                    {!! trans('frontend_user.recharge_detail_label_description') !!}
                </th>
            </tr>
            <tr>
                <td>
                    {!! $dataUserCard->name() !!}
                </td>
                <td>
                    {!! $dataRecharge->code() !!}
                </td>
                <td>
                    {!! $dataRecharge->point() !!}
                </td>
                <td>
                    {!! $dataRecharge->payment->paymentType->description() !!}
                </td>
            </tr>
            <tr>
                <td class="text-right" colspan="4">
                    {!! trans('frontend_user.recharge_detail_label_staff') !!}:
                    @if($dataRecharge->confirm() == 0)
                        {!! trans('frontend_user.recharge_detail_label_unConfirm') !!}
                    @else
                        <b>{!! $dataRecharge->staff->fullName() !!}</b>
                    @endif
                </td>
            </tr>
        </table>
    </div>
@endsection
