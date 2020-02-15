<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/30/2016
 * Time: 1:49 PM
 *
 * $modelArea
 * $dataProject
 *
 */

?>
@if(count($dataProject) > 0)
    @foreach($dataProject as $itemProject)
        <?php
        $projectId = $itemProject->projectId();
        $areaId = $itemProject->areaId();
        $dataArea = $modelArea->getInfo($areaId);
        $topPosition = $dataArea->y()*2; # on mini map (width == height == 2 px)
        $leftPosition = $dataArea->x()*2;
        ?>
        <div class="tf-mini-map-project" style="top: {!! $topPosition !!}px; left: {!!  $leftPosition !!}px;"></div>
    @endforeach
@endif
