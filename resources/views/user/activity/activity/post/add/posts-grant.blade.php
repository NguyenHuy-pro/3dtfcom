<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/29/2016
 * Time: 11:11 AM
 *
 *
 * dataBuilding
 * dataRelation
 *
 */

#building info
$buildingId = $dataBuilding->buildingId();
$postsRelation = $dataBuilding->postRelationId();
?>
<div id="tf_building_posts_grant" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tf-padding-none"
     data-building="{!! $buildingId !!}"
     data-href="{!! route('tf.building.posts.grant') !!}">
    <i class="dropdown-toggle tf-cursor-pointer fa fa-cog tf-font-size-14" data-toggle="dropdown"></i>
    <ul class="dropdown-menu dropdown-menu-right tf-font-size-12 tf-padding-none">
        <li class="tf-border-bottom ">
            <a>{!! trans('frontend_building.posts_gran_title') !!}?</a>
        </li>
        @if(count($dataRelation) > 0)
            @foreach($dataRelation as $objectRelation)
                <?php
                $relationId = $objectRelation->relationId();
                ?>
                <li>
                    <a class="tf_action tf-bg-hover" data-relation="{!! $relationId !!}">
                        {!! $objectRelation->name() !!}&nbsp; &nbsp;
                        @if($postsRelation == $relationId)
                            <i class="fa fa-check paged tf-color-grey tf-font-size-16"></i>
                        @endif
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
</div>
