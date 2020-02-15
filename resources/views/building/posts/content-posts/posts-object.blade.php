<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/28/2016
 * Time: 11:08 AM
 *
 * $modelUser
 * $dataBuilding
 * $dataBuildingPost
 * $dataUserBuilding
 *
 *
 */


$mobileDetect = new Mobile_Detect();
//info of user login
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
    $userLoginId = null;
}

# building owner
$userBuildingId = $dataUserBuilding->userId();

$dataBuildingPost = $dataBuildingActivity->buildingPost;
#content posts
$buildingId = $dataBuildingPost->buildingId();
$postId = $dataBuildingPost->postId();
$postCode = $dataBuildingPost->postCode();
$userPostId = $dataBuildingPost->userId();
$postsContent = $dataBuildingPost->content();
$postsImage = $dataBuildingPost->image();
$postsBuildingIntroId = $dataBuildingPost->buildingIntroId();
$dateAdded = $dataBuildingPost->createdAt();
$date = new DateTime($dateAdded);
$datePosts = $date->format('m-d-Y H:i:s');

$dataUserPost = $dataBuildingPost->user;
$userPostAvatarPath = $dataUserPost->pathSmallAvatar($dataUserPost->userId(), true);
$userPostAlias = $dataUserPost->alias();

$buildingOwner = false;
if (($loginStatus && $userLoginId == $userBuildingId)) {
    $buildingOwner = true;
}

?>
<div id="tf_building_posts_object_{!! $postId !!}"
     class="panel panel-default tf_building_activity_object tf_building_posts_object  tf-building-posts-object tf-margin-bot-10"
     data-posts="{!! $postId !!}" data-date="{!! $dataBuildingActivity->createdAt() !!}">
    <div class="panel-heading tf-bg-none tf-border-none">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <div class="media">
                    <a class="tf-link pull-left" href="{!! route('tf.user.home',$userPostAlias) !!}"
                       @if(!$mobileDetect->isMobile()) target="_blank" @endif>
                        <img class="tf-border tf-icon-40 tf-border-radius-4" alt="keyword-seo"
                             src="{!! $userPostAvatarPath !!}">
                    </a>

                    <div class="media-body">
                        <h4 class="media-heading">
                            <a class="tf-link-bold" href="{!! route('tf.user.home',$userPostAlias) !!}"
                               @if(!$mobileDetect->isMobile()) target="_blank" @endif>
                                {!! $dataUserPost->fullName() !!}
                            </a>
                        </h4>
                        <em class="tf-color-grey">{!! $datePosts !!}</em>
                    </div>
                </div>
            </div>

            {{--grant post--}}
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right ">
                @if($dataBuildingPost->highlight() == 1)
                    <i class="glyphicon glyphicon-star tf-font-bold tf-color-orange"
                       title="{!! trans('frontend_building.post_highlight_title') !!}"></i>
                @else
                    @if($loginStatus && $buildingOwner)
                        <a class="tf_highlight_on tf-link-grey"
                           data-href="{!! route('tf.building.posts.highlight.update') !!}">
                            {!! trans('frontend_building.post_highlight_on') !!}
                        </a>
                        &nbsp;
                    @endif
                @endif
                @if($loginStatus)
                    <i class="fa fa-chevron-down dropdown-toggle tf-link-grey tf-font-size-14"
                       data-toggle="dropdown"></i>
                    <ul class="dropdown-menu dropdown-menu-right tf_posts_object_menu tf-padding-none tf-font-size-12">
                        {{--highlight info--}}
                        @if($dataBuildingPost->highlight() == 1)
                            @if($buildingOwner)
                                <li>
                                    <a class="tf_highlight_off tf-bg-hover"
                                       data-href="{!! route('tf.building.posts.highlight.update') !!}">
                                        {!! trans('frontend_building.post_menu_highlight_drop') !!}
                                    </a>
                                </li>
                            @endif
                        @endif
                        {{--report info--}}
                        @if($userLoginId != $userPostId)
                            {{--visitor does not onwer of posts--}}
                            <li>
                                <a class="tf_report tf-bg-hover"
                                   data-href="{!! route('tf.building.posts.report.get') !!}">
                                    {!! trans('frontend_building.post_menu_bad_info') !!}
                                </a>
                            </li>
                        @endif

                        {{--edit info--}}
                        @if($userLoginId == $userPostId)
                            <li>
                                <a class="tf_edit tf-bg-hover"
                                   data-href="{!! route('tf.building.posts.edit.get') !!}">
                                    {!! trans('frontend_building.post_menu_edit') !!}
                                </a>
                            </li>
                        @endif

                        {{--delete --}}
                        @if($buildingOwner or $userLoginId == $userPostId)
                            <li>
                                <a class="tf_delete tf-bg-hover"
                                   data-href="{!! route('tf.building.posts.delete') !!}">
                                    {!! trans('frontend_building.post_menu_delete') !!}
                                </a>
                            </li>
                        @endif
                    </ul>
                @endif
            </div>

        </div>
    </div>

    {{--text post--}}
    <div class="panel-body">
        {{--content--}}
        <div class="row">
            <div id="tf_building_posts_object_content_{!! $postId !!}" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @include('building.posts.content-posts.posts-object-content',
                [
                    'modelUser' => $modelUser,
                    'dataBuildingPost'=>$dataBuildingPost,
                ])
            </div>
        </div>

        {{--building statistic--}}
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-building-posts-object-statistic text-right">
            {{--comment--}}
            <i class="glyphicon glyphicon-comment"></i>
            <span class="tf_building_post_comment_total">{!! $dataBuildingPost->totalComment() !!}</span>
            @if($loginStatus)
                <a class="tf-link" href="#">Comment</a>
            @else
                <span class="tf-color-grey">Comment</span>
            @endif &nbsp;

            {{--love--}}
            <i class="glyphicon glyphicon-thumbs-up"></i>
            <span class="tf_building_post_love_total">{!! $dataBuildingPost->totalLove() !!}</span>
            @if($loginStatus)
                @if($dataUserLogin->existUserLovePosts($postId))
                    <?php $labelLove = 'UnLove'; ?>
                @else
                    <?php $labelLove = 'Love'; ?>
                @endif
                <a class="tf_building_post_love tf-link"
                   data-href="{!! route('tf.building.posts.love') !!}">{!! $labelLove !!}</a>
            @else
                <span class="tf-color-grey">love</span>
            @endif

        </div>

        {{--comment--}}

        @include('building.posts.comments.comment-list',
            [
                'dataBuildingPost'=>$dataBuildingPost,
                'dataUserBuilding' => $dataUserBuilding,
                'dataUserLogin' =>$dataUserLogin
            ])

    </div>

</div>
