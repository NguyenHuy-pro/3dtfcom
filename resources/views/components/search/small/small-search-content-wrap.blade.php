<?php
/**
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/11/2016
 * Time: 8:53 AM
 *
 */
?>

<div id="tf_search_small_content_wrap" class="tf_container_remove tf-search-small-content-wrap panel panel-default "
     data-href-land="{!! route('tf.map.land.access') !!}"
     data-href-area="{!! route('tf.map.area.get') !!}">
    <div id="tf_search_small_header" class="panel-heading" style="height: 55px;">
        <div id="tf_search_small_header_content" class="tf-small-map-header-search">
            <form id="frmSearchSmall" name="frmSearchSmall" class="input-group"
                  action="{!! route('tf.search.small.info.get') !!}">
                <input id="tf_search_small_text" type="text" class="form-control"
                       placeholder="{!! trans('frontend_map.header_search_placeholder') !!}"
                       data-href="{!! route('tf.search.small.involved.get') !!}">
                <span class="input-group-btn">
                    <button class="tf_search tf-link btn btn-default" type="button">
                        {!! trans('frontend.button_search') !!}
                    </button>
                </span>
            </form>
        </div>
    </div>
    <div id="tf_search_small_content" class="panel-body tf-margin-padding-none tf-overflow-auto">

    </div>
    <div id="tf_search_small_footer" class="panel-footer tf-margin-padding-none text-center tf-height-30 tf-line-height-30">
        <a class="tf_remove_container tf-link-full tf-color-red tf-bg-hover " title="{!! trans('frontend.button_close') !!}">
            {!! trans('frontend.button_close') !!}
        </a>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var footerHeight = $('#tf_search_small_footer').outerHeight();
            var headerHeight = $('#tf_search_small_header').outerHeight();
            $('#tf_search_small_content_wrap').css({'height': windowHeight - 65});
            $('#tf_search_small_content').css({'height': windowHeight - 65 - headerHeight - footerHeight});
        });
    </script>
</div>
