<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 6/13/2017
 * Time: 12:16 PM
 */
/*
 * modelUser
 * dataUserPost
 */

$hFunction = new Hfunction();
#content posts
$textPost = $dataUserPost->content();
$postImage = $dataUserPost->image();
?>
<div class="row">
    <div class="tf_user_activity_post_object_content col-xs-12 col-ms-12 col-md-12 col-lg-12" data-post="{!! $dataUserPost->postId() !!}">
        @if(!empty($textPost))
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @if(strlen($textPost) > 500)
                        {!! $hFunction->cutString($textPost, 500, '...') !!}
                        <br>
                        <a class="tf-link" href="{!! route('tf.user.activity.post.detail.get', $dataUserPost->postCode()) !!}" target="_blank">
                            View more
                        </a>
                    @else
                        {!! $textPost !!}
                    @endif

                </div>
            </div>
        @endif
        {{--image--}}
        @if(!empty($postImage))
            <div class="row">
                <div class="tf-overflow-prevent tf-padding-top-10 tf-padding-bot-10 col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                    <img class="tf_post_image tf-cursor-pointer"
                         data-href="{!! route('tf.user.activity.post.image.view.get') !!}"
                         src="{!! $dataUserPost->pathSmallImage() !!}">
                </div>
            </div>
        @endif
    </div>
</div>