<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 10:51 AM
 */
/*
 *
 * modelUser
 * dataUser
 *
 */
$hFunction = new Hfunction();

#access user info
$userAccessId = $dataUser->userId();

$take = 30;
#card info
$dataUserCard = $dataUser->userCard;
$cardId = $dataUserCard->cardId();

$nganluongList = $dataUserCard->infoNganLuongOrder($cardId, $take, null);
?>
<div class="row tf_user_point_nganluong" data-user="{!! $userAccessId !!}"
     data-href-view="{!! route('tf.user.point.nganluong.detail') !!}">
    <div class="tf_list_content tf-bg-white col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <table class="table ">
            <tr>
                <th class="tf-border-none col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    {!! trans('frontend_user.point_nganluong_label_code') !!}
                </th>
                <th class="tf-border-none col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    {!! trans('frontend_user.point_nganluong_label_point') !!}
                </th>
                <th class="tf-border-none col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    {!! trans('frontend_user.point_nganluong_label_date') !!}
                </th>
            </tr>
        </table>
        @if(count($nganluongList) > 0)
            @foreach($nganluongList as $dataNganLuongOrder)
                @include('user.point.nganluong.nganluong-object', compact('dataNganLuongOrder'),
                    [
                        'modelUser'=>$modelUser,
                        'dataUser'=> $dataUser
                    ])
                <?php
                $checkDateViewMore = $dataNganLuongOrder->createdAt();
                ?>
            @endforeach
        @else
            <table class="table">
                <tr>
                    <td class="tf-border-none text-center">
                        {!! trans('frontend_user.point_nganluong_null_notify') !!}
                    </td>
                </tr>
            </table>
        @endif
    </div>
    {{--view more old image--}}
    @if(count($nganluongList) > 0)
        <?php
        #check exist of image
        $resultMore = $dataUserCard->infoNganLuongOrder($cardId, $take, $checkDateViewMore);
        ?>
        @if(count($resultMore) > 0)
            <div class="tf_view_more tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <a class="tf-link" data-take="{!! $take !!}"
                   data-href="{!! route('tf.user.point.nganluong.more.get') !!}">
                    {!! trans('frontend_user.point_nganluong_view_more') !!}
                </a>
            </div>
        @endif
    @endif
</div>

