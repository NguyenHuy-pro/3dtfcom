<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/10/2016
 * Time: 11:42 AM
 *
 * $modelStaff
 * $modelSellerPaymentPrice
 * dataSellerGuideObject
 *
 */
$hFunction = new Hfunction();

#login info
$dataStaffLogin = $modelStaff->loginStaffInfo();

$actionStatus = false;
if ($dataStaffLogin->level() == 2) $actionStatus = true;

$title = 'Payment price';
?>
@extends('manage.content.seller.payment-price.index')
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
                Total : {!! $modelSellerPaymentPrice->totalRecords() !!}
            </div>
            <div class="tf-line-height-40 text-right col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                @if($actionStatus)
                    <a href="{!! route('tf.m.c.seller.payment-price.add.get') !!}">
                        <button class="btn btn-primary tf-link-white-bold">
                            <i class="fa fa-plus"></i> &nbsp;Add new
                        </button>
                    </a>
                @endif
            </div>
        </div>

        <div class="tf_list_object col-xs-12 col-sm-12 col-md-12 col-lg-12 "
             data-href-status="{!! route('tf.m.c.seller.guide-object.status') !!}"
             data-href-view="{!! route('tf.m.c.seller.guide-object.view') !!}">
            <table class="table table-hover">
                <tr>
                    <th class="text-center">No</th>
                    <th>Payment price</th>
                    <th>Share</th>
                    <th>Access</th>
                    <th>Register</th>
                    <th>Payment limit</th>
                    <th>Date</th>
                </tr>
                @if(count($dataSellerPaymentPrice) > 0)
                    <?php
                    $perPage = $dataSellerPaymentPrice->perPage();
                    $currentPage = $dataSellerPaymentPrice->currentPage();
                    $n_o = ($currentPage == 1) ? 0 : ($currentPage - 1) * $perPage; // set row number
                    ?>
                    @foreach($dataSellerPaymentPrice as $object)
                        <?php
                        $priceId = $object->priceId();
                        ?>
                        <tr class="tf_object" data-object="{!! $priceId !!}">
                            <td class="text-center">
                                {!! $n_o+= 1 !!}.
                            </td>
                            <td>
                                {!! $object->paymentPrice() !!}
                            </td>
                            <td>
                                {!! $object->shareValue() !!}
                            </td>
                            <td>
                                {!! $object->accessValue() !!}
                            </td>
                            <td>
                                {!! $object->registerValue() !!}
                            </td>
                            <td>
                            {!! $object->paymentLimit() !!}
                            </td>
                            <td>
                                {!! $object->createdAt() !!}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="7">
                            <?php
                            $hFunction->page($dataSellerPaymentPrice);
                            ?>
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection