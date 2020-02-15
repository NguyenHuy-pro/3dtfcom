<?php
/*
 *
 * $modelUser
 * modelBuilding
 * dataBuilding
 * dataBuildingAccess
 * dataBuildingServiceType
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

$metaKeyword = $dataBuilding->metaKeyword();
$metaKeyword = (empty($metaKeyword)) ? $shortDescription : $metaKeyword;

$ownerStatus = false;
if ($loginStatus) {
    if ($userLoginId == $userBuildingId) $ownerStatus = true;
}

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
        <div class="tf-building-service-articles-add col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row tf-sub-menu">
                <div class="col-xs-7 col-sm-8 col-md-8 col-lg-8">
                    <h3 style="margin: 0;">{!! trans('frontend_building.service_articles_add_title') !!}</h3>
                </div>
                <div class="text-right col-xs-5 col-sm-4 col-md-4 col-lg-4">
                    <div class="btn-group btn-group-sm">
                        <a class="tf-link btn btn-default btn-sm"
                           title="{!! trans('frontend_building.service_home_menu_show_title') !!}"
                           href="{!! route('tf.building.services.get', $dataBuilding->alias()) !!}">
                            <i class="glyphicon glyphicon-th tf-building-service-action-icon-size"></i>
                        </a>
                        <a class="tf-link btn btn-default btn-sm"
                           title="{!! trans('frontend_building.service_home_menu_manage_title') !!}"
                           href="{!! route('tf.building.services.article.tool.get', $buildingId) !!}">
                            <i class="glyphicon glyphicon-cog tf-building-service-action-icon-size"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form class="tf_building_service_articles_add form-horizontal" role="form"
                      data-building="{!! $buildingId !!}"
                      enctype="multipart/form-data" method="post"
                      action="{!! route('tf.building.services.article.add.post', $buildingId) !!}">
                        <div class="form-group form-group-sm">
                            <label>
                                {!! trans('frontend_building.service_articles_add_type_label') !!}
                                <i class="glyphicon glyphicon-star tf-color-red"></i>
                            </label>
                            <select class="form-control form-control" name="cbServiceType">
                                <option value="">
                                    {!! trans('frontend_building.service_articles_add_type_title') !!}
                                </option>
                                @if(count($dataBuildingServiceType) > 0)
                                    @foreach($dataBuildingServiceType as $buildingServiceType)
                                        <option value="{!! $buildingServiceType->typeId() !!}">
                                            {!! $buildingServiceType->name() !!}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group form-group-sm">
                            <label>
                                {!! trans('frontend_building.service_articles_add_title_label') !!}
                                <i class="glyphicon glyphicon-star tf-color-red"></i>
                            </label>
                            <input type="text" class="form-control" name="txtTitle" placeholder="Title of service">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>
                                {!! trans('frontend_building.service_articles_add_avatar_label') !!}
                            </label>
                            <input class="tf_txtAvatar" style="display: none;" type="file" name="txtAvatar">
                            <br/>
                            <img class="tf_select_image tf-icon-30" alt="upload-image"
                                 src="{!! asset('public\main\icons\Photograph.png') !!}">
                        </div>
                        <div class="tf_avatar_preview form-group"></div>
                        <div class="form-group form-group-sm">
                            <label>
                                {!! trans('frontend_building.service_articles_add_short_description_label') !!}
                                <i class="glyphicon glyphicon-star tf-color-red"></i>
                            </label>
                            <input type="text" class="form-control" name="txtShortDescription"
                                   placeholder="Description of article">
                        </div>
                        <div class="form-group form-group-sm">
                            <label>
                                {!! trans('frontend_building.service_articles_add_content_label') !!}
                                <i class="glyphicon glyphicon-star tf-color-red"></i>
                            </label>
                            <textarea id="txtBuildingArticlesContent" class="form-control" name="txtContent"
                                      rows="5"></textarea>
                            <script type="text/javascript">ckeditor('txtBuildingArticlesContent', true)</script>
                        </div>
                        <div class="form-group form-group-sm">
                            <label>
                                {!! trans('frontend_building.service_articles_add_link_label') !!}
                            </label>
                            <textarea class="form-control" name="txtLink" rows="3"></textarea>
                        </div>
                        <div class="form-group form-group-sm">
                            <label>
                                {!! trans('frontend_building.service_articles_add_keyword_label') !!}
                            </label>
                            <input type="text" class="form-control" name="txtKeyWord" placeholder="Keyword">
                        </div>
                        {{--<div class="form-group">
                            <a class="tf-link" href="#">
                                + {!! trans('frontend_building.service_articles_add_relation_img_label') !!}
                            </a>
                        </div>--}}
                        <div class="form-group form-group-sm">
                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                            <button class="tf_save btn btn-sm btn-primary" type="button">
                                {!! trans('frontend_building.service_articles_add_save_label') !!}
                            </button>
                            <button class="btn btn-sm btn-default" type="reset">
                                {!! trans('frontend_building.service_articles_add_reset_label') !!}
                            </button>
                            <a class="tf-link" href="{!! route('tf.building.services.get', $alias) !!}">
                                <button class="btn btn-sm btn-default" type="button">
                                    {!! trans('frontend_building.service_articles_add_close_label') !!}
                                </button>
                            </a>
                        </div>
                </form>
            </div>
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