    <?php
/*
 * modelStaff
 * modelProvince
 * modelArea
 * modelProvinceArea
 */
?>

@extends('manage.build.master')
@section('titlePage')
    Build
@endsection
{{-- =========== css on map ============ --}}
@section('tf_m_build_css_page')
    {{--css on view map--}}
    <link href="{{ url('public/manage/build/map/css/map.css')}}" rel="stylesheet">
    {{--css on province--}}
    <link href="{{ url('public/manage/build/map/province/css/province.css')}}" rel="stylesheet">
    {{--css on area--}}
    <link href="{{ url('public/manage/build/map/area/css/area.css')}}" rel="stylesheet">
    {{--css on project--}}
    <link href="{{ url('public/manage/build/map/project/css/project.css')}}" rel="stylesheet">
    {{--css on land--}}
    <link href="{{ url('public/manage/build/map/land/css/land.css')}}" rel="stylesheet">
    {{--css on banner--}}
    <link href="{{ url('public/manage/build/map/banner/css/banner.css')}}" rel="stylesheet">
    {{--css on public--}}
    <link href="{{ url('public/manage/build/map/publics/css/public.css')}}" rel="stylesheet">
    {{--css on building--}}
    <link href="{{ url('public/manage/build/map/building/css/building.css')}}" rel="stylesheet">
@endsection
{{-- =========== css on map ============ --}}

{{-- ============ js on map ============== --}}
@section('tf_m_build_js_page_header')
    {{--js on view map--}}
    <script type="text/javascript" src="{{ url('public/manage/build/map/js/map.js')}}"></script>
    {{--js on view province--}}
    <script type="text/javascript" src="{{ url('public/manage/build/map/province/js/province.js')}}"></script>
    {{--js on view area--}}
    <script type="text/javascript" src="{{ url('public/manage/build/map/area/js/area.js')}}"></script>
    {{--js on view project--}}
    <script type="text/javascript" src="{{ url('public/manage/build/map/project/js/project.js')}}"></script>
    {{--js on view land--}}
    <script type="text/javascript" src="{{ url('public/manage/build/map/land/js/land.js')}}"></script>
    {{--js on view banner--}}
    <script type="text/javascript" src="{{ url('public/manage/build/map/banner/js/banner.js')}}"></script>
    {{--js on view map--}}
    <script type="text/javascript" src="{{ url('public/manage/build/map/publics/js/public.js')}}"></script>
    {{--js on view building--}}
    <script type="text/javascript" src="{{ url('public/manage/build/map/building/js/building.js')}}"></script>
@endsection
{{-- ============ js on map ============== --}}

<?php
#$modelArea = new TfArea();
#$modelProvinceArea = new TfProvinceArea();

# access info
$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccess = $dataMapAccess['areaAccess'];

if ($modelProvinceArea->checkSetup()) {
    $areaAccess = $modelProvinceArea->getSetupArea();
} else {
    # check history of area
    if ($modelArea->existHistoryArea()) {
        $areaAccess = $modelArea->getHistoryArea();
    }
}
# set new access info
$dataMapAccess['areaAccess'] = $areaAccess;
?>
{{-- header of map --}}
@include('manage.build.map.map-header',
    [
        'modelStaff' => $modelStaff,
        'modelCountry' => $modelCountry,
        'modelProvince' => $modelProvince,
        'modelArea' => $modelArea,
        'modelBusinessType' => $modelBusinessType
    ])

@section('tf_m_build_main_content')
    {{-- mini map --}}
    @include('manage.build.control.mini-map.mini-map')

    {{-- control tool menu --}}
    @include('manage.build.control.tool-menu.tool-menu',
        [
            'modelStaff' => $modelStaff,
            'modelPublicType' => $modelPublicType,
            'dataMapAccess'=>$dataMapAccess
        ])

    {{-- move map --}}
    @include('manage.build.control.move-map.trend-move')

    {{--=========  map ==========--}}
    <div id="tf_m_build_view_map" class="tf-m-build-view-map">
        @include('manage.build.map.province.province',
            [
                'modelStaff' => $modelStaff,
                'modelArea'=> $modelArea,
                'modelProvinceArea' => $modelProvinceArea,
                'dataMapAccess'=>$dataMapAccess
            ])
    </div>
@endsection

{{--js on map--}}
@section('tf_m_build_js_page_footer')

@endsection
{{-- end js on map--}}
