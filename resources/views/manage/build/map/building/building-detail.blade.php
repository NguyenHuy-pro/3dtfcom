<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/29/2016
 * Time: 4:02 PM
 */
$hFunction = new Hfunction();
#info of building
$buildingId = $dataBuilding->buildingId();
$buildingAlias = $dataBuilding->alias();
$shortDescription = $dataBuilding->shortDescription();
$website = $dataBuilding->website();
$email = $dataBuilding->email();
$address = $dataBuilding->address();
$phone = $dataBuilding->phone();
$landId = $dataBuilding->landId();

#get user id of land contain building
$dataUser = $dataBuilding->userInfo();
$buildingUserId = $dataUser->userId();
$buildingUserAlias = $dataUser->alias();
$userFullName = $dataUser->fullName();
$buildingUserAvatar = $dataUser->pathSmallAvatar($buildingUserId);

?>
<div class="dropdown-menu tf-m-build-building-detail" data-building="{!! $buildingId !!}">
    <div class="tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border-bottom: 1px solid #eceadf;">
        <div class="col-md-2 text-center">
            @if(empty($buildingUserAvatar))
                <span class="glyphicon glyphicon-user"></span>
            @else
                <img class="tf-icon-20 tf-border-radius-4" alt="{!! $buildingUserAlias !!}"
                     src="{!!$buildingUserAvatar !!}">
            @endif
        </div>
        <div class="col-md-10 tf-padding-none" title="{!! $userFullName !!}">
            <a href="{!! route('tf.user.home',$buildingUserAlias) !!}" target="_blank">
                {!! $hFunction->cutString($userFullName, 50, '...') !!}
            </a>
        </div>
    </div>
    <div class="col-md-12 tf-padding-none">
        <div class="col-md-12 tf-padding-none">
            <div class="col-md-2 text-center">
                <span class="glyphicon glyphicon-list-alt"></span>
            </div>
            <div class="col-md-10 tf-padding-none" title="{!! $shortDescription !!}">
                {!! $hFunction->cutString($shortDescription, 50,'...') !!}
            </div>
        </div>
        <div class="col-md-12 tf-padding-none">
            <div class="col-md-2 text-center">
                <span class="glyphicon glyphicon-globe"></span>
            </div>
            <div class="col-lg-10 tf-padding-none" title="{!! $website !!}">
                @if(empty($website))
                    <em>None</em>
                @else
                    <a class="tfMapBuildingWebsite" href="http://{!! $website !!}" target="_blank"
                       data-visit-href="{!! route('tf.building.visit.web.plus') !!}">
                        {!! $hFunction->cutString($website, 50,'...') !!}
                    </a>
                @endif
            </div>
        </div>
        <div class="col-md-12 tf-padding-none">
            <div class="col-md-2 text-center ">
                <span class="glyphicon glyphicon-envelope"></span>
            </div>
            <div class="col-md-10 tf-padding-none" title="{!! $email !!}">
                @if(empty($email))
                    <em>None</em>
                @else
                    {!! $hFunction->cutString($email, 40,'...') !!}
                @endif
            </div>
        </div>
        <div class="col-md-12 tf-padding-none">
            <div class="col-md-2 text-center ">
                <span class="glyphicon glyphicon-phone-alt"></span>
            </div>
            <div class="col-md-10 tf-padding-none">
                @if(empty($phone))
                    <em>None</em>
                @else
                    {!! $phone !!}
                @endif
            </div>
        </div>
        <div class="col-md-12 tf-padding-none">
            <div class="col-md-2 text-center ">
                <span class="glyphicon glyphicon-home"></span>
            </div>
            <div class="col-md-10 tf-padding-none" title="{!! $address !!}">
                @if(empty($address))
                    <em>None</em>
                @else
                    {!! $hFunction->cutString($address,40, '...') !!}
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-12 tf-padding-none" style="border-top: 1px solid #eceadf;">
        <div class="col-lg-3 text-center tf-padding-none">
            <span class="glyphicon glyphicon-eye-close"></span>
            <span>{!! $dataBuilding->totalFollow !!}</span><br>
        </div>
        <div class="col-lg-3 text-center ">
            <span class="glyphicon glyphicon-comment"></span>
            <span>{!! $dataBuilding->totalComment !!}</span><br>
        </div>
        <div class="col-lg-3 text-center tf-padding-none">
            <span class="glyphicon glyphicon-thumbs-up"></span>
            <spa>{!! $dataBuilding->totalLove !!}</spa>
        </div>
        <div class="col-lg-3 text-center ">
            <span class="glyphicon glyphicon-random"></span>
            <spa>{!! $dataBuilding->totalShare !!}</spa>
        </div>
    </div>
</div>