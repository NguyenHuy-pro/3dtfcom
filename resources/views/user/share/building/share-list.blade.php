<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 10:51 AM
 */
/*
 *
 * $modelUser
 * $dataUser
 *
 *
 */

$hFunction = new Hfunction();

#access user info
$userAccessId = $dataUser->userId();


$take = 30;
$dateTake = $hFunction->carbonNow();

#share
$shareInfo = $dataUser->infoBuildingShare($userAccessId, $take, $dateTake);

?>
<div class="row tf_user_share_container" data-user="{!! $userAccessId !!}"
     data-href-view="{!! route('tf.user.share.building.detail') !!}">
    <div class="tf_list_content tf-bg-white col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        @if(count($shareInfo) > 0)
            @foreach($shareInfo as $dataBuildingShare)
                @include('user.share.building.share-object', compact('dataBuildingShare'),
                    [
                        'modelUser'=>$modelUser,
                        'dataUser'=> $dataUser
                    ])
                <?php
                $checkDateViewMore = $dataBuildingShare->createdAt();
                ?>
            @endforeach
        @endif
    </div>
    {{--view more old image--}}
    @if(count($shareInfo) > 0)
        <?php
        #check exist of image
        $resultMore = $dataUser->infoLandShare($userAccessId, $take, $checkDateViewMore);
        ?>
        @if(count($resultMore) > 0)
            <div class="tf_view_more tf-padding-20 text-center col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <a class="tf-link" data-take="{!! $take !!}"
                   data-href="{!! route('tf.user.share.building.more.get') !!}">
                    {!! trans('frontend_user.share_building_view_more') !!}
                </a>
            </div>
        @endif
    @endif
</div>

