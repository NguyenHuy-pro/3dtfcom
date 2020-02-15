<?php
/*
 *
 * $modelUser
 * $dataBanner
 * $dataMapAccess
 * $dataBannerInfoAccess
 * $dataBannerSample
 *
 */
$mobileDetect = new Mobile_Detect();
#user login
$dataUserLogin = $modelUser->loginUserInfo();

# access info of project
$projectRankId = $dataMapAccess['projectRankId'];

# access info of banner
$bannerId = $dataBanner->bannerId();

# sample info
$sizeId = $dataBannerSample->sizeId();
$border = $dataBannerSample->border();

# get size of banner
$sampleWidth = $dataBannerSample->size->width();
$sampleHeight = $dataBannerSample->size->height();

# transaction status
$dataBannerTransaction = $dataBanner->transactionInfo();
$transactionStatusId = $dataBannerTransaction->transactionStatusId();

# set container image
$imageWidth = $sampleWidth - ($border * 2);
$imageHeight = $sampleHeight / 2 - ($border * 2);

# sold
if ($dataBannerTransaction->transactionStatus->checkNormalStatus()) {
    $dataBannerImage = $dataBanner->imageInfo();
} else {
    $dataBannerImage = null;
}

?>
<div id="tf_banner_image_wrap_{!! $bannerId !!}" class="tf_banner_image_wrap tf-banner-image-wrap"
     style="top: {!! $border !!}px; left: {!! $border !!}px; width: {!! $imageWidth !!}px; height:{!! $imageHeight !!}px;">

    {{--detail information--}}
    @if(!$mobileDetect->isMobile())
        @include('map.banner.information.information',
            [
                'modelUser' => $modelUser,
                'dataBanner' => $dataBanner,
                'dataBannerImage' => $dataBannerImage
            ])
    @endif

    {{--ad image--}}
    @if($dataBannerTransaction->transactionStatus->checkNormalStatus())
        {{--image--}}
        @if(count($dataBannerImage) > 0)
            @include('map.banner.image.banner-image', compact('dataBannerImage'))
        @endif
    @else
        {{--transaction--}}
        <?php
        $dataRuleBannerRank = $dataBanner->ruleOfSizeAndRank($sizeId, $projectRankId);
        ?>
        @include('map.banner.transaction.transaction-status', compact('dataBannerTransaction','dataRuleBannerRank'))
    @endif

    {{--menu--}}
    @include('map.banner.menu.banner-menu', compact('dataBannerImage', 'dataBannerTransaction'),
        [
            'modelUser' => $modelUser,
            'dataMapAccess'=>$dataMapAccess,
            'dataBanner'=>$dataBanner
        ])
</div>
