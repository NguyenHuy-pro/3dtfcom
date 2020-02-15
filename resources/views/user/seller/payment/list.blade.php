<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 10:51 AM
 */
/*
 *
 * $modelUser
 * $dataUser
 *
 */

$hFunction = new Hfunction();

#access user info
$userAccessId = $dataUser->userId();


$take = 30;
$dateTake = $hFunction->carbonNow();

$dataSeller = $dataUser->sellerInfoOfUser();
$sellerId = $dataSeller->sellerId();
$sellerPaymentList = $dataSeller->sellerPaymentOfSeller($sellerId, $take, $dateTake);

?>
<div class="row tf_user_seller_payment_wrap" data-user="{!! $userAccessId !!}"
     data-href-view="{!! route('tf.user.seller.payment.view') !!}">
    <div class="tf_list_content tf-bg-white col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <table class="table table-hover">
            <tr>
                <th class="tf-border-top-none">
                    {!! trans('frontend_user.seller_payment_code_label') !!}
                </th>
                <th class="tf-border-top-none">
                    {!! trans('frontend_user.seller_payment_from_label') !!}
                </th>
                <th class="tf-border-top-none">
                    {!! trans('frontend_user.seller_payment_to_label') !!}
                </th>
                <th class="tf-border-top-none text-right">
                    {!! trans('frontend_user.seller_payment_pay_label') !!}
                </th>

            </tr>
            @if(count($sellerPaymentList) > 0 )
                @foreach($sellerPaymentList as $dataSellerPayment)
                    @include('user.seller.payment.object', compact('dataSellerPayment'),
                            [
                                'modelUser' => $modelUser,
                            ])
                    <?php
                    $checkDateViewMore = $dataSellerPayment->createdAt();
                    ?>
                @endforeach
            @else
                <tr>
                    <td class="tf-border-top-none text-center" colspan="4">
                        <em>{!! trans('frontend_user.seller_payment_null_notify') !!}</em>
                    </td>
                </tr>
            @endif
        </table>
    </div>

    {{--view more old image--}}
    @if(count($sellerPaymentList) >0 )
        <?php
        #check exist of image
        $resultMore = $dataSeller->sellerPaymentOfSeller($sellerId, $take, $checkDateViewMore);
        ?>
        @if(count($resultMore))
            <div class="tf_view_more tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <a class="tf-link" data-take="{!! $take !!}" data-href="">
                    {!! trans('frontend_user.seller_payment_view_more') !!}
                </a>
            </div>
        @endif
    @endif
</div>

