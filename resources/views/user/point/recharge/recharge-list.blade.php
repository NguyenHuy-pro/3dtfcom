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

#card info
$dataUserCard = $dataUser->userCard;
$cardId = $dataUserCard->cardId();

$rechargeList = $dataUserCard->infoRecharge($cardId, $take, $dateTake);

?>
<div class="row tf_user_point_recharge" data-user="{!! $userAccessId !!}"
     data-href-view="{!! route('tf.user.point.recharge.detail') !!}">
    <div class="tf_list_content tf-bg-white col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <table class="table ">
            <tr>
                <th class="tf-border-none col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    {!! trans('frontend_user.point_recharge_label_code') !!}
                </th>
                <th class="tf-border-none col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    {!! trans('frontend_user.point_recharge_label_point') !!}
                </th>
                <th class="tf-border-none col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                    {!! trans('frontend_user.point_recharge_label_date') !!}
                </th>
            </tr>
        </table>
        @if(count($rechargeList) > 0)
            @foreach($rechargeList as $dataRecharge)
                @include('user.point.recharge.recharge-object', compact('dataRecharge'),
                    [
                        'modelUser'=>$modelUser,
                        'dataUser'=> $dataUser
                    ])
                <?php
                $checkDateViewMore = $dataRecharge->createdAt();
                ?>
            @endforeach
        @else
            <table class="table">
                <tr>
                    <td class="tf-border-none text-center">
                        {!! trans('frontend_user.point_recharge_null_notify') !!}
                    </td>
                </tr>
            </table>
        @endif
    </div>
    {{--view more info--}}
    @if(count($rechargeList) > 0)
        <?php
        #check exist of image
        $resultMore = $dataUserCard->infoRecharge($cardId, $take, $checkDateViewMore);
        ?>
        @if(count($resultMore) > 0)
            <div class="tf_view_more tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <a class="tf-link" data-take="{!! $take !!}"
                   data-href="{!! route('tf.user.point.recharge.more.get') !!}">
                    {!! trans('frontend_user.point_recharge_view_more') !!}
                </a>
            </div>
        @endif
    @endif
</div>

