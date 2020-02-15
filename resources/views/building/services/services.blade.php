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
$hFunction = new Hfunction();
$mobileDetect = new Mobile_Detect();
$dataUserLogin = $modelUser->loginUserInfo();
if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $userLoginId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
    $userLoginId = null;
}

$mobileStatus = $mobileDetect->isMobile();

$dataUserBuilding = $dataBuilding->userInfo();
$userBuildingId = $dataUserBuilding->userId();

$buildingId = $dataBuilding->buildingId();
$buildingSampleImage = $dataBuilding->buildingSample->pathImage();
$alias = $dataBuilding->alias();
$buildingName = $dataBuilding->name();
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

if (($loginStatus && $userLoginId == $userBuildingId)) {
    $ownerStatus = true;
}

$take = $dataBuildingAccess['take'];
$serviceTypeId = $dataBuildingAccess['serviceTypeId'];
$keyword = $dataBuildingAccess['keyword'];
$dataBuildingServiceType = $dataBuildingAccess['dataBuildingServiceType'];
$dataBuildingArticles = $dataBuildingAccess['dataBuildingArticles'];
?>
@extends('building.services.index')

{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection

@section('metaDescription'){!! $shortDescription !!}@endsection

@section('extendMetaPage')
    {{--share on fb--}}
    <meta property="fb:app_id" content="1687170274919207"/>
    <meta property="og:type" content="Website"/>
    <meta property="og:title" content="{!! $buildingName !!}"/>
    <meta property="og:site_name" content="3dtf.com"/>
    <meta property="og:url" content="{!! route('tf.building', $alias) !!}"/>
    <meta property="og:description" content="{!! $shortDescription !!}"/>
    <meta property="og:image" content="{!! $imgShareSrc !!}"/>
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">

    {{--share on G+--}}
    <meta itemprop="name" content="{!! $buildingName !!}"/>
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
{{--
@section('tf_building_title')
    @include('building.components.title.title', compact('dataUserBuilding'),
        [
            'dataBuilding'=>$dataBuilding,
            'modelUser'=>$modelUser,
            'dataBuildingBanner' => $dataBuildingBanner,
            'dataBuildingAccess' =>$dataBuildingAccess
        ])
@endsection
--}}

{{--menu--}}
{{--@section('tf_building_menu')
    @include('building.components.menu.menu',
        [
            'modelUser'=>$modelUser,
            'dataBuildingAccess'=>$dataBuildingAccess,
        ])
@endsection--}}

@section('tf_building_service_content')
    <div class="row">
        <div id="tf_building_services" class="tf-building-services col-xs-12 col-sm-12 col-md-12 col-lg-12"
             data-alias="{!! $alias !!}" data-building="{!! $buildingId !!}">
            {{--building--}}
            <div class="row ">
                <div class="tf-building-articles-building-info col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="media">
                        <a class="pull-left" href="{!! route('tf.building', $alias) !!}">
                            <img class="media-object" src="{!! $buildingSampleImage !!}" alt="{!! $alias !!}">
                        </a>

                        <div class="media-body">
                            <h4 class="media-heading">
                                <a class="tf-link-bold tf-font-size-16 tf-border-none"
                                   href="{!! route('tf.building', $alias) !!}">{!! $buildingName !!}</a>
                            </h4>
                            <a class="tf-link-green "
                               title="{!! trans('frontend_building.news_new_building_map_title') !!}"
                               href="{!! route('tf.home', $alias) !!}" @if(!$mobileStatus) target="_blank" @endif>
                                <i class="tf-font-size-20 fa fa-map-marker"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{--title--}}
            <div class="row tf-padding-top-10 tf-padding-bot-5">
                <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                    <h4>
                        {!! trans('frontend_building.service_home_title_label') !!}
                    </h4>
                </div>
                @if($ownerStatus)
                    <div class="tf-nav-bar col-xs-5 col-sm-4 col-md-4 col-lg-4">
                        <div class="btn-group btn-group-sm">
                            <a class="tf-link btn btn-default btn-sm"
                               title="{!! trans('frontend_building.service_home_menu_add_title') !!}"
                               href="{!! route('tf.building.services.article.add.get', $buildingId) !!}">
                                <i class="glyphicon glyphicon-plus tf-building-service-action-icon-size"></i>
                            </a>
                            <a class="tf-link btn btn-default btn-sm"
                               title="{!! trans('frontend_building.service_home_menu_manage_title') !!}"
                               href="{!! route('tf.building.services.article.tool.get', $buildingId) !!}">
                                <i class="glyphicon glyphicon-cog tf-building-service-action-icon-size"></i>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{--filter--}}
            <div class="row tf_building_articles_filter tf-building-articles-filter"
                 data-href="{!! route('tf.building.services.get') !!}">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" style="padding-top: 5px; padding-bottom: 5px;">
                    <div class="input-group">
                        <input type="text" class="tf_filter_keyword form-control input-sm" name="txtKeyword"
                               @if(!empty($keyword))value="{!! $keyword !!}" @endif
                               placeholder="Search">
                    <span class="tf_filter_keyword_search input-group-btn">
                        <button class="btn btn-default btn-sm" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                    </div>
                </div>
                <div class="text-right col-xs-12 col-sm-4 col-md-4 col-lg-4"
                     style="padding-top: 5px; padding-bottom: 5px;">
                    <div class="form-group" style="margin: 0;">
                        <select class="tf_filter_service_type form-control input-sm" name="cbServiceType">
                            <option value="0">All type</option>
                            @if(count($dataBuildingServiceType) > 0)
                                @foreach($dataBuildingServiceType as $buildingServiceType)
                                    <option value="{!! $buildingServiceType->typeId() !!}"
                                            @if($buildingServiceType->typeId() == $serviceTypeId) selected="selected" @endif>{!! $buildingServiceType->name() !!}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="tf_building_service_list"
                     class="tf_building_service_list tf-padding-top-20 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @if(count($dataBuildingArticles) > 0)
                        @foreach($dataBuildingArticles as $buildingArticles)
                            <?php
                            $createdAt = $buildingArticles->createdAt();
                            ?>
                            @include('building.services.services-articles',compact('buildingArticles'), [
                                'modelUser'=> $modelUser,
                                'dataUserBuilding' => $dataUserBuilding
                            ])
                            <?php
                            $newDateTake = $createdAt;
                            ?>
                        @endforeach
                    @endif

                </div>
            </div>
            @if(count($dataBuildingArticles) > 0)
                <?php
                #check more info
                $dataMoreBuildingPosts = $dataBuilding->articlesInfoOfBuilding($buildingId, $take, $newDateTake, $serviceTypeId, $keyword);
                ?>
                @if(count($dataMoreBuildingPosts) > 0)
                    <div id="tf_building_service_more"
                         class="tf-building-service-more col-xs-12 col-sm-12 co-md-12 col-lg-12 ">
                        <a class="tf-link" data-take="{!! $take !!}"
                           data-href="{!! route('tf.building.services.view_more.get') !!}">
                            {!! trans('frontend_building.service_home_view_more_label') !!}
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>
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