<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/4/2017
 * Time: 3:45 PM
 *
 *
 * $modelProvince
 *
 */

$dataProvince = $modelProvince->getInfoBuilt3d();

?>
<ul class="tf_province_filter_list dropdown-menu dropdown-menu-left tf-box-shadow tf-padding-none" style="max-height: 200px; overflow: auto"
    data-href="{!! route('tf.map.province.access') !!}">
    @if(count($dataProvince) > 0)
        @foreach($dataProvince as $province)
            <li>
                <a class="tf-bg-hover " data-province="{!! $province->provinceId() !!}">
                    {!! $province->name() !!}
                </a>
            </li>
        @endforeach
    @else
        <li>
            {!! trans('frontend_map.label_none') !!}
        </li>
    @endif
</ul>
