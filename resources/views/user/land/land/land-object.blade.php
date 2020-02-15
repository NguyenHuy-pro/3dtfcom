<?php
/*
 * $modelUser
 * $dataUser
 * $dataLandLicense
 * $skip
 * $take
 */

$newSkip = $skip + $take;

# access user info
$userAccessId = $dataUser->userId();
?>
@if(count($dataLandLicense) > 0)
    <?php
    $dataMoreLandLicense = $dataUser->landLicenseOfUser($userAccessId, $newSkip, $take);
    ?>
    @foreach($dataLandLicense as $landLicenseObject)
        <?php
        $landId = $landLicenseObject->landId();
        $n_o = (isset($n_o)) ? $n_o + 1 : $skip + 1;
        $dateEnd = $landLicenseObject->dateEnd();
        $dateEnd = date_create($dateEnd);

        $dataLand = $landLicenseObject->land;
        $name = $dataLand->name();

        $dataBuilding = $dataLand->buildingInfo();
        if (count($dataBuilding) > 0) {
            $imageAlt = $dataBuilding->alias;
            $imageSrc = $dataBuilding->buildingSample->pathImage();
        } else {
            $imageAlt = 'land-icon';
            $imageSrc = asset('public\main\icons\icon-land.gif');
        }
        ?>
        <tr class="tf_user_land_object" data-land="{!! $landId !!}">
            <td class="tf-vertical-middle tf-border-none ">
                <b>{!! $n_o !!} .</b>&nbsp;
                <a class="tf-link" href="{!! route('tf.map.land.access',$landId ) !!}" target="_blank">
                    <img style="max-width: 64px; max-height: 64px;" alt="{!!$imageAlt !!}" src="{!! $imageSrc !!}"/>
                </a>
            </td>
            <td class="tf-vertical-middle tf-border-none ">
                <a class="tf-link" href="{!! route('tf.map.land.access',$landId ) !!}" target="_blank">
                    {!! $name !!} &nbsp; <i class="fa fa-map-marker tf-font-size-14"></i>
                </a>
            </td>
            <td class="tf-vertical-middle tf-border-none" title="expiry date">
                <span class="glyphicon glyphicon-calendar"></span> {!! date_format($dateEnd, 'd-m-Y')  !!}
            </td>
        </tr>
    @endforeach
    @if(count($dataMoreLandLicense) > 0)
        <tr id="tf_user_land_more">
            <td class="text-center" colspan="3">
                <a class="tf-link" data-user="{!! $userAccessId !!}" data-skip="{!! $newSkip !!}"
                   data-take="{!! $take !!}"
                   data-href="{!! route('tf.user.land.more') !!}">
                    {!! trans('frontend_user.land_info_view_more') !!}
                </a>
            </td>
        </tr>
    @endif
@endif