<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 10/10/2017
 * Time: 11:41 AM
 */
$modelMobile = new Mobile_Detect();
?>
@if($modelMobile->isMobile())
    {{--search when show on mobile--}}
    <div class="tf-main-header-wrap-icon pull-left">
        <a id="tf_main_search_small_get" class="tf-link-action" data-href="{!! route('tf.search.small.get') !!}">
            <img class="tf-icon-20" title="Search" alt="mb_search"
                 src="{!! asset('public/main/icons/w_search.png') !!}"/>
        </a>
    </div>
@else
    {{--search on desktop--}}
    <div class="tf-main-header-wrap-icon pull-left">
        <form id="tf_main_search_wrap" name="tfMapSearchWrap" class="tf_main_search_wrap tf-main-search-wrap"
              method="post" action="{!! route('tf.search.info.get') !!}">
            <input id="tf_main_search_text" class="tf_main_search_text tf_keyword" type="text" name="txtSearch"
                   placeholder="search everything..." title="Search by keyword"
                   data-href="{!! route('tf.search.involved.get') !!}"/>
            <img class="tf_search pull-right tf-cursor-pointer tf-icon-20" title="Search" alt="search"
                 src="{!! asset('public/main/icons/search.png') !!}"/>
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"/>
        </form>
    </div>

@endif

