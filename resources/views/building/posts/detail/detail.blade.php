<?php
/*
 *
 *
 * modelUser
 * dataBuildingPost
 * dataBuildingAccess
 *
 *
 */
#post info
$postCode = $dataBuildingPost->postCode();
$postContent = $dataBuildingPost->content();
$postImage = $dataBuildingPost->image();
$postBuildingIntroId = $dataBuildingPost->buildingIntroId();

#user info
$dataUserPost = $dataBuildingPost->user;
$userPostAvatarPath = $dataUserPost->pathSmallAvatar($dataUserPost->userId(), true);
$userPostAlias = $dataUserPost->alias();

$dataBuilding = $dataBuildingPost->building;
$dataUserBuilding = $dataBuilding->userInfo();

$buildingSampleImage = $dataBuilding->buildingSample->pathImage();
$alias = $dataBuilding->alias();
$shortDescription = $dataBuilding->shortDescription();

$dataBuildingBanner = $dataBuilding->bannerInfoUsing();
# title image to share on social network
if (empty($postImage)) {
    #get banner is using
    if (count($dataBuildingBanner) > 0) {
        $imgShareSrc = $dataBuildingBanner->pathFullImage();

    } else {
        $imgShareSrc = $dataBuilding->pathBannerImageDefault();
    }
} else {
    $imgShareSrc = $dataBuildingPost->pathSmallImage();
}


$metaKeyword = $dataBuilding->metaKeyword();
$metaKeyword = (empty($metaKeyword)) ? $shortDescription : $metaKeyword;
?>
@extends('building.activity.index')

{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection

@section('metaDescription'){!! $shortDescription !!}@endsection

@section('extendMetaPage')
    {{--share on fb--}}
    <meta property="fb:app_id" content="1687170274919207"/>
    <meta property="og:type" content="Website"/>
    <meta property="og:title" content="{!! $dataBuilding->name() !!}"/>
    <meta property="og:site_name" content="3dtf.com"/>
    <meta property="og:url" content="{!! route('tf.building', $alias) !!}"/>
    <meta property="og:description" content="{!! $shortDescription !!}"/>
    <meta property="og:image" content="{!! $imgShareSrc !!}"/>
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">

    {{--share on G+--}}
    <meta itemprop="name" content="{!! $dataBuilding->name() !!}"/>
    <meta itemprop="description" content="{!! $shortDescription !!}"/>
    <meta itemprop="url" content="{!! route('tf.building', $alias) !!}"/>
    <meta itemprop="image" content="{!! $imgShareSrc !!}"/>
@endsection

@section('shortcutPage')
    <link rel="shortcut icon" href="{!! $buildingSampleImage !!}"/>
@endsection

@section('titlePage')
    {!! $shortDescription !!}
@endsection

{{--title of building--}}
@section('tf_building_title')
    @include('building.components.title.title', compact('dataUserBuilding'),
        [
            'dataBuilding'=>$dataBuilding,
            'modelUser'=>$modelUser,
            'dataBuildingBanner' => $dataBuildingBanner,
            'dataBuildingAccess' => $dataBuildingAccess
        ])
@endsection

{{--menu--}}
@section('tf_building_menu')
    @include('building.components.menu.menu',
        [
            'modelUser'=>$modelUser,
            'dataBuildingAccess'=>$dataBuildingAccess,
        ])
@endsection

@section('tf_building_activity_content')
    {{--share--}}
    @include('components.facebook.share.share')

    <div id="tf_building_post_detail"
         class="tf-building-post-detail tf-padding-top-20 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
        <table class="table">
            <tr>
                <td class="tf-border-top-none">
                    <a href="{!! route('tf.user.home',$userPostAlias) !!}" target="_blank">
                        <img class="tf-border tf-icon-50 tf-border-radius-4" alt="keyword-seo"
                             src="{!! $userPostAvatarPath !!}">
                    </a>
                    &nbsp;
                    <a class="tf-link-bold" href="{!! route('tf.user.home',$userPostAlias) !!}" target="_blank">
                        {!! $dataUserPost->fullName() !!}
                    </a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-none">
                    <div id="tf_building_post_detail_content" class="tf-overflow-prevent">
                        {!! $postContent !!}
                    </div>
                </td>
            </tr>
            @if(!empty($postImage))
                <tr>
                    <td class="tf-overflow-prevent tf-border-none">
                        <img src="{!! $dataBuildingPost->pathSmallImage() !!}">
                    </td>
                </tr>
            @endif

            @if(!empty($postBuildingIntroId))
                <?php
                $dataBuildingIntro = $dataBuildingPost->building->getInfo($postBuildingIntroId);
                if(!empty($dataBuildingIntro)){
                $alias = $dataBuildingIntro->alias();
                ?>
                <tr>
                    <td class="tf-padding-bot-10">
                        <div class="media tf-padding-top-10">
                            <a class="pull-left" href="{!! route('tf.building', $alias) !!}">
                                <img class="media-object wc-border-radius-4" alt="{!! $alias !!}"
                                     style="max-width: 256px; max-height: 256px"
                                     src="{!! $dataBuildingIntro->buildingSample->pathImage() !!}"/>
                            </a>

                            <div class="media-body">
                                <a class="tf-link-bold" href="{!! route('tf.building', $alias) !!}">
                                    {!! $dataBuildingIntro->name() !!}
                                </a>

                                <p>
                                    {!! $dataBuildingIntro->shortDescription() !!}
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            @endif

            {{--share--}}
            <tr>
                <td class="text-right tf-padding-rig-none">
                    <div class="pull-right" style="height:20px; line-height: 20px;">
                        <div class="fb-share-button" data-layout="button_count" style="margin-top: 0;"
                             data-href="{!! URL::route('tf.building.posts.detail.get', $postCode) !!}"
                             data-size="small" data-mobile-iframe="true">
                            <a class="fb-xfbml-parse-ignore" target="_blank"
                               href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2F3dtf.com%2Fbuilding%2Fabout&amp;src=sdkpreparse">
                                Share
                            </a>
                        </div>
                    </div>
                    <div class="pull-right" style="margin-right: 10px; height:20px; line-height: 20px;">
                        <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
                        <g:plusone size="medium"></g:plusone>
                    </div>
                </td>
            </tr>
        </table>
        <script type="text/javascript">
            //set width to use word-wrap
            var wrapWidth = $('#tf_building_post_detail').outerWidth();
            $('#tf_building_post_detail_content').css({'width': wrapWidth - 40});
        </script>
    </div>
@endsection

{{--news--}}
@section('tf_building_news')
    @include('building.components.news.news',
        [
            'modelUser'=>$modelUser,
            'dataBuilding' =>$dataBuilding,
            'dataUserBuilding' => $dataUserBuilding
        ])
@endsection

{{--bottom ads--}}
@section('tf_building_content_ads')
    @include('building.components.ads.content-footer',
        [
            'modelUser'=>$modelUser,
            'modelBuilding' =>$modelBuilding,
        ])
@endsection

{{-- right ads--}}
@section('tf_building_ads')
    @include('building.components.ads.right-ads',
        [
            'modelUser'=>$modelUser,
            'dataBuilding' =>$dataBuilding,
            'modelBuilding' => $modelBuilding
        ])
@endsection