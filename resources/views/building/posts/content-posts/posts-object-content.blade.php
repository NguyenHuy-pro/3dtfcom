<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/13/2017
 * Time: 12:16 PM
 */
/*
 * modelUser
 * dataBuildingPost
 */

$hFunction = new Hfunction();
#content posts
$buildingId = $dataBuildingPost->buildingId();
$postId = $dataBuildingPost->postId();
$postCode = $dataBuildingPost->postCode();
$userPostId = $dataBuildingPost->userId();
$postContent = $dataBuildingPost->content();
$postBuildingIntroId = $dataBuildingPost->buildingIntroId();
$dataPostImage = $dataBuildingPost->imageActivityInfo();
?>
@if(!empty($postContent))
    <div class="row">
        <div class="tf_building_posts_object_content_text col-xs-12 col-sm-12 col-md-12 col-lg-12" style="word-wrap: break-word;">
            @if(strlen($postContent) > 500)
                {!! $hFunction->identifyLink($hFunction->cutString($postContent, 500, '...')) !!}
                <br>
                <a class="tf-link" href="{!! route('tf.building.posts.detail.get', $postCode) !!}" @if(!$mobileDetect->isMobile()) target="_blank" @endif>
                    View more
                </a>
            @else
                {!! $hFunction->identifyLink($postContent) !!}
            @endif

        </div>
        <script type="text/javascript">
            tf_building_activity.posts.setWidthTextWrap(<?php echo $postId; ?>);
        </script>
    </div>
@endif

{{--image--}}
@if(count($dataPostImage) > 0)
    <div class="row">
        <div class="tf_posts_image tf-posts-image col-xs-12 col-sm-12 col-md-12 col-lg-12 "
             data-href="{!! route('tf.building.posts.image.view') !!}">
            <?php
            $totalPostImage = count($dataPostImage);
            $show_no = 1;
            ?>
            <div class="row">
                @foreach($dataPostImage as $postImage)
                    @if( $totalPostImage == 1)
                        <div class="tf-posts-image-show-top-1 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <img class="tf_posts_image_show tf-cursor-pointer" data-image="{!! $postImage->imageId() !!}" src="{!! $postImage->pathSmallImage() !!}">
                        </div>
                    @elseif($totalPostImage == 2)
                        <div class="tf-posts-image-show-top-1 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                            <img class="tf_posts_image_show tf-cursor-pointer" data-image="{!! $postImage->imageId() !!}" src="{!! $postImage->pathSmallImage() !!}">
                        </div>
                    @elseif($totalPostImage == 3)
                        @if($show_no == 1)
                            <div class="tf-posts-image-show-top-2 col-xs-12 col-sm-12 col-md-12 col-lg-12 " >
                                <img class="tf_posts_image_show tf-cursor-pointer" data-image="{!! $postImage->imageId() !!}" src="{!! $postImage->pathSmallImage() !!}">
                            </div>
                        @elseif($show_no >1)
                            <div class="tf-posts-image-show-bot col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <img class="tf_posts_image_show tf-cursor-pointer" data-image="{!! $postImage->imageId() !!}" src="{!! $postImage->pathSmallImage() !!}">
                            </div>
                        @endif
                    @elseif($totalPostImage == 4)
                        @if($show_no == 1)
                            <div class="tf-posts-image-show-top-2 col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <img class="tf_posts_image_show tf-cursor-pointer" data-image="{!! $postImage->imageId() !!}" src="{!! $postImage->pathSmallImage() !!}">
                            </div>
                        @elseif($show_no >1)
                            <div class="tf-posts-image-show-bot col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <img class="tf_posts_image_show tf-cursor-pointer" data-image="{!! $postImage->imageId() !!}" src="{!! $postImage->pathSmallImage() !!}">
                            </div>
                        @endif
                    @else
                        @if($show_no < 3)
                            <div class="tf-posts-image-show-top-2 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <img class="tf_posts_image_show tf-cursor-pointer" data-image="{!! $postImage->imageId() !!}" src="{!! $postImage->pathSmallImage() !!}">
                            </div>
                        @elseif($show_no >= 3 && $show_no <= 5 )
                            <div class="tf-posts-image-show-bot col-xs-4 col-sm-4 col-md-4 col-lg-4" >
                                <img class="tf_posts_image_show tf-cursor-pointer" data-image="{!! $postImage->imageId() !!}" src="{!! $postImage->pathSmallImage() !!}">
                            </div>
                        @endif
                    @endif
                    <?php
                    $show_no = $show_no + 1;
                    ?>
                @endforeach
            </div>
        </div>
    </div>
@endif
{{--introduct building--}}
@if(!empty($postBuildingIntroId))
    <?php
    $dataBuildingIntro = $dataBuildingPost->building->getInfo($postBuildingIntroId);
    if(!empty($dataBuildingIntro)){
    $alias = $dataBuildingIntro->alias();
    ?>
    <div class="row">
        <div class="tf-padding-bot-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
            <div class="media tf-padding-top-10" style="border-top: 1px solid #c2c2c2;">
                <a class="pull-left" href="{!! route('tf.building', $alias) !!}">
                    <img class="media-object wc-border-radius-4" alt="{!! $alias !!}"
                         style="max-width: 256px; max-height: 256px"
                         src="{!! $dataBuildingIntro->buildingSample->pathImage() !!}"/>
                </a>

                <div class="media-body">
                    <a class="tf-link-bold" href="{!! route('tf.building', $alias) !!}">
                        {!! $dataBuildingIntro->name() !!}
                    </a>

                    <p>
                        {!! $dataBuildingIntro->shortDescription() !!}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
@endif
