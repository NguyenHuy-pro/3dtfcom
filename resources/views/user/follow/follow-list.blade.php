<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/30/2016
 * Time: 12:27 AM
 *
 * $modelUser
 * $dataUser
 *
 */

$hFunction = new Hfunction();
# user info access
$userAccessId = $dataUser->userId();

$take = 2;
$dateTake = $hFunction->carbonNow();
$resultBuildingFollow = $modelUser->buildingFollowOfUser($userAccessId, $take, $dateTake);

?>
<div class="tf_user_follow_container tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12" data-user="{!! $userAccessId !!}">

    <div class="tf_list_content tf-bg-white tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12"
         data-href-del="{!! route('tf.map.building.follow.minus') !!}">
        @if(count($resultBuildingFollow) > 0)
            @foreach($resultBuildingFollow as $dataBuildingFollow)
                @include('user.follow.follow-object',
                    [
                        'modelUser' => $modelUser,
                        'dataUser' => $dataUser,
                        'dataBuildingFollow' => $dataBuildingFollow
                    ])
                <?php
                $checkDateViewMore = $dataBuildingFollow->createdAt();
                ?>
            @endforeach
        @endif
    </div>
    {{--view more old image--}}
    @if(count($resultBuildingFollow) > 0)
        <?php
        #check exist of follow
        $resultMore = $modelUser->buildingFollowOfUser($userAccessId, $take, $checkDateViewMore);
        ?>
        @if(count($resultMore) > 0)
            <div class="tf_view_more tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <a class="tf-link" data-take="{!! $take !!}" data-href="{!! route('tf.user.follow.more.get') !!}">
                    {!! trans('frontend_user.follow_building_view_more') !!}
                </a>
            </div>
        @endif
    @endif

</div>