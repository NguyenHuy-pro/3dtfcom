<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelSellerPayment
 * dataSellerPayment
 *
 */
$hFunction = new Hfunction();

#login info
$dataStaffLogin = $modelStaff->loginStaffInfo();

$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Seller';
$filterPayStatus = (isset($filterPayStatus)) ? $filterPayStatus : 999;
$filterCode = (isset($filterCode)) ? $filterCode : null;
?>
@extends('manage.content.seller.payment.index')
@section('tf_m_c_container_object')
    <div class="row tf-m-c-container-object">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="text-Left tf-padding-20 tf-font-size-20 tf-font-bold col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <span class="fa fa-database"></span>
                <span>{!! $title !!}</span>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="background-color: #BFCAE6;">
            <div class="tf-line-height-40 col-xs-6 col-sm-6 col-md-6 col-lg6 ">
                Total : {!! $modelSellerPayment->totalRecords() !!}
            </div>
            <div class="tf_seller_payment_filter tf-line-height-40 text-right col-xs-6 col-sm-6 col-md-6 col-lg-6 "
                 data-filter="{!! route('tf.m.c.seller.payment.filter') !!}">
                <select id="tf_seller_payment_filter_pay_status" class="tf-padding-4" name="cbPayStatus">
                    <option value="999" @if($filterPayStatus == 999) selected="selected" @endif >Show all</option>
                    <option value="0" @if($filterPayStatus == 0) selected="selected" @endif >Processing</option>
                    <option value="1" @if($filterPayStatus == 1) selected="selected" @endif >Paid</option>
                </select>
                <input id="tf_seller_payment_filter_code" class="tf-padding-left-5 tf-padding-rig-5"
                       name="txtFilterCode" type="text" placeholder="Seller code or Payment code"
                       value="{!! $filterCode !!}">
                <a id="tf_seller_payment_filter_code_go" class="tf-link-white-bold">
                    Go
                </a>
                &nbsp;&nbsp;
                <a class="tf-link-green-bold" href="{!! route('tf.m.c.seller.payment.list') !!}">
                    <i class="glyphicon glyphicon-refresh"></i>
                </a>
            </div>
        </div>

        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12 "
             data-href-confirm="{!! route('tf.m.c.seller.payment.confirm') !!}"
             data-href-view="{!! route('tf.m.c.seller.payment.view') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Code</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Total Pay</th>
                    <th>Payment info</th>
                    <th class="text-center">Status</th>
                    <th class="text-right"></th>
                </tr>
                @if(count($dataSellerPayment) > 0)
                    <?php
                    $perPage = $dataSellerPayment->perPage();
                    $currentPage = $dataSellerPayment->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataSellerPayment as $object)
                        <?php
                        $paymentId = $object->paymentId();
                        $status = $object->status();
                        $dataSeller = $object->seller;
                        $dateSellerPaymentInfo = $dataSeller->paymentInfoIsActive();
                        ?>
                        <tr class="tf_object" data-object="{!! $paymentId !!}">
                            <td class="text-center">
                                {!! $n_o+= 1 !!}.
                            </td>
                            <td>
                                {!! $object->paymentCode() !!}
                            </td>
                            <td>
                                {!! $hFunction->dateFormatDMY($object->fromDate(),'/') !!}
                            </td>
                            <td>
                                {!! $hFunction->dateFormatDMY($object->toDate(),'/') !!}
                            </td>
                            <td>
                                $<b>{!! $object->totalPay() !!}</b>
                            </td>
                            <td>
                                <em class="tf-text-under">Bank:</em> {!! $dateSellerPaymentInfo->bank->name()  !!}<br/>
                                <em class="tf-text-under">Account number:</em> {!! $dateSellerPaymentInfo->paymentCode()  !!}
                            </td>
                            <td class="text-center">
                                @if($object->payStatus() == 1)
                                    <em class="tf-color-grey">Paid</em>
                                @else
                                    <a class="tf_confirm tf-link-green-bold">
                                        Pay
                                    </a>
                                @endif
                            </td>
                            <td class="text-right">
                                <a class="btn btn-default btn-xs tf_object_view">
                                    <i class="glyphicon glyphicon-eye-open tf-color"></i> View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="8">
                            <?php
                            $hFunction->page($dataSellerPayment);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection