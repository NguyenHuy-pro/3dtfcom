<?php
/*
 *
 * $modelUser
 * $dataUser
 * dataAccess
 *
 */
#user login info
$dataUserLogin = $modelUser->loginUserInfo();

# access user
$userId = $dataUser->userId();
$actionStatus = false;
if (count($dataUserLogin) > 0) {
    # image owner
    if ($dataUserLogin->userId() == $userId) $actionStatus = true;
}

$sellerObject = $dataAccess['sellerObject'];
$dataSellerPaymentPrice = (isset($dataAccess['dataSellerPaymentPrice'])) ? $dataAccess['dataSellerPaymentPrice'] : null;
?>
@extends('user.index')

@section('titlePage')
    {!! trans('frontend_user.title_page_seller') !!}
@endsection

{{--insert js to process seller  --}}
@section('tf_user_page_js_header')
    <script src="{{ url('public/user/js/user-seller.js')}}"></script>
@endsection

@section('tf_user_content')
    <div class="panel panel-default tf-border-bot-none">
        <div class="panel-heading tf-padding-none tf-border-bot-none">
            <ul class="nav nav-tabs" role="tablist">
                <li class=" @if($sellerObject == 'statistic') active  @endif">
                    <a class="tf-link" href="{!! route('tf.user.seller.statistic.get') !!}">
                        {!! trans('frontend_user.seller_menu_statistic') !!}
                    </a>
                </li>
                <li class="@if($sellerObject == 'payment') active  @endif">
                    <a class="tf-link" href="{!! route('tf.user.seller.payment.get') !!}">
                        {!! trans('frontend_user.seller_menu_payment') !!}
                    </a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <em>Code: {!! $dataUser->seller->sellerCode() !!}</em>
            </div>
            {{--statistic content--}}
            @if($sellerObject == 'statistic')
                @include('user.seller.statistic.list', compact('dataSellerPaymentPrice'),
                    [
                        'modelUser' => $modelUser,
                        'dataUser' => $dataUser
                    ])

                {{-- payment content --}}
            @elseif($sellerObject == 'payment')
                @include('user.seller.payment.list',
                    [
                        'modelUser' => $modelUser,
                        'dataUser' => $dataUser
                    ])
                {{--share building--}}
            @endif
        </div>
    </div>
@endsection