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

$hFunction = new Hfunction();
$dataUserLogin = $modelUser->loginUserInfo();
#action info
$userShareId = $dataBuildingShare->userId();
$actionStatus = false;
if (!empty($dataUserLogin)) {
    # image owner
    if ($dataUserLogin->userId() == $userShareId) $actionStatus = true;
}

$dataLand = $dataBuildingShare->land;

$totalView = $dataBuildingShare->totalView();
$totalViewRegister = $dataBuildingShare->totalViewRegister();

$dataBuilding = $dataBuildingShare->building;
?>
<table class="tf_share_object table table-hover tf-share-object"
       data-share="{!! $dataBuildingShare->shareId() !!}"
       data-date="{!! $dataBuildingShare->createdAt() !!}">
    <tr>
        <td class="col-xs-5 col-sm-4 col-md-4">
            <a class="tf-link" href="{!! route('tf.building',$dataBuilding->alias()) !!}" target="_blank"
               title="{!! $dataBuilding->name() !!}">
                <img style="max-width: 64px; max-height: 32px;" alt="land"
                     src="{!! $dataBuilding->buildingSample->pathImage() !!}">
                &nbsp;
                {!! $hFunction->cutString($dataBuilding->name(),15,'...') !!}
            </a>
        </td>
        <td class="col-xs-2 col-sm-2 col-md-2">
            <i class="fa fa-eye tf-font-size-16 tf-color-grey" title="View"></i>&nbsp;
            @if($totalView > 0)
                <a class="tf_view tf-link">
                    {!! $totalView !!}
                </a>
            @else
                {!! $totalView !!}
            @endif
        </td>
        <td class="col-xs-2 col-sm-2 col-md-2">
            <i class="fa fa-user tf-font-size-16 tf-color-grey" title="Register"></i>+ &nbsp;
            {!! $totalViewRegister !!}
        </td>
        <td class="col-xs-3 col-sm-4 col-md-4 text-right">
            <i class="fa fa-calendar tf-font-size-16 tf-color-grey" title="View"></i>&nbsp;
            {!! $dataBuildingShare->createdAt() !!}
        </td>
    </tr>
</table>
