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
$mobileDetect = new Mobile_Detect();
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
    {{-- develop later --}}
@endsection

@section('shortcutPage')
    <link rel="shortcut icon" href="{!! $buildingSampleImage !!}"/>
@endsection

@section('titlePage')
    {!! $shortDescription !!}
@endsection

@section('tf_building_service_content')
    <div class="row">
        <div id="tf_building_service_tool" class="tf-building-service-tool col-xs-12 col-sm-12 col-md-12 col-lg-12"
             data-building="{!! $buildingId !!}">
            <div class="row tf-padding-top-10 tf-padding-bot-10">
                <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                    <h4 class="tf-margin-bot-none">{!! trans('frontend_building.service_manage_articles_title') !!}</h4>
                </div>
                <div class="tf-nav-bar text-right col-xs-5 col-sm-4 col-md-4 col-lg-4">
                    <div class="btn-group btn-group-sm">
                        <a class="tf-link btn btn-default btn-sm"
                           title="{!! trans('frontend_building.service_home_menu_show_title') !!}"
                           href="{!! route('tf.building.services.get', $dataBuilding->alias()) !!}">
                            <i class="glyphicon glyphicon-th tf-building-service-action-icon-size"></i>
                        </a>
                        <a class="tf-link btn btn-default btn-sm"
                           title="{!! trans('frontend_building.service_home_menu_add_title') !!}"
                           href="{!! route('tf.building.services.article.add.get', $buildingId) !!}">
                            <i class="glyphicon glyphicon-plus tf-building-service-action-icon-size"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row tf_building_tool_articles_filter tf-building-articles-filter"
                 data-href="{!! route('tf.building.services.article.tool.get') !!}">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8" style="padding-top: 5px; padding-bottom: 5px;">
                    <div class="input-group input-group-sm">
                        <input type="text" class="tf_filter_keyword form-control" name="txtKeyword"
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
            @if(Session::has('addArticlesNotify'))
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group text-center tf-color-red tf-padding-top-30">
                            <table class="table">
                                @if(Session::get('addArticlesNotify') == 'true')
                                    <tr>
                                        <td class="text-center" style="border: none;">
                                            <span class="tf-font-size-16">{!! trans('frontend_building.service_articles_add_notify_success') !!}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="border: none;">
                                            <a class="tf-link"
                                               href="{!! route('tf.building.services.article.add.get', $buildingId) !!}">
                                                <i class="glyphicon glyphicon-arrow-right"></i>
                                                {!! trans('frontend_building.service_articles_add_notify_success_continue') !!}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="border: none;">
                                            <a class="tf-link"
                                               href="{!! route('tf.building.services.article.tool.get', $buildingId) !!}">
                                                <i class="glyphicon glyphicon-arrow-right"></i>
                                                {!! trans('frontend_building.service_articles_add_notify_success_manage') !!}
                                            </a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="text-center" style="border: none;">
                                            <span>{!! trans('frontend_building.service_articles_add_notify_fail') !!}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center" style="border: none;">
                                            <a class="tf-link"
                                               href="{!! route('tf.building.services.article.add.get', $buildingId) !!}">
                                                <i class="glyphicon glyphicon-arrow-right"></i>
                                                {!! trans('frontend_building.service_articles_add_notify_fail_again') !!}
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            </table>

                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div id="tf_building_service_tool_list"
                     class="tf_building_service_tool_list tf-padding-top-10 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @if(count($dataBuildingArticles) > 0)
                        @foreach($dataBuildingArticles as $buildingArticles)
                            @include('building.services.tool.articles-object',compact('buildingArticles'), [
                                'modelUser'=> $modelUser,
                                'dataUserBuilding' => $dataUserBuilding
                            ])
                            <?php
                            $newDateTake = $buildingArticles->createdAt();
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
                    <div id="tf_building_service_tool_more"
                         class="tf-building-service-tool-more col-xs-12 col-sm-12 co-md-12 col-lg-12 ">
                        <a class="tf-link" data-take="{!! $take !!}"
                           data-href="{!! route('tf.building.services.article.tool.view_more') !!}">
                            {!! trans('frontend_building.service_tool_view_more_label') !!}
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