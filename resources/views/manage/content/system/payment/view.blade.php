<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/18/2016
 * Time: 9:39 AM
 *
 * $dataPayment
 */
$title = 'Payment detail';
?>
@extends('manage.content.components.container.contain-action-10')
@section('tf_m_c_action_content')
    <div class="panel panel-default tf-margin-bot-none">
        <div class="panel-heading tf-bg tf-color-white">
            <i class="fa fa-eye"></i>
            {!! $title !!}
            <button class="btn btn-primary btn-xs tf_m_c_container_close pull-right">Close</button>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-12 text-right">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span style="color: black;">{!! $dataPayment->createdAt() !!}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 tf-padding-bot-30">
                    <table class="table table-bordered tf-border-none">
                        <tr>
                            <td class="col-md-3 text-right tf-border-top-none">
                                <em>Payment type</em>
                            </td>
                            <td class="col-md-9 tf-border-top-none">
                                {!! $dataPayment->paymentType->name() !!}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3 text-right">
                                <em>Bank</em>
                            </td>
                            <td class="col-md-9">
                                @if(empty($dataPayment->bankId()))
                                    <em>Null</em>
                                @else
                                    {!! $dataPayment->bank->name() !!}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3 text-right ">
                                <em>Contact info</em>
                            </td>
                            <td class="col-md-9 ">
                                @if(empty($dataPayment->contactName()))
                                    <em>Null</em>
                                @else
                                    {!! $dataPayment->contactName() !!}
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3 text-right">
                                <em>Payment info</em>
                            </td>
                            <td class="col-md-9 ">
                                @if(empty($dataPayment->paymentName()))
                                    <em>Null</em>
                                @else
                                    {!! $dataPayment->paymentName() !!}
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td class="col-md-3 text-right">
                                <em>Code</em>
                            </td>
                            <td class="col-md-9 ">
                                @if(empty($dataPayment->paymentCode()))
                                    <em>Null</em>
                                @else
                                    {!! $dataPayment->paymentCode() !!}
                                @endif

                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <em>Action status</em>
                            </td>
                            <td>
                                {!! ($dataPayment->status() == 0)?'Disable': 'Enable' !!}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection