<?php
/*
 *
 *
 * modelUser
 * dataBuildingArticles
 * dataBuildingAccess
 *
 *
 */
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
//articles info
$articleId = $dataBuildingArticles->articlesId();
$articlesName = $dataBuildingArticles->name();
$articlesAlias = $dataBuildingArticles->alias();
$articlesKeyword = $dataBuildingArticles->keyword();
$articlesShortDescription = $dataBuildingArticles->shortDescription();
$articlesAvatar = $dataBuildingArticles->avatar();
$articlesContent = $dataBuildingArticles->content();
$articlesLink = $dataBuildingArticles->link();

#building info
$dataBuilding = $dataBuildingArticles->building;
$dataUserBuilding = $dataBuilding->userInfo();
$userBuildingId = $dataUserBuilding->userId();
$buildingId = $dataBuilding->buildingId();
$buildingSampleImage = $dataBuilding->buildingSample->pathImage();
$buildingAlias = $dataBuilding->alias();
$buildingName = $dataBuilding->name();
$shortDescription = $dataBuilding->shortDescription();
$website = $dataBuilding->website();
#get banner is using
if (!empty($articlesAvatar)) {
    $imgShareSrc = $dataBuildingArticles->pathSmallImage();
} else {
    $dataBuildingBanner = $dataBuilding->bannerInfoUsing();
    if (count($dataBuildingBanner) > 0) {
        $imgShareSrc = $dataBuildingBanner->pathFullImage();

    } else {
        $imgShareSrc = $dataBuilding->pathBannerImageDefault();
    }
}
$ownerStatus = false;
if ($loginStatus) {
    if ($userLoginId == $userBuildingId) $ownerStatus = true;
}
?>
@extends('building.services.index')

{{--develop seo--}}
@section('metaKeyword')
    {!! $articlesKeyword !!}
@endsection

@section('metaDescription')
    {!! $shortDescription !!}
@endsection

@section('extendMetaPage')
    {{--share on fb--}}
    <meta property="fb:app_id" content="1687170274919207"/>
    <meta property="og:type" content="Website"/>
    <meta property="og:title" content="{!! $articlesName !!}"/>
    <meta property="og:site_name" content="3dtf.com"/>
    <meta property="og:url" content="{!! route('tf.building.services.article.detail.get',$articlesAlias) !!}"/>
    <meta property="og:description" content="{!! $articlesShortDescription !!}"/>
    <meta property="og:image" content="{!! $imgShareSrc !!}"/>
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">

    {{--share on G+--}}
    <meta itemprop="name" content="{!! $articlesName !!}"/>
    <meta itemprop="description" content="{!! $articlesShortDescription !!}"/>
    <meta itemprop="url" content="{!! route('tf.building.services.article.detail.get',$articlesAlias) !!}"/>
    <meta itemprop="image" content="{!! $imgShareSrc !!}"/>
@endsection

@section('shortcutPage')
    <link rel="shortcut icon" href="{!! $imgShareSrc !!}"/>
@endsection

@section('titlePage')
    {!! $articlesName !!}
@endsection

@section('tf_building_service_content')
    {{--share--}}
    @include('components.facebook.share.share')
    <div class="row">
        <div class="tf_building_service_article_detail tf-building-service-article-detail col-xs-12 col-sm-12 col-md-12 col-lg-12"
             data-articles="{!! $articleId !!}">
            <div class="row">
                <div class="tf-sub-menu text-right col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a class="tf-link" title="{!! trans('frontend_building.service_home_menu_show_title') !!}"
                       href="{!! route('tf.building.services.get', $dataBuilding->alias()) !!}">
                        <i class="glyphicon glyphicon-th tf-building-service-action-icon-size"></i>
                    </a>
                    @if($ownerStatus)
                        <a class="tf-link" title="{!! trans('frontend_building.service_home_menu_manage_title') !!}"
                           href="{!! route('tf.building.services.article.tool.get', $buildingId) !!}">
                            <i class="glyphicon glyphicon-cog tf-building-service-action-icon-size"></i>
                        </a>
                    @endif
                </div>
            </div>
            {{--statistic and action--}}
            <div class="row">
                @if(!empty($dataBuildingArticles->avatar()))
                    <div class="tf-padding-top-10 tf-padding-bot-10 text-center tf-overflow-prevent tf-overflow-auto col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <img style="max-height: 200px;" src="{!! $dataBuildingArticles->pathSmallImage() !!}"
                             alt="{!! $buildingAlias !!}">
                    </div>
                @endif

                <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2>{!! $dataBuildingArticles->name() !!}</h2>
                </div>
                <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div class="tf_articles_statistic tf-articles-statistic col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <table class="table tf-margin-bot-none">
                                <tr>
                                    <td class="col-md-4 col-lg-4">
                                        <i class="glyphicon glyphicon-thumbs-up"></i>
                                        <span>{!! $dataBuildingArticles->totalLove() !!}</span>
                                        @if($loginStatus)
                                            @if ($modelUser->existUserLoveBuildingArticles($articleId, $userLoginId))
                                                <a class="tf_building_articles_love tf-link-grey"
                                                   data-href="{!! route('tf.building.services.article.love.minus') !!}">UnLove</a>
                                            @else
                                                <a class="tf_building_articles_love tf-link-grey"
                                                   data-href="{!! route('tf.building.services.article.love.plus') !!}">Love</a>
                                            @endif
                                        @endif
                                    </td>
                                    <td class=" col-md-4 col-lg-4">
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                        <span>{!! $dataBuildingArticles->totalVisit() !!}</span>
                                    </td>
                                    <td class="col-md-4 col-lg-4">
                                        <a class="tf_building_articles_share tf-link-grey" data-href="">
                                            <i class="glyphicon glyphicon-share-alt"></i>
                                            {!! trans('frontend_building.service_article_detail_statistic_share_label') !!}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>

                    </div>
                </div>

                {{-- share --}}
                @include('building.services.detail.share.share', compact('dataBuildingArticles'))

            </div>
            <div class="row">
                <div class="tf-articles-building col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="media">
                        <a class="pull-left" href="{!! route('tf.building', $buildingAlias) !!}">
                            <img class="media-object" src="{!! $dataBuilding->buildingSample->pathImage() !!}"
                                 alt="{!! $buildingAlias !!}">
                        </a>

                        <div class="media-body">
                            <h4 class="media-heading">
                                <a class="tf-link-bold tf-font-size-16 tf-border-none"
                                   href="{!! route('tf.building', $buildingAlias) !!}">{!! $buildingName !!}</a>
                            </h4>
                            <span class="tf-color-grey">Published</span>
                            <span class="tf-color-grey">{!! $hFunction->dateFormatDMY($dataBuildingArticles->createdAt(),'-') !!}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h4>{!! $articlesShortDescription !!}</h4>
                </div>
            </div>
            <div class="row">
                <div class="tf-content tf-overflow-prevent tf-overflow-auto col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    {!! $articlesContent !!}
                </div>
            </div>
            @if(!empty($articlesLink))
                <div class="row">
                    <div class="text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <label>Link</label>
                    </div>
                    <div class="tf_embed text-center col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        {!! $articlesLink !!}
                    </div>
                </div>
                <script type="text/javascript">
                    $('.tf_building_service_article_detail .tf_embed iframe').css({'max-width': '100%','height':'auto'});
                </script>
            @endif
            {{--next article--}}
            @include('building.services.detail.articles-next', compact('modelUser','dataBuildingArticles'))

            {{--comment--}}
            @include('building.services.detail.comment.comment', compact('modelUser','dataBuildingArticles','ownerStatus'))

        </div>
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