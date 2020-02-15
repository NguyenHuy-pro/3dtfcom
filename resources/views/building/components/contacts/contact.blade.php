<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/4/2016
 * Time: 8:45 AM
 *
 * modelUser
 * dataBuilding
 * dataBuildingAccess
 */

# info of user login
$hFunction = new Hfunction();
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
    $userLoginId = null;
}

# building info
$buildingId = $dataBuilding->buildingId();
$phone = $dataBuilding->phone();
$email = $dataBuilding->email();
$address = $dataBuilding->address();
$website = $dataBuilding->website();

$userBuildingId = $dataUserBuilding->userId();

$ownerStatus = false;
if ($loginStatus) {
    if ($userLoginId == $userBuildingId) $ownerStatus = true;
}

?>
<div class="row">
    <div class="tf_building_contact_wrap tf-building-contact-wrap tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12"
         data-building="{!! $buildingId !!}">
        <ul class="list-group">
            @if($ownerStatus)
                <li class="list-group-item tf-contact-border text-right">
                    <a class="tf_building_info_contact_edit tf-link tf-text-under"
                       href="{!! route('tf.building.information.get', $dataBuilding->alias()) !!}">
                        <i class="fa fa-cog"></i>
                        {!! trans('frontend_building.info_setting_label') !!}
                    </a>
                </li>
            @endif
            {{--phone--}}
            <li class="list-group-item tf-contact-border">
                <i class="fa fa-phone-square tf-icon"></i> &nbsp;
                @if(strlen($phone) > 0)
                    {!! $phone !!}
                @else
                    @if($ownerStatus)
                        <a class="tf-link-grey"
                           href="{!! route('tf.building.information.get', $dataBuilding->alias()) !!}">
                            <em>{!! trans('frontend_building.contact_phone_null_notify') !!}</em>
                        </a>
                    @else
                        <em>Null</em>
                    @endif
                @endif

            </li>


            {{--email--}}
            <li class="list-group-item tf-contact-border">
                <i class="fa fa-envelope tf-icon"></i> &nbsp;
                @if(strlen($email) > 0)
                    {!! $email !!}
                @else
                    @if($ownerStatus)
                        <a class="tf-link-grey"
                           href="{!! route('tf.building.information.get', $dataBuilding->alias()) !!}">
                            <em>{!! trans('frontend_building.contact_email_null_notify') !!}</em>
                        </a>
                    @else
                        <em>Null</em>
                    @endif
                @endif

            </li>

            {{--address--}}
            <li class="list-group-item tf-contact-border">
                <i class="fa fa-map-marker tf-icon"></i> &nbsp;
                @if(strlen($address) > 0)
                    {!! $address !!}
                @else
                    @if($ownerStatus)
                        <a class="tf-link-grey"
                           href="{!! route('tf.building.information.get', $dataBuilding->alias()) !!}">
                            <em>{!! trans('frontend_building.contact_address_null_notify') !!}</em>
                        </a>
                    @else
                        <em>Null</em>
                    @endif
                @endif

            </li>

            {{--website--}}
            <li class="list-group-item tf-contact-border">
                <i class="fa fa-globe tf-icon"></i> &nbsp;
                @if(strlen($website) > 0)
                    <a class="tf_building_contact_website tf-link-green" @if(!$hFunction->isHandset()) target="_blank"
                       @endif data-building="{!! $buildingId !!}"
                       data-visit-href="{!! route('tf.building.visit.web.plus') !!}"
                       href="http://{!! $website !!}" rel="nofollow">
                        <em>{!! (empty($website))? 'None': $website !!}</em>
                    </a>
                @else
                    @if($ownerStatus)
                        <a class="tf-link-grey"
                           href="{!! route('tf.building.information.get', $dataBuilding->alias()) !!}">
                            <em>{!! trans('frontend_building.contact_website_null_notify') !!}</em>
                        </a>
                    @else
                        <em>Null</em>
                    @endif
                @endif

            </li>

        </ul>
    </div>
</div>
