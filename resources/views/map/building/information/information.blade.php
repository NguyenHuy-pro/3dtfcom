<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/23/2017
 * Time: 6:56 PM
 *
 * $modelUser
 * $dataUserLogin
 * $dataUserBuilding
 *
 *
 */
$hFunction = new Hfunction();
#login info of user
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin)) {
    $loginStatus = true;
    $loginUserId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
}

#building info
$buildingId = $dataBuilding->buildingId();
$buildingName = $dataBuilding->name();
$buildingAlias = $dataBuilding->alias();
$shortDescription = $dataBuilding->shortDescription();
$website = $dataBuilding->website();
$landId = $dataBuilding->landLicense->landId();
$businessTypeOfBuilding = $dataBuilding->buildingSample->businessType->name();

#info of user (owner)
$dataUserBuilding = $dataBuilding->userInfo();
$buildingUserId = $dataUserBuilding->userId();
$buildingUserAlias = $dataUserBuilding->alias();
$userFullName = $dataUserBuilding->fullName();
$buildingUserAvatar = $dataUserBuilding->pathSmallAvatar($buildingUserId, true);

?>

<div class="tf_map_building_information tf-map-building-information tf-box-shadow" data-building="{!! $buildingId !!}">
    <table class="table tf-height-full" style="border-collapse: collapse;">
        <tr>
            <th class="tf-bg" colspan="2" style="border-radius: 5px;">
                <a class="tf-link-full tf-link-white-bold tf-font-size-14" href="{!! route('tf.building', $buildingAlias) !!}"
                   title="{!! $buildingName !!}" @if(!$hFunction->isHandset()) target="_blank" @endif>
                    {!! $hFunction->cutString($buildingName, 32,'...')  !!}
                </a>
            </th>
        </tr>
        <tr>
            <td class="col-xs-2 col-sm-2 col-md-1 col-lg-1 text-center">
                <span class="glyphicon glyphicon-list-alt tf-font-size-20"></span>
            </td>
            <td class="col-xs-10 col-sm-10 col-md-11 col-lg-11 text-left">
                <a class="tf-link" href="{!! route('tf.building.about.get', $buildingAlias) !!}"
                   @if(!$hFunction->isHandset()) target="_blank" @endif title="{!! $shortDescription !!}">
                    {!! $hFunction->cutString($shortDescription, 20,'...') !!}
                </a>
                <span class="badge pull-right" title="View">
                    {!! $dataBuilding->totalVisitHome() !!}
                </span>
                <a class="tf-link-bold pull-right tf-margin-rig-10"
                   href="{!! route('tf.building.about.get', $buildingAlias) !!}"
                   @if(!$hFunction->isHandset()) target="_blank" @endif>
                    View more
                </a>
            </td>
        </tr>
        <tr>
            <td class="col-xs-2 col-sm-2 col-md-1 col-lg-1 text-center">
                <span class="glyphicon glyphicon-globe tf-font-size-20"></span>
            </td>
            <td class="col-xs-10 col-sm-10 col-md-11 col-lg-11 text-left">
                @if(empty($website))
                    <em>{!! trans('frontend_map.building_detail_none') !!}</em>
                @else
                    <a class="tf_map_building_website" href="http://{!! $website !!}"
                       @if(!$hFunction->isHandset()) target="_blank" @endif
                       title="{!! $website !!}" rel="nofollow"
                       data-visit-href="{!! route('tf.building.visit.web.plus') !!}">
                        {!! $hFunction->cutString($website, 25,'') !!}
                    </a>
                @endif
                <span class="badge pull-right" title="Total visit">
                    {!! $dataBuilding->totalVisitWebsite() !!}
                </span>
            </td>
        </tr>
        <tr>
            <td class="col-xs-2 col-sm-2 col-md-1 col-lg-1 text-center">
                <img class="tf-icon-20" alt="{!! $dataUserBuilding->alias() !!}" src="{!! $buildingUserAvatar !!}">
            </td>
            <td class="col-xs-10 col-sm-10 col-md-11 col-lg-11 text-left">
                <a class="tf-link" href="{!! route('tf.user.home',$buildingUserAlias) !!}"
                   @if(!$hFunction->isHandset()) target="_blank" @endif
                   title="{!! $userFullName !!}">
                    {!! $userFullName !!}
                </a>
            </td>
        </tr>

        {{--statistic--}}
        <tr>
            <td colspan="2">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                    <span class="glyphicon glyphicon-paperclip tf-color-grey tf-font-bold"></span>
                    <span>{!! $dataBuilding->totalFollow() !!}</span>
                    <br/>
                    @if($loginStatus)
                        @if($loginUserId != $buildingUserId)
                            <?php
                            if ($dataUserLogin->checkFollowBuilding($buildingId)) {
                                $followLabel = trans('frontend_map.button_following');
                                $followHref = route('tf.map.building.follow.minus');
                            } else {
                                $followLabel = trans('frontend_map.button_follow');
                                $followHref = route('tf.map.building.follow.plus');
                            }
                            ?>
                            <a class="tf_follow tf-link-bold" data-href="{!! $followHref !!}">
                                {!! $followLabel  !!}
                            </a>
                        @endif
                    @else
                        <a class="tf_follow tf-link-bold" data-href="{!! route('tf.map.building.follow.plus') !!}">
                            {!! trans('frontend_map.button_follow') !!}
                        </a>
                    @endif
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                    <span class="glyphicon glyphicon-comment tf-color-grey tf-font-bold"></span>
                    <span>{!! $dataBuilding->totalComment() !!}</span>
                    <br/>
                    <a class="tf_comment tf-link-bold"
                       data-href="{!! route('tf.map.building.comment.index') !!}">
                        {!! trans('frontend_map.button_comment') !!}
                    </a>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                    <span class="glyphicon glyphicon-thumbs-up tf-color-grey tf-font-bold"></span>
                    <span>{!! $dataBuilding->totalLove() !!}</span>
                    <br>
                    @if($loginStatus)
                        <?php
                        if ($dataUserLogin->checkLoveBuilding($buildingId)) {
                            $loveLabel = trans('frontend_map.button_loved');
                            $loveHref = route('tf.map.building.love.minus');
                        } else {
                            $loveLabel = trans('frontend_map.button_love');
                            $loveHref = route('tf.map.building.love.plus');
                        }
                        ?>
                        <a class="tf_love tf-link-bold" data-href="{!! $loveHref !!}">
                            {!! $loveLabel !!}
                        </a>
                    @else
                        <a class="tf_love tf-link-bold" data-href="{!! route('tf.map.building.love.plus') !!}">
                            {!! trans('frontend_map.button_love') !!}
                        </a>
                    @endif
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-center">
                    <span class="fa fa-share-alt tf-color-grey tf-font-bold"></span>
                    <span>{!! $dataBuilding->totalShare() !!}</span>
                    <br>
                    <a class="tf_share tf-link-bold"
                       data-href="{!! URL::route('tf.map.building.share.get') !!}">
                        {!! trans('frontend_map.button_share') !!}
                    </a>
                </div>
            </td>
        </tr>
    </table>
</div>
