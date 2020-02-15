<?php
/**
 * Created by PhpStorm.
 * User: HUY
 * Date: 9/28/2016
 * Time: 11:08 AM
 */
/*
 *
 * modelAbout
 * modelUser
 * modelUserActivity
 * dataUser
 * dataUserActivity
 * dataAccess
 *
 */
$hFunction = new Hfunction();

$takeActivity = $dataAccess['takeActivity'];

$userId = $dataUser->userId();
?>
{{-- form post --}}
@include('user.activity.activity.post.add.form-wrap')

<div class="row">
    <div id="tf_user_activity_list"
         class="tf_user_activity_list tf-padding-none col-xs-12 col-sm-12 col-md-12 col-lg-12"
         style="background: #d7d7dd;" data-user="{!! $userId !!}">

        @if(count($dataUserActivity) > 0)
            @foreach($dataUserActivity as $userActivity)
                @include('user.activity.activity.activity-object',
                [
                    'modelUser'=>$modelUser,
                    'userActivity'=>$userActivity

                ])
                <?php
                $checkDate = $userActivity->createdAt();
                ?>
            @endforeach
        @else
            <div id="tf_user_activity_null_notify"  class="text-center tf-padding-top-30 tf-bg-white col-xs-12 col-sm-12 col-md-12 col-lg-12" style="height: 1000px;">
                {!! trans('frontend_user.activity_notify_not_found') !!}
            </div>
        @endif

    </div>
    @if(count($dataUserActivity) > 0)
        <?php
        $checkUserActivity = $modelUserActivity->infoOfUser($userId, $takeActivity, $checkDate);
        ?>
        @if(count($checkUserActivity) > 0)
            <div id="tf_user_activity_more_wrap" class="tf-user-more-info col-xs-12 col-sm-12 co-md-12 col-lg-12 ">
                <a class="tf_user_activity_more tf-link tf-link-full" data-user="{!! $userId !!}"
                   data-href="{!! route('tf.user.activity.more.get') !!}"
                   data-take="{!! $takeActivity !!}">
                    {!! trans('frontend_building.posts_view_more_label') !!}
                </a>
            </div>
        @endif
    @endif
</div>