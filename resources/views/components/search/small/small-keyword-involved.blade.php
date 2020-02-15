<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/7/2016
 * Time: 11:09 AM
 *
 *
 * $dataSearch
 *
 */

?>

<div id="tf_search_small_involved" class="tf-search-small-involved panel panel-default ">
    <div class="panel-body tf-margin-padding-none">
        <div class="list-group">
            @foreach($dataSearch as $itemSearch)
                <a class="tf_search_small_involved_name tf-search-involved tf-bg-hover tf-link-hover-white list-group-item">{!! $itemSearch->keyword !!}</a>
            @endforeach
        </div>
    </div>
</div>
