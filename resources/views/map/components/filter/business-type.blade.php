<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 2/13/2017
 * Time: 1:28 PM
 *
 *
 * $dataBusinessType
 *
 */
?>
<div id="tf_map_business_type_filter" class="tf_container_remove tf-map-business-type-filter tf-zindex-8 tf-box-shadow">
    <div class="tf_map_business_type_object_wrap tf-overflow-auto tf-width-height-full"
         data-href="{!! route('tf.map.filter.business-type.get') !!}">
        <div class="tf_map_business_type_object tf-map-business-type-object tf-bg-hover">
            <span class="tf_name" data-business-type="{!! null !!}">
                {!! trans('frontend_map.header_filter_business_label') !!}
            </span>
        </div>
        @if(count($dataBusinessType) > 0 )
            @foreach($dataBusinessType as $businessType)
                <div class="tf_map_business_type_object tf-map-business-type-object tf-bg-hover">
                    <span class="tf_name" data-business-type="{!! $businessType->typeId() !!}">
                        {!! $businessType->name() !!}
                    </span>
                    <span class="fa fa-caret-left tf-color-white tf-font-size-16 pull-left tf-margin-lef-10 tf-margin-top-4 "></span>
                    <?php
                    $dataBusiness = $businessType->businessOfType();
                    ?>

                    <div class="tf_map_business_object_wrap tf-map-business-object-wrap tf-position-abs">
                        @if(count($dataBusiness) > 0)
                            @foreach($dataBusiness as $business)
                                <div class="tf-map-business-object">{!! $business->name() !!}</div>
                            @endforeach
                        @endif
                    </div>

                </div>
            @endforeach
        @endif

    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#tf_map_business_type_filter').css({'height': windowHeight - 60});
            $('.tf_map_business_object_wrap').css({'height': windowHeight - 60});
        });
    </script>
</div>
