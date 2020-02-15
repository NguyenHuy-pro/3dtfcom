<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 8/5/2016
 * Time: 3:28 PM
 */

$topPosition = $dataProject->area->y() * 2; # on mini map (width == height == 2 px)
$leftPosition = $dataProject->area->x() * 2;
?>
<div class="tf-m-build-mini-map-project" style="top: {!! $topPosition !!}px; left: {!!  $leftPosition !!}px;"></div>

