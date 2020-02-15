<?php
/*
 *
 * $modelUser
 * $dataBuilding
 * $buildingObjectAccess
 *
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

# building info
$buildingId = $dataBuilding->buildingId();
$alias = $dataBuilding->alias();
$postsRelationId = $dataBuilding->postRelationId();

# user info of building
$dataUserBuilding = $dataBuilding->userInfo();
$userBuildingId = $dataUserBuilding->userId();
$shortDescription = $dataBuilding->shortDescription();

$buildingSampleImage = $dataBuilding->buildingSample->pathImage();

#get banner is using
$dataBuildingBanner = $dataBuilding->bannerInfoUsing();
if (count($dataBuildingBanner) > 0) {
    $imgShareSrc = $dataBuildingBanner->pathFullImage();

} else {
    $imgShareSrc = $dataBuilding->pathBannerImageDefault();
}

$metaKeyword = $dataBuilding->metaKeyword();
$metaKeyword = (empty($metaKeyword)) ? $shortDescription : $metaKeyword;
?>
@extends('building.activity.index')

{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection

@section('metaDescription'){!! $shortDescription !!}@endsection

@section('extendMetaPage')
    {{--share on facebook--}}
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
    {!! $dataBuilding->name() !!}
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

    @include('building.components.shortDescription.short-description', ['dataBuilding'=>$dataBuilding])
@endsection

{{--menu--}}
@section('tf_building_menu')
    @include('building.components.menu.menu',
        [
            'dataBuildingAccess'=>$dataBuildingAccess,
            'modelUser'=>$modelUser,
            'dataBuilding'=>$dataBuilding
        ])
@endsection

{{--content post--}}
@section('tf_building_activity_content')
    {{-- form posts--}}
    <?php
    $postStatus = false;
    if ($loginStatus) {
        if ($userLoginId == $userBuildingId) {
            $postStatus = true;
        } else {

            #public
            if ($dataBuilding->relation->publicRelation()) {
                $postStatus = true;
            } elseif ($dataBuilding->relation->friendRelation()) {
                #friend
                if ($dataUserLogin->checkFriend($userLoginId, $userBuildingId)) {
                    $postStatus = true;
                }
            }
        }
    }
    ?>
    @if($postStatus)
        @include('building.posts.form-posts.add.form-wrap',
            [
                'dataBuilding' => $dataBuilding,
                'dataUserBuilding' => $dataUserBuilding,
                'modelUser' => $modelUser
            ])
    @endif

    {{--content posts--}}
    @include('building.activity.activity-content',
        [
            'dataBuilding' => $dataBuilding,
            'dataUserBuilding' => $dataUserBuilding,
            'modelUser' => $modelUser
        ])
@endsection

{{--news--}}
@section('tf_building_news')
    @include('building.components.news.news',
        [
            'dataBuildingAccess'=>$dataBuildingAccess,
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