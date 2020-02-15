<?php
/*
 * modelUser
 * dataPointAccess
 * dataPointTransaction
 */

$hFunction = new Hfunction();
$package = $dataPointAccess['package'];

$pointTransaction = $dataPointTransaction->pointValue();
$usdTransaction = $dataPointTransaction->usdValue();
$onePoint = $usdTransaction / $pointTransaction; //point/USD

?>
@extends('point.online.index')
@section('online_content')
    <div class="panel panel-default tf-border-bot-none">
        <div class="panel-heading">
            <img src="{!! url('public\imgsample\moneyPackage.png') !!}" alt="point-package">
            &nbsp;{!! trans('frontend_point.online_payment_title_package') !!}
            <em>({!! trans('frontend_point.online_payment_title_package_notice') !!})</em>
        </div>

        {{--select package--}}
        <form id="frm_point_online_package" class="panel-body" name="frm_point_online_package" method="get"
              action="{!! route('tf.point.online.wallet.get') !!}">
            <div class="row">
                <?php
                $packageLimit = 20;
                $point = 50;
                ?>
                @for($i = 1;$i <= $packageLimit ;$i++)
                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                        <div class="tf_point_package thumbnail tf-cursor-pointer tf-border-radius-10"
                             data-point="{!! $point !!}">
                            <div class="caption">
                                <span class="tf-font-bold tf-color-red">{!! $hFunction->dotNumber($point) !!}</span>
                                <span class="tf-color-grey">Point</span>
                                <br/>
                                <i class="fa fa-arrow-down"></i>
                                <br/>
                                <span class="tf-color-red">{!! $hFunction->dotNumber($point * $onePoint) !!}</span>
                                <span class="tf-color-grey">USD</span>
                                <br/>
                                <i class="glyphicon glyphicon-hand-right"></i>
                                <a class="tf_point_package_buy_button tf-point-package-buy-button tf-link-hover-white tf-bg-hover btn btn-default pull-right">
                                    {!! trans('frontend_point.online_payment_package_label_buy') !!}
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                    $point = $point + 50;
                    ?>
                @endfor
            </div>
            <input type="hidden" class="txt_point" name="txtPoint" value="">
            <input name="_token" type="hidden" value="{!! csrf_token() !!}">
        </form>
    </div>
@endsection