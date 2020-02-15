<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/4/2017
 * Time: 3:45 PM
 *
 *
 * $modelCountry
 *
 */

$dataCountry = $modelCountry->getInfoBuilt3d();

?>
<ul class="tf_country_filter_list dropdown-menu dropdown-menu-left tf-box-shadow tf-padding-none" style="max-height: 200px; overflow: auto"
    data-href="{!! route('tf.map.country.access') !!}">
    @if(count($dataCountry) > 0)
        @foreach($dataCountry as $country)
            <li>
                <a class="tf-bg-hover " data-country="{!! $country->countryId() !!}">
                    {!! $country->name() !!}
                </a>
            </li>
        @endforeach
    @else
        <li>
            {!! trans('frontend_map.label_none') !!}
        </li>
    @endif
</ul>
