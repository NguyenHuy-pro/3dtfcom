<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/25/2016
 * Time: 11:33 AM
 */

$modelMobile = new Mobile_Detect();
$extendMenu = [
        [
                'label' => trans('frontend.header_extend_basic_build'),
                'icon' => 'fa fa-cogs',
                'href' => route('tf.guide.basic.build.get'),
                'action_js' => true,
                'action_class' => 'tf_guide_basic_build',
                'border_bottom' => true
        ],
        [
                'label' => trans('frontend.header_extend_about'),
                'icon' => 'fa fa-info-circle',
                'href' => route('tf.system.about.get'),
                'border_bottom' => false
        ],
        [
                'label' => trans('frontend.header_extend_notify'),
                'icon' => 'fa fa-volume-up',
                'href' => route('tf.system.notify.get'),
                'border_bottom' => false
        ],
        [
                'label' => trans('frontend.header_extend_contact'),
                'icon' => 'fa fa-comments',
                'href' => route('tf.system.contact.get'),
                'border_bottom' => true
        ],

    /*
        [
                'label' => trans('frontend.header_extend_ads'),
                'icon' => 'fa fa-map-marker',
                'href' => '#'
        ],
    */
        [
                'label' => trans('frontend.header_extend_ads'),
                'icon' => 'fa fa-bullhorn',
                'href' => route('tf.ads.banner.list.get'),
                'border_bottom' => true
        ],
        [
                'label' => trans('frontend.header_extend_seller'),
                'icon' => 'fa fa-usd',
                'href' => route('tf.seller.guide.get'),
                'border_bottom' => true
        ],

        [
                'label' => trans('frontend.header_extend_regulations'),
                'icon' => 'fa fa-file-text',
                'href' => route('tf.help'),
                'border_bottom' => true
        ],
        [
                'label' => trans('frontend.header_extend_help'),
                'icon' => 'fa fa-question',
                'href' => route('tf.help'),
                'border_bottom' => false
        ]
]
?>
<div class="tf-main-header-wrap-icon tf-main-header-extend pull-right ">
    {{--check mobile--}}
    @if($modelMobile->isMobile())
        <a class="tf_main_header_extend_icon dropdown-toggle tf-link-action" data-toggle="dropdown">
            <img class="tf-m-extend-icon dropdown-toggle" alt="3dtf-extend"
                 src="{!! asset('public/main/icons/m_extend_icon.png') !!}">
        </a>
    @else
        <a class="tf_main_header_extend_icon tf-link-action" data-toggle="dropdown">
            <i class="dropdown-toggle glyphicon glyphicon-th  tf-font-icon"></i>
        </a>
    @endif

    {{--new notify of system--}}
    {{--<div class="tf-main-header-notify-new">10</div>--}}

    <div class="dropdown-menu dropdown-menu-right list-group tf-box-shadow tf-margin-padding-none">
        @foreach($extendMenu as $menu)
            @if(isset($menu['action_js']) && $menu['action_js'])
                <a class="list-group-item {!! $menu['action_class'] !!} tf-bg-hover" data-href="{!! $menu['href'] !!}"
                   @if($menu['border_bottom'])
                   style="border-bottom: 2px solid #c2c2c2 !important;"
                        @endif >
                    <label style="width: 20px;">
                        <i class="tf-color-grey tf-font-bold tf-font-size-16 {!! $menu['icon'] !!}"></i>
                    </label>&nbsp;
                    {!! $menu['label'] !!}
                </a>
            @else
                <a class="list-group-item tf-bg-hover" href="{!! $menu['href'] !!}"
                   @if($menu['border_bottom'])
                   style="border-bottom: 2px solid #c2c2c2 !important;"
                        @endif >
                    <label style="width: 20px;"><i
                                class="tf-color-grey tf-font-bold tf-font-size-16 {!! $menu['icon'] !!}"></i></label>&nbsp;
                    {!! $menu['label'] !!}
                </a>
            @endif

        @endforeach
    </div>
</div>
