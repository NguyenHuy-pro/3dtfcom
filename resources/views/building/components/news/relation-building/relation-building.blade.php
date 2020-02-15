<?php
/*
 *
 * $modelUser
 * $dataBuilding
 * $dataRelationBuilding
 *
 */

$buildingId = $dataBuilding->buildingId();
?>
<table class="table tf-building-news-relation">
    @foreach($dataRelationBuilding as $buildingInfo)
        <?php
        $alias = $buildingInfo->alias();
        ?>
        {{--don't show current building--}}
        @if($buildingInfo->buildingId() != $buildingId )
            <tr>
                <td>
                    <a class="tf-link" href="{!! route('tf.building', $alias) !!}">
                        <img alt="{!! $alias !!}" style="max-width: 64px;"
                             src="{!! $buildingInfo->buildingSample->pathImage() !!}">
                    </a>
                    <br/>
                    <a class="tf-link" href="{!! route('tf.building', $alias) !!}">
                        {!! $buildingInfo->name() !!}1
                    </a>
                    &nbsp;&nbsp;
                    <a class="fa fa-map-marker tf-link-green tf-font-size-20"
                       title="{!! trans('frontend_building.news_relation_building_map_title') !!}"
                       href="{!! route('tf.home', $buildingInfo->alias()) !!}"></a>
                </td>
            </tr>
        @endif
    @endforeach
</table>