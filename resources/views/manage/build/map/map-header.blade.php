<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/18/2016
 * Time: 12:20 PM
 */
/*
 * modelStaff
 * modelCountry
 * modelProvince
 * modelArea
 * modelProvinceArea
 *
 */

$dataStaffLogin = $modelStaff->loginStaffInfo();
# info access
$provinceAccess = $dataMapAccess['provinceAccess'];
$areaAccess = $dataMapAccess['areaAccess'];

$countryId = $modelProvince->countryId($provinceAccess);
?>
@section('tf_m_build_header_left')
    <div class="tf-m-build-header-lef tf-margin-rig-8">
        <a class="tf-link-white" href="{!! route('tf.m.index') !!}">Panel</a>
    </div>
    {{--go to country--}}
    <div class="tf-m-build-header-lef tf-margin-rig-4">
        <select id="cbCountry" name="cbCountry" data-href="{!! route('tf.m.build.country.get') !!}">
            {!! $modelCountry->getOptionBuilt3d($countryId) !!}
        </select>
    </div>

    {{--go to province--}}
    <div class="tf-m-build-header-lef tf-margin-rig-4">
        <select id="cbProvince" name="cbProvince" data-href="{!! route('tf.m.build.province.get') !!}">
            {!! $modelProvince->getOptionBuilt3d($provinceAccess,$countryId) !!}
        </select>
    </div>

    {{--go to area by coordinates--}}
    <form id="frm_m_build_log_coordinates" class="tf-m-build-header-lef" method="get"
          action="{!! route('tf.m.build.area.coordinates.get') !!}">
        <?php
        $dataArea = $modelArea->getInfo($areaAccess);
        ?>
        <select id="cbAreaX" name="cbAreaX">
            @for($i=0; $i <= 100; $i++)
                <option value="{!! $i !!}" @if($i == $dataArea->x) selected="selected" @endif >{!! $i !!}</option>
            @endfor
        </select>
        <select id="cbAreaY" name="cbAreaY">
            @for($i=0; $i <= 100; $i++)
                <option value="{!! $i !!}" @if($i == $dataArea->y) selected="selected" @endif >{!! $i !!}</option>
            @endfor
        </select>
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    </form>

    {{--business type filter on building--}}
    <form id="frm_m_build_country" class="tf-m-build-header-lef tf-margin-lef-4" method="get" action="">
        <select id="cbBusinessType" name="cbBusinessType">
            <option value="">all business type</option>
            {!! $modelBusinessType->getOption() !!}
        </select>
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
    </form>
    {{--business type filter on building--}}
@endsection

{{--center  header--}}
@section('tf_m_build_header_center')

@endsection

{{--right header--}}
@section('tf_m_build_header_right')
    <span class="tf-color-white">{!! $dataStaffLogin->lastName() !!}</span>
    <span data-toggle="dropdown" class="dropdown-toggle caret tf-link-white-bold"></span>
    <ul class="dropdown-menu dropdown-menu-right">
        <li>
            <a class="text-center" href="{!! route('tf.m.logout.get') !!}">Exit</a>
        </li>
    </ul>
@endsection
