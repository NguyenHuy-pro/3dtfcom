<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/8/2016
 * Time: 9:26 AM
 */
$accessObject = (isset($accessObject)) ? $accessObject : '';

$systemMenu = [
    #Deparment
        [
                'object' => 'department',
                'label' => trans('backend_system.menu_department_label'),
                'subMenu' => [
                        [
                                'subObject' => 'department',
                                'label' => trans('backend_system.menu_department_department_label'),
                                'href' => route('tf.m.c.system.department.list')
                        ],
                        [
                                'subObject' => 'contact',
                                'label' => trans('backend_system.menu_department_contact_label'),
                                'href' => route('tf.m.c.system.department-contact.list')
                        ]

                ]
        ],

    #Staff
        [
                'object' => 'staff',
                'label' => trans('backend_system.menu_staff_label'),
                'subMenu' => [
                        [
                                'subObject' => 'staff',
                                'label' => trans('backend_system.menu_staff_staff_label'),
                                'href' => route('tf.m.c.system.staff.list')
                        ],
                        [
                                'subObject' => 'access',
                                'label' => trans('backend_system.menu_staff_access_label'),
                                'line' => true,
                                'href' => route('tf.m.c.system.staff-access.list')
                        ]

                ]
        ],

    #Tool
        [
                'object' => 'tool',
                'label' => trans('backend_system.menu_tool_label'),
                'subMenu' => [
                        [
                                'subObject' => 'businessType',
                                'label' => trans('backend_system.menu_tool_business_type_label'),
                                'href' => route('tf.m.c.system.business-type.list')
                        ],
                        [
                                'subObject' => 'buildingServiceType',
                                'label' => trans('backend_system.menu_tool_building_service_type_label'),
                                'href' => route('tf.m.c.system.building-service-type.list')
                        ],
                        [
                                'subObject' => 'provinceType',
                                'label' => trans('backend_system.menu_tool_province_type_label'),
                                'href' => route('tf.m.c.system.province-type.list')
                        ],
                        [
                                'subObject' => 'badInfo',
                                'label' => trans('backend_system.menu_tool_bad_info_label'),
                                'line' => true,
                                'href' => route('tf.m.c.system.badInfo.list')
                        ]

                ]
        ],

    # Content
        [
                'object' => 'content',
                'label' => trans('backend_system.menu_content_label'),
                'subMenu' => [
                        [
                                'subObject' => 'about',
                                'label' => trans('backend_system.menu_content_about_label'),
                                'href' => route('tf.m.c.system.about.list')
                        ],
                        [
                                'subObject' => 'business',
                                'label' => trans('backend_system.menu_content_business_label'),
                                'line' => true,
                                'href' => route('tf.m.c.system.business.list')
                        ],
                        [
                                'subObject' => 'country',
                                'label' => trans('backend_system.menu_content_country_label'),
                                'line' => true,
                                'href' => route('tf.m.c.system.country.list')
                        ],
                        [
                                'subObject' => 'province',
                                'label' => trans('backend_system.menu_content_province_label'),
                                'href' => route('tf.m.c.system.province.list')
                        ],
                        [
                                'subObject' => 'warning',
                                'label' => trans('backend_system.menu_content_warning_label'),
                                'line' => true,
                                'href' => route('tf.m.c.system.warning.list')
                        ],
                        [
                                'subObject' => 'run link',
                                'label' => trans('backend_system.menu_content_link_run_default_label'),
                                'href' => route('tf.m.c.system.link-run.list')
                        ],
                        [
                                'subObject' => 'notify',
                                'label' => trans('backend_system.menu_content_notification_label'),
                                'line' => true,
                                'href' => route('tf.m.c.system.notify.list')
                        ]

                ]
        ],

    # Exchange
        [
                'object' => 'exchange',
                'label' => trans('backend_system.menu_exchange_label'),
                'subMenu' => [
                        [
                                'subObject' => 'bank',
                                'label' => trans('backend_system.menu_exchange_bank_label'),
                                'href' => route('tf.m.c.system.bank.list')
                        ],
                        [
                                'subObject' => 'paymentType',
                                'label' => trans('backend_system.menu_exchange_payment_type_label'),
                                'line' => true,
                                'href' => route('tf.m.c.system.payment-type.list')
                        ],
                        [
                                'subObject' => 'payment',
                                'label' => trans('backend_system.menu_exchange_payment_label'),
                                'href' => route('tf.m.c.system.payment.list')
                        ],
                    /*
                        [
                                'subObject' => 'wallet',
                                'label' => 'Wallet',
                                'href' => route('tf.m.c.system.wallet.list')
                        ]*/

                ]
        ],

    # point
        [
                'object' => 'point',
                'label' => trans('backend_system.menu_point_label'),
                'subMenu' => [
                        [
                                'subObject' => 'pointType',
                                'label' => trans('backend_system.menu_point_type_label'),
                                'href' => route('tf.m.c.system.point-type.list')
                        ],
                        [
                                'subObject' => 'pointTransaction',
                                'label' => trans('backend_system.menu_point_transaction_label'),
                                'line' => true,
                                'href' => route('tf.m.c.system.point-transaction.list')
                        ],
                        [
                                'subObject' => 'convertType',
                                'label' => trans('backend_system.menu_point_convert_type_label'),
                                'line' => true,
                                'href' => route('tf.m.c.system.convert-type.list')
                        ],
                        [
                                'subObject' => 'convertPoint',
                                'label' => trans('backend_system.menu_point_convert_point_label'),
                                'href' => route('tf.m.c.system.convert-point.list')
                        ]

                ]
        ],

    #notify
    /*
        [
                'object' => 'notify',
                'label' => 'Notify',
                'subMenu' => [
                        [
                                'subObject' => 'fromSystem',
                                'label' => 'From system',
                                'href' => route('tf.m.c.system.notify.getList')
                        ]

                ]
        ],

*/
    # advisory
        [
                'object' => 'advisory',
                'label' => trans('backend_system.menu_advisory_label'),
                'subMenu' => [
                        [
                                'subObject' => 'advisory',
                                'label' => trans('backend_system.menu_advisory_advisory_label'),
                                'href' => route('tf.m.c.system.advisory.list')
                        ]

                ]
        ]

]
?>
<div class="row">
    <nav class="navbar navbar-default navbar-static-top tf-margin-padding-none" role="navigation">
        <div class="container-fluid tf-padding-lef-none">
            <div class="navbar-header ">
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse " id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left ">
                    <li class="dropdown ">
                        <a href="#" class="tf-bg tf-color-white tf-font-bold">
                            {!! trans('backend_system.manage_label') !!}
                        </a>
                    </li>

                    @foreach($systemMenu as $menuObject)
                        <li class="dropdown active">
                            <a class="dropdown-toggle @if($accessObject == $menuObject['object']) tf-color-red @else tf-link @endif"
                               data-toggle="dropdown">
                                {!! $menuObject['label'] !!} <span class="caret"></span>
                            </a>
                            @if(!empty($menuObject['subMenu']))
                                <ul class="dropdown-menu tf-padding-none">
                                    @foreach($menuObject['subMenu'] as $subMenuObject)
                                        <li @if(isset($subMenuObject['line']) && $subMenuObject['line']) class="tf-border-top" @endif >
                                            <a href="{!! $subMenuObject['href'] !!}">{!! $subMenuObject['label'] !!}</a>
                                        </li>
                                    @endforeach
                                </ul>

                            @endif
                        </li>
                    @endforeach
                </ul>

                {{--========== ========== To back panel =========== =========--}}
                <ul class="nav navbar-nav navbar-right ">
                    <li class="dropdown">
                        <a class="tf-link" href="{!! route('tf.m.index') !!}">
                            {!! trans('backend_system.manage_back_label') !!}
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</div>