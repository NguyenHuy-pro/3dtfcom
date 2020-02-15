<?php
# access project info
$projectRankId = $dataProjectInfoAccess['projectRankID'];
$projectOwnStatus = $dataProjectInfoAccess['projectOwnStatus'];
$settingStatus = $dataProjectInfoAccess['settingStatus'];


# info land

$bannerId = $dataBanner->bannerId();
$projectId = $dataBanner->projectId();
$top = $dataBanner->topPosition();
$left = $dataBanner->leftPosition();
$zIndex = $dataBanner->zIndex();
$publish = $dataBanner->publish();

# sample info
$dataBannerSample = $dataBanner->bannerSample;


?>
<div id="tf_m_build_banner_{!! $bannerId !!}" class="tf_m_build_banner tf-m-build-banner"
     data-banner="{!! $bannerId !!}"
     @if($settingStatus)
     data-href-position="{!! route('tf.m.build.banner.position.set') !!}"
     @endif
     style="top: {!! $top !!}px; left: {!! $left !!}px;z-index: {!! $zIndex !!}">

    {{--sample image--}}
    <img src="{!! $dataBannerSample->pathImage() !!}">

    {{--not exist license--}}
    @if(!$dataBanner->existLicense())
        <?php
        $dataBannerTransaction = $dataBanner->transactionInfo();
        ?>
        <div class="tf-m-build-banner-transaction">
            {!! $dataBannerTransaction->transactionStatus->name() !!}
        </div>
        {{--is setting--}}
        @if($settingStatus)
            @include('manage.build.map.banner.banner-menu')
        @endif
        @if($publish == 0)
            <img class="tf-m-build-banner-icon-new tf-position-abs tf-zindex-10" alt="new-banner"
                 src="{!! asset("public/main/icons/new.png") !!}"/>
        @endif
        {{--exist building--}}
    @else
        <?php
        $dataBannerImage = $dataBanner->imageInfo();
        $border = $dataBannerSample->border();

        $sampleWidth = $dataBannerSample->size->width();
        $sampleHeight = $dataBannerSample->size->height();
        $imageWidth = $sampleWidth - $border * 2;
        $imageHeight = $sampleHeight / 2 - $border * 2;
        ?>
        @if(count($dataBannerImage) > 0)
            <div class="tf-position-abs"  style="top: {!! $border !!}px; left: {!! $border !!}px; width: {!! $imageWidth !!}px; height:{!! $imageHeight !!}px;">
                @include('manage.build.map.banner.banner-image', compact('dataBannerImage'));
            </div>
        @endif
    @endif
</div>

