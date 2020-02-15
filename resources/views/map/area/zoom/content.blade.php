<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/30/2016
 * Time: 10:14 AM
 */
$modelMobile = new Mobile_Detect();
$provinceId = $dataProvince->provinceId();

#on mobile
if ($modelMobile->isMobile()) {
    $zoomPercent = 4;
} else {
    $zoomPercent = 2;
}

$provinceWidth = 90496; #default for 10000 projects
$provinceHeight = 90496;
$provinceHeight = $provinceHeight / $zoomPercent;
$provinceWidth = $provinceWidth / $zoomPercent;

#$areaAccessTop = $dataAreaAccess->topPosition();
#$areaAccessLeft = $dataAreaAccess->leftPosition();
#$areaAccessTop = $areaAccessTop / $zoomPercent;

#on mobile
if ($modelMobile->isMobile()) {
    #$areaAccessLeft = $areaAccessLeft / $zoomPercent;
} else {
    #$areaAccessLeft = $areaAccessLeft / $zoomPercent - 896 / $zoomPercent;
}
$provinceTop = $provinceTop / $zoomPercent;
$provinceLeft = $provinceLeft / $zoomPercent;

$provinceTop = ($provinceTop > 0) ? -$provinceTop : $provinceTop;
$provinceLeft = ($provinceLeft > 0) ? -$provinceLeft : $provinceLeft;
?>
@extends('components.container.contain-action-10')
@section('tf_main_action_content')
    <div id="tf_map_area_zoom" class="tf-map-area-zoom tf_action_height_fix">
        <div id="tf_map_area_zoom_province" class="tf-map-area-zoom-province" data-province="{!! $provinceId !!}"
             data-zoom="{!! $zoomPercent !!}" data-href="{!! route('tf.map.area.coordinates.get') !!}"
             style="width:{!! $provinceWidth !!}px;height: {!! $provinceHeight !!}px; top:{!! $provinceTop !!}px;left: {!! $provinceLeft !!}px;">
            @if(count($dataArea) > 0)
                @foreach($dataArea as $areaObject)
                    <?php
                    $x = $areaObject->x();
                    $y = $areaObject->y();
                    $top = $areaObject->topPosition() / $zoomPercent;
                    $left = $areaObject->leftPosition() / $zoomPercent;
                    $width = $areaObject->width() / $zoomPercent;
                    $height = $areaObject->height() / $zoomPercent;
                    $areaId = $areaObject->areaId();
                    $dataProject = $modelArea->projectInfoOfProvince($provinceId, $areaId);
                    ?>
                    <div class="tf_map_area_zoom_object tf-map-area-zoom-object tf-position-abs" data-x="{!! $x !!}"
                         data-y="{!! $y !!}"
                         style="width: {!! $width !!}px;height: {!! $height !!}px;top:{!! $top !!}px;left: {!! $left !!}px;">
                        @if(count($dataProject) > 0)
                            <?php
                            $projectBackgroundImage = $dataProject->pathImageBackground();
                            $projectBackgroundSize = 896 / $zoomPercent;
                            #element on project
                            $land = $dataProject->landInfo();
                            $banner = $dataProject->bannerInfo();
                            $public = $dataProject->publicInfo();

                            # info of icon
                            $dataProjectIcon = $dataProject->iconInfo();
                            $iconId = $dataProjectIcon->iconId();
                            $sampleId = $dataProjectIcon->sampleId();

                            #develop to move icon (develop later)
                            $projectIconTop = $dataProjectIcon->topPosition() / $zoomPercent;
                            $projectIconLeft = $dataProjectIcon->leftPosition() / $zoomPercent;
                            $projectIconZIndex = $dataProjectIcon->zIndex();
                            $dataProjectIconSample = $dataProjectIcon->projectIconSample;
                            $projectIconWidth = $dataProjectIconSample->size->width() / $zoomPercent;
                            $projectIconHeight = $dataProjectIconSample->size->height() / $zoomPercent;
                            ?>
                            <div class="tf_map_area_zoom_project tf-map-area-zoom-project tf-position-rel"
                                 style="background: url(' {!! $projectBackgroundImage !!}');background-size:{!! $projectBackgroundSize !!}px; ">

                                {{--project icon--}}
                                <img class="tf-position-abs"
                                     style="width:{!! $projectIconWidth !!}px; height:{!! $projectIconHeight !!}px; top: {!! $projectIconTop !!}px; left: {!! $projectIconLeft !!}px; z-index: {!! $projectIconZIndex !!}"
                                     src="{!! $dataProjectIconSample->pathImage() !!}">
                                @if(count($banner) > 0)
                                    @foreach($banner as $dataBanner)
                                        <?php
                                        $top = $dataBanner->topPosition() / $zoomPercent;
                                        $left = $dataBanner->leftPosition() / $zoomPercent;
                                        $zIndex = $dataBanner->zindex();
                                        $publish = $dataBanner->publish();

                                        #sample
                                        $dataBannerSample = $dataBanner->bannerSample;
                                        $width = $dataBannerSample->size->width() / $zoomPercent;
                                        $height = $dataBannerSample->size->height() / $zoomPercent;
                                        $border = (int)$dataBannerSample->border() / $zoomPercent;

                                        #image
                                        $dataBannerImage = $dataBanner->imageInfo();
                                        ?>
                                        @if($publish == 1)
                                            <div class="tf-position-abs"
                                                 style="top: {!! $top !!}px; left: {!! $left !!}px; z-index: {!! $zIndex !!}">
                                                <img style="width:{!! $width !!}px; height:{!! $height !!}px;"
                                                     alt="banner"
                                                     src="{!! $dataBannerSample->pathImage() !!}">
                                                @if(count($dataBannerImage)>0 )
                                                    <?php
                                                    # set container image
                                                    $imageWidth = $width - ($border * 2);
                                                    $imageHeight = $height / 2 - ($border * 2);
                                                    ?>
                                                    <img class="tf-position-abs" style=" top: {!! $border !!}px; left:
                                                    {!! $border !!}px; width: {!! $imageWidth !!}px; height:{!! $imageHeight !!}px;"
                                                         alt="banner-image"
                                                         src="{!! $dataBannerImage->pathSmallImage() !!}">
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                @if(count($land) > 0)
                                    @foreach($land as $dataLand)
                                        <?php
                                        $top = $dataLand->topPosition() / $zoomPercent;
                                        $left = $dataLand->leftPosition() / $zoomPercent;
                                        $zIndex = $dataLand->zindex();
                                        $publish = $dataLand->publish();
                                        $landWidth = $dataLand->size->width() / $zoomPercent;
                                        $landHeight = $dataLand->size->height() / $zoomPercent;
                                        ?>
                                        @if($publish == 1)
                                            <?php
                                            #building info
                                            $dataBuilding = $dataLand->buildingInfo();
                                            ?>
                                            <div class="tf-position-abs"
                                                 style="width: {!! $landWidth !!}px;height: {!! $landHeight !!}px;top: {!! $top !!}px; left: {!! $left !!}px; z-index: {!! $zIndex !!};">
                                                @if(count($dataBuilding)>0 )
                                                    <?php
                                                    #sample
                                                    $dataBuildingSample = $dataBuilding->buildingSample;
                                                    $buildingWidth = $dataBuildingSample->size->width() / $zoomPercent;
                                                    $buildingHeight = $dataBuildingSample->size->height() / $zoomPercent;
                                                    ?>
                                                    <img class="tf-position-abs"
                                                         style="width: {!! $buildingWidth !!}px; height:{!! $buildingHeight !!}px;left: 0; bottom: 0;"
                                                         alt="building-image"
                                                         src="{!! $dataBuildingSample->pathImage() !!}">
                                                @else
                                                    <img class="tf-position-abs"
                                                         style="width: {!! $landWidth !!}px; height:{!! $landHeight !!}px;left: 0; bottom: 0;"
                                                         src="{!! asset('public/main/icons/icon-land.gif') !!}">
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                @if(count($public) > 0)
                                    @foreach($public as $dataPublic)
                                        <?php
                                        $top = $dataPublic->topPosition() / $zoomPercent;
                                        $left = $dataPublic->leftPosition() / $zoomPercent;
                                        $zIndex = $dataPublic->zindex();
                                        $dataPublicSample = $dataPublic->publicSample;
                                        $width = $dataPublicSample->size->width() / $zoomPercent;
                                        $height = $dataPublicSample->size->height() / $zoomPercent;
                                        ?>
                                        <img class="tf-position-abs" alt="3dtf-public"
                                             style="width:{!! $width !!}px; height:{!! $height !!}px; top: {!! $top !!}px; left: {!! $left !!}px; z-index: {!! $zIndex !!}"
                                             src="{!! $dataPublicSample->pathImage() !!}">
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                //var wrapHeight = $('#tf_main_action_content_wrap').outerHeight();
                //alert(wrapHeight);
                //var zoomWidth = $('#tf_map_project_zoom').outerWidth();
                //var zoomHeight = $('#tf_map_project_zoom').outerHeight();
                $('#tf_map_area_zoom').css('height', windowHeight - 80);
                $('#tf_map_area_zoom_province').draggable();
            });
        </script>
    </div>
@endsection