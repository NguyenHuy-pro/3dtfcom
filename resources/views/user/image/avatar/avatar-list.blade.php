<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 11/29/2016
 * Time: 10:51 AM
 */
/*
 *
 * $modelUser
 * $dataUser
 *
 */
use App\Models\Manage\Content\Users\ImageType\TfUserImageType;
$hFunction = new Hfunction();
$modelUserImageType = new TfUserImageType();
#access user info
$userAccessId = $dataUser->userId();


$take = 15;
$dateTake = $hFunction->carbonNow();

#image info
$imageTypeId = $modelUserImageType->typeIdAvatar();
$resultUserImage = $dataUser->imageInfo($userAccessId, $take, $dateTake, $imageTypeId);
?>
<div class="row tf_user_image_container" data-user="{!! $userAccessId !!}">
    <div class="tf_list_content col-xs-12 col-sm-12 col-md-12 tf-bg-white tf-padding-none "
         data-href-view="{!! route('tf.user.image.view.get') !!}"
         data-href-del="{!! route('tf.user.image.avatar.delete') !!}">
        @if(count($resultUserImage) > 0)
            @foreach($resultUserImage as $dataUserImage)
                @include('user.image.avatar.avatar-object',
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
                <a class="tf-link" data-take="{!! $take !!}" data-href="{!! route('tf.user.image.avatar.more') !!}">
                    {!! trans('frontend_user.image_info_view_more') !!}
                </a>
            </div>
        @endif
    @endif
</div>

