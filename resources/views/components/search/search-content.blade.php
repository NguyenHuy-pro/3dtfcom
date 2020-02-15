<?php
/**
 *
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/7/2016
 * Time: 1:36 PM
 *
 *
 *modelBuilding
 *dataSearchResult
 *keyword
 *
 */


#show records
$skip = 0;
$take = 10;

if (count($dataSearchResult) > 0) {
    if (count($dataSearchResult) > $take) {
        $moreStatus = true;
        $showRecords = array_slice($dataSearchResult, $skip, $take);
        $skip = $take;
    } else {
        $moreStatus = false;
        $showRecords = $dataSearchResult;
    }

} else {
    $showRecords = null;
}
?>
<div class="tf_main_search_content col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="max-width: 420px;">
    @if(count($showRecords) > 0)
        <div class="row">
            <div class="tf_search_object_list col-xs-12 col-sm-12 col-md-12">
                @foreach($showRecords as $value)
                    @include('components.search.search-object',
                        [
                            'modelBuilding'=>$modelBuilding,
                            'searchObject' => $value,
                            'keyword' =>$keyword,
                        ])
                @endforeach
            </div>
        </div>

        {{--show view more info--}}
        @if($moreStatus)
            <form class="list-group tf_frm_view_more text-center tf-margin-padding-none tf-border-none" method="post"
                  name="tf_frm_view_more" action="{!! route('tf.search.info.more') !!}">
                <input class="tf_skip" name="tf_skip" type="hidden" value="{!! $skip !!}">
                <input class="tf_take" name="tf_take" type="hidden" value="{!! $take !!}">

                <div class="list-group-item tf-border-none">
                    <a class="tf_get tf-link-bold">
                        {!! trans('frontend_map.search_content_view_more') !!}
                    </a>
                </div>
            </form>
        @endif
    @else
        <div class="list-group tf-map-search-result-object">
            <a href="#" class="list-group-item tf-border-none">
                <span class="tf-color-red">Not found</span>
            </a>
        </div>
    @endif
</div>