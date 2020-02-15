<?php
/**
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/11/2016
 * Time: 8:53 AM
 *
 * $modelBuilding
 * dataSearchResult
 * keyword
 */
?>

<div id="tf_main_search_content_wrap" class="tf_container_remove tf-main-search-content-wrap  panel panel-default "
     data-href-land="{!! route('tf.map.land.access') !!}" data-href-area="{!! route('tf.map.area.get') !!}">
    <div id="tf_main_search_content" class="panel-body tf-margin-padding-none tf-overflow-auto">
        @include('components.search.search-content', compact('modelBuilding', 'dataSearchResult'),['keyword'=>$keyword]);
    </div>

    <div id="tf_map_search_footer"
         class="panel-footer tf-margin-padding-none text-center tf-height-30 tf-line-height-30">
        <span class="tf_remove_container tf-link-red" title="{!! trans('frontend.button_close') !!}">
            {!! trans('frontend.button_close') !!}
        </span>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            var footerHeight = $('#tf_map_search_footer').outerHeight();
            $('#tf_main_search_content_wrap').css({'height': windowHeight - 60});
            $('#tf_main_search_content').css({'height': windowHeight - 60 - footerHeight});
        });
    </script>
</div>
