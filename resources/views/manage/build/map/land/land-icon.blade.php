<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 7/26/2016
 * Time: 8:36 AM
 */
use App\Models\Manage\Content\Map\RuleLandRank\TfRuleLandRank;
$modelRuleLandRank = new TfRuleLandRank();

# project info
$projectRankId = $dataProjectInfoAccess['projectRankID'];
$projectOwnStatus = $dataProjectInfoAccess['projectOwnStatus'];

# sale info
$dataLandTransaction = $dataLand->transactionInfo();
$transactionStatusId = $dataLandTransaction->transactionStatusId();

$landId = $dataLand->landId();
$sizeId = $dataLand->sizeId();
$landPrice = $modelRuleLandRank->salePrice($sizeId, $projectRankId);
$landOwnStatus = 0;

# owns the project.
if ($projectOwnStatus == 1) {
    # not of the user.
    if (!$dataLand->existLicense()) {
        $landOwnStatus = 1;
    }
}

# get icon image
$iconImage = $dataLand->icon($sizeId, $transactionStatusId);
?>
<div class="tf-m-build-land-icon">
    {{--the land is sold.--}}
    @if($transactionStatusId == 1)
        <div class="tf-m-build-land-price">
            {!! $landPrice !!} (P)
        </div>
    @endif
    <img alt="{!! $dataLand->name() !!}" src="{!! $dataLand->pathIcon($iconImage) !!}"/>
</div>
