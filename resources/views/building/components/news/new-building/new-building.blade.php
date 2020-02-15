<?php

/*
 * $modelUser
 * $dataBuilding
 * $recentBuildingList
 *
 */

?>
<table class="table tf-building-news-new-building">
    @foreach($recentBuildingList as $buildingInfo)
        <?php
        $alias = $buildingInfo->alias();
        ?>
        <tr>
            <td>
                <a class="tf-link" href="{!! route('tf.building', $alias) !!}">
                    <img class="tf-building-icon" alt="{!! $alias !!}" style="max-width: 64px;"
                         src="{!! $buildingInfo->buildingSample->pathImage() !!}">
                </a>
                <br/>
                <a class="tf-link" href="{!! route('tf.building', $alias) !!}">
                    {!! $buildingInfo->name() !!}
                </a>
                &nbsp;&nbsp;
                <a class="fa fa-map-marker tf-link-green tf-font-size-20"
                   title="{!! trans('frontend_building.news_new_building_map_title') !!}"
                   href="{!! route('tf.home', $buildingInfo->alias()) !!}">
                </a>
            </td>
        </tr>
    @endforeach
</table>