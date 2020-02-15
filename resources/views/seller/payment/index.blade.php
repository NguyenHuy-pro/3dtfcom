<?php
/*
 * modelUser
 * modelSellerGuide
 * dataSellerAccess
 */
$dataSellerGuide = $modelSellerGuide->infoOfPayment();
?>

@extends('seller.index')
@section('titlePage')
    {!! trans('frontend_seller.title_page_guide') !!}
@endsection

@section('seller_menu')
    @include('seller.components.menu.menu', ['dataSellerAccess' => $dataSellerAccess])
@endsection

@section('seller_content')
    <div class="row">
        <div class="tf-padding-top-30 col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <table class="table">
                @if(count($dataSellerGuide) > 0)
                    @foreach($dataSellerGuide as $sellerGuide)
                        <tr>
                            <td class="tf-border-none">
                                <label>* {!! $sellerGuide->name() !!}</label>
                            </td>
                        </tr>
                        <tr>
                            <td class="tf-border-none">
                                {!! $sellerGuide->content() !!}
                            </td>
                        </tr>
                        @if(!empty($sellerGuide->video()))
                            <tr>
                                <td class="tf-border-none text-center">
                                    <em>{!! trans('frontend_seller.guide_payment_video_label') !!}</em>
                                    <br/>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-8 col-lg-offset-2">
                                            <iframe width="100%" height="500" src="//www.youtube.com/embed/{!! $sellerGuide->video() !!}?autoplay=0"
                                                    frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    </div>

                                </td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td class="tf-border-none">
                            <em>{!! trans('frontend_seller.guide_payment_notify_null') !!}</em>
                        </td>
                    </tr>
                @endif

            </table>
        </div>
    </div>
@endsection