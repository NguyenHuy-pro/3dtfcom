<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 5/24/2016
 * Time: 10:12 AM
 *
 * $modelUser
 * $dataBuilding
 * $buildingObjectAccess
 *
 */

$dataUserLogin = $modelUser->loginUserInfo();

if (count($dataUserLogin) > 0) {
    $loginStatus = true;
    $loginUserId = $dataUserLogin->userId();
} else {
    $loginStatus = false;
}

# info of building
$buildingId = $dataBuilding->buildingId();
$alias = $dataBuilding->alias();

$buildingMenu = [
    #activity
        [
                'object' => 'activity',
                'label' => trans('frontend_building.menu_action'),
                'href' => route('tf.building.activity', $alias)
        ],

    #about

        [
                'object' => 'services',
                'label' => trans('frontend_building.menu_services'),
                'href' => route('tf.building.services.get', $alias)
        ],
        [
                'object' => 'about',
                'label' => trans('frontend_building.menu_about'),
                'href' => route('tf.building.about.get', $alias)
        ],

]
?>
{{--menu content--}}
<div class="row tf-building-menu-wrap" data-building="{!! $buildingId !!}">

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="tf-margin-bot-10 col-xs-12 col-sm-12 col-md-12 col-lg-12" ></div>
        <ul class="nav nav-pills">
            {{--<li class="active"><a href="#">Home</a></li>--}}
            @foreach($buildingMenu as $menuObject)
                <li class="@if( $dataBuildingAccess['accessObject'] == $menuObject['object'])  tf-building-menu-selected  @endif">
                    <a class="tf-link-bold " href="{!! $menuObject['href'] !!}">
                        {!! $menuObject['label'] !!}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
