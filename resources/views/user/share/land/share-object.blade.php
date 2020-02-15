<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 12:28 PM
 */
/*
 *
 * $modelUser
 * $dataLandShare
 *
 *
 */
$dataUserLogin = $modelUser->loginUserInfo();
#action info
$userShareId = $dataLandShare->userId();
$actionStatus = false;
if (!empty($dataUserLogin)) {
    # image owner
    if ($dataUserLogin->userId() == $userShareId) $actionStatus = true;
}

$dataLand = $dataLandShare->land;
$totalView = $dataLandShare->totalView();
$totalViewRegister = $dataLandShare->totalViewRegister();
?>
@if(count($dataLand)> 0)
    <table class="tf_share_object table table-hover tf-share-object"
           data-share="{!! $dataLandShare->shareId() !!}"
           data-date="{!! $dataLandShare->createdAt() !!}">
        <tr>
            <td class="col-xs-5 col-sm-4 col-md-4 col-lg-4">
                <a class="tf-link" href="{!! route('tf.map.land.access',$dataLand->landId() ) !!}" target="_blank">
                    <img style="max-width: 64px; max-height: 32px;" alt="land"
                         src="{!! asset('public/main/icons/icon-land.gif') !!}">
                    &nbsp;
                    {!! $dataLand->name() !!}
                </a>

            </td>
            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <i class="fa fa-eye tf-font-size-16 tf-color-grey" title="View"></i>&nbsp;
                @if($totalView > 0)
                    <a class="tf_view tf-link">
                        {!! $totalView !!}
                    </a>
                @else
                    {!! $totalView !!}
                @endif
            </td>
            <td class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                <i class="fa fa-user tf-font-size-16 tf-color-grey" title="Register"></i>+ &nbsp;
                {!! $totalViewRegister !!}
            </td>
            <td class="col-xs-3 col-sm-4 col-md-4 col-lg-4 text-right">
                <i class="fa fa-calendar tf-font-size-16 tf-color-grey" title="View"></i>&nbsp;
                {!! $dataLandShare->createdAt() !!}
            </td>
        </tr>
    </table>
@endif