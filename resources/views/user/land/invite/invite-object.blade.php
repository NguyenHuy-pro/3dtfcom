<?php
/*
 *
 * $modelUser
 * $dataUser
 * dataLandLicenseInvite
 * $skip
 *
 *
 */
$hFunction = new Hfunction();
$dataUserLogin = $modelUser->loginUserInfo();


$dataLandLicense = $dataLandLicenseInvite->landLicense;
?>
@if(count($dataLandLicense) > 0)
    <?php
    $dataBuilding = $dataLandLicense->buildingViable();
    if (count($dataBuilding) > 0) {
        $imageSrc = $dataBuilding->buildingSample->pathImage();
    } else {
        $imageAlt = 'land-icon';
        $imageSrc = asset('public\main\icons\icon-land.gif');
    }
    ?>
    <table class="tf_user_land_invite_object table table-hover  tf-border-none ">
        <tr class="tf-border-bottom">
            <td class="tf-vertical-middle tf-border-none ">
                <a class="tf-link" href="{!! route('tf.map.land.access',$dataLandLicense->landId() ) !!}"
                   target="_blank">
                    <img style="max-width: 64px; max-height: 64px;" alt="land" src="{!! $imageSrc !!}">
                    &nbsp;
                    {!! $dataLandLicense->land->name() !!}
                </a>
            </td>
            <td class="tf-vertical-middle tf-border-none col-xs-5 col-sm-5 col-md-5 col-lg-5" title="expiry date">
                <b>To:</b>&nbsp; {!! $dataLandLicenseInvite->email() !!}
            </td>
            <td class="tf-vertical-middle tf-border-none text-right col-xs-3 col-sm-3 col-md-3 col-lg-3 ">
                {!! $hFunction->dateFormatDMY($dataLandLicenseInvite->createdAt(),'-') !!}
                <br/>
                <a class="tf_cancel tf-link" data-invite="{!! $dataLandLicenseInvite->inviteId() !!}"
                   data-href="{!! route('tf.user.land.invited.cancel') !!}">
                    {!! trans('frontend.button_cancel') !!}
                </a>
            </td>
        </tr>
    </table>
@endif

