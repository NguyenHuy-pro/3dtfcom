<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/30/2016
 * Time: 12:27 AM
 */
/*
 *
 * $modelUser
 * $dataUser
 * $dataBuildingFollow
 *
 *
 */

$mobile = new Mobile_Detect();
$dataUserLogin = $modelUser->loginUserInfo();
#access user
$userAccessId = $dataUser->userId();

# follow info
$buildingFollowId = $dataBuildingFollow->buildingId();

#building info
$dataBuilding = $dataBuildingFollow->building;

$alias = $dataBuilding->alias();

$actionStatus = false;
if (count($dataUserLogin) > 0) {
    if ($dataUserLogin->userId() == $userAccessId) $actionStatus = true;
}
?>
<table class="tf_follow_object tf-follow-object table" data-date="{!! $dataBuildingFollow->createdAt() !!}"
     data-building="{!! $buildingFollowId !!}">
    <tr>
        <td class="tf-padding-none ">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  ">
                <div class="tf-padding-10 text-left col-xs-12 col-sm-3 col-md-2 col-lg-2">
                    <img style="max-width: 64px;" alt="{!! $alias !!}"
                         src="{!! $dataBuilding->buildingSample->pathImage() !!}"/>
                    @if(!$mobile->isMobile()) <br/> @else &nbsp;&nbsp;&nbsp; @endif
                    @if($actionStatus)
                        <a class="tf_delete tf-link">
                            <button class="btn btn-default btn-xs">{!! trans('frontend_user.follow_building_menu_delete') !!}</button>
                        </a>
                    @endif
                </div>
                <div class="tf-padding-10 text-left tf-statistic col-xs-12 col-sm-9 col-md-10 col-lg-10">
                    <h4>{!! $dataBuilding->name() !!}</h4>
                    <p>
                        <a class="tf-link" href="{!! route('tf.building',$alias) !!}">
                            {!! trans('frontend_user.follow_building_view_detail') !!}
                        </a>
                        &nbsp;<i class="fa fa-minus tf-color-grey"></i>&nbsp;
                        <a class="tf-link" href="{!! route('tf.home',$alias) !!}" target="_blank">
                            {!! trans('frontend_user.follow_building_view_on_map') !!}
                            &nbsp;
                            <i class="fa fa-map-marker tf-font-size-14"></i>
                        </a>
                    </p>
                    <p class="tf-statistic">
                        <i class="glyphicon glyphicon-eye-open tf-icon"></i>
                        {!! $dataBuilding->totalVisit() !!} &nbsp;&nbsp;
                        <i class="glyphicon glyphicon-paperclip tf-icon"></i>
                        {!! $dataBuilding->totalFollow() !!} &nbsp;&nbsp;
                        <i class="glyphicon glyphicon-comment tf-icon"></i>
                        {!! $dataBuilding->totalComment() !!}&nbsp;&nbsp;
                        <i class="glyphicon glyphicon-thumbs-up tf-icon"></i>
                        {!! $dataBuilding->totalLove() !!}&nbsp;&nbsp;
                        <i class="fa fa-share-alt tf-icon"></i>
                        {!! $dataBuilding->totalShare() !!}
                    </p>
                </div>
            </div>
        </td>
    </tr>
</table>
