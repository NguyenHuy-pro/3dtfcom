<?php
/*
 * modelAbout
 * modelUser
 * modelProvince
 * modelArea
 * dataMapAccess
 *
 */
$moBileDetect = new Mobile_Detect();
$dataUserLogin = $modelUser->loginUserInfo();

#about info
$dataAbout = $modelAbout->defaultInfo();
if (count($dataAbout) > 0) {
    $metaKeyword = $dataAbout->metaKeyword();
    $metaDescription = $dataAbout->metaDescription();
    #title image
    if (empty($dataAbout->image())) {
        $titleImage = $modelAbout->pathDefaultImage();
    } else {
        $titleImage = $dataAbout->pathFullImage();
    }

} else {
    $metaKeyword = null;
    $metaDescription = null;
    $titleImage = $modelAbout->pathDefaultImage();
}

# access info
# only id
$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccess = $dataMapAccess['areaAccess'];
# object type
$landAccess = $dataMapAccess['landAccess'];
$bannerAccess = $dataMapAccess['bannerAccess'];

if (count($bannerAccess) == 0 AND count($landAccess) == 0) {
    if ($modelArea->existMainHistoryArea()) {
        $areaAccess = $modelArea->getMainHistoryArea();
    }

    # set new access info
    $dataMapAccess['areaAccess'] = $areaAccess;
}


$dataProvince = $modelProvince->getInfo($provinceAccess);
$pageTile = $dataProvince->name();
if (count($landAccess) > 0) {
    //get building info of land
    $dataBuilding = $landAccess->buildingInfo();
    if (count($dataBuilding) > 0) {
        $pageTile = $pageTile . '/' . $dataBuilding->name();
    }
}
?>
@extends('master')

{{--develop seo--}}
@section('metaKeyword'){!! $metaKeyword !!}@endsection

@section('metaDescription'){!! $metaDescription !!}@endsection

{{--title page--}}
@section('titlePage')
    {!! $pageTile !!}
@endsection

@section('extendMetaPage')

    {{--share on fb--}}
    <meta property="fb:app_id" content="1687170274919207"/>
    <meta property="og:type" content="Website"/>
    <meta property="og:title" content="{!! $pageTile !!}"/>
    <meta property="og:site_name" content="3dtf.com"/>
    <meta property="og:url" content="{!! route('tf.home') !!}"/>
    <meta property="og:description" content="{!! $metaDescription !!}"/>
    <meta property="og:image" content="{!! $titleImage !!}"/>
    <meta property="og:image:width" content="200">
    <meta property="og:image:height" content="200">

    {{--share on G+--}}
    <meta itemprop="name" content="3dtf.com"/>
    <meta itemprop="description" content="{!! $metaDescription !!}"/>
    <meta itemprop="url" content="{!! route('tf.home') !!}"/>
    <meta itemprop="image" content="{!! $titleImage !!}"/>
@endsection

{{--shortcut page --}}
@section('shortcutPage')
    <link rel="shortcut icon" href="{!! asset('public/main/icons/3dlogo128.png') !!}"/>
@endsection

{{-- ========== =========== css map page ========== ========== --}}
@section('tf_master_page_css')
    <link href="{{ url('public/map/css/map.css')}}" rel="stylesheet">
    <link href="{{ url('public/map/province/css/province.css')}}" rel="stylesheet">
    <link href="{{ url('public/map/area/css/area.css')}}" rel="stylesheet">
    <link href="{{ url('public/map/project/css/project.css')}}" rel="stylesheet">
    <link href="{{ url('public/map/land/css/land.css')}}" rel="stylesheet">
    <link href="{{ url('public/map/banner/css/banner.css')}}" rel="stylesheet">
    <link href="{{ url('public/map/public/css/public.css')}}" rel="stylesheet">
    <link href="{{ url('public/map/building/css/building.css')}}" rel="stylesheet">
@endsection

{{--js--}}
@section('tf_master_page_js_header')

@endsection

@section('tf_main_action')
    @if(count($dataUserLogin) > 0)
        @if($modelUser->checkNewUser($dataUserLogin->userId()))
            @include('components.guide.basic-build', ['modelUser'=>$modelUser])
            <?php $dataUserLogin->updateNewInfo(); ?>
        @endif
    @endif
@endsection

{{--========== ========= content header ========= ========== --}}
{{--left header--}}
@section('tf_main_header_Left')
    @include('map.components.header.header-left',
        [
            'modelProvince' => $modelProvince,
            'dataMapAccess' => $dataMapAccess
        ])

@endsection

{{--center header--}}
@section('tf_main_header_center')
    @include('map.components.header.header-center',
       [
            'modelProvince' => $modelProvince
       ])
@endsection

{{--right header--}}
@section('tf_main_header_right')
    @include('map.components.header.header-right',
        [
            'modelUser'=>$modelUser,
            'dataProvince' => $dataProvince
        ])
@endsection

{{--=========== ========== content map =========== =========--}}

@section('tf_main_content')
    <H1 class="tf-display-none">{!! $metaKeyword !!}</H1>

    {{--province map--}}
    <div id="tf_main_view_map" class="tf_main_view_map tf-main-view-map">
        <ul class="tf-main-show-icon-wrap tf-zindex-8 list-group">
            <li class="list-group-item">
                {{--zoom project--}}
                @include('map.area.zoom.area-zoom-icon')
            </li>

            @if(count($dataUserLogin) > 0)
                @if(!$dataUserLogin->checkIsSeller())
                    <li class="list-group-item">
                        {{--zoom project--}}
                        @include('seller.components.seller-icon')
                    </li>
                @endif
            @else
                {{--notify main features--}}
                <li class="list-group-item">
                    @include('components.guide.guide-icon')
                </li>
                <li class="list-group-item">
                    {{--zoom project--}}
                    @include('seller.components.seller-icon')
                </li>
            @endif
        </ul>
        @if(!$moBileDetect->isMobile())
            {{--move map--}}
            @include('map.control.move-map.move-map',
                [
                    'dataMapAccess' => $dataMapAccess
                ])
        @endif
        @include('map.province.province',
            [
                'modelUser'=>$modelUser,
                'modelProvince' => $modelProvince,
                'modelArea' => $modelArea,
                'dataMapAccess' => $dataMapAccess
            ])
    </div>
@endsection

{{--=========== ========== Footer map =========== =========--}}
@section('tf_main_footer')
    @include('components.footer.footer')
@endsection

{{--js on map--}}
@section('tf_master_page_js_footer')
    <script src="{{ url('public/map/js/map.js')}}"></script>
    {{--province--}}
    <script src="{{ url('public/map/province/js/province.js')}}"></script>
    {{--area--}}
    <script src="{{ url('public/map/area/js/area.js')}}"></script>
    {{--project--}}
    <script src="{{ url('public/map/project/js/project.js')}}"></script>
    {{--banner--}}
    <script src="{{ url('public/map/banner/js/banner.js')}}"></script>
    {{--land--}}
    <script src="{{ url('public/map/land/js/land.js')}}"></script>
    {{--building--}}
    <script src="{{ url('public/map/building/js/building.js')}}"></script>
    {{--public--}}
    <script src="{{ url('public/map/public/js/public.js')}}"></script>
@endsection