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

$buildingSampleImage = $dataBuilding->buildingSample->pathImage();
$buildingId = $dataBuilding->buildingId();
$name = $dataBuilding->name();
$alias = $dataBuilding->alias();
$phone = $dataBuilding->phone();
$website = $dataBuilding->website();
$email = $dataBuilding->email();
$address = $dataBuilding->address();
$shortDescription = $dataBuilding->shortDescription();

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
@extends('building.index')

{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection

@section('metaDescription'){!! $shortDescription !!}@endsection
@section('shortcutPage')
    <link rel="shortcut icon" href="{!! $buildingSampleImage !!}"/>
@endsection

@section('titlePage')
    {!! trans('frontend_building.page_title') !!}
@endsection

{{--title of building--}}
@section('tf_building_title')
    @include('building.components.banner.banner',
                [
                    'modelUser' => $modelUser,
                    'dataBuilding'=>$dataBuilding,
                    'dataBuildingBanner' => $dataBuildingBanner,
                    'dataBuildingAccess'=>$dataBuildingAccess
                ]
            )
@endsection

@section('tf_building_content')
    <div id="tf_building_information"
         class="tf-building-information tf-padding-top-20 col-xs-12 col-sm-12 col-md-12 col-lg-12"
         data-building="{!! $buildingId !!}">
        <table class="table">
            <tr>
                <td class="tf-border-none" colspan="2">
                    <span class="tf-font-size-20 tf-font-bold">
                        {!! trans('frontend_building.info_setting_title') !!}
                    </span>
                    <a class="btn btn-primary btn-sm pull-right" href="{!! route('tf.building.about.get', $alias) !!}">
                        {!! trans('frontend_building.info_setting_close_label') !!}
                    </a>
                </td>
            </tr>
            <tr>
                <td class="tf-padding-bot-none col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    <label>
                        <i class="glyphicon glyphicon-play"></i>
                        {!! trans('frontend_building.info_setting_sample_label') !!}:
                    </label>
                </td>
                <td class="text-right col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <a class="tf_info_edit tf-font-border-black tf-link-white glyphicon glyphicon-pencil tf-font-size-16"
                       data-href="{!! route('tf.building.info.sample.edit.get') !!}"></a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-none" colspan="2">
                    <img alt="{!! $alias !!}" style="max-width: 100%;"
                         src="{!! $dataBuilding->buildingSample->pathImage() !!}">
                </td>
            </tr>
            <tr>
                <td class="tf-padding-bot-none col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    <label>
                        <i class="glyphicon glyphicon-play"></i>
                        {!! trans('frontend_building.info_setting_name_label') !!}:
                    </label>
                </td>
                <td class="text-right col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <a class="tf_info_edit tf-font-border-black tf-link-white glyphicon glyphicon-pencil tf-font-size-16"
                       data-href="{!! route('tf.building.info.name.edit.get') !!}">
                    </a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-none" colspan="2">
                    {!! $name !!}
                </td>
            </tr>
            <tr>
                <td class="tf-padding-bot-none col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    <label>
                        <i class="glyphicon glyphicon-play"></i>
                        {!! trans('frontend_building.info_setting_phone_label') !!}:
                    </label>
                </td>
                <td class="text-right col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <a class="tf_info_edit tf-font-border-black tf-link-white glyphicon glyphicon-pencil tf-font-size-16"
                       data-href="{!! route('tf.building.info.phone.edit.get') !!}"></a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-none" colspan="2">
                    @if(empty($phone))
                        Null
                    @else
                        {!! $phone !!}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="tf-padding-bot-none col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    <label>
                        <i class="glyphicon glyphicon-play"></i>
                        {!! trans('frontend_building.info_setting_website_label') !!}:
                    </label>
                </td>
                <td class="text-right col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <a class="tf_info_edit tf-font-border-black tf-link-white glyphicon glyphicon-pencil tf-font-size-16"
                       data-href="{!! route('tf.building.info.website.edit.get') !!}"></a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-none" colspan="2">
                    @if(empty($website))
                        Null
                    @else
                        {!! $website !!}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="tf-padding-bot-none col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    <label>
                        <i class="glyphicon glyphicon-play"></i>
                        {!! trans('frontend_building.info_setting_email_label') !!}:
                    </label>
                </td>
                <td class="text-right col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <a class="tf_info_edit tf-font-border-black tf-link-white glyphicon glyphicon-pencil tf-font-size-16"
                       data-href="{!! route('tf.building.info.email.edit.get') !!}"></a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-none" colspan="2">
                    @if(empty($email))
                        Null
                    @else
                        {!! $email !!}
                    @endif
                </td>
            </tr>
            <tr>
                <td class="tf-padding-bot-none col-xs-10 col-sm-10 col-md-10 col-lg-10">
                    <label>
                        <i class="glyphicon glyphicon-play"></i>
                        {!! trans('frontend_building.info_setting_address_label') !!}:
                    </label>
                </td>
                <td class="text-right col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <a class="tf_info_edit tf-font-border-black tf-link-white glyphicon glyphicon-pencil tf-font-size-16"
                       data-href="{!! route('tf.building.info.address.edit.get') !!}"></a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-none" colspan="2">
                    {!! $dataBuilding->address() !!}
                </td>
            </tr>

            <tr>
                <td class="col-xs-8 col-sm-2 col-md-10 col-lg-10">
                    <label>
                        <i class="glyphicon glyphicon-play"></i>
                        {!! trans('frontend_building.info_setting_short_description_label') !!}:
                    </label>
                </td>
                <td class="text-right col-xs-4 col-sm-2 col-md-2 col-lg-2">
                    <a class="tf_info_edit tf-font-border-black tf-link-white glyphicon glyphicon-pencil tf-font-size-16"
                       data-href="{!! route('tf.building.info.short-description.edit.get') !!}"></a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-none" colspan="2">
                    {!! $dataBuilding->shortDescription() !!}
                </td>
            </tr>
            <tr>
                <td class="col-xs-8 col-sm-2 col-md-10 col-lg-10">
                    <label>
                        <i class="glyphicon glyphicon-play"></i>
                        {!! trans('frontend_building.info_setting_description_label') !!}:
                    </label>
                </td>
                <td class="text-right col-xs-4 col-sm-2 col-md-2 col-lg-2">
                    <a class="tf_info_edit tf-font-border-black tf-link-white glyphicon glyphicon-pencil tf-font-size-16"
                       data-href="{!! route('tf.building.info.description.edit.get') !!}"></a>
                </td>
            </tr>
            <tr>
                <td class="tf-border-none" colspan="2">
                    <div id="tf_building_information_content"
                         class="tf-position-rel tf-overflow-prevent tf-overflow-auto ">
                        {!! $dataBuilding->description() !!}
                    </div>
                </td>
            </tr>
        </table>
        <script type="text/javascript">
            //set width to use word-wrap
            var wrapWidth = $('#tf_building_information').outerWidth();
            $('#tf_building_information_content').css({'width': wrapWidth - 40});
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