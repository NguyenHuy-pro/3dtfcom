<?php
/*
 *
 * $modelUser
 * modelBuilding
 * dataBuilding
 * dataBuildingAccess
 *
 */
# info of user login
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
    $userLoginId = null;
}

$dataUserBuilding = $dataBuilding->userInfo();
$userBuildingId = $dataUserBuilding->userId();

$buildingId = $dataBuilding->buildingId();
$buildingSampleImage = $dataBuilding->buildingSample->pathImage();
$alias = $dataBuilding->alias();
$shortDescription = $dataBuilding->shortDescription();
$website = $dataBuilding->website();

#get banner is using
$dataBuildingBanner = $dataBuilding->bannerInfoUsing();
if (count($dataBuildingBanner) > 0) {
    $imgShareSrc = $dataBuildingBanner->pathFullImage();

} else {
    $imgShareSrc = $dataBuilding->pathBannerImageDefault();
}

$metaKeyword = $dataBuilding->metaKeyword();
$metaKeyword = (empty($metaKeyword)) ? $shortDescription : $metaKeyword;

$ownerStatus = false;
if ($loginStatus) {
    if ($userLoginId == $userBuildingId) $ownerStatus = true;
}

$settingBuildingStatus = (isset($dataBuildingAccess['settingBuilding'])) ? $dataBuildingAccess['settingBuilding'] : 0;
?>
@extends('building.index')

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
            'dataBuildingAccess' =>$dataBuildingAccess
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

@section('tf_building_content')
    {{--share--}}
    @include('components.facebook.share.share')

    <div id="tf_building_about" class="tf-building-about col-xs-12 col-sm-12 col-md-12 col-lg-12"
         data-building="{!! $buildingId !!}">
        <table class="table">
            @if($ownerStatus)
                <tr>
                    <td class="tf-border-none text-right">
                        <a class="tf_building_about_content_edit tf-link-white" data-building="{!! $buildingId !!}"
                           data-href="{!! route('tf.building.about.content.edit.get') !!}"
                           title="{!! trans('frontend_building.about_content_edit_title') !!}">
                            <i class="tf-font-border-black tf-font-size-16 glyphicon glyphicon-pencil "></i>
                            <span class="tf-color">
                                {!! trans('frontend_building.about_content_edit_action_label') !!}
                            </span>
                        </a>
                    </td>
                </tr>
            @endif
            <tr>
                <td id="tf_building_about_content" class="tf-border-none tf-padding-none">
                    @include('building.about.about-content',['modelUser'=>$modelUser,'dataBuilding'=>$dataBuilding])
                </td>
            </tr>
            @if(!empty($website))
                <tr>
                    <td class="tf-border-none">
                        <em>
                            {!! trans('frontend_building.about_visit_website_label') !!}:
                            <a class="tf_building_contact_website tf-link-green" rel="nofollow"
                               data-building="{!! $buildingId !!}"
                               data-visit-href="{!! route('tf.building.visit.web.plus') !!}">
                                {!! $website !!}
                            </a>
                        </em>
                    </td>
                </tr>
            @endif
            <tr>
                <td class="text-right tf-padding-rig-none">
                    <div class="pull-right" style="height:20px; line-height: 20px;">
                        <div class="fb-share-button" data-href="{!! URL::route('tf.building.about.get', $alias) !!}"
                             data-layout="button_count" style="margin-top: 0;"
                             data-size="small" data-mobile-iframe="true">
                            <a class="fb-xfbml-parse-ignore" target="_blank"
                               href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2F3dtf.com%2Fbuilding%2Fabout&amp;src=sdkpreparse"></a>
                        </div>
                    </div>
                    <div class="tf-margin-rig-10 pull-right" style="height:20px; line-height: 20px;">
                        <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
                        <g:plusone size="medium"></g:plusone>
                    </div>
                </td>
            </tr>
        </table>
        <script type="text/javascript">
            //set width to use word-wrap
            var wrapWidth = $('#tf_building_about').outerWidth();
            $('#tf_building_about_content').css({'width': wrapWidth - 40});
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

{{--footer ads--}}
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
            'modelBuilding' =>$modelBuilding,
            'dataBuilding' =>$dataBuilding,
        ])
@endsection