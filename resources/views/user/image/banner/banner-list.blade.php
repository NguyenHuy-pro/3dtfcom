<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 1:06 PM
 */
/*
 * $modelUser
 * $dataUser
 */
use App\Models\Manage\Content\Users\ImageType\TfUserImageType;
$modelUserImageType = new TfUserImageType();

$hFunction = new Hfunction();
#access user info
$userAccessId = $dataUser->userId();


$take = 15;
$dateTake = $hFunction->carbonNow();

#image info
$imageTypeId = $modelUserImageType->typeIdBanner();
$resultUserImage = $dataUser->imageInfo($userAccessId, $take, $dateTake, $imageTypeId);

?>
<div class="row tf_user_image_container" data-user="{!! $userAccessId !!}">
    <div class="tf_list_content col-xs-12 col-sm-12 col-md-12 tf-bg-white tf-padding-none "
         data-href-view="{!! route('tf.user.image.view.get') !!}"
         data-href-del="{!! route('tf.user.image.banner.delete') !!}">
        @if(count($resultUserImage) > 0)
            @foreach($resultUserImage as $dataUserImage)
                @include('user.image.banner.banner-object',
                    [
                        'modelUser'=>$modelUser,
                        'dataUserImage'=>$dataUserImage
                    ])
                <?php
                $checkDateViewMore = $dataUserImage->createdAt();
                ?>
            @endforeach
        @endif
    </div>
    {{--view more old image--}}
    @if(count($resultUserImage) > 0)
        <?php
        #check exist of image
        $resultMore = $dataUser->imageInfo($userAccessId, $take, $checkDateViewMore, $imageTypeId);
        ?>
        @if(count($resultMore) > 0)
            <div class="tf_view_more col-xs-12 col-sm-12 col-md-12 tf-padding-20 text-center">
                <a class="tf-link" data-take="{!! $take !!}" data-href="{!! route('tf.user.image.banner.more') !!}">
                    {!! trans('frontend_user.banner_info_view_more') !!}
                </a>
            </div>
        @endif
    @endif
</div>